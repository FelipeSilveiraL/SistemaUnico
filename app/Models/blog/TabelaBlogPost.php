<?php

namespace App\Models\blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelaBlogPost extends Model
{
    use HasFactory;
    protected $table = 'blog_post';
    protected $connection = 'mysql_blog';

    protected $fillable = [
        'id_postagem',
    ];

    public $timestamps = false;
}
