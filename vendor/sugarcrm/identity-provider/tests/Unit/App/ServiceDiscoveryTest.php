<?php
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/Resources/Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */

namespace Sugarcrm\IdentityProvider\Tests\Unit\App;

use Psr\Http\Message\ResponseInterface;
use Sugarcrm\IdentityProvider\App\ServiceDiscovery;

use GuzzleHttp\Client;

/**
 * Class TenantConfigurationTest
 * @package Sugarcrm\IdentityProvider\Tests\Unit\App
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\ServiceDiscovery
 */
class ServiceDiscoveryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $httpClient;

    /**
     * @var ServiceDiscovery|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * @var ResponseInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    protected $httpResponse;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->httpClient = $this->createMock(Client::class);
        $this->httpResponse = $this->createMock(ResponseInterface::class);

        $this->subject = $this->getMockBuilder(ServiceDiscovery::class)
            ->setConstructorArgs(['http://discovery/', '/v1/'])
            ->setMethods(['getHttpClient'])
            ->getMock();
    }

    /**
     * @return array
     */
    public function expectedReturns(): array
    {
        return [
            'emptyReturn' => [
                null,
                'foo',
                'bar',
                null,
                null,
            ],
            'servicesEmpty' => [
                [
                    'services' => [],
                ],
                'foo',
                'bar',
                null,
                null,
            ],
            'serviceNotFoundByName' => [
                [
                    'services' => [
                        [
                            'name' => 'console',
                            'type' => 'rest',
                            'endpoints' => [
                                [
                                    'url' => 'http://console',
                                    'region' => 'na'
                                ],
                                [
                                    'url' => 'http://console2',
                                    'region' => 'eu'
                                ],
                            ],
                        ],
                    ],
                ],
                'my-console',
                'na',
                'rest',
                null,
            ],
            'serviceNotFoundByRegion' => [
                [
                    'services' => [
                        [
                            'name' => 'console',
                            'type' => 'rest',
                            'endpoints' => [
                                [
                                    'url' => 'http://console',
                                    'region' => 'na'
                                ],
                                [
                                    'url' => 'http://console2',
                                    'region' => 'eu'
                                ],
                            ],
                        ],
                    ],
                ],
                'console',
                'asia',
                'rest',
                null,
            ],
            'serviceNotFoundByType' => [
                [
                    'services' => [
                        [
                            'name' => 'console',
                            'type' => 'rest',
                            'endpoints' => [
                                [
                                    'url' => 'http://console',
                                    'region' => 'na'
                                ],
                                [
                                    'url' => 'http://console2',
                                    'region' => 'eu'
                                ],
                            ],
                        ],
                    ],
                ],
                'console',
                'na',
                'grpc',
                null,
            ],
            'serviceFoundWhenTypeIsNotSpecified' => [
                [
                    'services' => [
                        [
                            'name' => 'console',
                            'type' => 'rest',
                            'endpoints' => [
                                [
                                    'url' => 'http://console',
                                    'region' => 'na'
                                ],
                                [
                                    'url' => 'http://console2',
                                    'region' => 'eu'
                                ],
                            ],
                        ],
                    ],
                ],
                'console',
                'eu',
                null,
                'http://console2',
            ],
            'serviceFoundAndTrimmed' => [
                [
                    'services' => [
                        [
                            'name' => 'console',
                            'type' => 'rest',
                            'endpoints' => [
                                [
                                    'url' => 'http://console/',
                                    'region' => 'na'
                                ],
                                [
                                    'url' => 'http://console2',
                                    'region' => 'eu'
                                ],
                            ],
                        ],
                    ],
                ],
                'console',
                'na',
                'rest',
                'http://console',
            ],
        ];
    }

    /**
     * @param $return
     * @param $serviceName
     * @param $region
     * @param $serviceType
     * @param $expected
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @covers ::getServiceURL
     * @dataProvider expectedReturns
     */
    public function testGetServiceURL($return, $serviceName, $region, $serviceType, $expected): void
    {
        $this->httpResponse->expects($this->once())
            ->method('getBody')
            ->willReturn(\GuzzleHttp\json_encode($return));
        $this->httpClient
            ->expects($this->once())
            ->method('request')
            ->with('GET', 'http://discovery/v1/services')
            ->willReturn($this->httpResponse);
        $this->subject->method('getHttpClient')->willReturn($this->httpClient);

        $url = $this->subject->getServiceURL($serviceName, $region, $serviceType);
        $this->assertEquals($expected, $url);
    }
}
