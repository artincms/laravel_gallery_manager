<form id="frm_create_slider_item" class="form-horizontal" name="frm_create_slider_item">
    <input type="hidden" name="encode_id" value="{{$slider_id}}" >
    <div class="space-20"></div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_transition" for="transition">انتخاب گالری</label>
        <div class="col-6">
            <select name="slider_id" id="slider_id" class="form-control">
                @foreach($sliders as $slider)
                    <option value="{{$slider->id}}">{{$slider->title}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="show_slider_items"></div>
</form>