<?php


namespace App\Service\Filter\Builder\Strategies;


abstract class AbstractStrategy
{
    abstract public function run(array $blogs, array $urlItems, array $rawUrlItems);

    /**
     * @param $slug
     * @param $urlItems
     * @param $filterKey
     * @return string
     */
    protected function getFilterSlug($slug, $urlItems, $rawUrlItems, $filterKey): string
    {
        $filterSlug = "";
        $selectedFilterElementSlugs = [];
        if(isset($urlItems[$filterKey])){
            $selectedFilterElementSlugs = $urlItems[$filterKey];
        }

        if(in_array($slug, $selectedFilterElementSlugs)){
            unset($selectedFilterElementSlugs[array_search($slug, $selectedFilterElementSlugs)]);
        }else{
            $selectedFilterElementSlugs[] = $slug;
        }
        if(!empty($selectedFilterElementSlugs)){
            $rawUrlItems['filter'][$filterKey] = implode(",", $selectedFilterElementSlugs);
        }else{
            unset($rawUrlItems['filter'][$filterKey]);
        }
        if(!empty($rawUrlItems)){
            $filterSlug = "?" . urldecode(http_build_query($rawUrlItems));
        }


        return $filterSlug;
    }

    /**
     * @param $slug
     * @param $urlItems
     * @param $filterKey
     * @return string
     */
    protected function getStatus($slug, $urlItems, $filterKey)
    {
        $status = "unselected";
        $selectedFilterElementSlugs = [];
        if(isset($urlItems[$filterKey])){
            $selectedFilterElementSlugs = $urlItems[$filterKey];
        }

        if(in_array($slug, $selectedFilterElementSlugs)){
            $status = "selected";
        }
        return $status;
    }
}