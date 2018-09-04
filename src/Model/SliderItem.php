<?php

namespace ArtinCMS\LGS\Model;

use Illuminate\Database\Eloquent\Model;

class SliderItem extends Model
{
    protected $table = 'lgs_slider_items';
    public function user()
    {
        return $this->belongsTo(config('laravel_gallery_system.userModel'), 'created_by');
    }

    public function item()
    {
        return $this->hasOne('ArtinCMS\LGS\Model\GalleryItem','id','item_id');
    }
    public function files()
    {
        return $this->morphToMany('ArtinCMS\LFM\Models\File' , 'fileable','lfm_fileables','fileable_id','file_id')->withPivot('type')->withTimestamps() ;
    }
}
