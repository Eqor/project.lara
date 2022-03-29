<?php

namespace App\Observers;

use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogCategoryObsever
{
    /**
     * Handle the blog category "created" event.
     *
     * @param  BlogCategory  $blogCategory
     * @return void
     */
    public function created(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * @param BlogCategory $blogCategory
     */
    public function creating(BlogCategory $blogCategory)
    {
        $this->setSlug($blogCategory);

    }

    /**
     * @param BlogCategory $model
     */
    protected function setSlug(BlogCategory $blogCategory)
    {
        if (empty($blogCategory['slug'])) {
            $blogCategory['slug'] = Str::slug($blogCategory['title']);
        }
    }

    /**
     * Handle the blog category "updated" event.
     *
     * @param  BlogCategory  $blogCategory
     * @return void
     */
    public function updated(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * @param BlogCategory $blogCategory
     */
    public function updating(BlogCategory $blogCategory)
    {

        $this->setSlug($blogCategory);

    }

    /**
     * Handle the blog category "deleted" event.
     *
     * @param  BlogCategory  $blogCategory
     * @return void
     */
    public function deleted(BlogCategory $blogCategory)
    {

    }

    /**
     * @param BlogCategory $blogCategory
     *
     */
    public function deleting(BlogCategory $blogCategory)
    {

    }



    /**
     * Handle the blog category "force deleted" event.
     *
     * @param  BlogCategory  $blogCategory
     * @return void
     */
    public function forceDeleted(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * @param BlogCategory $blogCategory
     */
    public function forceDeliting(BlogCategory $blogCategory)
    {

    }
}
