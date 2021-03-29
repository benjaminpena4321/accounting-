<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Posts extends Model
{
    use HasFactory;

    use SoftDeletes;
    public $timestamps = true;

    public function management()
    {
        return $this->hasOne(Management::class,'id','posted_by')->withTrashed();
    }
}
