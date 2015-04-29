<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/acl for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Role;

use Zend\Permissions\Acl\Role\RoleInterface,
    CmsPermissions\Role\AbstractMapperProvider;

/**
 * Role provider based on a {@see \CmsCommon\Persistence\MapperInterface}
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
class MapperProvider extends AbstractMapperProvider
{
    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        $result = $this->getMapper()->findAll();
        $roles  = [];

        // Pass One: Build each object
        foreach ($result as $role) {
            if (!$role instanceof RoleInterface) {
                continue;
            }

            $roleId = $role->getRoleId();
            $parent = null;
            if ($role instanceof HierarchicalRoleInterface) {
                $parent = $role->getParent();
            }

            $roles[$roleId] = new HierarchicalRole($roleId, $parent);
        }

        // Pass Two: Re-inject parent objects to preserve hierarchy
        /* @var $role HierarchicalRole */
        foreach ($roles as $role) {
            $parentRole = $role->getParent();
            if ($parentRole && $parentRole->getRoleId()) {
                $role->setParent($roles[$parentRole->getRoleId()]);
            }
        }

        return array_values($roles);
    }
}
