<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @copyright   Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Resource;

use Zend\ServiceManager\AbstractPluginManager,
    CmsPermissions\Exception\InvalidArgumentException;

class ProviderPluginManager extends AbstractPluginManager
{
    /**
     * Validate the plugin
     *
     * Checks that the element is an instance of CmsAcl\Resource\ProviderInterface
     *
     * @param mixed $plugin
     * @throws InvalidArgumentException
     * @return bool
     */
    public function validatePlugin($plugin)
    {
        if (! $plugin instanceof ProviderInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    'Plugin of type %s is invalid; must implement CmsAcl\Resource\ProviderInterface',
                    (is_object($plugin) ? get_class($plugin) : gettype($plugin))
                )
            );
        }

        return true;
    }
}
