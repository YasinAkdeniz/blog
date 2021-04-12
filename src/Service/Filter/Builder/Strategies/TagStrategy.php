<?php


namespace App\Service\Filter\Builder\Strategies;


use App\Entity\Blog;
use App\Entity\BlogTag;

class TagStrategy extends AbstractStrategy
{
    protected $tagList = [];

    public function run(array $blogs, array $urlItems, array $rawUrlItems)
    {
        foreach ($blogs as $blog){
           $this->updateTagList($blog, $urlItems, $rawUrlItems);
        }
        return array_values($this->tagList) ;
    }

    protected function updateTagList(Blog $blog, $urlItems, $rawUrlItems)
    {
        /** @var BlogTag $blogTag */
        foreach ($blog->getBlogTags() as $blogTag) {
            $tagId = $blogTag->getId();
            if (!isset($this->tagList[$tagId])){
                $this->tagList[$blogTag->getId()] = [
                    'id' => $tagId,
                    'slug'=> $this->getFilterSlug($blogTag->getSlug(), $urlItems, $rawUrlItems,'tags'),
                    'name' => $blogTag->getTitle(),
                    'status' => $this->getStatus($blogTag->getSlug(), $urlItems, 'tags'),
                    'count' => 1
                ];
            }else
                $this->tagList[$tagId]['count'] = $this->tagList[$tagId]['count'] + 1;

        }
    }

}