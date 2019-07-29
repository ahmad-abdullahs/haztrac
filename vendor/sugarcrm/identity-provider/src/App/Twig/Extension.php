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

namespace Sugarcrm\IdentityProvider\App\Twig;

use Sugarcrm\IdentityProvider\App\Application;

use Sugarcrm\IdentityProvider\App\Twig\Functions\Tenant as TenantFunction;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Extension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @var Application
     */
    private $app;


    /**
     * Extension constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TenantFunction($this->app->getSession(), $this->app->getTenantRepository()),
        ];
    }

    /**
     * @return array|\Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('translate_array', [$this, 'translateArray']),
        ];
    }

    /**
     * @return array
     */
    public function getGlobals()
    {
        $config = $this->app->getConfig();

        return [
            'recaptcha_sitekey' => $config['recaptcha']['sitekey'],
            'honeypot_name' => $config['honeypot']['name'],
            'locales' => $config['locales'],
        ];
    }

    /**
     * @param array|string $value
     * @return array|string
     */
    public function translateArray($value)
    {
        $translator = $this->app->getTranslator();
        if (!is_array($value)) {
            return $translator->trans($value);
        }
        return array_map(function ($id) use ($translator) {
            return $translator->trans($id);
        }, $value);
    }
}
