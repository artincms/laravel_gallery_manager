<?php

namespace ArtinCMS\LGS\Controllers;


use App\Http\Controllers\Controller;
use ArtinCMS\LGS\Model\Gallery;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GalleryController extends Controller
{
    public function index()
    {
        $option_default_img = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['png', 'jpg']];
        $default_img = LFM_CreateModalFileManager('defaultImg', $option_default_img, 'insert', 'showDefaultImg');
        $parrents = Gallery::all();
        return view('laravel_gallery_system::backend.gallery.index', compact('default_img', 'parrents'));
    }

    public function getGallery(Request $request)
    {
        $gallery = Gallery::with('parent', 'user');
        return DataTables::eloquent($gallery)
            ->editColumn('id', function ($data) {
                return enCodeId($data->id);
            })
            ->editColumn('default_img', function ($data) {
                return enCodeId($data->default_img);
            })
            ->make(true);
    }

    public function saveGallery(Request $request)
    {
        $gallery = new Gallery;
        $gallery->title = $request->title;
        $gallery->order = $request->order;
        $gallery->status = $request->status;
        $gallery->parent_id = $request->parent_id;
        if (Auth::user())
        {
            if (isset(Auth::user()->id))
            {
                $gallery->created_by = Auth::user()->id;
            }
        }
        $gallery->save();
        $res['file'] = LFM_SaveSingleFile($gallery, 'default_img', 'defaultImg', 'options');
        $res =
            [
                'status' => "1",
                'status_type' => "success",
                'title' => "ثبت گالری",
                'message' => 'گالری با موفقیت ثبت شد.'
            ];
        return $res;
    }

}
