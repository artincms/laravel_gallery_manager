<?php

namespace ArtinCMS\LGS\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LaraveLikeablesSystem ;
use App\Traits\LaravelVisitablesSystem ;
use App\Traits\LaraveTagablesSystem ;

class Gallery extends Model
{
    use LaraveLikeablesSystem ;
    use LaravelVisitablesSystem ;
    use LaraveTagablesSystem ;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            if ($query->order == null)
            {
                $query->order = self::where('parent_id', '=', $query->parent_id)->max('order') + 1;
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

    public function getEncodeIdAttribute()
    {
        return LFM_getEncodeId($this->id);
    }

    public function getDefaultImageLinkSmallAttribute()
    {
        return LFM_GenerateDownloadLink('ID', $this->default_img, 'small');
    }

}
