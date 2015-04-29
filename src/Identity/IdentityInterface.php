<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @copyright   Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Identity;

use Zend\Permissions\Acl\Role\RoleInterface,
    CmsPermissions\Identity\IdentityInterface as BaseIdentityInterface;

/**
 * Interface for an identity
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
interface IdentityInterface extends BaseIdentityInterface, RoleInterface
{
    
}
