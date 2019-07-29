<?php
/**
 * Created by PhpStorm.
 * User: famchyk
 * Date: 6/8/18
 * Time: 10:42
 */

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\Authentication\ConfigAdapter;

use PHPUnit\Framework\TestCase;
use Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\LocalConfigAdapter;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\Authentication\ConfigAdapter\LocalConfigAdapter
 */
final class LocalConfigAdapterTest extends TestCase
{

    /**
     * @var LocalConfigAdapter
     */
    private $configAdapter;

    public function getConfigDataProvider(): array
    {
        $baseConfig = [
            'password_requirements' => [
                'minimum_length' => '8',
                'maximum_length' => '16',
                'require_upper' => 0,
                'require_lower' => 1,
                'require_number' => null,
                'require_special' => '1',
            ],
            'password_expiration' => [
                'time' => ['seconds' => 0],
                'attempt' => 0,
            ],
            'login_lockout' => [
                'type' => '0',
                'attempt' => '0',
                'time' => ['seconds' => 0],
            ],
        ];
        $partiallyEmptyConfig = $baseConfig;
        unset($partiallyEmptyConfig['login_lockout']);

        $baseExpectsConfig = [
            'password_requirements' => [
                'minimum_length' => 8,
                'maximum_length' => 16,
                'require_upper' => false,
                'require_lower' => true,
                'require_number' => false,
                'require_special' => true,
            ],
            'password_expiration' => [
                'type' => 0,
                'time' => 0,
                'attempt' => 0,
            ],
            'login_lockout' => [
                'type' => LocalConfigAdapter::LOCKOUT_DISABLED,
                'attempt' => 0,
                'time' => 0,
            ],
        ];

        return [
            'empty' => [
                'encoded' => json_encode(null),
                'expects' => [],
            ],
            'partially_empty' => [
                'encoded' => json_encode($partiallyEmptyConfig),
                'expects' => $baseExpectsConfig,
            ],
            'base' => [
                'encoded' => json_encode($baseConfig),
                'expects' => $baseExpectsConfig,
            ],
            'passwordExpirationTime' => [
                'encoded' => json_encode(
                    array_merge(
                        $baseConfig,
                        [
                            'password_expiration' =>
                                [
                                    'time' => ['seconds' => 3600],
                                    'attempt' => false,
                                ],
                        ]
                    )
                ),
                'expects' => array_merge(
                    $baseExpectsConfig,
                    [
                        'password_expiration' =>
                            [
                                'type' => LocalConfigAdapter::PASSWORD_EXPIRATION_TYPE_TIME,
                                'time' => 3600,
                                'attempt' => 0,
                            ],
                    ]
                ),
            ],
            'passwordExpirationAttempt' => [
                'encoded' => json_encode(
                    array_merge(
                        $baseConfig,
                        [
                            'password_expiration' =>
                                [
                                    'time' => false,
                                    'attempt' => 500,
                                ],
                        ]
                    )
                ),
                'expects' => array_merge(
                    $baseExpectsConfig,
                    [
                        'password_expiration' =>
                            [
                                'type' => LocalConfigAdapter::PASSWORD_EXPIRATION_TYPE_LOGIN,
                                'time' => 0,
                                'attempt' => 500,
                            ],
                    ]
                ),
            ],
            'passwordRegexpNotPresentInResultConfig' => [
                'encoded' => json_encode(
                    array_merge(
                        $baseConfig,
                        [
                            'password_requirements' => [
                                'minimum_length' => 8,
                                'maximum_length' => 16,
                                'require_upper' => false,
                                'require_lower' => true,
                                'require_number' => false,
                                'require_special' => true,
                                'password_regex' => '/Some regexp/',
                                'regex_description' => 'Some description ',
                            ],
                            'password_expiration' =>
                                [
                                    'time' => false,
                                    'attempt' => 500,
                                ],
                        ]
                    )
                ),
                'expects' => array_merge(
                    $baseExpectsConfig,
                    [
                        'password_expiration' =>
                            [
                                'type' => LocalConfigAdapter::PASSWORD_EXPIRATION_TYPE_LOGIN,
                                'time' => 0,
                                'attempt' => 500,
                            ],
                    ]
                ),
            ]
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
        $this->configAdapter = new LocalConfigAdapter();
    }
}
