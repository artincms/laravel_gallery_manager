<?php

namespace ArtinCMS\LGS\Controllers;


use DataTables;
use ArtinCMS\LVS\Models\Visit;
use ArtinCMS\LGS\Model\Gallery;
use ArtinCMS\LGS\Model\GalleryItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;


class GalleryController extends Controller
{
    private function reOrderGalleryForm($parrent_id)
    {
        $all_Gallery = Gallery::where('parent_id', $parrent_id)->orderBy('order', 'asc')->get();
        $i = 1;
        foreach ($all_Gallery as $item)
        {
            $item->order = $i++;
            $item->save();
        }

        return $i;
    }

    private function reOrderGalleryItemForm($gallery_id)
    {
        $all_Gallery = GalleryItem::where('gallery_id', $gallery_id)->orderBy('order', 'asc')->get();
        $i = 1;
        foreach ($all_Gallery as $item)
        {
            $item->order = $i++;
            $item->save();
        }

        return $i;
    }


    //-------------------------------------------------- Gallery methods -------------------------------------------------------
    public function index()
    {
        $option_default_img = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['png', 'jpg']];
        $default_img = LFM_CreateModalFileManager('defaultImg', $option_default_img, 'insert', 'showDefaultImg', false, false, false, 'انتخاب فایل تصویر', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $parrents = Gallery::with('parent')->select("id", 'title AS text')->get()->makeVisible('id');
        $multi_langFunc = config('laravel_gallery_system.multi_lang');
        if ($multi_langFunc)
        {
            $multi_lang = json_encode($multi_langFunc());
        }
        else
        {
            $multi_lang = false;
        }

        return view('laravel_gallery_system::backend.gallery.index', compact('default_img', 'parrents', 'multi_lang'));
    }

    public function getGallery(Request $request)
    {
        $gallery = Gallery::with('parent', 'user');
        if ($request->filter_title)
        {
            $gallery->where('title', 'like', '%' . $request->filter_title . '%');
        }
        if ($request->filter_parrent_id != 'false')
        {
            $gallery->where('parent_id', $request->filter_parrent_id);
        }
        if ($request->filter_is_active == "1")
        {
            $gallery->where('is_active', '1');
        }
        elseif ($request->filter_is_active == "0")
        {
            $gallery->where('is_active', '0');
        }

        return DataTables::eloquent($gallery)
            ->editColumn('id', function ($data) {
                return LFM_getEncodeId($data->id);
            })
            ->editColumn('parent_id', function ($data) {
                return LFM_getEncodeId($data->parent_id);
            })
            ->editColumn('default_img', function ($data) {
                return LFM_getEncodeId($data->default_img);
            })
            ->editColumn('description', function ($data) {
                return strip_tags($data->description);
            })
            ->make(true);
    }

