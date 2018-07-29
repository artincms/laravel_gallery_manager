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
    <div class="form-group row fg_title">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="order">
            <span class="more_info"></span>
            <span class="label_title">ترتیب</span>
        </label>
        <div class="col-6">
            <input class="form-control" value="{{$gallery->order}}" name="order" id="gallery_order" tab="1">
        </div>
        <div class="col-sm-3 messages"></div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
        <div class="col-6">
            <textarea class="form-control" name="description" id="gallery_description" rows="3">{!! $gallery->description !!}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">وضعیت</label>
        <div class="col-6">
            <select id="gallery_is_active" name="is_active" class="form-control">
                <option value="-1">وضعیت را انتخاب نمایید</option>
                <option value="0" @if($gallery->is_active ==0) selected @endif>غیر فعال</option>
                <option value="1"  @if($gallery->is_active ==1) selected @endif>فعال</option>
            </select>
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
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">انتخاب تصویر پیش فرض</label>
        <div class="col-6">
            {!! $default_img['button'] !!}
            {!! $default_img['modal_content'] !!}
            <div id="show_area_medium_default_img">{!! $load_default_img['view']['medium'] !!}</div>
        </div>
    </div>
    <div class="clearfixed"></div>
    <div class="col-12">
        <button type="submit" class="float-right btn bg-teal-400"><b><i class="fa fa-save"></i></b>ذخیره</button>
        <button type="button" class="float-right btn btn-defaul cancel_edit_gallery"><b><i class="fa fa-times"></i></b>لغو</button>
    </div>
</form>
<script>
    function showDefaultImg(res) {
        $('#show_area_medium_default_img').html(res.defaultImg.view.medium) ;
    }
</script>

