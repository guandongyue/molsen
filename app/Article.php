<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    const CREATED_AT = 'intime';
    const UPDATED_AT = 'uptime';

    //
    const CATEGORYS = [1=>'服务端', '前端', '服务器', '客户端'];
    const TAGS = [1=>'PHP', 'Javascrtip', 'Linux', 'Swift'];

    // protected $fillable = ['title'];
    protected $guarded = ['id'];
}
