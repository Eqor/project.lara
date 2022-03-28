<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BlogPostObserver
{
    /**
     * Handle the blog post "creating" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function creating(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "updating" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function updating(BlogPost $blogPost)
    {
//        $test[] = $blogPost->isDirty();
//        $test[] = $blogPost->isDirty('is_published');
//        $test[] = $blogPost->isDirty('user_id');
//        $test[] = $blogPost->getAttribute('is_published');
//        $test[] = $blogPost->is_published;
//        $test[] = $blogPost->getOriginal('is_published');
//        dd($test);
        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
    }

    /**
     *  Если дата публикации не установлена и происходит установка флага - Опубликовано,
     * то устанавливаем текущую дату публикации
     * @param BlogPost $blogPost
     * @return Carbon
     */
    protected function setPublishedAt(BlogPost $blogPost)
    {
        if (empty($blogPost->published_at && $blogPost->is_published))
        {
          return  $blogPost->published_at = Carbon::now();
        }

    }

    /**
     * Если skug не установлен, то pflftv slug  на основе title
     * @param BlogPost $blogPost
     */
    protected function setSlug(BlogPost $blogPost)
    {
        if (empty($blogPost['slug'])) {
            $blogPost['slug'] = Str::slug($blogPost['title']);
        }

    }

    /**
     * Handle the blog post "deleting" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function deleting(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "restoring" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function restoring(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "force deleting" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function forceDeleting(BlogPost $blogPost)
    {
        //
    }
}
