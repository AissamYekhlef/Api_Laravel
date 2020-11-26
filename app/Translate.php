<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translate extends Model
{

    // protected $fillable =[
    //     'created_at', 'updated_at'
    // ];
    
    protected $casts = [
        'wEN' => 'array',
        'wAR' => 'array'
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];


}
