<?php


namespace App\Service\Filter\Builder\Strategies;


use App\Entity\Blog;
use App\Entity\BlogTag;

class TagStrategy implements StrategyInterface
{
    const SLUG_PREFIX = '/blog_tag/';
    protected $tagList = [];

    public function run(array $blogs)
    {
        foreach ($blogs as $blog){
           $this->updateTagList($blog);
        }
        return array_values($this->tagList) ;
    }

    protected function updateTagList(Blog $blog)
    {
        /** @var BlogTag $blogTag */
        foreach ($blog->getBlogTags() as $blogTag) {
            $tagId = $blogTag->getId();
            if (!isset($this->tagList[$tagId])){
                $this->tagList[$blogTag->getId()] = [
                    'id' => $tagId,
                    'slug'=> self::SLUG_PREFIX. $blogTag->getSlug(),
                    'name' => $blogTag->getTitle(),
                    'count' => 1
                ];
            }else
                $this->tagList[$tagId]['count'] = $this->tagList[$tagId]['count'] + 1;

        }
    }

}