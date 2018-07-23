<?php

namespace ArtinCMS\LGS\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ArtinCMS\LFM\Traits\lfmFillable ;

class GalleryItem extends Model
{
    use lfmFillable ;
    use softDeletes;
    protected $table = 'lgs_gallery_items';
    public function gallery()
    {
        return $this->belongsTo('ArtinCMS\LGS\Model\Gallery');
    }

}
