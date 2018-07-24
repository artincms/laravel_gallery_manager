<div class="space-20"></div>
<form id="frm_edit_gallery" class="form-horizontal" name="frm_create_gallery">
    <input type="hidden" name="item_id" value="{{$gallery->encode_id}}">
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">عنوان</span>
        </label>
        <div class="col-sm-6">
            <input name="title" value="{{$gallery->title}}" class="form-control" id="gallery_title" tab="1">
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
        <div class="col-6">
            <textarea class="form-control" name="description" id="gallery_description" rows="3">{!! $gallery->description !!}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">گالری پدر</label>
        <div class="col-6">
            <select name="parent_id" id="gallery_parrent" class="form-control">
                <option value="0">بدون والد</option>
                @foreach($parrents as $parrent)
                    <option value="{{$parrent->id}}" @if($gallery->parent_id ==$parrent->id) selected @endif>{{$parrent->title}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">وضعیت</label>
        <div class="col-6">
            <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="gallery_status1" name="status" value="1"  @if($gallery->status ==1) checked @endif>فعال
                </label>
            </div>
            <div class="form-check-inline">
                <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="gallery_status2" name="status" value="0"  @if($gallery->status ==0) checked @endif>غیر فعال
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">انتخاب تصویر پیش فرض</label>
        <div class="col-6">
            {!! $default_img['button'] !!}
            {!! $default_img['modal_content'] !!}
            <div id="show_area_medium_load_default_img">{!! $load_default_img['view']['medium'] !!}</div>
        </div>
    </div>
    <div class="clearfixed"></div>
    <div class="col-12">
        <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>ذخیره</button>
        <button type="button" class="float-right btn bg-secondary color_white cancel_edit_gallery"><i class="fa fa-times margin_left_8"></i>انصراف</button>
    </div>
</form>
<script>
    function showDefaultImg(res) {
        $('#show_area_medium_load_default_img').html(res.LoadDefaultImg.view.medium) ;
    }
</script>

