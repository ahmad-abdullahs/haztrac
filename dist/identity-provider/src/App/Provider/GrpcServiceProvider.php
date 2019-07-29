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

namespace Sugarcrm\IdentityProvider\App\Provider;

use Google\Auth\CredentialsLoader;
use Grpc\ChannelCredentials;
use League\OAuth2\Client\Token\AccessToken;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Sugarcrm\Apis\Iam\App\V1alpha\AppAPIClient;
use Sugarcrm\Apis\Iam\User\V1alpha\UserAPIClient;
use Sugarcrm\IdentityProvider\App\ServiceDiscovery;
use Sugarcrm\IdentityProvider\Authentication\Exception\RuntimeException;

/**
 * Class GrpcServiceProvider
 * @package Sugarcrm\IdentityProvider\App\Provider
 */
class GrpcServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        if ($app['config']['grpc']['disabled']) {
            $app['grpc.discovery'] = null;
            $app['grpc.userapi'] = null;
            $app['grpc.appapi'] = null;
            return;
        }

        $requestMetadataUpdater = function () use ($app) {
            /** @var AccessToken $accessToken */
            $accessToken = $app['oAuth2Service']->getAccessToken();
            return [
                CredentialsLoader::AUTH_METADATA_KEY => ['Bearer ' . $accessToken],
            ];
        };

        /**
         * Gets URL for service
         */
        $app['grpc.service.url'] = $app->protect(function (string $serviceName) use ($app) {
            if (null === $app['config']['idm']['region']) {
                throw new RuntimeException('Region for the entire login service is absent. Set it in config.');
            }

            return $app['grpc.discovery']->getServiceURL($serviceName, $app['config']['idm']['region'], 'grpc');
        });

        /**
         * Create connection credentials
         */
        $app['grpc.service.credentials'] = $app->protect(function (string $scheme) {
            if ($scheme === 'https') {
                return ChannelCredentials::createSsl(null);
            }

            return ChannelCredentials::createInsecure();
        });

        $app['grpc.discovery'] = function ($app) {
            $errMsg = 'Discovery service %s is absent. Please set value in config';
            $discoURL = $app['config']['discovery']['url'] ?? null;
            if (!$discoURL) {
                throw new RuntimeException(sprintf($errMsg, 'URL'));
            }
            $discoVersion = $app['config']['discovery']['version'] ?? null;
            if (!$discoVersion) {
                throw new RuntimeException(sprintf($errMsg, 'version'));
            }
            return new ServiceDiscovery($discoURL, $discoVersion);
        };

        $app['grpc.userapi'] = function ($app) use ($requestMetadataUpdater) {
            $userApiUrl = $app['grpc.service.url']('iam-user:v1alpha');
            $hostInfo = parse_url($userApiUrl);
            $grpcHost = isset($hostInfo['port']) ? $hostInfo['host'] . ':' . $hostInfo['port'] : $hostInfo['host'];

            return new UserAPIClient(
                $grpcHost,
                [
                    'credentials' => $app['grpc.service.credentials']($hostInfo['scheme'] ?? 'http'),
                    'update_metadata' => $requestMetadataUpdater,
                ]
            );
        };

        $app['grpc.appapi'] = function ($app) use ($requestMetadataUpdater) {
            $appApiUrl = $app['grpc.service.url']('iam-app:v1alpha');
            $hostInfo = parse_url($appApiUrl);
            $grpcHost = isset($hostInfo['port']) ? $hostInfo['host'] . ':' . $hostInfo['port'] : $hostInfo['host'];

            return new AppAPIClient(
                $grpcHost,
                [
                    'credentials' => $app['grpc.service.credentials']($hostInfo['scheme'] ?? 'http'),
                    'update_metadata' => $requestMetadataUpdater,
                ]
            );
        };
    }
}
