<?php

namespace ArtinCMS\LGS\Controllers;


use App\Http\Controllers\Controller;
use ArtinCMS\LGS\Model\Gallery;
use ArtinCMS\LGS\Model\GalleryItem;
use ArtinCMS\LGS\Model\Portfilio;
use ArtinCMS\LGS\Model\Slider;
use ArtinCMS\LGS\Model\SliderItem;
use DataTables;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PortfolioController extends Controller
{
    private function reOrderPortfolioForm($lang_id)
    {
        $all = Portfilio::where('lang_id', $lang_id)->orderBy('order', 'asc')->get();
        $i = 1;
        foreach ($all as $item)
        {
            $item->order = $i++;
            $item->save();
        }

        return $i;
    }

    public function index()
    {
        $multiLangFunc = config('laravel_gallery_system.multiLang');
        if ($multiLangFunc)
        {
            $multiLang = json_encode($multiLangFunc());
        }
        else
        {
            $multiLang = false;
        }
        $option_default_img = ['size_file' => 2000, 'max_file_number' => 1, 'true_file_extension' => ['png', 'jpg']];
        $option_other_image = ['size_file' => 2000, 'max_file_number' => 2, 'true_file_extension' => ['png', 'jpg']];
        $default_img = LFM_CreateModalFileManager('defaultImg', $option_default_img, 'insert', 'showDefaultImg', false, false, false, 'انتخاب فایل تصویر', 'btn-block', 'fa fa-folder-open font_button mr-2');
        $option_other_image = LFM_CreateModalFileManager('OtherImg', $option_other_image, 'insert', 'showOtherImg', false, false, false, 'انتخاب فایل تصویر', 'btn-block', 'fa fa-folder-open font_button mr-2');

        return view('laravel_gallery_system::backend.portfolio.index', compact('sliderTypes', 'multiLang', 'default_img', 'option_other_image'));
    }

    public function getPortfolio(Request $request)
    {
        $port = Portfilio::with('user');
        if ($request->filter_title)
        {
            $port->where('title', 'like', '%' . $request->filter_title . '%');
        }
        if ($request->filter_lang_id != 'false')
        {
            $port->where('lang_id', (int)$request->filter_lang_id);
        }
        if ($request->filter_is_active == "1")
        {
            $port->where('is_active', '1');
        }
        elseif ($request->filter_is_active == "0")
        {
            $port->where('is_active', '0');
        }
        $multiLangFunc = config('laravel_gallery_system.multiLang');
        if ($multiLangFunc)
        {
            $multiLang = $multiLangFunc();
        }
        else
        {
            $multiLang = false;
        }

        return DataTables::eloquent($port)
            ->editColumn('id', function ($data) {
                return LFM_getEncodeId($data->id);
            })
            ->addColumn('lang_name', function ($data) use ($multiLang) {
                if ($multiLang)
                {
                    return $this->searchForId($data->lang_id, $multiLang);
                }
                else
                {
                    return '';
                }
            })
            ->editColumn('default_img', function ($data) {
                return LFM_getEncodeId($data->default_img);
            })
            ->editColumn('description', function ($data) {
                return strip_tags($data->description);
            })
            ->make(true);
    }

    public function savePortfolio(Request $request)
    {
        $port = new Portfilio;
        $port->title = $request->title;
        $port->description = $request->description;

        if (Auth::user())
        {
            if (isset(Auth::user()->id))
            {
                $port->created_by = Auth::user()->id;
            }
        }
        if ($request->lang_id)
        {
            $lang_id = $request->lang_id;
            $port->lang_id = $lang_id;
        }
        $port->save();
        $res['tag'] = LTS_saveTag($port, $request->tag);
        $res['file'] = LFM_SaveSingleFile($port, 'default_img', 'defaultImg', 'default_img_options');
        $saveMultiFile = LFM_SaveMultiFile($port, 'OtherImg', 'image', 'files');
        $res =
            [
                'success' => true,
                'title'   => "ثبت نمونه کار",
                'message' => 'نمونه کار با موفقیت ثبت شد.'
            ];

        return $res;
    }

    public function setPortfolioStatus(Request $request)
    {
        $item = Portfilio::find(LFM_GetDecodeId($request->item_id));
        if ($request->is_active == "true")
        {
            $item->is_active = "1";
            $res['message'] = ' نمونه کار فعال گردید';
        }
        else
        {
            $item->is_active = "0";
            $res['message'] = 'نمونه کار غیر فعال شد';
        }
        $item->save();
        $res['success'] = true;
        $res['title'] = 'وضعیت نمونه کار تغییر پیدا کرد .';

        return $res;
    }

    public function trashPortfolio(Request $request)
    {
        $item = Portfilio::find(LFM_GetDecodeId($request->item_id));
        $item->delete();

        $res =
            [
                'success' => true,
                'title'   => "حذف آیتم",
                'message' => 'آیتم با موفقیت حذف شد.'
            ];

        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }

    public function autoCompletePortfolio(Request $request)
    {
        $multiLangFunc = config('laravel_gallery_system.multiLang');
        $x = $request->term;
        $data = $multiLangFunc();
        if ($x['term'] != '...')
        {
            $data = $multiLangFunc()
                ->where("text", "LIKE", "%" . $x['term'] . "%");
        }
        $data = ['results' => $data];

        return response()->json($data);
    }

    public function saveOrderPortfolioForm(Request $request)
    {
        $item_id = LFM_GetDecodeId($request->item_id);
        $lang_id = $request->lang_id;
        $count = $this->reOrderPortfolioForm($lang_id);
        $port = Portfilio::find($item_id);
        $order = $port->order;
        if ($request->order_type == 'increase')
        {
            $nextItem = Portfilio::where([
                ['lang_id', $lang_id],
                ['order', $order + 1]
            ])->first();
            if ($nextItem)
            {
                $port->order = $order + 1;
                $port->save();
                //set new order
                $nextItem->order = $order;
                $nextItem->save();
            }
        }
        elseif ($request->order_type == 'decrease')
        {

            $previousItem = Portfilio::where([
                ['lang_id', $lang_id],
                ['order', $order - 1]
            ])->first();
            if ($previousItem)
            {
                $port->order = $order - 1;
                $port->save();
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
}
