<?php

namespace ArtinCMS\LGS\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ArtinCMS\LFM\Traits\lfmFillable ;

class Slider extends Model
{
    use lfmFillable ;
    use softDeletes;
    protected $table = 'lgs_sliders';
    public function user()
    {
        return $this->belongsTo(config('laravel_gallery_system.userModel'), 'created_by');
    }
}
