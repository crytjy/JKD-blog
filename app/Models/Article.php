<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'article';
    public $fillable = [
        'id', 'category_id', 'user_id', 'author', 'title', 'content', 'keywords', 'description', 'is_top', 'is_original', 'click', 'mp3_url', 'pic', 'status', 'last_update_id'
    ];


    public function getPicAttribute($value)
    {
        return $value ? Storage::disk('public')->url($value) : config('jkd.default_img');
    }


    public function getKeywordsAttribute($value)
    {
        return $value ? explode(',', $value) : '';
    }


    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'article_tag', 'article_id', 'tag_id');
    }


    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

}
