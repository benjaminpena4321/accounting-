<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Management extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = ['name'];
    use SoftDeletes;

    public function posts(){

        return $this->hasMany(Post::class,'posted_by','id')->withTrashed();

    }

}
