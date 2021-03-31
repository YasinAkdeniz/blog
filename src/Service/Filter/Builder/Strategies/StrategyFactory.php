<?php


namespace App\Service\Filter\Builder\Strategies;


class StrategyFactory
{
    public static function create($type)
    {
        $basePath = 'App\\Service\\Filter\\Builder\\Strategies\\';
        $className = $basePath . ucfirst($type) . 'Strategy';
        if(!class_exists($className)){
            throw new \Exception("Böyle bir filtre stratejisi yok");
        }
        return new $className();
    }
}