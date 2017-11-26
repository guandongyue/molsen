<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    const CREATED_AT = 'intime';
    const UPDATED_AT = 'uptime';

    // protected $fillable = ['title'];
    protected $guarded = ['id'];

    public function tree()
    {
        # code...
    }
}
