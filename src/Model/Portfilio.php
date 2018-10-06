<?php

namespace ArtinCMS\LGS\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LaraveTagablesSystem;
use App\Traits\lfmFillable ;

class Portfilio extends Model
{
    protected $hidden = ['default_img'];
    protected $appends = ['encode_id','encode_file_id','url'];
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
    public function getUrlAttribute()
    {
        return LFM_GenerateDownloadLink('ID',$this->default_img);
    }

    public function user()
    {
        return $this->belongsTo(config('laravel_gallery_system.user_model'), 'created_by');
    }

    public function portfolioSimilars()
    {
        return $this->hasMany('ArtinCMS\LGS\Model\PortfilioSimilar','item_id','id');
    }

    public function tags()
    {
        return $this->morphToMany('ArtinCMS\LTS\Models\Tag' , 'taggable','lts_taggables','taggable_id','tag_id')->withPivot('type')->withTimestamps() ;
    }

}
