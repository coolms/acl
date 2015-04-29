<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/acl for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Rule;

use Zend\Permissions\Acl\Assertion\AssertionInterface;

/**
 * Base rule object
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
class Rule implements RuleInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var array|\Zend\Permissions\Acl\Role\RoleInterface[]
     */
    protected $roles;

    /**
     * @var array|\Zend\Permissions\Acl\Resource\ResourceInterface[]
     */
    protected $resources;

    /**
     * @var array\Traversable
     */
    protected $privileges;

    /**
     * @var AssertionInterface
     */
    protected $assertion;

    /**
     * __construct
     *
     * @param array|\Zend\Permissions\Acl\Role\RoleInterface[]      $roles
     * @param array|\Zend\Permissions\Acl\Role\ResourcesInterface[] $resources
     * @param array|\Traversable|null                               $privileges
     * @param AssertionInterface|null                               $assertion
     * @param string                                                $type
     */
    public function __construct($roles = [], $resources = [], $privileges = null,
            AssertionInterface $assertion = null, $type = self::TYPE_DENY
    ) {
        $this->setRoles($roles);
        $this->setResources($resources);
        $this->setPrivileges($privileges);
        $this->setAssertion($assertion);
        $this->setType($type);
    }

    /**
     * {@inheritDoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array|\Zend\Permissions\Acl\Role\RoleInterface[] $roles
     * @return self
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @param array|\Zend\Permissions\Acl\Resource\ResourceInterface[] $resources
     * @return self
     */
    public function setResources($resources)
    {
        $this->resources = $resources;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPrivileges()
    {
        return $this->privileges;
    }

    /**
     * @param array|\Traversable|null $privileges
     * @return self
     */
    public function setPrivileges($privileges = null)
    {
        $this->privileges = $privileges;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAssertion()
    {
        return $this->assertion;
    }

    /**
     * @param AssertionInterface|null $assertion
     * @return self
     */
    public function setAssertion(AssertionInterface $assertion = null)
    {
        $this->assertion = $assertion;
        return $this;
    }
}
