<div class="space-20"></div>
<form id="frm_edit_portfolio" class="form-horizontal" name="frm_edit_portfolio">
    <input type="hidden" name="item_id" value="{{$portfolio->encode_id}}">
    @if($multiLang)
    <div class="form-group row fg_lang">
        <label class="col-sm-2 control-label col-form-label label_post" for="lang">
            <span class="more_info"></span>
            <span class="label_lang">انتخاب زبان</span>
        </label>
        <div class="col-sm-6">
            <select class="form-control" name="lang_id" id="FaqSelectLangEdit">
                <option value="{{$portfolio->lang_id}}" value="-1">{{$active_lang_title}}</option>
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
            <input name="title" value="{{$portfolio->title}}" class="form-control" id="portfolio_title" tab="1">
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
        <div class="col-6">
            <textarea class="form-control" name="description" id="portfolio_eidt_description" rows="3">{!! $portfolio->description !!}</textarea>
        </div>
    </div>
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">انتخاب تگ</span>
        </label>
        <div class="col-sm-6">
            <select class="form-control" multiple id="showSelectTagEdit" name="tag[]">
                @if($tags)
                @foreach($tags as $tag)
                <option value="{{$tag->id}}" selected>{{$tag->title}}</option>
                @endforeach
                @endif
            </select>
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">انتخاب تصویر پیش فرض</label>
        <div class="col-lg-6 col-sm-12 col-md-5">
            <div class="card bg-light mb-3" style="">
                <div class="card-header">{!! $default_img['button'] !!}</div>
                <div class="card-body">
                    {!! $default_img['modal_content'] !!}
                    <div id="show_area_medium_default_eidt_img">{!! $load_default_img['view']['medium'] !!}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">انتخاب سایر تصاویر</label>
        <div class="col-lg-6 col-sm-12 col-md-5">
            <div class="card bg-light mb-3" style="">
                <div class="card-header">{!! $portfolioFile['button'] !!}</div>
                <div class="card-body">
                    {!! $portfolioFile['modal_content'] !!}
                    <div id="show_area_medium_file_eidt_img">{!! $portfolioFileLoad['view']['medium'] !!}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfixed"></div>
    <div class="col-12">
        <button type="submit" class="float-right btn btn-success ml-2"><i class="fa fa-save margin_left_8"></i>ذخیره</button>
        <button type="button" class="float-right btn bg-secondary color_white cancel_edit_portfolio"><i class="fa fa-times margin_left_8"></i>انصراف</button>
    </div>
</form>
<script>
    init_select2_data('#FaqSelectLangEdit',{!! $multiLang !!});
    function showDefaultEditImg(res) {
        $('#show_area_medium_default_eidt_img').html(res.LoadDefaultImg.view.medium);
    }
    function showEditportfolioFile(res) {
        $('#show_area_medium_file_eidt_img').html(res.editPortfolioFile.view.medium);
    }
    $('#portfolio_eidt_description').summernote({
        height: 200,
    } );
    init_select2_ajax('#showSelectTagEdit', '{{route('LTS.autoCompleteTag')}}', true,true,true);
    init_select2_data('#FaqSelectLangEdit',{!! $multiLang !!});

</script>