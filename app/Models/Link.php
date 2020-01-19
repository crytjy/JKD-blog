<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use SoftDeletes;

    protected $table = 'link';
    public $fillable = [
        'id', 'title', 'url', 'status', 'sort'
    ];
}
