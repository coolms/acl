<?php
/**
 * CoolMS2 ACL Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/acl for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsAcl;

return [
    'cmspermissions' => [
        'acl' => [
            'resource_provider_manager' => [
                'factories' => [
                    'CmsAcl\Resource\InMemoryProvider'
                        => 'CmsAcl\Factory\Resource\InMemoryProviderFactory',
                ],
            ],
            'resource_providers' => [
                
            ],
            'role_provider_manager' => [
                'factories' => [
                    'CmsAcl\Role\InMemoryProvider'
                        => 'CmsAcl\Factory\Role\InMemoryProviderFactory',
                    'CmsAcl\Role\MapperProvider'
                        => 'CmsAcl\Factory\Role\MapperProviderFactory',
                ],
            ],
            'role_providers' => [
                
            ],
            'rule_provider_manager' => [
                'factories' => [
                    'CmsAcl\Rule\InMemoryProvider'
                        => 'CmsAcl\Factory\Rule\InMemoryProviderFactory',
                ],
            ],
            'rule_providers' => [
                'CmsAcl\Rule\InMemoryProvider' => [
                    'allow' => [],
                    // Don't mix allow/deny rules if you are using role inheritance.
                    // There are some weird bugs.
                    'deny' => [],
                ],
            ],
            'guard_manager' => [
                'factories' => [
                    'CmsAcl\Guard\Controller'
                        => 'CmsAcl\Factory\Guard\ControllerGuardFactory',
                    'CmsAcl\Guard\Route'
                        => 'CmsAcl\Factory\Guard\RouteGuardFactory',
                ],
            ],
            'guards' => [
                
            ],
        ],
    ],
    'controller_plugins' => [
        'aliases' => [
            'cmsIsAllowed' => 'CmsAcl\Controller\Plugin\IsAllowed'
        ],
        'factories' => [
            'CmsAcl\Controller\Plugin\IsAllowed'
                => 'CmsAcl\Factory\Controller\Plugin\IsAllowedPluginFactory',
        ],
    ],
    'controllers' => [
        'invokables' => [
            'CmsAcl\Controller\Privilege' => 'CmsAcl\Controller\PrivilegeController',
            'CmsAcl\Controller\Resource' => 'CmsAcl\Controller\ResourceController',
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'Zend\Permissions\Acl\AclInterface' => 'Zend\Permissions\Acl\Acl',
            'CmsAcl\Options\ModuleOptionsInterface' => 'CmsAcl\Options\ModuleOptions',
            'CmsAcl\Service\AuthorizationServiceInterface'
                => 'CmsAcl\Service\AuthorizationService',
        ],
        'factories' => [
            'Zend\Permissions\Acl\Acl' => 'CmsAcl\Factory\AclFactory',
            'Zend\Permissions\Acl\Assertion\AssertionManager'
                => 'CmsAcl\Factory\AssertionPluginManagerFactory',
            'CmsAcl\CacheKeyGenerator' => 'CmsAcl\Factory\CacheKeyGeneratorFactory',
            'CmsAcl\Collector\RoleCollector' => 'CmsAcl\Factory\RoleCollectorFactory',
            'CmsAcl\Guard\GuardPluginManager'
                => 'CmsAcl\Factory\Guard\GuardPluginManagerFactory',
            'CmsAcl\Guards' => 'CmsAcl\Factory\Guard\GuardsFactory',
            'CmsAcl\Options\ModuleOptions' => 'CmsAcl\Factory\ModuleOptionsFactory',
            'CmsAcl\Resource\ProviderPluginManager'
                => 'CmsAcl\Factory\Resource\ProviderPluginManagerFactory',
            'CmsAcl\Resources' => 'CmsAcl\Factory\Resource\ProvidersFactory',
            'CmsAcl\Role\ProviderPluginManager'
                => 'CmsAcl\Factory\Role\ProviderPluginManagerFactory',
            'CmsAcl\Roles' => 'CmsAcl\Factory\Role\ProvidersFactory',
            'CmsAcl\Rule\ProviderPluginManager'
                => 'CmsAcl\Factory\Rule\ProviderPluginManagerFactory',
            'CmsAcl\Rules' => 'CmsAcl\Factory\Rule\ProvidersFactory',
            'CmsAcl\Service\AuthorizationService'
                => 'CmsAcl\Factory\AuthorizationServiceFactory',
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'cmsIsAllowed' => 'CmsAcl\View\Helper\IsAllowed',
        ],
        'factories' => [
            'CmsAcl\View\Helper\IsAllowed'
                => 'CmsAcl\Factory\View\Helper\IsAllowedHelperFactory',
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'zend-developer-tools/toolbar/cms-acl-role'
                => __DIR__ . '/../view/zend-developer-tools/toolbar/role.phtml',
        ],
        'template_path_stack' => [
            __NAMESPACE__ => __DIR__ . '/../view',
        ],
    ],
    'zenddevelopertools' => [
        'profiler' => [
            'collectors' => [
                'CmsAclRoles' => 'CmsAcl\Collector\RoleCollector',
            ],
        ],
        'toolbar' => [
            'entries' => [
                'CmsAclRoles' => 'zend-developer-tools/toolbar/cms-acl-role',
            ],
        ],
    ],
];
