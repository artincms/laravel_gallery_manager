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
        $default_img = LFM_CreateModalFileManager('defaultImg', $option_default_img, 'insert', 'showDefaultImg',false, false, false, 'انتخاب فایل تصویر', 'btn-block','fa fa-folder-open font_button mr-2');
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
                'status'      => "1",
                'status_type' => "success",
                'title'       => "ثبت گالری",
                'section'     => 'defaultImg',
                'message'     => 'گالری با موفقیت ثبت شد.'
            ];

        return $res;
    }

    public function getEditGalleryForm(Request $request)
    {
        $option_default_img = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['png', 'jpg']];
        $gallery = Gallery::find(deCodeId($request->item_id)[0]);
        $gallery->encode_id = enCodeId($gallery->id);
        $parrents = Gallery::all();
        $default_img = LFM_CreateModalFileManager('LoadDefaultImg', $option_default_img, 'insert', 'showDefaultImg', 'gallery_edit_tab', false, false, 'انتخاب فایل تصویر', 'btn-block','fa fa-folder-open font_button mr-2');
        $load_default_img = LFM_loadSingleFile($gallery, 'default_img', 'LoadDefaultImg');
        $gallery_form = view('laravel_gallery_system::backend.gallery.view.edit', compact('gallery', 'parrents', 'default_img', 'load_default_img'))->render();
        $res =
            [
                'status'            => "1",
                'status_type'       => "success",
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
                'status'      => "1",
                'status_type' => "success",
                'title'       => "ثبت گالری",
                'section'     => 'defaultImg',
                'message'     => 'گالری با موفقیت ثبت شد.'
            ];

        return $res;
    }

    public function trashGallery(Request $request)
    {
        $gallery = Gallery::find(deCodeId($request->item_id)[0])->first();
        $gallery->delete();

        $res =
            [
                'status'  => "1",
                'title'   => "حذف گالری",
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
        $option_audio_ogg_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['oga', 'ogg']];
        $option_audio_mp3_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['mpga', 'mp3']];
        $option_audio_wav_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['wav']];

        $itmeFile = LFM_CreateModalFileManager('itemFile', $option_item_file, 'insert', 'showitemFile', false, false, false,
            'انتخاب فایل تصویر', 'btn-block','fa fa-folder-open font_button mr-2');

        $itmeVideoMp4File = LFM_CreateModalFileManager('videoMp4itemFile', $option_video_mp4_file, 'insert', 'showVideoMp4File', false,
            false, false, 'انتخاب  فایل ویدئو(mp4)', 'btn-block','fa fa-folder-open font_button mr-2');
        $itmeVideoWebmFile = LFM_CreateModalFileManager('videoWebmFile', $option_video_webm_file, 'insert', 'showVideoWebmFile', false,
            false, false, 'انتخاب فایل ویدئو(webm)', 'btn-block','fa fa-folder-open font_button mr-2');
        $itmeVideoOggFile = LFM_CreateModalFileManager('videoOggFile', $option_video_ogg_file, 'insert', 'showVideoOggFile', false,
            false, false, 'انتخاب فایل ویدئو(ogg)', 'btn-block','fa fa-folder-open font_button mr-2');

        $itmeAudioOggFile = LFM_CreateModalFileManager('audioOggFile', $option_audio_ogg_file, 'insert', 'showAudioOggFile', false,
            false, false, 'انتخاب فایل صوت(ogg)', 'btn-block','fa fa-folder-open font_button mr-2');
        $itmeAudioMp3File = LFM_CreateModalFileManager('audioMp3File', $option_audio_mp3_file, 'insert', 'showAudioMp3File', false,
            false, false, 'انتخاب فایل صوت(mp3)', 'btn-block','fa fa-folder-open font_button mr-2');
        $itmeAudioWavFile = LFM_CreateModalFileManager('audioWavFile', $option_audio_wav_file, 'insert', 'showAudioWavFile', false,
            false, false, 'انتخاب فایل(wav)', 'btn-block','fa fa-folder-open font_button mr-2');

        $gallery_id = $request->item_id;
        $gallery_form = view('laravel_gallery_system::backend.gallery.view.add_item', compact('gallery_id', 'itmeFile', 'itmeVideoMp4File'
            , 'itmeVideoWebmFile', 'itmeVideoOggFile', 'itmeAudioOggFile', 'itmeAudioMp3File', 'itmeAudioWavFile'))->render();
        $res =
            [
                'status'           => "1",
                'status_type'      => "success",
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
        $item = new GalleryItem;
        $item->gallery_id = deCodeId($request->gallery_id)[0];
        $item->title = $request->title;
        $item->description = $request->description;
        $item->type = $request->type;
        if ($request->order)
        {
            $item->order = $request->order;
        }
        else
        {
            $item->order = 0;
        }
        if ($request->status)
        {
            $item->status = $request->status;
        }
        else
        {
            $item->status = '0';
        }
        if (Auth::user())
        {
            if (isset(Auth::user()->id))
            {
                $item->created_by = Auth::user()->id;
            }
        }
        $item->save();

        switch ($request->type)
        {
            case 1 :
                $audioOggFile = LFM_SaveMultiFile($item, 'audioOggFile', 'audio/ogg', 'files');
                $itmeAudioMp3File = LFM_SaveMultiFile($item, 'audioMp3File', 'audio/mpeg', 'files');
                $itmeAudioWavFile = LFM_SaveMultiFile($item, 'audioWavFile', 'audio/x-wav', 'files');
                $section = [$audioOggFile, $itmeAudioMp3File, $itmeAudioWavFile];
                break;
            case 2 :
                $itmeVideoMp4File = LFM_SaveMultiFile($item, 'videoMp4itemFile', 'video/mp4', 'files');
                $itmeVideoWebmFile = LFM_SaveMultiFile($item, 'videoWebmFile', 'video/webm', 'files');
                $itmeVideoOggFile = LFM_SaveMultiFile($item, 'videoOggFile', 'video/ogg', 'files');
                $section = [$itmeVideoMp4File, $itmeVideoWebmFile, $itmeVideoOggFile];
                break;
            default :
                $itemFile = LFM_SaveSingleFile($item, 'file_id', 'itemFile', 'options');
                $section = [];
                break;
        }
        $res =
            [
                'status'      => "1",
                'status_type' => "success",
                'title'       => "ثبت فایل",
                'section'     => 'itemFile',
                'message'     => 'فایل با موفقیت به گالری اضافه شد.',
                'saveFile'    => $section
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
        $item = GalleryItem::find(deCodeId($request->item_id)[0]);
        $item->encode_id = enCodeId($item->id);
        $item->gallery_encode_id = enCodeId($item->gallery_id);

        //image options
        $option_item_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['png', 'jpg']];
        //video options
        $option_video_mp4_file = [
            'size_file'           => 2000,
            'max_file_number'     => 1,
            'true_file_extension' => ['mp4']
        ];
        $option_video_webm_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['webm']];
        $option_video_ogg_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['ogv']];
        //audio options
        $option_audio_ogg_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['oga', 'ogg']];
        $option_audio_mp3_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['mpga', 'mp3']];
        $option_audio_wav_file = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['wav']];

        $itmeFile = LFM_CreateModalFileManager('editItemFile', $option_item_file, 'insert', 'showEdititemFile', false,
            false, false, 'انتخاب فایل تصویر', 'btn-block','fa fa-folder-open font_button mr-2');

        $itmeVideoMp4File = LFM_CreateModalFileManager('editVideoMp4itemFile', $option_video_mp4_file, 'insert', 'showEditVideoMp4File', false,
            false, false, 'انتخاب فایل ویدئویی (mp4)', 'btn-block','fa fa-folder-open font_button mr-2');
        $itmeVideoWebmFile = LFM_CreateModalFileManager('editVideoWebmFile', $option_video_webm_file, 'insert', 'showEditVideoWebmFile', false,
            false, false, 'انتخاب فایل ویدئویی(webm)', 'btn-block','fa fa-folder-open font_button mr-2');
        $itmeVideoOggFile = LFM_CreateModalFileManager('editVideoOggFile', $option_video_ogg_file, 'insert', 'showEditVideoOggFile', false,
            false, false, 'انتخاب فایل ویدئویی(ogg)', 'btn-block','fa fa-folder-open font_button mr-2');

        $itmeAudioOggFile = LFM_CreateModalFileManager('editAudioOggFile', $option_audio_ogg_file, 'insert', 'showEditAudioOggFile', false,
            false, false, 'انتخاب فایل صوتی(ogg)', 'btn-block','fa fa-folder-open font_button mr-2');
        $itmeAudioMp3File = LFM_CreateModalFileManager('editAudioMp3File', $option_audio_mp3_file, 'insert', 'showEditAudioMp3File', false,
            false, false, 'انتخاب فایل صوتی(mp3)', 'btn-block','fa fa-folder-open font_button mr-2');
        $itmeAudioWavFile = LFM_CreateModalFileManager('editAudioWavFile', $option_audio_wav_file, 'insert', 'showEditAudioWavFile', false,
            false, false, 'انتخاب فایل صوتی(wav)', 'btn-block','fa fa-folder-open font_button mr-2');

        //load files
        $itmeFileLoad = LFM_loadSingleFile($item, 'file_id', 'editItemFile');

        $itmeVideoMp4FileLoad = LFM_LoadMultiFile($item, 'editVideoMp4itemFile', 'video/mp4');
        $itmeVideoWebmFileLoad = LFM_LoadMultiFile($item, 'editVideoWebmFile', 'video/webm');
        $itmeVideoOggFileLoad = LFM_LoadMultiFile($item, 'editVideoOggFile', 'video/ogg');

        $itmeAudioOggFileLoad = LFM_LoadMultiFile($item, 'editAudioOggFile', 'audio/ogg');
        $itmeAudioMp3FileLoad = LFM_LoadMultiFile($item, 'editAudioMp3File', 'audio/mpeg');
        $itmeAudioWavFileLoad = LFM_LoadMultiFile($item, 'editAudioWavFile', 'audio/x-wav');
        switch ($item->type)
        {
            case '2' :
                $pic_class = 'hidden';
                $audio_class = 'hidden';
                $video_class = '';
                break;
            case '1':
                $pic_class = 'hidden';
                $audio_class = '';
                $video_class = 'hidden';
                break;
            default :
                $pic_class = '';
                $audio_class = 'hidden';
                $video_class = 'hidden';
                break;
        }

        $item_form = view('laravel_gallery_system::backend.gallery.view.edit_item', compact('item', 'itmeFile', 'itmeVideoMp4File'
            , 'itmeVideoWebmFile', 'itmeVideoOggFile', 'itmeAudioOggFile', 'itmeAudioMp3File', 'itmeAudioWavFile', 'itmeFileLoad', 'itmeVideoMp4FileLoad', 'itmeVideoWebmFileLoad',
            'itmeVideoOggFileLoad', 'itmeAudioOggFileLoad', 'itmeAudioMp3FileLoad', 'itmeAudioWavFileLoad', 'pic_class', 'audio_class', 'video_class'))->render();
        $res =
            [
                'status'                 => "1",
                'status_type'            => "success",
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
        $item->type = $request->type;
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

        switch ($request->type)
        {
            case 1 :
                $audioOggFile = LFM_SaveMultiFile($item, 'editAudioOggFile', 'audio/ogg', 'files', 'sync');
                $itmeAudioMp3File = LFM_SaveMultiFile($item, 'editAudioMp3File', 'audio/mpeg', 'files', 'sync');
                $itmeAudioWavFile = LFM_SaveMultiFile($item, 'editAudioWavFile', 'audio/x-wav', 'files', 'sync');
                $section = [$audioOggFile, $itmeAudioMp3File, $itmeAudioWavFile];
                break;
            case 2 :
                $itmeVideoMp4File = LFM_SaveMultiFile($item, 'editVideoMp4itemFile', 'video/mp4', 'files', 'sync');
                $itmeVideoWebmFile = LFM_SaveMultiFile($item, 'editVideoWebmFile', '	video/webm', 'files', 'sync');
                $itmeVideoOggFile = LFM_SaveMultiFile($item, 'editVideoOggFile', 'video/ogg', 'files', 'sync');
                $section = [$itmeVideoMp4File, $itmeVideoWebmFile, $itmeVideoOggFile];
                break;
            default :
                $itemFile = LFM_SaveSingleFile($item, 'file_id', 'editItemFile', 'options');
                $section = [];
                break;
        }
        $item->save();
        $res =
            [
                'status'      => "1",
                'status_type' => "success",
                'title'       => "ثبت آیتم",
                'section'     => $section,
                'message'     => 'آیتم با موفقیت ثبت شد.'
            ];

        return $res;
    }

    public function trashGalleryItem(Request $request)
    {
        $item = GalleryItem::find(deCodeId($request->item_id)[0]);
        $item->delete();

        $res =
            [
                'status'  => "1",
                'title'   => "حذف آیتم",
                'message' => 'آیتم با موفقیت حذف شد.'
            ];

        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }

    //--------------------------------------------------Auto Complete function --------------------------------
    public function autoCompleteGalleryParrent(Request $request)
    {
        $x = $request->term;
        $data = Gallery::select("id", 'title AS text')->where('status', '1');
        if ($x['term'] != '...')
        {
            $data = Gallery::select("id", 'title AS text')
                ->where('status', '1')
                ->where("title", "LIKE", "%" . $x['term'] . "%");
        }
        $data = $data->get();
        $data = array('results' => $data);
        return response()->json($data);
    }


}
