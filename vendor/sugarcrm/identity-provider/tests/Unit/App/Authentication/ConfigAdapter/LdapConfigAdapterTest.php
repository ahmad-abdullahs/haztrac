<?php
/**
 * Created by PhpStorm.
 * User: famchyk
 * Date: 6/8/18
 * Time: 11:55
 */

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Authentication\ConfigAdapter;

use PHPUnit\Framework\TestCase;
use Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\LdapConfigAdapter;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\LdapConfigAdapter
 */
final class LdapConfigAdapterTest extends TestCase
{
    /**
     * @var LdapConfigAdapter
     */
    private $configAdapter;

    public function getConfigDataProvider(): array
    {
        $baseExpects = [
            'adapter_config' => [
                'host' => '127.0.0.1',
                'port' => 389,
                'options' => [
                    'network_timeout' => 60,
                    'timelimit' => 60,
                ],
                'encryption' => 'none',
            ],
            'adapter_connection_protocol_version' => 3,
            'baseDn' => 'baseDn-value',
            'uidKey' => 'uidKey-value',
            'filter' => '({uid_key}={username})',
            'dnString' => null,
            'entryAttribute' => 'entryAttribute-value',
            'auto_create_users' => false,
        ];
        $config = [
            'auto_create_users' => 0,
            'server' => '127.0.0.1:389',
            'user_dn' => 'baseDn-value',
            'user_filter' => '',
            'login_attribute' => 'uidKey-value',
            'bind_attribute' => 'entryAttribute-value',
        ];

        $configWithFilterExpected = [
            'adapter_config' => [
                'host' => '127.0.0.1',
                'port' => 389,
                'options' => [
                    'network_timeout' => 60,
                    'timelimit' => 60,
                ],
                'encryption' => 'none',
            ],
            'adapter_connection_protocol_version' => 3,
            'baseDn' => 'baseDn-value',
            'uidKey' => 'uidKey-value',
            'filter' => '(&({uid_key}={username})(objectClass=person))',
            'dnString' => null,
            'entryAttribute' => 'entryAttribute-value',
            'auto_create_users' => false,
        ];

        $configWithFilter = [
            'auto_create_users' => 0,
            'server' => '127.0.0.1:389',
            'user_dn' => 'baseDn-value',
            'user_filter' => '(objectClass=person)',
            'login_attribute' => 'uidKey-value',
            'bind_attribute' => 'entryAttribute-value',
        ];

        return [
            'empty' => [
                'encoded' => json_encode(null),
                'expects' => [],
            ],
            'base' => [
                'encoded' => json_encode($config),
                'expects' => $baseExpects,
            ],
            'filter' => [
                'encoded' => json_encode($configWithFilter),
                'expects' => $configWithFilterExpected,
            ],
            'ssl' => [
                'encoded' => json_encode(
                    array_merge(
                        $config,
                        [
                            'server' => 'ldaps://some.ldap.host:388',
                        ]
                    )
                ),
                'expects' => array_merge(
                    $baseExpects,
                    [
                        'adapter_config' => [
                            'host' => 'some.ldap.host',
                            'port' => 388,
                            'options' => [
                                'network_timeout' => 60,
                                'timelimit' => 60,
                            ],
                            'encryption' => 'ssl',
                        ]
                    ]
                ),
            ],
            'authentication' => [
                'encoded' => json_encode(
                    array_merge(
                        $config,
                        [
                            'authentication' => true,
                            'authentication_user_dn' => 'authentication_user_dn_value',
                            'authentication_password' => 'authentication_password-value',
                        ]
                    )
                ),
                'expects' => array_merge(
                    $baseExpects,
                    [
                        'searchDn' => 'authentication_user_dn_value',
                        'searchPassword' => 'authentication_password-value',
                    ]
                ),
            ],
            'group' => [
                'encoded' => json_encode(
                    array_merge(
                        $config,
                        [
                            'group_membership' => 1,
                            'group_dn' => 'group_dn-value',
                            'group_name' => 'group_name-value',
                            'group_attribute' => 'group_attribute-value',
                            'user_unique_attribute' => 'user_unique_attribute-value',
                            'include_user_dn' => 0,
                        ]
                    )
                ),
                'expects' => array_merge(
                    $baseExpects,
                    [
                        'groupMembership' => true,
                        'groupDn' => 'group_name-value,group_dn-value',
                        'groupAttribute' => 'group_attribute-value',
                        'userUniqueAttribute' => 'user_unique_attribute-value',
                        'includeUserDN' => false,
                    ]
                ),
            ],
        ];
    }

    /**
     * @dataProvider getConfigDataProvider
     * @covers ::getConfig
     * @param string $encoded
     * @param array $expects
     */
    public function testGetConfig(string $encoded, array $expects): void
    {
        $result = $this->configAdapter->getConfig($encoded);

        $this->assertEquals($expects, $result);
        $this->assertSame($expects, $result);
    }

    protected function setUp()
    {
        parent::setUp();
        $this->configAdapter = new LdapConfigAdapter();
    }
}
