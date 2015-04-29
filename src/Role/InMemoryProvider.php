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

use CmsPermissions\Role\ProviderInterface;

/**
 * Role provider based on a given array of roles
 *
 * @author Ben Youngblood <bx.youngblood@gmail.com>
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
class InMemoryProvider implements ProviderInterface
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * __construct
     *
     * @param array $configRoles
     */
    public function __construct(array $configRoles)
    {
        $this->config = $configRoles;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        $roles  = [];

        foreach ($this->config as $key => $value) {
            $roles = array_merge(
                $roles,
                is_numeric($key) ? $this->loadRole($value) : $this->loadRole($key, $value)
            );
        }

        return $roles;
    }

    /**
     * @param string      $name
     * @param array       $children
     * @param string|null $parent
     * @return array
     */
    protected function loadRole($name, $children = [], $parent = null)
    {
        $roles   = [];
        $role    = new HierarchicalRole($name, $parent);
        $roles[] = $role;
        foreach ($children as $key => $value) {
            $roles = array_merge(
                $roles,
                is_numeric($key)
                    ? $this->loadRole($value, [], $role)
                    : $this->loadRole($key, $value, $role)
            );
        }

        return $roles;
    }
}
