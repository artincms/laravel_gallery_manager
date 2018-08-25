@extends('laravel_gallery_system::backend.layouts.master')
@section('page_title')
Laravel Gallery Manager
@stop
@section('custom_plugin_js')
@endsection
@section('content')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header text-center">مدیریت نمونه کارها</div>
            <div class="card-body">
                <div class="tabbable">
                    <ul class="nav nav-tabs nav-tabs-bottom" id="portfolio_tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" href="#manage_tab" data-toggle="tab"><i class="fas fa-th-list"></i><span class="margin_right_5">مدیریت نمونه کارها</span></a></li>
                        <li class="nav-item add_portfolio_tab">
                            <a class="nav-link" href="#add_portfolio" data-toggle="tab">
                                <i class="far fa-plus-square"></i>
                                <span>افزودن</span>
                            </a>
                        </li>
                        <li class="nav-item edit_portfolio_tab hidden">
                            <a href="#edit_portfolio" class="nav-link paddin_left_30" data-toggle="tab">
                                <span class="span_edit_portfolio_tab">ویرایش</span>
                            </a>
                            <button class="close closeTab cancel_edit_portfolio" type="button">×</button>
                        </li>
                        <li class="nav-item manage_portfolio_related_item_tab hidden">
                            <a href="#manage_tab_related_item" class="nav-link paddin_left_30" data-toggle="tab">
                                <span class="span_manage_portfolio_related_item_tab">مدیریت نمونه کارهای مرتبط</span>
                            </a>
                            <button class="close closeTab cancel_manage_portfolio_related_item" type="button">×</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="manage_tab">
                            <div>
                                <div class="space-20"></div>
                                <div class="col-xs-12 portfolio_manager_parrent_div">
                                    <table id="PortfolioManagerGridData" class="table " width="100%"></table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="add_portfolio">
                            <div class="space-20"></div>
                            <form id="frm_create_portfolio" class="form-horizontal" name="frm_create_portfolio">
                                @if($multiLang)
                                <div class="form-group row fg_lang">
                                    <label class="col-sm-2 control-label col-form-label label_post" for="lang">
                                        <span class="more_info"></span>
                                        <span class="label_lang">انتخاب زبان</span>
                                    </label>
                                    <div class="col-sm-6">
                                        <select class="form-control" name="lang_id" id="PortfolioSelectLang">
                                            <option value="-1">انتخاب زبان</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 messages"></div>
                                </div>
                                @endif
                                <div class="form-group row fg_title">
                                    <label class="col-sm-2 control-label col-form-label label_post" for="title">
                                        <span class="more_info"></span>
                                        <span class="label_title">عنوان</span>
                                    </label>
                                    <div class="col-sm-6">
                                        <input name="title" class="form-control" id="portfolio_title" tab="1">
                                    </div>
                                    <div class="col-sm-4 messages"></div>
                                </div>
                                <div class="form-group row fg_title">
                                    <label class="col-sm-2 control-label col-form-label label_post" for="title">
                                        <span class="more_info"></span>
                                        <span class="label_title">انتخاب تگ</span>
                                    </label>
                                    <div class="col-sm-6">
                                        <select class="form-control" multiple id="showSelectTag" name="tag[]">
                                        </select>
                                    </div>
                                    <div class="col-sm-4 messages"></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
                                    <div class="col-6">
                                        <textarea class="form-control" name="description" id="portfolio_description" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">انتخاب تصویر پیش فرض</label>
                                    <div class="col-lg-6 col-sm-12 col-md-5">
                                        <div class="card bg-light mb-3" style="">
                                            <div class="card-header">{!! $default_img['button'] !!}</div>
                                            <div class="card-body">
                                                {!! $default_img['modal_content'] !!}
                                                <div id="show_area_medium_default_img"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">سایر تصاویر</label>
                                    <div class="col-lg-6 col-sm-12 col-md-5">
                                        <div class="card bg-light mb-3" style="">
                                            <div class="card-header">{!! $option_other_image['button'] !!}</div>
                                            <div class="card-body">
                                                {!! $option_other_image['modal_content'] !!}
                                                <div id="show_area_medium_other_img"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfixed"></div>
                                <div class="col-12">
                                    <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>ذخیره</button>
                                    <button type="button" class="float-right btn bg-secondary color_white cancel_add_close_btn"><i class="fa fa-times margin_left_8"></i>انصراف</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="edit_portfolio"></div>
                        <div class="tab-pane" id="manage_tab_related_item">
                            <div class="space-20"></div>
                            <form id="frm_edit_portfolio_related" class="form-horizontal" name="frm_edit_portfolio_related">
                                <input type="hidden" name="item_id" class="input_related_portfolio" value="">
                                <div class="form-group row fg_title">
                                    <label class="col-sm-2 control-label col-form-label label_post" for="title">
                                        <span class="more_info"></span>
                                        <span class="label_title">انتخاب نمونه کار مرتبط</span>
                                    </label>
                                    <div class="col-sm-6">
                                        <select class="form-control" multiple id="selectPortfolioRelated" name="related_id[]">
                                        </select>
                                    </div>
                                    <div class="col-sm-4 messages"></div>
                                </div>
                                <div class="clearfixed"></div>
                                <div class="col-12">
                                    <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>افزودن</button>
                                </div>
                            </form>
                            <div class="space-20"></div>
                            <div>
                                <div class="space-20"></div>
                                <div class="col-xs-12 portfolio_manager_related_parrent_div">

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
    @include('laravel_gallery_system::backend.portfolio.helper.inline_js')
@stop