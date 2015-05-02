<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/acl for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin,
    CmsAcl\Service\AuthorizationServiceAwareTrait,
    CmsAcl\Service\AuthorizationServiceInterface;

/**
 * IsAllowed Controller plugin. Allows checking access to a resource/privilege in controllers.
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
class IsAllowed extends AbstractPlugin
{
    use AuthorizationServiceAwareTrait;

    /**
     * __construct
     *
     * @param AuthorizationServiceInterface $authorizationService
     */
    public function __construct(AuthorizationServiceInterface $authorizationService)
    {
        $this->setAuthorizationService($authorizationService);
    }

    /**
     * @param mixed|null $resource
     * @param mixed|null $privilege
     * @return bool
     */
    public function __invoke($resource = null, $privilege = null)
    {
        if (null === $resource) {
            return $this;
        }

        return $this->isAllowed($resource, $privilege);
    }

    /**
     * Proxy the authorization service
     *
     * @param  string $method
     * @param  array  $argv
     * @return mixed
     */
    public function __call($method, $argv)
    {
        $service = $this->getAuthorizationService();
        return call_user_func_array([$service, $method], $argv);
    }
}
