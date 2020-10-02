<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function articles() {
        // this tag belongs to many articles
        return $this->belongsToMany(Article::class);
    }
}
