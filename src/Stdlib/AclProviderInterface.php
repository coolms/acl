<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/acl for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Stdlib;

/**
 * Acl provider interface
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
interface AclProviderInterface
{
    /**
     * @return \Zend\Permissions\Acl\AclInterface
     */
    public function getAcl();
}