<?php

namespace App\Twig;

use App\Resolver\GeneralSettingResolver;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppTwigExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('value', [$this, 'getSettingValue']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            //new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    /**
     * @param GeneralSettingResolver $settings
     * @param string $key
     */
    public function getSettingValue($settings, $key)
    {
        return $settings->get($key);
    }
}
