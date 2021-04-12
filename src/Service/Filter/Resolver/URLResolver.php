<?php


namespace App\Service\Filter\Resolver;


use App\Service\Filter\Event\ResolveEvent;


class URLResolver
{

    /**
     * @param ResolveEvent $event
     */
    public function resolve(ResolveEvent $event)
    {
        $query = (array) $event->getRequest()->query->all();
        $event->setRawUrlItems($query);
        if(isset($query['filter'])){
            $filterParams = $query['filter'];
            $this->resolveFilterParams($filterParams, 'categories', $event);
            $this->resolveFilterParams($filterParams, 'tags', $event);
        }
        $this->setUrlItemParamDirectly($event, 'page');
        $this->setUrlItemParamDirectly($event, 'rpp');
        $this->setUrlItemParamDirectly($event, 'search');
    }

    protected function resolveFilterParams($filterParams, $filterType, ResolveEvent $event)
    {

        if(isset($filterParams[$filterType])){
            $filterValues = explode(",", $filterParams[$filterType]);
            $urlItems = $event->getUrlItems();
            $urlItems[$filterType] = $filterValues;
            $event->setUrlItems($urlItems);
        }
    }

    /**
     * @param ResolveEvent $event
     * @param $queryParamKey
     */
    public function setUrlItemParamDirectly(ResolveEvent $event, $queryParamKey): void
    {
        $query = (array) $event->getRequest()->query->all();
        $urlItems = $event->getUrlItems();
        if (isset($query[$queryParamKey])) {
            $urlItems[$queryParamKey] = $query[$queryParamKey];
            $event->setUrlItems($urlItems);

        }

    }
}