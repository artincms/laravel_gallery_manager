<?php

namespace ArtinCMS\LGS\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use softDeletes;
    protected $table = 'lgs_sliders';
    public function user()
    {
        return $this->belongsTo(config('laravel_gallery_system.user_model'), 'created_by');
    }

    public function slider_items()
    {
        return $this->hasMany('ArtinCMS\LGS\Model\SliderItem', 'slider_id');
    }
    public function files()
    {
        return $this->morphToMany('ArtinCMS\LFM\Models\File' , 'fileable','lfm_fileables','fileable_id','file_id')->withPivot('type')->withTimestamps() ;
    }

}
