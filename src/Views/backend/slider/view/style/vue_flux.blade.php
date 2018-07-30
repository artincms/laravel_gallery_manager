<div class="space-20"></div>
<div class="form-group row">
    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_transition" for="transition">نوع اسلایدر</label>
    <div class="col-6">
        <select name="transition" id="transitions" class="form-control">
            @foreach($transitions as $transition)
                <option value="{{$transition->id}}">{{$transition->title}}</option>
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
        <input type="number" name="transition_speed" class="form-control" id="transition_speed" tab="1">
    </div>
    <div class="col-sm-4 messages"></div>
</div>
<div class="form-group row">
    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="text_position">مکان نمایش متن</label>
    <div class="col-6">
        <select name="text_position" id="text_position" class="form-control">
           <option value="1">top</option>
           <option value="2">center</option>
           <option value="3">bottom</option>
        </select>
    </div>
</div>
<div class="form-group row ">
    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_show_button" for="show_button">نمایش دکمه ها</label>
    <div class="col-6">
        <div class="form-check-inline">
            <label class="form-check-label" for="radio2">
                <input type="radio" class="form-check-input" id="show_button_active" name="show_button" checked value="1">نمایش
            </label>
        </div>
        <div class="form-check-inline">
            <label class="form-check-label" for="radio2">
                <input type="radio" class="form-check-input" id="show_button_hide" name="show_button" value="0">پنهان
            </label>
        </div>
    </div>
</div>
<div class="form-group row ">
    <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="show_arrow">نمایش هدایتگر</label>
    <div class="col-6">
        <div class="form-check-inline">
            <label class="form-check-label" for="radio2">
                <input type="radio" class="form-check-input" id="show_arrow_active" name="show_arrow" checked value="1">نمایش
            </label>
        </div>
        <div class="form-check-inline">
            <label class="form-check-label" for="radio2">
                <input type="radio" class="form-check-input" id="show_arrow_hide" name="show_arrow" value="0">پنهان
            </label>
        </div>
    </div>
</div>

<script>
    init_select2_data('#transitions');
</script>