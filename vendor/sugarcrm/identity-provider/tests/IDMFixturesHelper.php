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

namespace Sugarcrm\IdentityProvider\Tests;

use OneLogin\Saml2\Constants;

/**
 * Helper class to retrieve necessary certificates for tests.
 * Class ConfigHelper
 * @package Sugarcrm\IdentityProvider\Tests
 */
class IDMFixturesHelper
{
    /**
     * Service provider private key.
     *
     * @return string
     */
    public static function getSpPrivateKey()
    {
        return file_get_contents(__DIR__.'/../app/config/certs/travis.key');
    }

    /**
     * Service provider public key.
     *
     * @return string
     */
    public static function getSpPublicKey()
    {
        return file_get_contents(__DIR__.'/../app/config/certs/travis.crt');
    }

    /**
     * Gets x509 key for service.
     *
     * @param string $idp
     * @return string
     */
    public static function getIdpX509Key($idp)
    {
        return file_get_contents(__DIR__.'/Functional/SAML/fixtures/certs/'.$idp.'/x509.crt');
    }

    /**
     * Gets SAML xml request/response from fixtures.
     *
     * @param string $path
     * @return string
     */
    public static function getSAMLFixture($path)
    {
        return file_get_contents(__DIR__.'/Functional/SAML/fixtures/'.$path);
    }

    /**
     * Gets valid ADFS config.
     *
     * @return array
     */
    public static function getADFSParameters()
    {
        return [
            'strict' => false,
            'debug' => false,
            'sp' => [
                'entityId' => 'https://localhost/saml/metadata',
                'assertionConsumerService' => [
                    'url' => 'https://localhost/saml/acs',
                    'binding' => Constants::BINDING_HTTP_POST,
                ],
                'singleLogoutService' => [
                    'url' => 'https://localhost/saml/logout',
                    'binding' => Constants::BINDING_HTTP_REDIRECT,
                ],
                'NameIDFormat' => Constants::NAMEID_EMAIL_ADDRESS,
                'x509cert' => static::getSpPublicKey(),
                'privateKey' => static::getSpPrivateKey(),
            ],

            'idp' => [
                'entityId' => 'https://vmstack104.test.com/adfs/services/trust',
                'singleSignOnService' => [
                    'url' => 'https://vmstack104.test.com/adfs/ls',
                    'binding' => Constants::BINDING_HTTP_REDIRECT,
                ],
                'singleLogoutService' => [
                    'url' => 'https://vmstack104.test.com/adfs/ls',
                    'binding' => Constants::BINDING_HTTP_REDIRECT,
                ],
                'x509cert' => static::getIdpX509Key('ADFS'),
            ],
            'security' => [
                'lowercaseUrlencoding' => true,
                'authnRequestsSigned' => true,
                'signatureAlgorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
                'logoutRequestSigned' => true,
                'validateRequestId' => true,
            ],
        ];
    }

    /**
     * Gets valid Okta config.
     *
     * @return array
     */
    public static function getOktaParameters()
    {
        return [
            'strict' => false,
            'debug' => false,
            'sp' => [
                'entityId' => 'http://localhost:8000/saml/metadata',
                'assertionConsumerService' => [
                    'url' => 'http://localhost:8000/saml/acs',
                    'binding' => Constants::BINDING_HTTP_POST,
                ],
                'singleLogoutService' => [
                    'url' => 'http://localhost:8000/saml/logout',
                    'binding' => Constants::BINDING_HTTP_REDIRECT,
                ],
                'NameIDFormat' => Constants::NAMEID_EMAIL_ADDRESS,
                'x509cert' => static::getSpPublicKey(),
                'privateKey' => static::getSpPrivateKey(),
            ],

            'idp' => [
                'entityId' => 'http://www.okta.com/exk9f6zk3cchXSMkP0h7',
                'singleSignOnService' => [
                    'url' => 'https://dev-432366.oktapreview.com/app/sugarcrmdev432366_sugarcrmidmdev_1/exk9f6zk3cchXSMkP0h7/sso/saml',
                    'binding' => Constants::BINDING_HTTP_REDIRECT,
                ],
                'singleLogoutService' => [
                    'url' => 'https://dev-432366.oktapreview.com/app/sugarcrmdev432366_sugarcrmidmdev_1/exk9f6zk3cchXSMkP0h7/slo/saml',
                    'binding' => Constants::BINDING_HTTP_POST,
                ],
                'x509cert' => static::getIdpX509Key('Okta'),
            ],
            'security' => [
                'logoutRequestSigned' => true,
                'wantMessagesSigned' => true,
                'signatureAlgorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
                'validateRequestId' => true,
            ],
        ];
    }
    /**
     * Gets valid OneLogin config.
     *
     * @return array
     */
    public static function getOneLoginParameters()
    {
        return [
            'strict' => false,
            'debug' => false,
            'sp' => [
                'entityId' => 'idpdev',
                'assertionConsumerService' => [
                    'url' => 'http://localhost:8000/saml/acs',
                    'binding' => Constants::BINDING_HTTP_POST,
                ],
                'singleLogoutService' => [
                    'url' => 'http://localhost:8000/saml/logout',
                    'binding' => Constants::BINDING_HTTP_REDIRECT,
                ],
                'NameIDFormat' => Constants::NAMEID_EMAIL_ADDRESS,
                'x509cert' => static::getSpPublicKey(),
                'privateKey' => static::getSpPrivateKey(),
            ],

            'idp' => [
                'entityId' => 'https://app.onelogin.com/saml/metadata/622315',
                'singleSignOnService' => [
                    'url' => 'https://sugarcrm-idmeloper-dev.onelogin.com/trust/saml2/http-post/sso/622315',
                    'binding' => Constants::BINDING_HTTP_REDIRECT,
                ],
                'singleLogoutService' => [
                    'url' => 'https://sugarcrm-idmeloper-dev.onelogin.com/trust/saml2/http-redirect/slo/622315',
                    'binding' => Constants::BINDING_HTTP_REDIRECT,
                ],
                'x509cert' => static::getIdpX509Key('OneLogin'),
            ],
            'security' => [
                'validateRequestId' => true,
            ],
        ];
    }

