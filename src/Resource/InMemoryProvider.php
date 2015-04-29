<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Ben Youngblood <bx.youngblood@gmail.com>
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Resource;

/**
 * Resource provider based on a given array of resources
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
     * @param array $configResources
     */
    public function __construct(array $configResources)
    {
        $this->config = $configResources;
    }

    /**
     * {@inheritDoc}
     */
    public function getResources()
    {
        $resources  = [];

        foreach ($this->config as $key => $value) {
            $resources = array_merge(
                $resources,
                is_numeric($key) ? $this->loadResource($value) : $this->loadResource($key, $value)
            );
        }

        return $resources;
    }

    /**
     * @param string      $name
     * @param array       $children
     * @param string|null $parent
     * @return array
     */
    protected function loadResource($name, $children = [], $parent = null)
    {
        $resources   = [];
        $resource    = new HierarchicalResource($name, $parent);
        $resources[] = $resource;
        foreach ($children as $key => $value) {
            $resources = array_merge(
                $resources,
                is_numeric($key)
                    ? $this->loadResource($value, [], $resource)
                    : $this->loadResource($key, $value, $resource)
            );
        }

        return $resources;
    }
}
