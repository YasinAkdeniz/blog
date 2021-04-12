<?php


namespace App\Service\Filter\Builder\Strategies;




use App\Entity\Blog;
use App\Entity\BlogCategory;

class CategoryStrategy extends AbstractStrategy
{
    protected $categoryList = [];

    /**
     * @param array $blogs
     * @param array $urlItems
     * @return array
     */
    public function run(array $blogs, array $urlItems, array $rawUrlItems)
    {
        /** @var Blog $blog */
        foreach ($blogs as $blog){
            $this->updateCategoryList($blog, $urlItems, $rawUrlItems);
        }
        return array_values($this->categoryList);
    }

    /**
     * @param Blog $blog
     * @param array $urlItems
     */
    protected function updateCategoryList(Blog $blog, $urlItems, $rawUrlItems)
    {
        /** @var BlogCategory $blogCategory */
        foreach ($blog->getBlogCategories() as $blogCategory){
            $categoryId = $blogCategory->getId();
            if(!isset($this->categoryList[$categoryId])){
                $this->categoryList[$blogCategory->getId()] = [
                    'id' => $categoryId,
                    'name' => $blogCategory->getName(),
                    'slug' => $this->getFilterSlug($blogCategory->getSlug(), $urlItems, $rawUrlItems, 'categories'),
                    'status' => $this->getStatus($blogCategory->getSlug(), $urlItems, 'categories'),
                    'count' => 1,
                ];
            } else{
                $this->categoryList[$categoryId]['count'] = $this->categoryList[$categoryId]['count'] + 1;
            }
        }
    }


}