    /**
     * Returns a valid JWT token with:
     * 'aud' => 'audTest',
     * 'exp' => 1529826678,
     * 'jti' => 'jtiTest',
     * 'redir' => 'http://sugarcrm.test/auth',
     * 'scp' => ['core', 'hydra'],
     *
     * travis.key used for sign.
     *
     * @return string
     */
    /**
     * Returns a valid JWT token with:
     * 'aud' => 'audTest',
     * 'exp' => 1529826678,
     * 'jti' => 'jtiTest',
     * 'redir' => 'http://sugarcrm.test/auth',
     * 'scp' => ['core', 'hydra'],
     *
     * travis.key used for sign.
     *
     * @return string
     */
    public static function getValidJWT()
    {
        return 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpYXQiOjE1Mjk5MTIwMTcsImV4cCI6MTcwMjcxMjAxNywiYXVkIjoiYXVkVGV' .
            'zdCIsImp0aSI6Imp0aVRlc3QiLCJzY3AiOlsiY29yZSIsImh5ZHJhIl0sImlkX2V4dCI6W10sImF0X2V4dCI6W10sInJlZGlyIjoiaH' .
            'R0cDpcL1wvc3VnYXJjcm0udGVzdFwvYXV0aCJ9.Umz66v7dxsYHu6L1vktx0B9Apvfj4hbu1jeyWbqDbfxuPPlrWfq1DyemyzyxgMhf' .
            'HMTWKHI6TDoF7M4s6RJaTOW2SAjorkciGp-eZtytaaxjnnr14YNDLNTHqBZ5HpT6jWuDd70di75DWx9aNDYiR8SpYHRN8DkcCGlten9' .
            'p5xXaX-uwMEj0T43FK4n7ncNIVJtkvMCuIrr1y0KPq8w1lw1JlIUEoUfFLAffwCeLDmuZKAZzIi1_BbmbZKlwWPAqN7UU99XGLUtgvH' .
            'YzlffeFs8nWDuj_0HNESP0mZOmsMOV3OFitqZjMu7QwSVyT2OWivaH4IvrajHhYIEq3umBnQ';
    }

    /**
     * Returns a expired JWT token.
     *
     * @return string
     */
    public static function getExpiredJWT()
    {
        return 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.'.
            'eyJhdWQiOiJhdWRUZXN0IiwiZXhwIjoxNTAzODIzNjEyLCJqdGkiOiJqdGlUZXN0IiwicmVkaXIiOiJodHRwOlwvXC9zdWdhcmNybS50'.
            'ZXN0XC9hdXRoIiwic2NwIjpbImNvcmUiLCJoeWRyYSJdfQ.mOVKc1qgbKr8CWg7r-J2yLTbrHTnZFISVvM7PKXY8gYMMs1ykO46N_GDY'.
            'qWvSMLqoCuvcm2jsWeXGkZwL2RDXv4sRwc_CLsDN_9WdtLQ7Wot7jeRopH1lm4UEsexyg51D24dvX48LRTFiLkI6vQvVhNb_uIt17i_D'.
            '7nBtDIv2NtHTDCGmkIveHhlnfTYT0BKYVLPGfJRQypQW1RFItIhK9_sSFEDFQeiXqfbSKf9Q0-XenMrsQEzx0k1gg8tCTYVtYFb_pZnR'.
            'wkawBiHGemD0g3pX_XC-CMBS5wqzV7C8ZSNegC4moB8FnX49X7LwYAdifEMYWsq7FCKqsNlXnCbxA';
    }

    /**
     * Returns JWT key that was signed by another key.
     *
     * @return string
     */
    public static function getJWTSignedByAnotherKey()
    {
        return 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.'.
            'eyJhdWQiOiJjM2I0OWNmMC04OGU0LTRmYWEtOTQ4OS0yOGQ1Yjg5NTc4NTgiLCJleHAiOjE0NjQ1MTU0ODIsImp0aSI6IjNmYWRlN2Nj'.
            'LTdlYTItNGViMi05MGI1LWY5OTUwNTI4MzgyOSIsInJlZGlyIjoiaHR0cHM6Ly8xOTIuMTY4Ljk5LjEwMDo0NDQ0L29hdXRoMi9hdXRo'.
            'P2NsaWVudF9pZD1jM2I0OWNmMC04OGU0LTRmYWEtOTQ4OS0yOGQ1Yjg5NTc4NThcdTAwMjZyZXNwb25zZV90eXBlPWNvZGVcdTAwMjZz'.
            'Y29wZT1jb3JlK2h5ZHJhXHUwMDI2c3RhdGU9d2V3dXBoa2d5d2h0bGRzbWFpbmVma3l4XHUwMDI2bm9uY2U9dXFmamp6ZnRxcGpjY2R2'.
            'eGx0YXBvc3JpIiwic2NwIjpbImNvcmUiLCJoeWRyYSJdfQ.KpLBotIEE4izVSAjLOeCCfm_wYZ7UWSCA81akr6Ci1yycKs8e_bhBYdST'.
            'hy8JW3bAvofNcZ0v48ov9KxZVegWm8GuNbBEcNvKeiyW_8PiJXWE92YsMv-tDIL3VFPOp0469FmDLsSg5ohsFj5S89FzykNYfVxLPBAF'.'
            cAS_JElWbo';
    }
}
