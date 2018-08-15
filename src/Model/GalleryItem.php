<?php

namespace ArtinCMS\LGS\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ArtinCMS\LFM\Traits\lfmFillable ;
use App\Traits\LaraveLikeablesSystem ;
use App\Traits\LaravelVisitablesSystem ;
use App\Traits\LaraveTagablesSystem ;
use Illuminate\Support\Facades\Auth;


class GalleryItem extends Model
{
    use lfmFillable ;
    use softDeletes;
    use LaraveLikeablesSystem ;
    use LaravelVisitablesSystem ;
    use LaraveTagablesSystem ;
    protected $hidden = ['id','gallery_id','file_id'];
    protected $appends = ['auth','encode_id','encode_file_id','encode_gallery_id'];

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

    public function comments()
    {
        return $this->morphMany('ArtinCMS\LCS\Models\Comment', 'commentable','target_type','target_id');
    }

    public function getEncodeIdAttribute()
    {
        return LFM_getEncodeId($this->id);
    }

    public function getEncodeFileIdAttribute()
    {
        return LFM_getEncodeId($this->file_id);
    }

    public function getEncodeGalleryIdAttribute()
    {
        return LFM_getEncodeId($this->gallery_id);
    }
    public function getLikesCountAttribute($value)
    {
        return (int)LGS_ConvertNumbersEntoFa($value);
    }

    public function getDisLikesCountAttribute($value)
    {
        return (int)LGS_ConvertNumbersEntoFa($value);
    }

    public function getVisitsCountAttribute($value)
    {
        return (int)LGS_ConvertNumbersEntoFa($value);
    }

    public function getAuthAttribute($value)
    {
        if(!config('laravel_gallery_system.guestCanVote'))
        {
            $auth = Auth::check() ;

        }
        else
        {
            $auth = true ;
        }
        return $auth ;
    }

}
