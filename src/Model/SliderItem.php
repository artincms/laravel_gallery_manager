<?php

namespace ArtinCMS\LGS\Model;

use Illuminate\Database\Eloquent\Model;
use ArtinCMS\LFM\Traits\lfmFillable ;

class SliderItem extends Model
{
    use lfmFillable ;
    protected $table = 'lgs_slider_items';
    public function user()
    {
        return $this->belongsTo(config('laravel_gallery_system.userModel'), 'created_by');
    }

    public function item()
    {
        return $this->hasOne('ArtinCMS\LGS\Model\GalleryItem','id');
    }
}
