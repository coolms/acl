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

use Zend\Permissions\Acl\Resource\ResourceInterface;

/**
 * Interface for a resource with a possible parent resource.
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
interface HierarchicalResourceInterface extends ResourceInterface
{
    /**
     * Get the parent resource
     *
     * @return ResourceInterface|null
     */
    public function getParent();
}
