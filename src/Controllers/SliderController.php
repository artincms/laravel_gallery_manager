<?php

namespace ArtinCMS\LGS\Controllers;


use App\Http\Controllers\Controller;
use ArtinCMS\LGS\Model\Gallery;
use ArtinCMS\LGS\Model\GalleryItem;
use ArtinCMS\LGS\Model\Slider;
use ArtinCMS\LGS\Model\SliderItem;
use DataTables;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SliderController extends Controller
{
    protected $sliderTypes;
    protected $transitions;

    public function __construct()
    {
        $this->sliderTypes = [
            0 => (object)['id' => 1, 'title' => 'اسلایدر نوع یک'],
            1 => (object)['id' => 2, 'title' => 'اسلایدر نوع دو'],
        ];
        $this->transitions = [
            0 => [],
            1 => [
                (object)['id' => 0, 'title' => 'Fade','name'=> 'transitionFade'],
                (object)['id' => 1, 'title' => 'Swipe','name'=> 'transitionSwipe'],
                (object)['id' => 2, 'title' => 'Slide 2D','name'=> 'transitionSlide2d'],
                (object)['id' => 3, 'title' => 'Bars 3D','name'=> 'transitionSlide3d'],
                (object)['id' => 4, 'title' => 'Zip','name'=> 'transitionZip'],
                (object)['id' => 5, 'title' => 'Blinds 2D','name'=> 'transitionBlinds2d'],
                (object)['id' => 6, 'title' => 'Blinds 3D','name'=> 'transitionBlinds3d'],
                (object)['id' => 7, 'title' => 'Turn 3D','name'=> 'transitionTurn3d'],
                (object)['id' => 8, 'title' => 'Blocks 2D 2','name'=> 'transitionBlocks2d1'],
                (object)['id' => 9, 'title' => 'Blocks 2D 1','name'=> 'transitionBlocks2d2'],
                (object)['id' => 10, 'title' => 'Blocks 3D','name'=> 'transitionBlocks3d'],
                (object)['id' => 11, 'title' => 'Concentric','name'=> 'transitionConcentric'],
                (object)['id' => 12, 'title' => 'Warp','name'=> 'transitionWarp'],
                (object)['id' => 13, 'title' => 'Camera','name'=> 'transitionCamera'],
            ]
        ];
    }

    public function index()
    {
        $sliderTypes = $this->sliderTypes;

        return view('laravel_gallery_system::backend.slider.index', compact('sliderTypes'));
    }

    public function getSlider(Request $request)
    {
        $slider = Slider::with('user');
        if ($request->filter_title)
        {
            $slider->where('title', 'like', '%' . $request->filter_title . '%');
        }
        if ($request->filter_is_active == "1")
        {
            $slider->where('is_active', '1');
        }
        elseif ($request->filter_is_active == "0")
        {
            $slider->where('is_active', '0');
        }

        return DataTables::eloquent($slider)
            ->editColumn('id', function ($data) {
                return LFM_getEncodeId($data->id);
            })
            ->editColumn('default_img', function ($data) {
                return LFM_getEncodeId($data->default_img);
            })
            ->editColumn('description', function ($data) {
                return strip_tags($data->description);
            })
            ->make(true);
    }

    public function getAdvanceStyleOptoins(Request $request)
    {
        switch ($request->style_id)
        {
            case '1':
                $transitions = $this->transitions[1];
                break;
            default:
                $transitions = [];
                break;
        }
        $slider_advance_form = view('laravel_gallery_system::backend.slider.view.style.vue_flux', compact('transitions'))->render();
        $res =
            [
                'success'                     => true,
                'status_type'                 => "success",
                'slider_create_style_options' => $slider_advance_form
            ];
        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );

        return $res;
    }

    public function createSlider(Request $request)
    {
        $slider = new Slider;
        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->style = $request->style;
        $slider->is_active = $request->is_active;
        if (Auth::user())
        {
            if (isset(Auth::user()->id))
            {
                $slider->created_by = Auth::user()->id;
            }
        }
        $options = new \stdClass();
        $options->transition = $request->transition;
        $options->transition_speed = $request->transition_speed;
        $options->text_position = $request->text_position;
        $options->show_button = $request->show_button;
        $options->show_arrow = $request->show_arrow;
        $slider->style_options = json_encode($options);
        $slider->save();
        $res =
            [
                'success' => true,
                'title'   => "ثبت اسلایدر",
                'section' => 'defaultImg',
                'message' => 'اسلایدر با موفقیت ثبت شد.'
            ];

        return $res;
    }

    public function setStatusSlider(Request $request)
    {
        $slider = Slider::find(LFM_GetDecodeId($request->item_id));
        if ($request->is_active == "true")
        {
            $slider->is_active = "1";
            $res['message'] = ' اسلایدر فعال گردید';
        }
        else
        {
            $slider->is_active = "0";
            $res['message'] = 'اسلایدر غیر فعال شد';
        }
        $slider->save();
        $res['success'] = true;
        $res['title'] = 'وضعیت اسلایدر تغییر پیدا کرد .';

        return $res;
    }

    public function trashSlider(Request $request)
    {
        $slider = Slider::find(LFM_GetDecodeId($request->item_id))->first();
        $slider->delete();

        $res =
            [
                'success' => true,
                'title'   => "حذف اسلایدر",
                'message' => 'اسلایدر با موفقیت حذف شد.'
            ];

        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }

    public function getEditSliderForm(Request $request)
    {
        $slider = Slider::find(LFM_GetDecodeId($request->item_id));
        $slider->encode_id = LFM_getEncodeId($slider->id);
        $sliderTypes = $this->sliderTypes;
        $options = json_decode($slider->style_options);
        $transitions = $this->transitions[ $slider->style ];
        $slider_form = view('laravel_gallery_system::backend.slider.view.edit_slider', compact('slider', 'sliderTypes', 'transitions', 'options'))->render();
        $res =
            [
                'success'          => true,
                'status_type'      => "success",
                'slider_edit_view' => $slider_form
            ];
        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }

    public function editSlider(Request $request)
    {
        $slider = Slider::find(LFM_GetDecodeId($request->encode_id));
        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->style = $request->style;
        $slider->is_active = $request->is_active;
        if (Auth::user())
        {
            if (isset(Auth::user()->id))
            {
                $slider->created_by = Auth::user()->id;
            }
        }
        $options = new \stdClass();
        $options->transition = $request->transition;
        $options->transition_speed = $request->transition_speed;
        $options->text_position = $request->text_position;
        $options->show_button = $request->show_button;
        $options->show_arrow = $request->show_arrow;
        $slider->style_options = json_encode($options);
        $slider->save();
        $res =
            [
                'success' => true,
                'title'   => "ثبت اسلایدر",
                'section' => 'defaultImg',
                'message' => 'اسلایدر با موفقیت ثبت شد.'
            ];

        return $res;
    }

    //----------------------------------------------Slider Items ------------------------------------------------------------------------------
    public function getSliderItem(Request $request)
    {
        $slider = SliderItem::with('user')->where('slider_id', LFM_GetDecodeId($request->item_id));
        return DataTables::eloquent($slider)
            ->editColumn('id', function ($data) {
                return LFM_getEncodeId($data->id);
            })
            ->addColumn('title', function ($data) {
                if (isset($data->item->title))
                {
                    return $data->item->title;
                }
                else
                {
                    return '';
                }
            })
            ->addColumn('description', function ($data) {
                if (isset($data->item->description))
                {
                    return strip_tags($data->item->description);
                }
                else
                {
                    return '';
                }
            })
            ->make(true);
    }

    public function getAddSliderItem(Request $request)
    {
        $slider_id = $request->item_id;
        $sliders = SliderItem::all();
        $add_slider_form = view('laravel_gallery_system::backend.slider.view.add_slider_item', compact('sliders', 'slider_id'))->render();
        $res = [
            'success'         => true,
            'status_type'     => "success",
            'slider_add_item' => $add_slider_form
        ];
        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }

    public function createSliderItem(Request $request)
    {
        if ($request->selected_slider_items)
        {
            foreach ($request->selected_slider_items as $selected_slider_items)
            {
                $item = new SliderItem;
                $item->slider_id = LFM_GetDecodeId($request->slider_id_in_item);
                $item->item_id = LFM_GetDecodeId($selected_slider_items);
                if (Auth::user())
                {
                    if (isset(Auth::user()->id))
                    {
                        $item->created_by = Auth::user()->id;
                    }
                }
                $item->save();
            }
            $res =
                [
                    'success' => true,
                    'title'   => "ثبت آیتم جدید",
                    'message' => 'آیتم با موفقیت به اسلایدر اضافه شد.'
                ];
        }
        else
        {
            $res =
                [
                    'success' => false,
                    'title'   => "ثبت آیتم جدید",
                    'message' => 'هیچ آیتمی انتخاب نشده است .'
                ];
        }

        return $res;
    }

    public function autoCompleteGallery(Request $request)
    {
        $x = $request->term;
        $data = Gallery::select("id", 'title AS text')->where('is_active', '1');
        if ($x['term'] != '...')
        {
            $data = Gallery::select("id", 'title AS text')
                ->where('is_active', '1')
                ->where("title", "LIKE", "%" . $x['term'] . "%");
        }
        $data = $data->get();
        $data = ['results' => $data];

        return response()->json($data);
    }

    public function getViewGalleryItem(Request $request)
    {
        $galleryItems = GalleryItem::where('gallery_id', $request->gallery_id)->whereNotNull('file_id')->get();
        $view_get_gallery_item = view('laravel_gallery_system::backend.slider.view.get_view_slider_items', compact('galleryItems'))->render();
        $res = [
            'success'               => true,
            'status_type'           => "success",
            'view_get_gallery_item' => $view_get_gallery_item
        ];
        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }

    public function setSliderItemStatus(Request $request)
    {
        $slider = SliderItem::find(LFM_GetDecodeId($request->item_id));
        if ($request->is_active == "true")
        {
            $slider->is_active = "1";
            $res['message'] = ' تصویر فعال گردید';
        }
        else
        {
            $slider->is_active = "0";
            $res['message'] = 'تصویر غیر فعال شد';
        }
        $slider->save();
        $res['success'] = true;
        $res['title'] = 'وضعیت تصویر تغییر پیدا کرد .';

        return $res;
    }

    public function getSliderItemFront(Request $request)
    {
        $slider_id = $request->slider_id ;
        $sliders = Slider::find($slider_id);
        $options = json_decode($sliders->style_options) ;
        $result =LGS_propearSlider($sliders,'original',100,400,400);
        $name = $this->transitions[$sliders->style][$options->transition]->name;
        $result['transiton'] =$name;
        $result['transiton_id'] = $options->transition;
        return $result ;
    }
}
