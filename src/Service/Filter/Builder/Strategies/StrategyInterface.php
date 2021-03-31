<?php


namespace App\Service\Filter\Builder\Strategies;


interface StrategyInterface
{
    public function run(array $blogs);
}