<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Table Name
    protected $table = 'posts';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    // Creating a relationship
    // A single post belong to a user
    public function user() {
        return $this->belongsTo('App\User');
    }
}
