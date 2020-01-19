<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{
    protected $table = 'article_tag';
    public $fillable = [
        'article_id', 'tag_id'
    ];

}
