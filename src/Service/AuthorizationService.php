<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Ben Youngblood <bx.youngblood@gmail.com>
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Service;

use Zend\Permissions\Acl\AclInterface,
    Zend\Permissions\Acl\Exception\InvalidArgumentException,
    Zend\Permissions\Acl\Resource\ResourceInterface,
    Zend\Permissions\Acl\Role\GenericRole,
    Zend\Permissions\Acl\Role\RoleInterface,
    Zend\ServiceManager\ServiceLocatorAwareTrait,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsAcl\Exception\InvalidRoleException,
    CmsAcl\Resource\HierarchicalResourceInterface,
    CmsAcl\Resource\ProviderInterface as ResourceProvider,
    CmsAcl\Role\HierarchicalRoleInterface,
    CmsAcl\Rule\ProviderInterface as RuleProvider,
    CmsAcl\Stdlib\AclProviderInterface,
    CmsPermissions\Role\ProviderInterface as RoleProvider;

/**
 * Authorization service
 *
 * @author Ben Youngblood <bx.youngblood@gmail.com>
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
class AuthorizationService implements AuthorizationServiceInterface, AclProviderInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var AclInterface
     */
    protected $acl;

    /**
     * @var string|RoleInterface
     */
    protected $identity;

    /**
     * @var \Closure|null
     */
    protected $loaded;

    /**
     * __construct
     *
     * @param AclInterface $acl
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(AclInterface $acl, ServiceLocatorInterface $serviceLocator)
    {
        $this->acl = $acl;
        $this->setServiceLocator($serviceLocator);

        $this->loaded = function() {
            $this->load();
        };
    }

    /**
     * {@inheritDoc}
     */
    public function getAcl()
    {
        $this->loaded && $this->loaded->__invoke();
        return $this->acl;
    }

    /**
     * {@inheritDoc}
     */
    public function isAllowed($resource, $privilege = null, $role = null)
    {
        $this->loaded && $this->loaded->__invoke();

        try {
            return $this->acl->isAllowed($role ?: $this->identity, $resource, $privilege);
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    /**
     * Initializes the service
     *
     * @internal
     * @return self
     */
    public function load()
    {
        if (null === $this->loaded) {
            return $this;
        }

        $this->loaded = null;

        /* @var $cache \Zend\Cache\Storage\StorageInterface */
        $cache = $this->getServiceLocator()->get('CmsPermissions\\Cache');

        /* @var $cacheKeyGenerator callable */
        $cacheKeyGenerator  = $this->getServiceLocator()->get('CmsAcl\\CacheKeyGenerator');
        $cacheKey           = $cacheKeyGenerator();

        $success = false;
        $acl = $cache->getItem($cacheKey, $success);
        if (!($acl instanceof AclInterface) || !$success) {
            $this->loadAcl();
            $cache->setItem($cacheKey, $this->acl);
        } else {
            $this->acl = $acl;
        }

        /* @var $identityProvider \CmsPermissions\Identity\ProviderInterface */
        $identityProvider = $this->getServiceLocator()->get('CmsPermissions\\Identity\\ProviderInterface');
        $this->identity   = $identityProvider->getIdentity();

        $this->loadRole($this->identity);

        return $this;
    }

    /**
     * Initialize the ACL
     */
    private function loadAcl()
    {
        /* @var $provider RoleInterface */
        foreach ($this->getServiceLocator()->get('CmsAcl\\Roles') as $provider) {
            $this->loadRoles($provider->getRoles());
        }

        /* @var $provider ResourceProvider */
        foreach ($this->getServiceLocator()->get('CmsAcl\\Resources') as $provider) {
            $this->loadResources($provider->getResources());
        }

        /* @var $provider RuleProvider */
        foreach ($this->getServiceLocator()->get('CmsAcl\\Rules') as $provider) {
            $this->loadRules($provider->getRules());
        }

        /* @var $guard \CmsAcl\Guard\GuardInterface */
        foreach ($this->getServiceLocator()->get('CmsAcl\\Guards') as $guard) {
            if ($guard instanceof ResourceProvider) {
                $this->loadResources($guard->getResources());
            }

            if ($guard instanceof RuleProvider) {
                $this->loadRules($guard->getRules());
            }
        }
    }

    /**
     * @param RoleInterface[] $roles
     */
    private function loadRoles(array $roles)
    {
        /* @var $role RoleInterface */
        foreach ($roles as $role) {
            $this->loadRole($role);
        }
    }

    /**
     * @param string|RoleInterface $role
     * @throws InvalidRoleException
     */
    private function loadRole($role)
    {
        if ($this->acl->hasRole($role)) {
            return;
        }

        $parent = null;

        if (is_string($role)) {
            $role = new GenericRole($role);
        } elseif ($role instanceof RoleProvider && ($roles = $role->getRoles())) {
            $this->loadRoles($roles);
        } elseif ($role instanceof HierarchicalRoleInterface && ($parent = $role->getParent())) {
            is_array($parent) ? $this->loadRoles($parent) : $this->loadRole($parent);
        } elseif (!$role instanceof RoleInterface) {
            throw InvalidRoleException::invalidRoleInstance($role);
        }

        $this->acl->addRole($role, $parent);
    }

    /**
     * @param ResourceInterface[] $resources
     */
    private function loadResources(array $resources)
    {
        /* @var $resource ResourceInterface */
        foreach ($resources as $resource) {
            $this->loadResource($resource);
        }
    }

    /**
     * @param string|ResourceInterface $resource
     */
    private function loadResource($resource)
    {
        if ($this->acl->hasResource($resource)) {
        	return;
        }

        $parent = null;
        if ($resource instanceof HierarchicalResourceInterface && ($parent = $resource->getParent())) {
            is_array($parent) ? $this->loadResources($parent) : $this->loadResource($parent);
        }

        $this->acl->addResource($resource, $parent);
    }

    /**
     * @param array $rules
     */
    private function loadRules(array $rules)
    {
        /* @var $rule \CmsAcl\Rule\RuleInterface */
        foreach ($rules as $rule) {
            $type = $rule->getType();
            $this->acl->$type(
                $rule->getRoles(),
                $rule->getResources(),
                $rule->getPrivileges(),
                $rule->getAssertion()
            );
        }
    }
}
