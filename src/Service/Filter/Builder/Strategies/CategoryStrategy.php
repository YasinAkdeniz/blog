<?php


namespace App\Service\Filter\Builder\Strategies;




use App\Entity\Blog;
use App\Entity\BlogCategory;

class CategoryStrategy implements StrategyInterface
{
    const SLUG_PREFIX = '/blog_category/';
    protected $categoryList = [];

    /**
     * @param array $blogs
     * @return array
     */
    public function run(array $blogs)
    {
        /** @var Blog $blog */
        foreach ($blogs as $blog){
            $this->updateCategoryList($blog);
        }
        return array_values($this->categoryList);
    }

    /**
     * @param Blog $blog
     */
    protected function updateCategoryList(Blog $blog)
    {
        /** @var BlogCategory $blogCategory */
        foreach ($blog->getBlogCategories() as $blogCategory){
            $categoryId = $blogCategory->getId();
            if(!isset($this->categoryList[$categoryId])){
                $this->categoryList[$blogCategory->getId()] = [
                    'id' => $categoryId,
                    'name' => $blogCategory->getName(),
                    'slug' => self::SLUG_PREFIX . $blogCategory->getSlug(),
                    'count' => 1
                ];
            } else{
                $this->categoryList[$categoryId]['count'] = $this->categoryList[$categoryId]['count'] + 1;
            }
        }
    }
}
