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

use Zend\Permissions\Acl\Assertion\AssertionManager,
    CmsPermissions\Exception\InvalidArgumentException;

/**
 * Rule provider based on a given array of rules
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
class InMemoryProvider implements ProviderInterface
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var AssertionManager
     */
    protected $assertionPluginManager;

    /**
     * @param array $configRules
     * @param AssertionManager $assertionManager
     */
    public function __construct(array $configRules, AssertionManager $assertionManager)
    {
        $this->config = $configRules;
        $this->assertionPluginManager = $assertionManager;
    }

    /**
     * {@inheritDoc}
     */
    public function getRules()
    {
        $rules = [];

        foreach ($this->config as $type => $typedRules) {
            foreach ($typedRules as $rule) {
            	$rules[] = $this->loadRule($rule)->setType($type);
            }
        }

        return $rules;
    }

    /**
     * @param array $rule
     * @throws InvalidArgumentException
     * @return Rule
     */
    protected function loadRule(array $rule)
    {
        switch (count($rule)) {
        	case 4:
                list($roles, $resources, $privileges, $assertion) = $rule;
                if (is_string($assertion)) {
                    $assertion = $this->assertionPluginManager->get($assertion);
                }

                return new Rule($roles, $resources, $privileges, $assertion);
        	case 3:
                list($roles, $resources, $privileges) = $rule;
                return new Rule($roles, $resources, $privileges);
        	case 2:
                list($roles, $resources) = $rule;
                return new Rule($roles, $resources);
        	default:
                throw new InvalidArgumentException('Invalid rule definition: ' . print_r($rule, true));
        }
    }
}
