<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'category';
    public $fillable = [
        'id', 'title', 'keywords', 'description', 'status', 'sort'
    ];
    

    public function getKeywordsAttribute($value)
    {
        return $value ? explode(',', $value) : '';
    }


    public function category()
    {
        return $this->hasOne(Article::class, 'id', 'category_id');
    }

}
