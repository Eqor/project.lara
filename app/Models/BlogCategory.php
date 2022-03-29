<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogCategory
 *
 * @package App/Models
 *
 * @property-read BlogCategory $parentCategory
 * @property-read string       $parentTitle
 * @mixin Model
 */
class BlogCategory extends Model
{
    use SoftDeletes;
    const ROOT = 1;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'description',
    ];

    /**
     * Получить родительскую категория
     * @return BlogCategory
     */
    public function parentCategory()
    {
        return $this->belongsTo(BlogCategory::class,'parent_id', 'id');
    }

    /**
     * Пример аксессора (Accessor)
     * @url https://laravel.su/docs/8.x/eloquent-mutators
     * @return string
     */
    public function getParentTitleAttribute()
    {
        return  $this->parentCategory->title
            ?? ($this->isRoot()
                ? 'Корень'
                : '???');

    }

    /**
     * Является ли текущий объект корневым
     * @return bool
     */
    public function isRoot()
    {
        return $this->id === BlogCategory::ROOT;
    }
}
