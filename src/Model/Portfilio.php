<?php

namespace ArtinCMS\LGS\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LaraveTagablesSystem;
use App\Traits\lfmFillable ;

class Portfilio extends Model
{
    protected $hidden = ['id','default_img'];
    protected $appends = ['encode_id','encode_file_id'];
    protected $table = 'lgs_portfolio';
    use softDeletes;
    use LaraveTagablesSystem;
    use lfmFillable ;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            if ($query->order == null)
            {
                $query->order = self::where('lang_id', '=', $query->lang_id)->max('order') + 1;
            }
        });
    }

    public function getEncodeIdAttribute()
    {
        return LFM_getEncodeId($this->id);
    }

    public function getEncodeFileIdAttribute()
    {
        return LFM_getEncodeId($this->default_img);
    }

    public function user()
    {
        return $this->belongsTo(config('laravel_gallery_system.userModel'), 'created_by');
    }

}
