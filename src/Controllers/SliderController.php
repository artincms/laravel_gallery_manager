<?php

namespace ArtinCMS\LGS\Controllers;


use App\Http\Controllers\Controller;
use ArtinCMS\LGS\Model\Gallery;
use ArtinCMS\LGS\Model\GalleryItem;
use ArtinCMS\LGS\Model\Slider;
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
                (object)['id' => 1, 'title' => 'Fade'],
                (object)['id' => 2, 'title' => 'Swipe'],
                (object)['id' => 3, 'title' => 'Slide 2D'],
                (object)['id' => 4, 'title' => 'Bars 3D'],
                (object)['id' => 5, 'title' => 'Zip'],
                (object)['id' => 6, 'title' => 'Blinds 2D'],
                (object)['id' => 7, 'title' => 'Blinds 3D'],
                (object)['id' => 8, 'title' => 'Turn 3D'],
                (object)['id' => 9, 'title' => 'Blocks 2D 2'],
                (object)['id' => 9, 'title' => 'Blocks 2D 1'],
                (object)['id' => 9, 'title' => 'Blocks 3D'],
                (object)['id' => 9, 'title' => 'Concentric'],
                (object)['id' => 9, 'title' => 'Warp'],
                (object)['id' => 9, 'title' => 'Camera'],
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
                return enCodeId($data->id);
            })
            ->editColumn('default_img', function ($data) {
                return enCodeId($data->default_img);
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
                $transitions =$this->transitions[1] ;
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
        $options['transition'] = $request->transition;
        $options['transition_speed'] = $request->transition_speed;
        $options['text_position'] = $request->text_position;
        $options['show_button'] = $request->show_button;
        $options['show_arrow'] = $request->show_arrow;
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
        $slider = Slider::find(deCodeId($request->item_id)[0]);
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
        $slider = Slider::find(deCodeId($request->item_id)[0])->first();
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
        $slider = Slider::find(deCodeId($request->item_id)[0]);
        $slider->encode_id = enCodeId($slider->id);
        $sliderTypes = $this->sliderTypes ;
        $slider_form = view('laravel_gallery_system::backend.slider.view.edit_slider', compact('slider','sliderTypes'))->render();
        $res =
            [
                'success'           => true,
                'status_type'       => "success",
                'slider_edit_view' => $slider_form
            ];
        throw new HttpResponseException(
            response()
                ->json($res, 200)
                ->withHeaders(['Content-Type' => 'text/plain', 'charset' => 'utf-8'])
        );
    }
}
