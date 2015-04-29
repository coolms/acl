<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Ben Youngblood <bx.youngblood@gmail.com>
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Role;

use Zend\Permissions\Acl\Role\GenericRole,
    Zend\Permissions\Acl\Role\RoleInterface,
    CmsPermissions\Exception\InvalidRoleException;

/**
 * Base role object
 *
 * @author  Ben Youngblood <bx.youngblood@gmail.com>
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class HierarchicalRole extends GenericRole implements HierarchicalRoleInterface
{
    /**
     * @var RoleInterface
     */
    protected $parent;

    /**
     * @param string|RoleInterface|null                 $roleId
     * @param string|RoleInterface|RoleInterface[]|null $parent
     */
    public function __construct($roleId, $parent = null)
    {
        if ($roleId instanceof RoleInterface) {
            $roleId = $roleId->getRoleId();
        }

        parent::__construct($roleId);
        $this->setParent($parent);
    }

    /**
     * {@inheritDoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param RoleInterface|string|RoleInterface[]|null $parent
     * @return Role
     */
    public function setParent($parent)
    {
        if (is_array($parent) || $parent instanceof \Traversable) {
            foreach ($parent as $role) {
                $this->parent[] = $this->loadParent($role);
            }

            return $this;
        }

        if (null === $parent) {
            $this->parent = $parent;
            return $this;
        }

        $this->parent = $this->loadParent($parent);
        return $this;
    }

    /**
     * @param string|RoleInterface $role
     * @throws InvalidRoleException
     * @return RoleInterface
     */
    protected function loadParent($role)
    {
        if (is_string($role)) {
            return new GenericRole($role);
        }

        if ($role instanceof RoleInterface) {
            return $role;
        }

        throw InvalidRoleException::invalidRoleInstance($role);
    }
}
