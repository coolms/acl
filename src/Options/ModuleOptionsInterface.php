<?php 
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/acl for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Options;

interface ModuleOptionsInterface
{
    /**
     * @param array $providers
     * @return self
     */
    public function setResourceProviders(array $providers);

    /**
     * @return array
     */
    public function getResourceProviders();

    /**
     * @param array $providers
     * @return self
     */
    public function setRuleProviders(array $providers);

    /**
     * @return array
     */
    public function getRuleProviders();

    /**
     * @param array $guards
     * @return self
     */
    public function setGuards(array $guards);

    /**
     * @return array
     */
    public function getGuards();

    /**
     * @param string $cacheKey
     * @return self
     */
    public function setCacheKey($cacheKey);

    /**
     * @return string
     */
    public function getCacheKey();

    /**
     * @param string $service
     * @return self
     */
    public function setAuthorizationService($service);

    /**
     * @return string
     */
    public function getAuthorizationService();
}
