<form id="frm_edit_slider" class="form-horizontal" name="frm_edit_slider">
    <input type="hidden" name="encode_id" value="{{$slider->encode_id}}" >
    <div class="space-20"></div>
    <div class="tabbable">
        <ul class="nav nav-tabs nav-tabs-bottom" id="edit_slider_original_tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#edit_slider_original" data-toggle="tab">
                    <i class="fas fa-th-list"></i>
                    <span class="margin_right_5">اطلاعات عمومی</span>
                </a>
            </li>
            <li class="nav-item" id="edit_slider_advance_tab">
                <a class="nav-link" href="#edit_slider_advance" data-toggle="tab">
                    <i class="far fa-plus-square"></i>
                    <span>تنظیمات پیشرفته</span>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="edit_slider_original">
                <div class="space-20"></div>
                <div class="form-group row fg_title">
                    <label class="col-sm-2 control-label col-form-label label_post" for="title">
                        <span class="more_info"></span>
                        <span class="label_title">عنوان</span>
                    </label>
                    <div class="col-sm-6">
                        <input name="title" class="form-control" value="{{$slider->title}}" id="edit_slider_title" tab="1">
                    </div>
                    <div class="col-sm-4 messages"></div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
                    <div class="col-6">
                        <textarea class="form-control" name="description" id="edit_slider_description" rows="5">{{$slider->description}}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">نوع اسلایدر</label>
                    <div class="col-6">
                        <select name="style" id="edit_style" class="form-control">
                            @foreach($sliderTypes as $type)
                                <option value="{{$type->id}}" @if($slider->style == $type->id) selected @endif>{{$type->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">وضعیت</label>
                    <div class="col-6">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                                <input type="radio" class="form-check-input" id="edit_slider_is_active1" name="is_active" @if($slider->is_active == 1) checked @endif value="1">فعال
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                                <input type="radio" class="form-check-input" id="editslider_is_active2" name="is_active" @if($slider->is_active == 0) checked @endif value="0">غیر فعال
                            </label>
                        </div>
                    </div>
                </div>
                <div class="clearfixed"></div>
            </div>
            <div class="tab-pane" id="edit_slider_advance">
                <div class="space-20"></div>
                <div class="form-group row">
                    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_transition" for="transition">نوع اسلایدر</label>
                    <div class="col-6">
                        <select name="transition" id="transitions" class="form-control">
                            @foreach($transitions as $transition)
                                <option value="{{$transition->id}}" @if($options->transition == $transition->id ) selected @endif>{{$transition->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row fg_title">
                    <label class="col-sm-2 control-label col-form-label label_transition_speed" for="transition_speed">
                        <span class="more_info"></span>
                        <span class="label_transition_speed">سرعت اسلایدر</span>
                    </label>
                    <div class="col-sm-6">
                        <input type="number" name="transition_speed" value="{{$options->transition_speed}}" class="form-control" id="transition_speed" tab="1">
                    </div>
                    <div class="col-sm-4 messages"></div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="text_position">مکان نمایش متن</label>
                    <div class="col-6">
                        <select name="text_position" id="text_position" class="form-control">
                            <option value="1" @if($options->text_position == 1) selected   @endif>top</option>
                            <option value="2" @if($options->text_position == 2) selected   @endif>center</option>
                            <option value="3" @if($options->text_position == 3) selected   @endif>bottom</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_show_button" for="show_button">نمایش دکمه ها</label>
                    <div class="col-6">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                                <input type="radio" class="form-check-input" id="show_button_active" name="show_button" @if($options->show_button == 1) checked   @endif value="1">نمایش
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                                <input type="radio" class="form-check-input" id="show_button_hide" name="show_button" value="0" @if($options->show_button == 0) checked   @endif>پنهان
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row ">
                    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="show_arrow">نمایش هدایتگر</label>
                    <div class="col-6">
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                                <input type="radio" class="form-check-input" id="show_arrow_active" name="show_arrow" @if($options->show_arrow == 1) checked   @endif value="1">نمایش
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                                <input type="radio" class="form-check-input" id="show_arrow_hide" name="show_arrow" value="0" @if($options->show_arrow == 0) checked   @endif>پنهان
                            </label>
                        </div>
                    </div>
                </div>

                <script>
                    init_select2_data('#transitions');
                </script>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>ذخیره</button>
            <button type="button" class="float-right btn bg-secondary color_white cancel_edit_slider"><i class="fa fa-times margin_left_8"></i>انصراف</button>
        </div>
    </div>
</form>