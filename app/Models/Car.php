<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'cars';

    protected $keyType = 'integer';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'title',
        'price',
        'status'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
