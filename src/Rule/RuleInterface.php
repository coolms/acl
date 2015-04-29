<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/acl for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Rule;

/**
 * Interface for a rule.
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
interface RuleInterface
{
    const TYPE_ALLOW = 'allow';
    const TYPE_DENY  = 'deny';

    /**
     * @return string
     */
    public function getType();

    /**
     * Get roles
     *
     * @return array|\Zend\Permissions\Acl\Role\RoleInterface[]
     */
    public function getRoles();

    /**
     * Get resources
     *
     * @return array|\Zend\Permissions\Acl\Resource\ResourceInterface[]
     */
    public function getResources();

    /**
     * Get privileges
     *
     * @return null|array
     */
    public function getPrivileges();

    /**
     * Get assertion
     *
     * @return null|\Zend\Permissions\Acl\Assertion\AssertionInterface
     */
    public function getAssertion();
}
