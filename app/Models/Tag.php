<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $table = 'tag';
    public $fillable = [
        'id', 'title', 'status'
    ];
    
    
    public function article()
    {
        return $this->hasOne(ArticleTag::class, 'id', 'tag_id');
    }
    
}
