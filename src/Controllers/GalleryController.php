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

    public function editGallery(Request $request)
    {
        $gallery = Gallery::find(deCodeId($request->item_id)[0]);
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

    //--------------------------------------------------ITem function --------------------------------
    public function getGalleryItem(Request $request)
    {
        $item = GalleryItem::with('gallery')->where('gallery_id', deCodeId($request->item_id)[0]);
        return DataTables::eloquent($item)
            ->editColumn('id', function ($data) {
                return enCodeId($data->id);
            })
            ->editColumn('file_id', function ($data) {
                return enCodeId($data->file_id);
            })
            ->make(true);
    }

    public function getAddGalleryItemForm(Request $request)
    {
        //image options
        $option_item_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['png', 'jpg']];
        //video options
        $option_video_mp4_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['mp4']];
        $option_video_webm_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['webm']];
        $option_video_ogg_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['ogv']];
        //audio options
        $option_audio_ogg_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['oga','ogg']];
        $option_audio_mp3_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['mpga','mp3']];
        $option_audio_wav_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['wav']];

        $itmeFile = LFM_CreateModalFileManager('itemFile', $option_item_file, 'insert', 'showitemFile');

        $itmeVideoMp4File = LFM_CreateModalFileManager('videoMp4itemFile', $option_video_mp4_file, 'insert', 'showVideoMp4File');
        $itmeVideoWebmFile = LFM_CreateModalFileManager('videoWebmFile', $option_video_webm_file, 'insert', 'showVideoWebmFile');
        $itmeVideoOggFile = LFM_CreateModalFileManager('videoOggFile', $option_video_ogg_file, 'insert', 'showVideoOggFile');

        $itmeAudioOggFile = LFM_CreateModalFileManager('audioOggFile', $option_audio_ogg_file, 'insert', 'showAudioOggFile');
        $itmeAudioMp3File = LFM_CreateModalFileManager('audioMp3File', $option_audio_mp3_file, 'insert', 'showAudioMp3File');
        $itmeAudioWavFile = LFM_CreateModalFileManager('audioWavFile', $option_audio_wav_file, 'insert', 'showAudioWavFile');

        $gallery_id = $request->item_id;
        $gallery_form = view('laravel_gallery_system::backend.gallery.view.add_item', compact('gallery_id', 'itmeFile','itmeVideoMp4File'
            ,'itmeVideoWebmFile','itmeVideoOggFile','itmeAudioOggFile','itmeAudioMp3File','itmeAudioWavFile'))->render();
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

    public function createGalleryItem(Request $request)
    {
        $gallery = new GalleryItem;
        $gallery->gallery_id = deCodeId($request->gallery_id)[0];
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
        if (Auth::user())
        {
            if (isset(Auth::user()->id))
            {
                $gallery->created_by = Auth::user()->id;
            }
        }
        $gallery->save();
        $res['file'] = LFM_SaveSingleFile($gallery, 'file_id', 'itemFile', 'options');
        $res =
            [
                'status' => "1",
                'status_type' => "success",
                'title' => "ثبت فایل",
                'section' => 'defaultImg',
                'message' => 'فایل با موفقیت به گالری اضافه شد.'
            ];
        return $res;
    }

    public function setItemStatus(Request $request)
    {
        $item = GalleryItem::find(deCodeId($request->item_id)[0]);
        if ($request->status == "true")
        {
            $item->status = "1";
            $res['message'] = ' آیتم فعال گردید';
        }
        else
        {
            $item->status = "0";
            $res['message'] = 'آیتم غیر فعال شد';
        }
        $item->save();
        $res['success'] = true;
        $res['title'] = 'وضعیت آیتم تغییر پیدا کرد .';
        return $res;
    }

    public function getEditGalleryItemForm(Request $request)
    {
        $option_edit_item = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['png', 'jpg']];
        $item = GalleryItem::find(deCodeId($request->item_id))->first();
        $item->encode_id = enCodeId($item->id);
        $item->gallery_encode_id = enCodeId($item->gallery_id);
        $itmeFile = LFM_CreateModalFileManager('LoadImageItem', $option_edit_item, 'insert', 'show_item_image', 'gallery_item_edit_tab', false
            , 'button_edit_gallery_item', 'انتخاب تصویر');
        $load_gallery_item = LFM_loadSingleFile($item, 'file_id', 'LoadImageItem');
        $item_form = view('laravel_gallery_system::backend.gallery.view.edit_item', compact('item', 'itmeFile', 'load_gallery_item'))->render();
        $res =
            [
                'status' => "1",
                'status_type' => "success",
                'gallery_item_edit_view' => $item_form
            ];
        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }

    public function editGalleryItem(Request $request)
    {
        $item = GalleryItem::find(deCodeId($request->item_id)[0]);
        $item->title = $request->title;
        $item->description = $request->description;
        if ($request->order)
        {
            $item->order = $request->order;
        }
        else
        {
            $item->order = 0;
        }
        if ($request->status == -1)
        {
            $item->status = '0';
        }
        else
        {
            $item->status = $request->status;

        }
        if (Auth::user())
        {
            if (isset(Auth::user()->id))
            {
                $item->created_by = Auth::user()->id;
            }
        }
        $item->save();
        $res['file'] = LFM_SaveSingleFile($item, 'file_id', 'LoadImageItem', 'options');
        $res =
            [
                'status' => "1",
                'status_type' => "success",
                'title' => "ثبت آیتم",
                'section' => 'defaultImg',
                'message' => 'آیتم با موفقیت ثبت شد.'
            ];
        return $res;
    }

    public function trashGalleryItem(Request $request)
    {
        $item = GalleryItem::find(deCodeId($request->item_id)[0]);
        $item->delete();

        $res =
            [
                'status' => "1",
                'title' => "حذف آیتم",
                'message' => 'آیتم با موفقیت حذف شد.'
            ];

        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }


}
