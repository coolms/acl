<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link        http://github.com/coolms/acl for the canonical source repository
 * @license     http://www.coolms.com/license/new-bsd New BSD License
 * @author      Ben Youngblood <bx.youngblood@gmail.com>
 * @author      Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl\Guard;

use Zend\Permissions\Acl\Assertion\AssertionManager,
    CmsAcl\Resource\ProviderInterface as ResourceProviderInterface,
    CmsAcl\Rule\ProviderInterface as RuleProviderInterface,
    CmsAcl\Rule\Rule,
    CmsAcl\Service\AuthorizationServiceAwareTrait,
    CmsAcl\Service\AuthorizationServiceInterface,
    CmsPermissions\Guard\AbstractGuard as AbstractPermissionsGuard;

/**
 * Abstract ACL Guard listener
 *
 * @author Ben Youngblood <bx.youngblood@gmail.com>
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
abstract class AbstractGuard extends AbstractPermissionsGuard implements
    ResourceProviderInterface,
    RuleProviderInterface
{
    use AuthorizationServiceAwareTrait;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var AssertionManager
     */
    protected $assertionPluginManager;

    /**
     * @var \Zend\Permissions\Acl\Resource\ResourceInterface[]
     */
    protected $resoruces;

    /**
     * @var \CmsAcl\Rule\RuleInterface[]
     */
    protected $rules;

    /**
     * __construct
     *
     * @param array|\Traversable $configRules
     * @param AuthorizationServiceInterface $authorizationService
     * @param AssertionManager
     */
    public function __construct(
        $configRules,
        AuthorizationServiceInterface $authorizationService,
        AssertionManager $assertionManager
    ) {
        $this->setConfig($configRules);
        $this->setAuthorizationService($authorizationService);
        $this->assertionPluginManager = $assertionManager;
    }

    /**
     * @param array $rule
     * @return array
     */
    abstract protected function extractResourcesFromRule(array $rule);

    /**
     * {@inheritDoc}
     */
    public function getResources()
    {
        if (null === $this->resoruces) {
            $this->resoruces = [];
            /* @var $rule \CmsAcl\Rule\RuleInterface */
            foreach ($this->getRules() as $rule) {
                /* @var $resource \Zend\Permissions\Acl\Resource\ResourceInterface */
                foreach ($rule->getResources() as $resource) {
                    $this->resoruces[] = $resource;
                }
            }
        }

        return $this->resoruces;
    }

    /**
     * {@inheritDoc}
     */
    public function getRules()
    {
        if (null === $this->rules) {
            $this->rules = [];
            foreach ($this->config as $resource => $ruleData) {
                $assertion = null;
                if (isset($ruleData['assertion'])) {
                    $assertion = $this->assertionPluginManager->get($ruleData['assertion']);
                }

                $this->rules[] = new Rule($ruleData['roles'], [$resource], null, $assertion, Rule::TYPE_ALLOW);
            }
        }

        return $this->rules;
    }

    /**
     * @param array|\Traversable $config
     * @return self
     */
    public function setConfig($config)
    {
        foreach ($config as $rule) {
            $rule['roles']  = (array) $rule['roles'];
            $rule['action'] = isset($rule['action']) ? (array) $rule['action'] : [null];
            foreach ($this->extractResourcesFromRule($rule) as $resource) {
                $this->config[$resource] = ['roles' => (array) $rule['roles']];
                if (isset($rule['assertion'])) {
                    $this->config[$resource]['assertion'] = $rule['assertion'];
                }
            }
        }

        return $this;
    }
}
