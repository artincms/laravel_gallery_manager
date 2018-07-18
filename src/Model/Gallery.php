<?php

namespace ArtinCMS\LGS\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use softDeletes;
    protected $table = 'lgs_galleries';

    public function child()
    {
        return $this->hasMany('ArtinCMS\LGS\Model\Gallery', 'parent_id');
    }

    public function parent()
    {
        return $this->hasOne('ArtinCMS\LGS\Model\Gallery', 'id', 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(config('laravel_gallery_system.userModel'), 'created_by');
    }

}
