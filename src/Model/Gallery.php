<?php

namespace ArtinCMS\LGS\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Gallery extends Model
{
    protected $hidden = ['id','parent_id','default_img'];
    protected $appends = ['auth','encode_id','encode_file_id','encode_parent_id'];
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
        return $this->hasMany('ArtinCMS\LGS\Model\GalleryItem','gallery_id');
    }


    public function getEncodeIdAttribute()
    {
        return LFM_getEncodeId($this->id);
    }

    public function getEncodeFileIdAttribute()
    {
        return LFM_getEncodeId($this->default_img);
    }

    public function getEncodeParentIdAttribute()
    {
        return LFM_getEncodeId($this->parent_id);
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

     public function tags()
    {
        return $this->morphToMany('ArtinCMS\LTS\Models\Tag' , 'taggable','lts_taggables','taggable_id','tag_id')->withPivot('type')->withTimestamps() ;
    }

    public function likes()
    {
        return $this->morphMany('ArtinCMS\LLS\Models\Like','likeable','target_type','target_id') ;
    }

    public function disLikes()
    {
        return $this->morphMany('ArtinCMS\LLS\Models\Like','likeable','target_type','target_id') ;
    }
    public function visits()
    {
        return $this->morphMany('ArtinCMS\LVS\Models\Visit','visitable','target_type','target_id') ;
    }
    public function files()
    {
        return $this->morphToMany('ArtinCMS\LFM\Models\File' , 'fileable','lfm_fileables','fileable_id','file_id')->withPivot('type')->withTimestamps() ;
    }


}
