<div class="space-20"></div>
<form id="frm_create_gallery_item" class="form-horizontal" name="frm_create_gallery">
    <input type="hidden" value="{{$item->gallery_encode_id}}" name="gallery_id">
    <input type="hidden" value="{{$item->encode_id}}" name="item_id">
    <div class="form-group row fg_title">
        <label class="col-sm-2 control-label col-form-label label_post" for="title">
            <span class="more_info"></span>
            <span class="label_title">عنوان</span>
        </label>
        <div class="col-sm-6">
            <input name="title" class="form-control" value="{{$item->title}}" id="gallery_title" tab="1">
        </div>
        <div class="col-sm-4 messages"></div>
    </div>
    <div class="form-group row fg_title">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="order">
            <span class="more_info"></span>
            <span class="label_title">ترتیب</span>
        </label>
        <div class="col-6">
            <input class="form-control" name="order" value="{{$item->order}}" id="gallery_order" tab="1">
        </div>
        <div class="col-sm-3 messages"></div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">وضعیت</label>
        <div class="col-6">
            <select id="gallery_status" name="status" class="form-control">
                <option value="-1">وضعیت را انتخاب نمایید</option>
                <option value="0" @if($item->status ==0) selected @endif>غیر فعال</option>
                <option value="1"  @if($item->status ==1) selected @endif>فعال</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">نوع فایل</label>
        <div class="col-6">
            <select id="gallery_type_edit" name="type" class="form-control">
                <option value="0"  @if($item->type ==0) selected @endif>تصویر</option>
                <option value="1" @if($item->type ==1) selected @endif>صوت</option>
                <option value="2" @if($item->type ==2) selected @endif>ویدئو</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">توضیحات</label>
        <div class="col-6">
            <textarea class="form-control" name="description" id="gallery_description" rows="3">{{$item->description}}</textarea>
        </div>
    </div>

    <div class="form-group row" id="form_group_picture_edit">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">انتخاب تصویر</label>
        <div class="col-6">
            {!! $itmeFile['button'] !!}
            {!! $itmeFile['modal_content'] !!}
        </div>
    </div>
    <div class="form-group row hidden" id="form_group_video_mp4_edit">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">انتخاب ویدئو(mp4)</label>
        <div class="col-6">
            {!! $itmeVideoMp4File['button'] !!}
            {!! $itmeVideoMp4File['modal_content'] !!}
        </div>
    </div>
    <div class="form-group row hidden" id="form_group_video_webm_edit">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">انتخاب ویدئو(webm)</label>
        <div class="col-6">
            {!! $itmeVideoWebmFile['button'] !!}
            {!! $itmeVideoWebmFile['modal_content'] !!}
        </div>
    </div>
    <div class="form-group row hidden" id="form_group_video_ogg_edit">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">انتخاب ویدئو(ogg)</label>
        <div class="col-6">
            {!! $itmeVideoOggFile['button'] !!}
            {!! $itmeVideoOggFile['modal_content'] !!}
        </div>
    </div>
    <div class="form-group row hidden" id="form_group_audio_ogg_edit">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">انتخاب فایل صوتی(ogg)</label>
        <div class="col-6">
            {!! $itmeAudioOggFile['button'] !!}
            {!! $itmeAudioOggFile['modal_content'] !!}
        </div>
    </div>
    <div class="form-group row hidden" id="form_group_audio_mp3_edit">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">انتخاب فایل صوتی(mp3)</label>
        <div class="col-6">
            {!! $itmeAudioMp3File['button'] !!}
            {!! $itmeAudioMp3File['modal_content'] !!}
        </div>
    </div>
    <div class="form-group row hidden" id="form_group_audio_wav_edit">
        <label class="col-lg-2 col-sm-12 col-md-3 control-label col-form-label label_post" for="description">انتخاب فایل صوتی(wav)</label>
        <div class="col-6">
            {!! $itmeAudioWavFile['button'] !!}
            {!! $itmeAudioWavFile['modal_content'] !!}
        </div>
    </div>
    <div class="clearfixed"></div>
    <div class="picture_area">
        <div id="show_area_medium_item_file_edit">{!! $itmeFileLoad['view']['medium'] !!}</div>
    </div>
    <div class="audio_area">
        <div id="show_area_medium_audio_ogg_file_eidt">{!! $itmeAudioOggFileLoad['view']['medium'] !!}</div>
        <div id="show_area_medium_audio_mp3_file_eidt">{!! $itmeAudioMp3FileLoad['view']['medium'] !!}</div>
        <div id="show_area_medium_audio_wav_file_eidt">{!! $itmeAudioWavFileLoad['view']['medium'] !!}</div>
    </div>
    <div class="video_area">
        <div id="show_area_medium_video_mp4_file_eidt">{!! $itmeVideoMp4FileLoad['view']['medium'] !!}</div>
        <div id="show_area_medium_video_webm_file_eidt">{!! $itmeVideoWebmFileLoad['view']['medium'] !!}</div>
        <div id="show_area_medium_video_ogg_file_eidt">{!! $itmeVideoOggFileLoad['view']['medium'] !!}</div>
    </div>
    <div class="clearfixed"></div>
    <div class="col-12">
        <button type="submit" class="float-right btn btn-primary "><i class="fa fa-save margin_left_8"></i>ذخیره</button>
        <button type="button" class="float-right btn bg-secondary cancel_edit_gallery_item_tab color_white"><i class="fa fa-times margin_left_8"></i>انصراف</button>
    </div>
