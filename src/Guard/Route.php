<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Ben Youngblood <bx.youngblood@gmail.com>
 */

namespace CmsAcl\Guard;

use Zend\Mvc\MvcEvent,
    CmsPermissions\Exception\UnauthorizedException;

/**
 * Route Guard listener
 *
 * @author Ben Youngblood <bx.youngblood@gmail.com>
 */
class Route extends AbstractGuard
{
    /**
     * {@inheritDoc}
     */
    protected function extractResourcesFromRule(array $rule)
    {
        return ['route/' . $rule['route']];
    }

    /**
     * {@inheritDoc}
     */
    public function isAuthorized(MvcEvent $event)
    {
        $service    = $this->getAuthorizationService();
        $match      = $event->getRouteMatch();
        $routeName  = $match->getMatchedRouteName();

        if ($service->isAllowed('route/' . $routeName)) {
            return true;
        }

        $event->setParam('route', $routeName);

        $errorMessage = sprintf('You are not authorized to access %s', $routeName);
        throw new UnauthorizedException($errorMessage, 403);
    }
}
