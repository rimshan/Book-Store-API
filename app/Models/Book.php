<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
      'title',
      'user_id',
      'description'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