    public function saveGallery(Request $request)
    {
        $gallery = new Gallery;
        $gallery->title = $request->title;
        $gallery->description = $request->description;
        if ($request->parent_id)
        {
            $gallery->parent_id = $request->parent_id;
        }

        if ($request->lang_id)
        {
            $gallery->lang_id = $request->lang_id;
        }
        if (auth()->check())
        {
            $auth = auth()->id();
        }
        else
        {
            $auth = 0;
        }
        $gallery->created_by = $auth;
        if ($gallery->parent_id)
        {
            $parent = Gallery::find($gallery->parent_id);
            $gallery->lang_id = $parent->lang_id;
        }
        $gallery->save();
        $res['tag'] = LTS_saveTag($gallery, $request->tag);
        $res['file'] = LFM_SaveSingleFile($gallery, 'default_img', 'defaultImg', 'default_img_options');
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
        $gallery = Gallery::find(LFM_GetDecodeId($request->item_id));
        $gallery->encode_id = LFM_getEncodeId($gallery->id);
        $tags = LTS_showTag($gallery);
        $parrents_edit = Gallery::with('parrent')->select("id", 'title AS text')->get()->makeVisible('id');
        $default_img = LFM_CreateModalFileManager('LoadDefaultImg', $option_default_img, 'insert', 'showDefaultImg', 'gallery_edit_tab', false, false, 'انتخاب فایل تصویر', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $load_default_img = LFM_loadSingleFile($gallery, 'default_img', 'LoadDefaultImg');
        $multi_langFunc = config('laravel_gallery_system.multi_lang');
        if ($multi_langFunc)
        {
            $multi_lang = json_encode($multi_langFunc());
            $active_lang_title = $this->searchForId($gallery->lang_id, $multi_langFunc());
        }
        else
        {
            $multi_lang = false;
            $active_lang_title = '';
        }
        $gallery_form = view('laravel_gallery_system::backend.gallery.view.edit', compact('gallery', 'tags', 'parrents_edit', 'default_img', 'load_default_img', 'multi_lang', 'active_lang_title'))->render();
        $res =
            [
                'status'            => "1",
                'success'           => true,
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
        $gallery = Gallery::find(LFM_GetDecodeId($request->item_id));
        $gallery->title = $request->title;
        $gallery->description = $request->description;
        $gallery->parent_id = $request->parent_id;
        $gallery->lang_id = $request->lang_id;
        if (auth()->check())
        {
            $auth = auth()->id();
        }
        else
        {
            $auth = 0;
        }
        $gallery->created_by = $auth;
        if ($gallery->parent_id)
        {
            $parent = Gallery::find($gallery->parent_id);
            $gallery->lang_id = $parent->lang_id;
        }
        $gallery->save();
        $res['tag'] = LTS_saveTag($gallery, $request->tag, 'tag', 'tags', 'sync');
        $res['file'] = LFM_SaveSingleFile($gallery, 'default_img', 'LoadDefaultImg', 'default_img_options');
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
        $gallery = Gallery::find(LFM_GetDecodeId($request->item_id));
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
        $gallery = Gallery::find(LFM_GetDecodeId($request->item_id));
        if ($request->is_active == "true")
        {
            $gallery->is_active = "1";
            $res['message'] = ' گالری فعال گردید';
        }
        else
        {
            $gallery->is_active = "0";
            $res['message'] = 'گالری غیر فعال شد';
        }
        $gallery->save();
        $res['success'] = true;
        $res['title'] = 'وضعیت گالری تغییر پیدا کرد .';

        return $res;
    }


    //-------------------------------------------------- ITem function -------------------------------------------------------
    public function getGalleryItem(Request $request)
    {
        $item = GalleryItem::with('gallery')->where('gallery_id', LFM_GetDecodeId($request->item_id));
        if ($request->filter_item_title)
        {
            $item->where('title', 'like', '%' . $request->filter_item_title . '%');
        }
        if ($request->filter_item_is_active == "1")
        {
            $item->where('is_active', '1');
        }
        elseif ($request->filter_item_is_active == "0")
        {
            $item->where('is_active', '0');
        }

        return DataTables::eloquent($item)
            ->editColumn('id', function ($data) {
                return LFM_getEncodeId($data->id);
            })
            ->editColumn('file_id', function ($data) {
                return LFM_getEncodeId($data->file_id);
            })
            ->editColumn('gallery_id', function ($data) {
                return LFM_getEncodeId($data->gallery_id);
            })
            ->editColumn('description', function ($data) {
                return strip_tags($data->description);
            })
            ->make(true);
    }

    public function getAddGalleryItemForm(Request $request)
    {
        //get language
        $multi_langFunc = config('laravel_gallery_system.multi_lang');
        if ($multi_langFunc)
        {
            $multi_lang = json_encode($multi_langFunc());
        }
        else
        {
            $multi_lang = false;
        }
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

        $itmeFile = LFM_CreateModalFileManager('itemFile', $option_item_file, 'insert', 'showitemFile', false, false, false, 'انتخاب فایل تصویر', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $itmeVideoMp4File = LFM_CreateModalFileManager('videoMp4itemFile', $option_video_mp4_file, 'insert', 'showVideoMp4File', false, false, false, 'انتخاب  فایل ویدئو(mp4)', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $itmeVideoWebmFile = LFM_CreateModalFileManager('videoWebmFile', $option_video_webm_file, 'insert', 'showVideoWebmFile', false, false, false, 'انتخاب فایل ویدئو(webm)', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $itmeVideoOggFile = LFM_CreateModalFileManager('videoOggFile', $option_video_ogg_file, 'insert', 'showVideoOggFile', false, false, false, 'انتخاب فایل ویدئو(ogg)', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $itmeAudioOggFile = LFM_CreateModalFileManager('audioOggFile', $option_audio_ogg_file, 'insert', 'showAudioOggFile', false, false, false, 'انتخاب فایل صوت(ogg)', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $itmeAudioMp3File = LFM_CreateModalFileManager('audioMp3File', $option_audio_mp3_file, 'insert', 'showAudioMp3File', false, false, false, 'انتخاب فایل صوت(mp3)', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $itmeAudioWavFile = LFM_CreateModalFileManager('audioWavFile', $option_audio_wav_file, 'insert', 'showAudioWavFile', false, false, false, 'انتخاب فایل(wav)', 'btn-block', 'fa fa-folder-open font_button mr-2');

        $gallery_id = $request->item_id;
        $gallery_form = view('laravel_gallery_system::backend.gallery.view.add_item', compact('gallery_id', 'itmeFile', 'itmeVideoMp4File', 'itmeVideoWebmFile', 'itmeVideoOggFile', 'itmeAudioOggFile', 'itmeAudioMp3File', 'itmeAudioWavFile', 'multi_lang'))->render();
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
        $gallery_id = LFM_GetDecodeId($request->gallery_id);
        $item->gallery_id = $gallery_id;
        $item->title = $request->title;
        $item->description = $request->description;
        $item->type = $request->type;
        if (auth()->check())
        {
            $auth = auth()->id();
        }
        else
        {
            $auth = 0;
        }
        $item->created_by = $auth;
        if ($gallery_id)
        {
            $gallery = Gallery::find($gallery_id);
            $item->lang_id = $gallery ? $gallery->lang_id : 0;
        }
        if ($request->lang_id)
        {
            $lang_id = $request->lang_id;
            $item->lang_id = $lang_id;
        }
        $item->save();
        $res['tag'] = LTS_saveTag($item, $request->tag);
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
        $item = GalleryItem::find(LFM_GetDecodeId($request->item_id));
        if ($request->is_active == "true")
        {
            $item->is_active = "1";
            $res['message'] = ' آیتم فعال گردید';
        }
        else
        {
            $item->is_active = "0";
            $res['message'] = 'آیتم غیر فعال شد';
        }
        $item->save();
        $res['success'] = true;
        $res['title'] = 'وضعیت آیتم تغییر پیدا کرد .';

        return $res;
    }

    public function getEditGalleryItemForm(Request $request)
    {
        $item = GalleryItem::find(LFM_GetDecodeId($request->item_id));
        $item->encode_id = LFM_getEncodeId($item->id);
        $item->gallery_encode_id = LFM_getEncodeId($item->gallery_id);
        $tags = LTS_showTag($item);

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

        $itmeFile = LFM_CreateModalFileManager('editItemFile', $option_item_file, 'insert', 'showEdititemFile', false, false, false, 'انتخاب فایل تصویر', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $itmeVideoMp4File = LFM_CreateModalFileManager('editVideoMp4itemFile', $option_video_mp4_file, 'insert', 'showEditVideoMp4File', false, false, false, 'انتخاب فایل ویدئویی (mp4)', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $itmeVideoWebmFile = LFM_CreateModalFileManager('editVideoWebmFile', $option_video_webm_file, 'insert', 'showEditVideoWebmFile', false, false, false, 'انتخاب فایل ویدئویی(webm)', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $itmeVideoOggFile = LFM_CreateModalFileManager('editVideoOggFile', $option_video_ogg_file, 'insert', 'showEditVideoOggFile', false, false, false, 'انتخاب فایل ویدئویی(ogg)', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $itmeAudioOggFile = LFM_CreateModalFileManager('editAudioOggFile', $option_audio_ogg_file, 'insert', 'showEditAudioOggFile', false, false, false, 'انتخاب فایل صوتی(ogg)', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $itmeAudioMp3File = LFM_CreateModalFileManager('editAudioMp3File', $option_audio_mp3_file, 'insert', 'showEditAudioMp3File', false, false, false, 'انتخاب فایل صوتی(mp3)', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $itmeAudioWavFile = LFM_CreateModalFileManager('editAudioWavFile', $option_audio_wav_file, 'insert', 'showEditAudioWavFile', false, false, false, 'انتخاب فایل صوتی(wav)', 'btn-block', 'fa fa-folder-open font_button mr-2');

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
        $multi_langFunc = config('laravel_gallery_system.multi_lang');
        if ($multi_langFunc)
        {
            $multi_lang = json_encode($multi_langFunc());
            $active_lang_title = $this->searchForId($item->lang_id, $multi_langFunc());
        }
        else
        {
            $multi_lang = false;
            $active_lang_title = '';
        }
        $item_form = view('laravel_gallery_system::backend.gallery.view.edit_item', compact('item', 'itmeFile', 'itmeVideoMp4File'
            , 'itmeVideoWebmFile', 'itmeVideoOggFile', 'itmeAudioOggFile', 'itmeAudioMp3File', 'itmeAudioWavFile', 'itmeFileLoad', 'itmeVideoMp4FileLoad', 'itmeVideoWebmFileLoad',
            'itmeVideoOggFileLoad', 'itmeAudioOggFileLoad', 'itmeAudioMp3FileLoad', 'itmeAudioWavFileLoad', 'pic_class', 'audio_class', 'video_class', 'tags', 'multi_lang', 'active_lang_title'))->render();
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
        $item = GalleryItem::find(LFM_GetDecodeId($request->item_id));
        $item->title = $request->title;
        $item->description = $request->description;
        $item->type = $request->type;
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
        if ($request->lang_id)
        {
            $lang_id = $request->lang_id;
            $item->lang_id = $lang_id;
        }
        $item->save();
        $res['tag'] = LTS_saveTag($item, $request->tag, 'tags', 'tags', 'sync');
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
        $item = GalleryItem::find(LFM_GetDecodeId($request->item_id));
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


    //-------------------------------------------------- Auto Complete function -----------------------------------------------
    public function autoCompleteGalleryParrent(Request $request)
    {
        $x = $request->term;
        $data = Gallery::select("id", 'title AS text')->where('is_active', '1');
        if ($x['term'] != '...')
        {
            $data = Gallery::select("id", 'title AS text')
                ->where('is_active', '1')
                ->where("title", "LIKE", "%" . $x['term'] . "%");
        }
        $data = $data->get()->makeVisible('id');
        $data = ['results' => $data];

        return response()->json($data);
    }

    public function saveOrderGalleryForm(Request $request)
    {
        $item_id = LFM_GetDecodeId($request->item_id);
        $parrent_id = LFM_GetDecodeId($request->parrent_id);
        $count = $this->reOrderGalleryForm($parrent_id);
        $gallery = Gallery::find($item_id);
        $order = $gallery->order;
        if ($request->order_type == 'increase')
        {
            $nextItem = Gallery::where([
                ['parent_id', $parrent_id],
                ['order', $order + 1]
            ])->first();
            if ($nextItem)
            {
                $gallery->order = $order + 1;
                $gallery->save();
                //set new order
                $nextItem->order = $order;
                $nextItem->save();
            }
        }
        elseif ($request->order_type == 'decrease')
        {

            $previousItem = Gallery::where([
                ['parent_id', $parrent_id],
                ['order', $order - 1]
            ])->first();
            if ($previousItem)
            {
                $gallery->order = $order - 1;
                $gallery->save();
                //set new order
                $previousItem->order = $order;
                $previousItem->save();
            }
        }
        else
        {
            $result['error'][] = "متاسفانه با مشکل مواجه شد!";
            $result['success'] = false;

            return response()->json($result, 200)->withHeaders(['Content-Type' => 'json', 'charset' => 'utf-8']);
        }
        $result['message'][] = "با موفقیت انجام شد.";
        $result['success'] = true;

        return response()->json($result, 200)->withHeaders(['Content-Type' => 'json', 'charset' => 'utf-8']);
    }

    public function saveOrderGalleryItemForm(Request $request)
    {
        $item_id = LFM_GetDecodeId($request->item_id);
        $gallery_id = LFM_GetDecodeId($request->gallery_id);
        $count = $this->reOrderGalleryItemForm($gallery_id);
        $item = GalleryItem::find($item_id);
        $order = $item->order;
        if ($request->order_type == 'increase')
        {
            $nextItem = GalleryItem::where([
                ['gallery_id', $gallery_id],
                ['order', $order + 1]
            ])->first();
            if ($nextItem)
            {
                $item->order = $order + 1;
                $item->save();
                //set new order
                $nextItem->order = $order;
                $nextItem->save();
            }
        }
        elseif ($request->order_type == 'decrease')
        {
            $previousItem = GalleryItem::where([
                ['gallery_id', $gallery_id],
                ['order', $order - 1]
            ])->first();
            if ($previousItem)
            {
                $item->order = $order - 1;
                $item->save();
                //set new order
                $previousItem->order = $order;
                $previousItem->save();
            }
        }
        else
        {
            $result['error'][] = "متاسفانه با مشکل مواجه شد!";
            $result['success'] = false;

            return response()->json($result, 200)->withHeaders(['Content-Type' => 'json', 'charset' => 'utf-8']);
        }
        $result['message'][] = "با موفقیت انجام شد.";
        $result['success'] = true;

        return response()->json($result, 200)->withHeaders(['Content-Type' => 'json', 'charset' => 'utf-8']);
    }


    //-------------------------------------------------- ّ Front Controllers--------------- -------------------------------------
    public function getGalleryItemFront(Request $request)
    {
        $gallery_id = LFM_GetDecodeId($request->gallery_id);
        $lang_id = $request->lang_id;
        if ($lang_id == 0)
        {
            $lang_id = false;
        }
        $galleries = Gallery::withCount(
            [
                'likes'    => function ($e) {
                    $e->where('type', '1');
                },
                'disLikes' => function ($e) {
                    $e->where('type', '-1');
                },
                'visits',
            ]
        )->with('tags')->where('parent_id', $gallery_id)->where('lang_id', $lang_id)->where('is_active', '1')->get();
        if ($gallery_id != 0)
        {
            //increase visits
            $this->setVisit('ArtinCMS\LGS\Model\Gallery', $gallery_id, $request->ip);
            $myGallery = Gallery::withCount(
                [
                    'likes'    => function ($e) {
                        $e->where('type', '1');
                    },
                    'disLikes' => function ($e) {
                        $e->where('type', '-1');
                    },
                    'visits'
                ]
            )->with('parrent')->find($gallery_id);
            $myGallery->string_description = strip_tags($myGallery->description);
            $myGallery->main_id = $gallery_id;
            $result['gallery'] = $myGallery;
            $images = GalleryItem::withCount(
                [
                    'likes'    => function ($e) {
                        $e->where('type', '1');
                    },
                    'disLikes' => function ($e) {
                        $e->where('type', '-1');
                    },
                    'visits'
                ]
            )->with('files')->where('gallery_id', $gallery_id)->where('lang_id', $lang_id)->where('is_active', '1')->get();
            $result['images'] = $images;
            $result['showHeader'] = true;
        }
        else
        {
            $result['images'] = [];
            $result['showHeader'] = false;
            $result['gallery'] = ['id' => 0, 'encode_id' => 0, 'main_id' => 0, 'par', 'title' => __('laravel_gallery_system.home')];
        }
        $result['galleries'] = $galleries;
        if (config('laravel_gallery_system.show_bread_crumb'))
        {
            $result['showBread'] = true;

        }
        else
        {
            $result['showBread'] = false;
        }
        $result['lang'] = (string)app()->getLocale();
        $result['encode_id'] = LFM_getEncodeId(LFM_GetDecodeId($gallery_id));
        $result['h_b_color'] = config('laravel_gallery_system.header_back_color');
        $result['h_f_color'] = config('laravel_gallery_system.header_font_color');

        return $result;
    }

    public function searchForId($id, $array)
    {
        foreach ($array as $value)
        {
            if ($value['id'] == $id)
            {
                return $value['text'];
            }
        }

        return null;
    }

    public function setVisit($model, $id, $ip)
    {
        $item = new Visit;
        if (Auth::user())
        {
            if (isset(Auth::user()->id))
            {
                $item->user_id = Auth::user()->id;
            }
        }
        $item->ip = $ip;
        $item->target_id = $id;
        $item->target_type = $model;
        $item->save();
        $result = [
            'success' => true,
        ];

        return $result;
    }
}
