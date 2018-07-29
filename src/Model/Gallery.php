<?php

namespace ArtinCMS\LGS\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query)
        {
            if ($query->order == null)
            {
                $query->order = self::where('parent_id','=',$query->parent_id)->max('order')+1;
            }
        });
    }
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

    public function items()
    {
        return $this->hasMany('ArtinCMS\LGS\Model\GalleryItem', 'gallery_id');
    }

}
