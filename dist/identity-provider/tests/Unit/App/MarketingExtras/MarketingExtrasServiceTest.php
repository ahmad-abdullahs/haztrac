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

namespace Sugarcrm\IdentityProvider\Tests\Unit\App\MarketingExtras;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Sugarcrm\IdentityProvider\App\MarketingExtras\MarketingExtrasService;

/**
 * @coversDefaultClass \Sugarcrm\IdentityProvider\App\MarketingExtras\MarketingExtrasService
 */
class MarketingExtrasServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ClientInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $httpClient;

    private $httpResponse;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        $this->httpClient = $this->createMock(Client::class);
        $this->httpResponse = $this->createMock(ResponseInterface::class);
    }

    /**
     * @return array
     */
    public function getMarketingContentUrlProvider(): array
    {
        return [
            'emptyFlavorInConfigAndLanguage' => [
                'config' => [
                    'baseUrl' => 'http://marketing',
                ],
                'language' => '',
                'expectedMarketingEndpoint' => 'http://marketing',
                'returnedData' => false,
                'expectedContentUrl' => null,
            ],
            'emptyLanguageEmptyReturn' => [
                'config' => [
                    'baseUrl' => 'http://marketing',
                    'flavor' => 'ULT',
                ],
                'language' => '',
                'expectedMarketingEndpoint' => 'http://marketing?flavor=ULT',
                'returnedData' => json_encode([]),
                'expectedContentUrl' => null,
            ],
            'fullDataNoKeyInJson' => [
                'config' => [
                    'baseUrl' => 'http://marketing',
                    'flavor' => 'ULT',
                ],
                'language' => 'en_US',
                'expectedMarketingEndpoint' => 'http://marketing?language=en_US&flavor=ULT',
                'returnedData' => json_encode(['test' => '1']),
                'expectedContentUrl' => null,
            ],
            'fullDataNormalJson' => [
                'config' => [
                    'baseUrl' => 'http://marketing',
                    'flavor' => 'ULT',
                ],
                'language' => 'en_US',
                'expectedMarketingEndpoint' => 'http://marketing?language=en_US&flavor=ULT',
                'returnedData' => json_encode(['content_url' => 'http://content']),
                'expectedContentUrl' => 'http://content',
            ],
        ];
    }

    /**
     * @param array $config
     * @param string $language
     * @param $expectedMarketingEndpoint
     * @param $returnedData
     * @param $expectedContentUrl
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @dataProvider getMarketingContentUrlProvider
     *
     * @covers ::getMarketingContentUrl
     */
    public function testGetMarketingContentUrl(
        array $config,
        string $language,
        $expectedMarketingEndpoint,
        $returnedData,
        $expectedContentUrl
    ): void {
        /** @var MarketingExtrasService $marketingExtras */
        $marketingExtras = $this->getMockBuilder(MarketingExtrasService::class)
            ->setConstructorArgs([$config, $language])
            ->setMethods(['getHttpClient'])->getMock();

        $marketingExtras->method('getHttpClient')->willReturn($this->httpClient);

        $this->httpClient->expects($this->once())->method('request')
            ->with('GET', $expectedMarketingEndpoint)
            ->willReturn($this->httpResponse);

        $this->httpResponse->method('getBody')->willReturn($returnedData);

        $this->assertEquals($expectedContentUrl, $marketingExtras->getMarketingContentUrl());
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @covers ::getMarketingContentUrl
     */
    public function testGetMarketingContentUrlWithEmptyConfig(): void
    {
        /** @var MarketingExtrasService $marketingExtras */
        $marketingExtras = $this->getMockBuilder(MarketingExtrasService::class)
            ->setConstructorArgs([[], ''])
            ->setMethods(['getHttpClient'])->getMock();

        $this->assertNull($marketingExtras->getMarketingContentUrl());
    }
}
