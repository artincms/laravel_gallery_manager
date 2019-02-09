<?php

namespace ArtinCMS\LGS\Model;

use ArtinCMS\LLS\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Gallery extends Model
{
    protected $hidden = ['id','default_img'];
    protected $appends = ['auth','encode_id','encode_file_id','encode_parent_id','voted'];
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
        return $this->belongsTo(config('laravel_gallery_system.user_model'), 'created_by');
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

//    public function getLikesCountAttribute($value)
//    {
//        return LGS_ConvertNumbersEntoFa($value);
//    }
//
//    public function getDisLikesCountAttribute($value)
//    {
//        return (int)LGS_ConvertNumbersEntoFa($value);
//    }
//
//    public function getVisitsCountAttribute($value)
//    {
//        return (int)LGS_ConvertNumbersEntoFa($value);
//    }
    public function getVotedAttribute()
    {
        if(!config('laravel_gallery_system.guest_can_vote'))
        {
            if (auth()->check())
            {
                $user_id = auth()->id();
            }
            else
            {
                $user_id = 0;

            }
            $vote = Like::where([
                ['target_type','ArtinCMS\LGS\Model\Gallery'],
                ['target_id',$this->id],
                ['user_id',$user_id]
            ])->get();
            if (count($vote) > 0)
            {
                $res = $vote->first() ;
            }
            else
            {
                $res = false ;
            }
        }
        else
        {
            $res = false ;
        }
        return $res ;
    }
    public function getAuthAttribute($value)
    {
        if(!config('laravel_gallery_system.guest_can_vote'))
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
        return $this->morphToMany('ArtinCMS\LTS\Models\Tag' , 'tagable','lts_tagables','tagable_id','tag_id')->withPivot('type')->withTimestamps() ;
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

    public function parrent()
    {
        return $this->belongsTo('ArtinCMS\LGS\Model\Gallery','parent_id','id');
    }


}
