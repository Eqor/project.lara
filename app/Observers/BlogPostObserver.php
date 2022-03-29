<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BlogPostObserver
{
    /**
     * Handle the blog before "creating" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function creating(BlogPost $blogPost)
    {
        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
        $this->setHtml($blogPost);
        $this->setUser($blogPost);
    }

    /**
     * @param BlogPost $blogPost
     */
    protected function setHtml(BlogPost $blogPost)
    {
        if ($blogPost->isDirty('content_raw')) {
            $blogPost->content_html = $blogPost->content_raw;
        }

    }

    /**
     * Если не указан user_id, то устанавливаем поле по умолчанию
     * @param BlogPost $blogPost
     */
    protected function setUser(BlogPost $blogPost)
    {
        $blogPost->user_id = auth()->id() ?? BlogPost::UNKNOWN_USER;

    }
    /**
     * Handle the blog post "updating" event.
     *
     * @param BlogPost $blogPost
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
     * @return Carbon|string
     *
     */
    protected function setPublishedAt(BlogPost $blogPost)
    {
        if (empty($blogPost->published_at && $blogPost->is_published)) {
            return $blogPost->published_at = Carbon::now();
        }
        return $blogPost->published_at;

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
     * @param BlogPost $blogPost
     * @return void
     */
    public function deleting(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "restoring" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function restoring(BlogPost $blogPost)
    {
        //
    }

    /**
     * Handle the blog post "force deleting" event.
     *
     * @param BlogPost $blogPost
     * @return void
     */
    public function forceDeleting(BlogPost $blogPost)
    {
        //
    }
}
