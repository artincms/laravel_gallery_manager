<form id="frm_create_gallery_item" class="form-horizontal" name="frm_create_gallery">
    <input type="hidden" value="{{$gallery_id}}" name="gallery_id">
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">عنوان</span>
        </label>
        <div class="col-sm-6">
            <input name="title" class="form-control" id="gallery_title" tab="1">
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row fg_title">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="order">
            <span class="more_info"></span>
            <span class="label_title">ترتیب</span>
        </label>
        <div class="col-6">
            <input class="form-control" name="order" id="gallery_order" tab="1">
        </div>
        <div class="col-sm-3 messages"></div>
    </div>

    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">وضعیت</label>
        <div class="col-6">
            <select id="gallery_status" name="status" class="form-control">
                <option value="-1">وضعیت را انتخاب نمایید</option>
                <option value="0">غیر فعال</option>
                <option value="1">فعال</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">انتخاب فایل</label>
        <div class="col-6">
            {!! $itmeFile['button'] !!}
            {!! $itmeFile['modal_content'] !!}
            <div id="show_area_medium_item_file"></div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
        <div class="col-6">
            <textarea class="form-control" name="description" id="gallery_description" rows="3"></textarea>
        </div>
    </div>
    <div class="clearfixed"></div>
    <div class="col-12">
        <button type="submit" class="float-right btn btn-primary "><i class="fa fa-save margin_left_8"></i>ذخیره</button>
        <button type="button" class="float-right btn bg-secondary cancel_add_close_btn color_white"><i class="fa fa-times margin_left_8"></i>انصراف</button>
    </div>
</form>