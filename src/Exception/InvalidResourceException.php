<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Ben Youngblood <bx.youngblood@gmail.com>
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Exception;

use CmsPermissions\Exception\InvalidArgumentException;

/**
 * Invalid resource exception for CmsAcl
 */
class InvalidResourceException extends InvalidArgumentException
{
    /**
     * @param mixed $resource
     */
    public static function invalidResourceInstance($resource)
    {
        return new self(
            sprintf(
                'Invalid resource of type "%s" provided',
                is_object($resource)
                    ? get_class($resource)
                    : gettype($resource)
            )
        );
    }
}
