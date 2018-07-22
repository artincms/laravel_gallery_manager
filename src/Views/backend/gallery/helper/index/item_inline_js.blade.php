<script>
    window['gallery_item_columns'] = [
        {
            width: '5%',
            data: 'id',
            title: 'ردیف',
            searchable: false,
            sortable: false,
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            data: 'id',
            name: 'id',
            title: 'آی دی',
            visible: false
        },
        {
            data: 'file_id',
            name: 'file_id',
            title: 'فایل',
            mRender: function (data, type, full) {
                var img = full.file_id;
                if (typeof img === 'undefined' || img === null || img === '') {
                    return "";
                }
                else {
                    return '<img width="112" height="70" src="{{ route('LFM.DownloadFile',['ID',''])}}/' + img + '/small/404.png/100/112/70?0" alt="" class="img-rounded img-preview">';
                }
            }
        },
        {
            data: 'title',
            name: 'title',
            title: 'عنوان',
        },
        {
            data: 'description',
            name: 'description',
            title: 'توضیحات',
        },
        {
            width: '5%',
            data: 'status',
            name: 'status',
            title: 'وضعیت',
            mRender: function (data, type, full) {
                var ch = '';
                if (parseInt(full.status))
                    ch = 'checked';
                else
                    ch = '';
                return '<input class="styled " id="change_item_status_' + full.id + '" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_status_item(this)"' + ch + '>'
            }
        },
        {
            width: '5%',
            searchable: false,
            sortable: false,
            title: 'عملیات',
            mRender: function (data, type, full) {
                return '' +
                    '<a class="btn_edit_gallery_item pointer" data-item_id="' + full.id + '" data-title="' + full.title + '">' +
                    '   <i class="fa fa-edit"></i>' +
                    '</a>' +
                    '<a class="btn_trash_gallery_item pointer" style="color: red" data-item_id="' + full.id + '" data-title="' + full.title + '">' +
                    '   <i class="fa fa-trash"></i>' +
                    '</a>'
            }
        }
    ];
    var create_gallery_item_constraints = {
        title: {
            presence: {message: '^<strong>عنوان فرم ضروریست.</strong>'}
        }
    };
    $(document).off("click", ".show_gallery_item");
    $(document).on("click", ".show_gallery_item", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('a[href="#manage_tab_item"]').click();
        $('.manage_gallery_item_tab').removeClass('hidden');
        var html = '' +
            '<div class="space-20"></div>' +
            '<table id="GalleryItemGridData" class="table" width="100%"></table>';
        $('.span_manage_gallery_item_tab').html('گالری : ' + title);
        $('#manage_tab_gallery_item').html(html);
        dataTablesGrid('#GalleryItemGridData', 'GalleryItemGridData', '{{ route('LGS.getGalleryItem') }}', gallery_item_columns, {item_id: item_id}, null, true, null, null, 1, 'desc');

        $(document).off("click", "#add_gallery_item_tab");
        $(document).on("click", "#add_gallery_item_tab", function () {
            get_gallery_item(item_id);
        });

        function get_gallery_item(item_id) {
            $('#add_gallery_picture').append(generate_loader_html('لطفا منتظر بمانید...'));
            $.ajax({
                type: "POST",
                url: '{{ route('LGS.getAddGalleryItemForm')}}',
                dataType: "json",
                data: {
                    item_id: item_id
                },
                success: function (result) {
                    $('#edit_gallery .total_loader').remove();
                    if (result.status == true) {
                        $('#add_gallery_item').html(result.gallery_add_item);
                        var frm_gallery_add_item = document.querySelector("#frm_create_gallery_item");
                        init_validatejs(frm_gallery_add_item, create_gallery_item_constraints, ajax_func_add_gallery_item);

                        function ajax_func_add_gallery_item(formElement) {
                            var formData = new FormData(formElement);
                            $.ajax({
                                type: "POST",
                                url: '{{ route('LGS.createGalleryItem')}}',
                                dataType: "json",
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (data) {
                                    $('#frm_create_gallery_item .total_loader').remove();
                                    if (data.status == -1) {
                                        showMessages(data.message, 'form_message_box', 'error', formElement);
                                        showErrors(formElement, data.errors);
                                    }
                                    else {
                                        clear_form_elements('#frm_create_gallery_item');
                                        menotify('success', data.title, data.message);
                                        GalleryItemGridData.ajax.reload(null, false);
                                        $('a[href="#manage_tab_gallery_item"]').click();
                                        $('#show_area_medium_item_file').html('');
                                    }
                                }
                            });
                        }
                    }
                }
            });
        }
    });

    /*___________________________________________________close manage_____________________________________________________________________*/
    $(document).off("click", ".cancel_manage_gallery_item");
    $(document).on("click", ".cancel_manage_gallery_item", function () {
        $('a[href="#manage_tab"]').click();
        $('.manage_gallery_item_tab').addClass('hidden');
        //$('#edit_gallery').html('');
    });

    /*___________________________________________________change status_____________________________________________________________________*/
    function change_status_item(input) {
        console.log();
        var checked = input.checked;
        var id = input.id;
        var item_id = $(input).data('item_id');
        var parameters = {status: checked, item_id: item_id};
        yesNoAlert('تغییر وضعیت کاربر', 'از تغییر وضعیت کاربر مطمئن هستید ؟', 'warning', 'بله، وضعیت کاربر را تغییر بده!', 'لغو', set_item_status, parameters, remove_checked_item, parameters);
    }

    function set_item_status(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LGS.setItemStatus') !!}',
            data: params,
            success: function (result) {
                if (result.success) {
                    menotify('success', result.title, result.message);
                }
                else {

                }
            }
        });
    }

    function remove_checked_item(params) {
        var $this = $('#change_item_status_' + params.item_id);
        if (params.status) {
            $this.prop('checked', false);
        }
        else {
            $this.prop('checked', true);
        }
    }

    /*___________________________________________________add item_____________________________________________________________________*/

    function showitemFile(res) {
        $('#show_area_medium_item_file').html(res.itemFile.view.medium);
    }
    function showVideoMp4File(res) {
        $('#show_area_medium_video_mp4_file').html(res.videoMp4itemFile.view.medium);
    }
    function showVideoWebmFile(res) {
        $('#show_area_medium_video_webm_file').html(res.videoWebmFile.view.medium);
    }
    function showVideoOggFile(res) {
        $('#show_area_medium_video_ogg_file').html(res.videoOggFile.view.medium);
    }
    function showAudioOggFile(res) {
        $('#show_area_medium_audio_ogg_file').html(res.audioOggFile.view.medium);
    }
    function showAudioMp3File(res) {
        $('#show_area_medium_audio_mp3_file').html(res.audioMp3File.view.medium);
    }
    function showAudioWavFile(res) {
        $('#show_area_medium_audio_mp3_file').html(res.audioWavFile.view.medium);
    }
    /*___________________________________________________Edit Gallery Item_____________________________________________________________________*/
    $(document).off("click", ".btn_edit_gallery_item ");
    $(document).on("click", ".btn_edit_gallery_item ", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('.span_edit_gallery_item_tab').html('ویرایش آیتم: ' + title);
        get_edit_gallery_item_form(item_id);
    });

    function get_edit_gallery_item_form(item_id) {
        $('#edit_gallery_item').children().remove();
        $('#edit_gallery_item').append(generate_loader_html('لطفا منتظر بمانید...'));
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.getEditGalleryItemForm')}}',
            dataType: "json",
            data: {
                item_id: item_id
            },
            success: function (result) {
                $('#edit_gallery_item .total_loader').remove();
                if (result.status == true) {
                    $('#edit_gallery_item').append(result.gallery_item_edit_view);
                    $('.edit_gallery_item_tab').removeClass('hidden');
                    $('a[href="#edit_gallery_item"]').click();

                    var edit_gallery_item_form_id = document.querySelector("#frm_create_gallery_item");
                    init_validatejs(edit_gallery_item_form_id, create_gallery_item_constraints, ajax_func_edit_gallery_item);
                }
                else {

                }
            }
        });
    }

    function ajax_func_edit_gallery_item(formElement) {
        var formData = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.editGalleryItem')}}',
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#frm_edit_gallery .total_loader').remove();
                if (data.status == -1) {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
                else {
                    menotify('success', data.title, data.message);
                    GalleryItemGridData.ajax.reload(null, false);
                    $('a[href="#manage_tab_gallery_item"]').click();
                    $('.edit_gallery_item_tab').addClass('hidden');
                    $('#edit_gallery_item').html('');
                }
            }
        });
    }

    /*___________________________________________________cancel edit gallery item button_____________________________________________________________________*/
    $(document).off("click", ".cancel_edit_gallery_item_tab");
    $(document).on("click", ".cancel_edit_gallery_item_tab", function () {
        $('a[href="#manage_tab_gallery_item"]').click();
        $('.edit_gallery_item_tab').addClass('hidden');
        $('#edit_gallery_item').html('');
    });

    /*___________________________________________________Trash Gallery Item_____________________________________________________________________*/
    $(document).off("click", ".btn_trash_gallery_item");
    $(document).on("click", ".btn_trash_gallery_item", function () {
        var item_id = $(this).data('item_id');
        var parameters = {item_id:item_id};
        yesNoAlert('حذف گالری', 'از حذف گالری مطمئن هستید ؟', 'warning', 'بله، گالری را حذف کن!', 'لغو', trash_gallery_item, parameters);
    });

    function trash_gallery_item(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LGS.trashGalleryItem') !!}',
            data: params,
            success: function (data) {
                if (data.status == -1) {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
                else {
                    menotify('success', data.title, data.message);
                    GalleryItemGridData.ajax.reload(null,false);
                }
            }
        });
    }

</script>