<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/acl for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Service;

/**
 * Authorization service interface
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
interface AuthorizationServiceInterface
{
    /**
     * @param string|\Zend\Permissions\Acl\Resource\ResourceInterface   $resource
     * @param string                                                    $privilege
     * @param string|\Zend\Permissions\Acl\Role\RoleInterface           $role
     *
     * @return bool
     */
    public function isAllowed($resource, $privilege = null, $role = null);
}
