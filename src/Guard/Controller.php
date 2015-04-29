<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Ben Youngblood <bx.youngblood@gmail.com>
 */

namespace CmsAcl\Guard;

use Zend\Http\Request as HttpRequest,
    Zend\Mvc\MvcEvent,
    CmsPermissions\Exception\UnauthorizedException;

/**
 * Controller Guard listener
 *
 * @author Ben Youngblood <bx.youngblood@gmail.com>
 */
class Controller extends AbstractGuard
{
    /**
     * {@inheritDoc}
     */
    protected function extractResourcesFromRule(array $rule)
    {
        $results = [];
        $rule['action'] = isset($rule['action']) ? (array) $rule['action'] : [null];
        foreach ((array) $rule['controller'] as $controller) {
            foreach ($rule['action'] as $action) {
                $results[] = $this->getResourceName($controller, $action);
            }
        }

        return $results;
    }

    /**
     * Retrieves the resource name for a given controller
     *
     * @param string $controller
     * @param string $action
     * @return string
     */
    public function getResourceName($controller, $action = null)
    {
        if (isset($action)) {
            return sprintf('controller/%s:%s', $controller, strtolower($action));
        }

        return sprintf('controller/%s', $controller);
    }

    /**
     * {@inheritDoc}
     */
    public function isAuthorized(MvcEvent $event)
    {
        $service    = $this->getAuthorizationService();
        $match      = $event->getRouteMatch();
        $controller = $match->getParam('controller');
        $action     = $match->getParam('action');
        $request    = $event->getRequest();
        $method     = $request instanceof HttpRequest ? strtolower($request->getMethod()) : null;

        if ($service->isAllowed($this->getResourceName($controller))
            || $service->isAllowed($this->getResourceName($controller, $action))
            || ($method && $service->isAllowed($this->getResourceName($controller, $method)))
        ) {
            return true;
        }

        $event->setParam('controller', $controller);
        $event->setParam('action', $action);

        $errorMessage = sprintf('You are not authorized to access %s:%s', $controller, $action);
        throw new UnauthorizedException($errorMessage, 403);
    }
}
