<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Marco Pivetta <ocramius@gmail.com>
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Collector;

use Zend\Mvc\MvcEvent,
    Zend\Permissions\Acl\Role\RoleInterface,
    ZendDeveloperTools\Collector\CollectorInterface,
    CmsAcl\Role\HierarchicalRoleInterface,
    CmsPermissions\Identity\ProviderInterface as IdentityProvider,
    CmsPermissions\Role\ProviderInterface as RoleProvider;

/**
 * Role collector - collects the role during dispatch
 *
 * @author  Marco Pivetta <ocramius@gmail.com>
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class RoleCollector implements \Serializable, CollectorInterface
{
    /**
     * Collector name
     */
    const NAME = 'CmsAclRoles';

    /**
     * Collector priority
     */
    const PRIORITY = 150;

    /**
     * @var array|string[] collected role ids
     */
    protected $collectedRoles = [];

    /**
     * @var IdentityProvider
     */
    protected $identityProvider;

    /**
     * @param IdentityProvider $identityProvider
     */
    public function __construct(IdentityProvider $identityProvider)
    {
        $this->identityProvider = $identityProvider;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * {@inheritDoc}
     */
    public function getPriority()
    {
        return static::PRIORITY;
    }

    /**
     * {@inheritDoc}
     */
    public function collect(MvcEvent $mvcEvent)
    {
        if (null === $this->identityProvider) {
            return;
        }

        /* @var $role RoleInterface */
        $role  = $this->identityProvider->getIdentity();
        $roles = [$role];

        if ($role instanceof HierarchicalRoleInterface && ($parent = $role->getParent())) {
            foreach ($parent as $parentRole) {
                $roles[] = $parentRole;
            }
        } elseif ($role instanceof RoleProvider && ($parent = $role->getRoles())) {
            foreach ($parent as $parentRole) {
                $roles[] = $parentRole;
            }
        }

        foreach ($roles as $role) {
            if ($role instanceof RoleInterface) {
                $role = $role->getRoleId();
            }

            if ($role) {
                $this->collectedRoles[] = (string) $role;
            }
        }
    }

    /**
     * @return array|string[]
     */
    public function getCollectedRoles()
    {
        return $this->collectedRoles;
    }

    /**
     * {@inheritDoc}
     */
    public function serialize()
    {
        return serialize($this->collectedRoles);
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $this->collectedRoles = unserialize($serialized);
    }
}
