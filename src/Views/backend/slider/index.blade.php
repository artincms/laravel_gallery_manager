@extends('laravel_gallery_system::backend.layouts.master')
@section('page_title')
    Laravel Slider Manager
@stop
@section('custom_plugin_js')
@endsection
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header text-center">مدیریت اسلایدرها</div>
            <div class="card-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs nav-tabs-bottom" id="slider_tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" href="#manage_tab" data-toggle="tab"><i class="fas fa-th-list"></i><span class="margin_right_5">مدیریت اسلایدرها</span></a></li>
                        <li class="nav-item add_slider_tab">
                            <a class="nav-link" href="#add_slider" data-toggle="tab">
                                <i class="far fa-plus-square"></i>
                                <span>افزودن</span>
                            </a>
                        </li>
                        <li class="nav-item edit_slider_tab hidden">
                            <a href="#edit_slider" class="nav-link paddin_left_30" data-toggle="tab">
                                <span class="span_edit_slider_tab">ویرایش</span>
                            </a>
                            <button class="close closeTab cancel_edit_slider" type="button">×</button>
                        </li>
                        <li class="nav-item manage_slider_item_tab hidden">
                            <a href="#manage_tab_item" class="nav-link paddin_left_30" data-toggle="tab">
                                <span class="span_manage_slider_item_tab">مدیریت آیتم</span>
                            </a>
                            <button class="close closeTab cancel_manage_slider_item" type="button">×</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="manage_tab">
                            <div>
                                <div class="space-20"></div>
                                <div class="col-xs-12 slider_manager_parrent_div">
                                    <table id="SliderManagerGridData" class="table " width="100%"></table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="add_slider">
                            <form id="frm_create_slider" class="form-horizontal" name="frm_create_slider">
                            <div class="space-20"></div>
                                <div class="tabbable">
                                <ul class="nav nav-tabs nav-tabs-bottom" id="add_slider_original_tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#add_slider_original" data-toggle="tab">
                                            <i class="fas fa-th-list"></i>
                                            <span class="margin_right_5">اطلاعات عمومی</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" id="add_slider_advance_tab">
                                        <a class="nav-link" href="#add_slider_advance" data-toggle="tab">
                                            <i class="far fa-plus-square"></i>
                                            <span id="span_advance_setting">تنظیمات پیشرفته</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="add_slider_original">
                                        <div class="space-20"></div>
                                            <div class="form-group row fg_title">
                                                <label class="col-sm-2 control-label col-form-label label_post" for="title">
                                                    <span class="more_info"></span>
                                                    <span class="label_title">عنوان</span>
                                                </label>
                                                <div class="col-sm-6">
                                                    <input name="title" class="form-control" id="slider_title" tab="1">
                                                </div>
                                                <div class="col-sm-4 messages"></div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">نوع اسلایدر</label>
                                                <div class="col-6">
                                                    <select name="style" id="style" class="form-control">
                                                        @foreach($sliderTypes as $type)
                                                            <option id="slider_type_{{$type->id}}" value="{{$type->id}}">{{$type->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
                                                <div class="col-6">
                                                    <textarea class="form-control" name="description" id="slider_description" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row ">
                                                <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">وضعیت</label>
                                                <div class="col-6">
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="radio2">
                                                            <input type="radio" class="form-check-input" id="slider_is_active1" name="is_active" checked value="1">فعال
                                                        </label>
                                                    </div>
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="radio2">
                                                            <input type="radio" class="form-check-input" id="slider_is_active2" name="is_active" value="0">غیر فعال
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfixed"></div>
                                    </div>
                                    <div class="tab-pane" id="add_slider_advance"></div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>ذخیره</button>
                                    <button type="button" class="float-right btn bg-secondary color_white cancel_add_slider"><i class="fa fa-times margin_left_8"></i>انصراف</button>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="edit_slider"></div>
                        <div class="tab-pane" id="manage_tab_item">
                            <div class="space-20"></div>
                                <div class="tabbable">
                                    <ul class="nav nav-tabs nav-tabs-bottom" id="slider_tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#manage_tab_slider_item" data-toggle="tab">
                                                <i class="fas fa-th-list"></i>
                                                <span class="margin_right_5">مدیریت تصاویر</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" id="add_slider_item_tab">
                                            <a class="nav-link" href="#add_slider_item" data-toggle="tab">
                                                <i class="far fa-plus-square"></i>
                                                <span>افزودن تصویر</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="manage_tab_slider_item"></div>
                                        <div class="tab-pane" id="add_slider_item">
                                            <div class="space-20"></div>
                                            <form id="frm_create_slider_item" class="form-horizontal" name="frm_create_slider_item">
                                                <input type="hidden" id="slider_id_in_item" name="slider_id_in_item" value="" >
                                                <div class="space-20"></div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_transition" for="transition">انتخاب گالری</label>
                                                    <div class="col-6">
                                                        <select name="slider_id" id="slider_id" class="form-control">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_transition" for="transition"></label>
                                                    <div class="col-lg-10 col-sm-12 col-md-9">
                                                        <div class="show_slider_items"></div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>ذخیره</button>
                                                    <button type="button" class="float-right btn bg-secondary color_white cancel_add_slider_item"><i class="fa fa-times margin_left_8"></i>انصراف</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('inline_js')
    @include('laravel_gallery_system::backend.slider.helper.inline_js')
    @include('laravel_gallery_system::backend.slider.helper.item_inline_js')
@stop