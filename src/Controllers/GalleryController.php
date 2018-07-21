<?php

namespace ArtinCMS\LGS\Controllers;


use App\Http\Controllers\Controller;
use ArtinCMS\LGS\Model\Gallery;
use ArtinCMS\LGS\Model\GalleryItem;
use DataTables;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GalleryController extends Controller
{
    public function index()
    {
        $option_default_img = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['png', 'jpg']];
        $default_img = LFM_CreateModalFileManager('defaultImg', $option_default_img, 'insert', 'showDefaultImg');
        $parrents = Gallery::with('parent')->get();
        //dd($parrents);
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
        $gallery->description = $request->description;
        if ($request->order)
        {
            $gallery->order = $request->order;
        }
        else
        {
            $gallery->order = 0;
        }
        if ($request->status == -1)
        {
            $gallery->status = '0';
        }
        else
        {
            $gallery->status = $request->status;

        }
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
                'section' => 'defaultImg',
                'message' => 'گالری با موفقیت ثبت شد.'
            ];
        return $res;
    }

    public function getEditGalleryForm(Request $request)
    {
        $option_default_img = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['png', 'jpg']];
        $gallery = Gallery::find(deCodeId($request->item_id))->first();
        $gallery->encode_id = enCodeId($gallery->id);
        $parrents = Gallery::all();
        $default_img = LFM_CreateModalFileManager('LoadDefaultImg', $option_default_img, 'insert', 'showDefaultImg', 'gallery_edit_tab', false
            , 'button_edit_gallery', 'انتخاب تصویر');
        $load_default_img = LFM_loadSingleFile($gallery, 'default_img', 'LoadDefaultImg');
        $gallery_form = view('laravel_gallery_system::backend.gallery.view.edit', compact('gallery', 'parrents', 'default_img', 'load_default_img'))->render();
        $res =
            [
                'status' => "1",
                'status_type' => "success",
                'gallery_edit_view' => $gallery_form
            ];
        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }

    public function getAddGalleryItemForm(Request $request)
    {
        $option_item_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['png', 'jpg']];
        $itmeFile = LFM_CreateModalFileManager('itemFile', $option_item_file, 'insert', 'showitemFile');
        $gallery_id = $request->item_id ;
        $gallery_form = view('laravel_gallery_system::backend.gallery.view.add_item', compact('gallery_id', 'itmeFile'))->render();
        $res =
            [
                'status' => "1",
                'status_type' => "success",
                'gallery_add_item' => $gallery_form
            ];
        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }

    public function editGallery(Request $request)
    {
        $gallery = Gallery::find(deCodeId($request->item_id)[0])->first();
        $gallery->title = $request->title;
        $gallery->description = $request->description;
        if ($request->order)
        {
            $gallery->order = $request->order;
        }
        else
        {
            $gallery->order = 0;
        }
        if ($request->status == -1)
        {
            $gallery->status = '0';
        }
        else
        {
            $gallery->status = $request->status;

        }
        $gallery->parent_id = $request->parent_id;
        if (Auth::user())
        {
            if (isset(Auth::user()->id))
            {
                $gallery->created_by = Auth::user()->id;
            }
        }
        $gallery->save();
        $res['file'] = LFM_SaveSingleFile($gallery, 'default_img', 'LoadDefaultImg', 'options');
        $res =
            [
                'status' => "1",
                'status_type' => "success",
                'title' => "ثبت گالری",
                'section' => 'defaultImg',
                'message' => 'گالری با موفقیت ثبت شد.'
            ];
        return $res;
    }

    public function trashGallery(Request $request)
    {
        $gallery = Gallery::find(deCodeId($request->item_id)[0])->first();
        $gallery->delete();

        $res =
            [
                'status' => "1",
                'title' => "حذف گالری",
                'message' => 'گالری با موفقیت حذف شد.'
            ];

        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }

    public function setGalleryStatus(Request $request)
    {
        $gallery = Gallery::find(deCodeId($request->item_id)[0]);
        if ($request->status == "true")
        {
            $gallery->status = "1";
            $res['message'] = ' گالری فعال گردید';
        }
        else
        {
            $gallery->status = "0";
            $res['message'] = 'گالری غیر فعال شد';
        }
        $gallery->save();
        $res['success'] = true;
        $res['title'] = 'وضعیت گالری تغییر پیدا کرد .';
        return $res;
    }

    public function getGalleryItem(Request $request)
    {
        $item = GalleryItem::with('gallery')->where('gallery_id',deCodeId($request->item_id)[0]);
        return DataTables::eloquent($item)
            ->editColumn('id', function ($data) {
                return enCodeId($data->id);
            })
            ->make(true);
    }

}