</form>

<script>
    function showEdititemFile(res) {
        $('#show_area_medium_item_file'_eidt).html(res.itemFile.view.medium);
    }

    function showEditVideoMp4File(res) {
        $('#show_area_medium_video_mp4_file_eidt').html(res.videoMp4itemFile.view.medium);
    }

    function showEditVideoWebmFile(res) {
        $('#show_area_medium_video_webm_file_eidt').html(res.videoWebmFile.view.medium);
    }

    function showEditVideoOggFile(res) {
        $('#show_area_medium_video_ogg_file_eidt').html(res.videoOggFile.view.medium);
    }

    function showEditAudioOggFile(res) {
        $('#show_area_medium_audio_ogg_file_eidt').html(res.audioOggFile.view.medium);
    }

    function showEditAudioMp3File(res) {
        $('#show_area_medium_audio_mp3_file_eidt').html(res.audioMp3File.view.medium);
    }

    function showEditAudioWavFile(res) {
        $('#show_area_medium_audio_wav_file_eidt').html(res.audioWavFile.view.medium);
    }

    $(document).off("change", "#gallery_type_edit");
    $(document).on("change", "#gallery_type_edit", function () {
        show_input_file(this.value);
    });

    function show_input_file(value) {
        if (value == 2) {
            $('#form_group_video_mp4_edit').removeClass('hidden');
            $('#form_group_video_webm_edit').removeClass('hidden');
            $('#form_group_video_ogg_edit').removeClass('hidden');

            $('#form_group_audio_ogg_edit').addClass('hidden');
            $('#form_group_audio_mp3_edit').addClass('hidden');
            $('#form_group_audio_wav_edit').addClass('hidden');
            $('#form_group_picture_edit').addClass('hidden');

        }
        else if (value == 1) {
            $('#form_group_audio_ogg').removeClass('hidden');
            $('#form_group_audio_mp3').removeClass('hidden');
            $('#form_group_audio_wav').removeClass('hidden');

            $('#form_group_video_mp4').addClass('hidden');
            $('#form_group_video_webm').addClass('hidden');
            $('#form_group_video_ogg').addClass('hidden');
            $('#form_group_picture').addClass('hidden');
        }
        else {
            $('#form_group_picture').removeClass('hidden');

            $('#form_group_video_mp4').addClass('hidden');
            $('#form_group_video_webm').addClass('hidden');
            $('#form_group_video_ogg').addClass('hidden');
            $('#form_group_audio_ogg').addClass('hidden');
            $('#form_group_audio_mp3').addClass('hidden');
            $('#form_group_audio_wav').addClass('hidden');
        }
    }
</script>

