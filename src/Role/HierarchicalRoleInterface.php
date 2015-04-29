<?php
/**
 * CoolMS2 Authorization Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/authorization for the canonical source repository
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Ben Youngblood <bx.youngblood@gmail.com>
 */

namespace CmsAcl\Role;

use Zend\Permissions\Acl\Role\RoleInterface;

/**
 * Interface for a role with a possible parent role(s).
 *
 * @author  Ben Youngblood <bx.youngblood@gmail.com>
 */
interface HierarchicalRoleInterface extends RoleInterface
{
    /**
     * Get the parent role(s)
     *
     * @return RoleInterface|RoleInterface[]|null
     */
    public function getParent();
}
