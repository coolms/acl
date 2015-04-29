<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Ben Youngblood <bx.youngblood@gmail.com>
 */

namespace CmsAcl\Resource;

/**
 * Resource provider interface, provides existing resources list
 *
 * @author Ben Youngblood <bx.youngblood@gmail.com>
 */
interface ProviderInterface
{
    /**
     * @return \Zend\Permissions\Acl\Resource\ResourceInterface[]
     */
    public function getResources();
}
