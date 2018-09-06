<?php

namespace ArtinCMS\LGS\Model;

use ArtinCMS\LLS\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


class GalleryItem extends Model
{
    use softDeletes;
    protected $hidden = ['id','gallery_id','file_id'];
    protected $appends = ['auth','encode_id','encode_file_id','encode_gallery_id','voted'];

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
//    public function getLikesCountAttribute($value)
//    {
//        return (int)LGS_ConvertNumbersEntoFa($value);
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

    public function getVotedAttribute()
    {
        if(!config('laravel_gallery_system.guestCanVote'))
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
                ['target_type','ArtinCMS\LGS\Model\GalleryItem'],
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

}
