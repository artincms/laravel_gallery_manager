<?php

namespace ArtinCMS\LGS\Controllers;


use App\Http\Controllers\Controller;
use ArtinCMS\LGS\Model\Gallery;
use DataTables;
use Zend\Diactoros\Request;


class GalleryController extends Controller
{
    public function index()
    {
        $option_default_img = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['png','jpg']];
        $default_img = LFM_CreateModalFileManager('defaultImg',$option_default_img , 'insert','showDefaultImg');
        return view('laravel_gallery_system::backend.gallery.index',compact('default_img')) ;
    }

    public function getGallery(Request $request)
    {
        $gallery = Gallery::with('parent','user');
        return DataTables::eloquent($gallery)
            ->editColumn('id', function ($data) {
                return enCodeId($data->id);
            })
            ->make(true);
    }
}
