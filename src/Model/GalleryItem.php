<?php

namespace ArtinCMS\LGS\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ArtinCMS\LFM\Traits\lfmFillable ;

class GalleryItem extends Model
{
    use lfmFillable ;
    use softDeletes;
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
    protected $table = 'lgs_gallery_items';
    public function gallery()
    {
        return $this->belongsTo('ArtinCMS\LGS\Model\Gallery');
    }

}
