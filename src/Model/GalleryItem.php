<?php

namespace ArtinCMS\LGS\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ArtinCMS\LFM\Traits\lfmFillable ;
use App\Traits\LaraveLikeablesSystem ;
use App\Traits\LaravelVisitablesSystem ;
use App\Traits\LaraveTagablesSystem ;


class GalleryItem extends Model
{
    use lfmFillable ;
    use softDeletes;
    use LaraveLikeablesSystem ;
    use LaravelVisitablesSystem ;
    use LaraveTagablesSystem ;

    protected $table = 'lgs_items';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query)
        {
            if ($query->order == null)
            {
                $query->order = self::where('gallery_id','=',$query->gallery_id)->max('order')+1;
            }
        });
    }
    public function gallery()
    {
        return $this->belongsTo('ArtinCMS\LGS\Model\Gallery');
    }

    public function getEncodeIdAttribute()
    {
        return enCodeId($this->id);
    }
    public function comments()
    {
        return $this->morphMany('ArtinCMS\LCS\Models\Comment', 'commentable','target_type','target_id');
    }

}
