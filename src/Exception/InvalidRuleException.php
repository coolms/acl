<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @copyright   Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Exception;

use CmsPermissions\Exception\InvalidRoleException as BaseInvalidRoleException;

/**
 * Invalid rule exception for CmsAcl
 */
class InvalidRuleException extends BaseInvalidRoleException implements ExceptionInterface
{
    
}
