<script>
    //get gallery
    window['gallery_grid_columns'] = [
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
            visible:false
        },
        {
            width: '20%',
            data: 'default_img',
            name: 'default_img',
            title: 'پیش نمایش',
            mRender: function (data, type, full) {
                var img = full.default_img;
                if (typeof img === 'undefined' || img === null || img === '') {
                    return "";
                }
                else {
                    return '<img width="112" height="70" src="{{ route('LFM.DownloadFile',['ID',''])}}/' + img + '/small/404.png/100/112/70?0" alt="" class="img-rounded img-preview">';
                }
            }
        },
        {
            width: '20%',
            data: 'title',
            name: 'title',
            title: 'عنوان',
            mRender: function (data, type, full) {
                return '<a class="show_gallery_item pointer" data-title="' + full.title + '"  data-item_id="' + full.id + '">' + full.title + '</a>';
            }
        },
        {
            width: '20%',
            data: 'description',
            name: 'description',
            title: 'توضیحات',
        },
        {
            width: '15%',
            data: 'parent_id',
            name: 'parent_id',
            title: 'گالری پدر',
            mRender: function (data, type, full) {
                $('#gallery_parrent_id').val(full.parent_id);
                if (full.parent != null)
                    return '<a class="show_parrent_items"  data-gallery_id="' + full.parent_id + '">' + full.parent.title + '</a>';
                else
                    return '';
            }
        },
        {
            width: '20%',
            data: 'created_by',
            name: 'created_by',
            title: 'ایجاد شده توسط',
            mRender: function (data, type, full) {
                if (full.user && full.user.name) {
                    return '<span>' + full.user.name + '<span>';
                }
                else
                    return '<span><span>';
            }
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
                return '<input class="styled " id="change_gallery_status_'+full.id+'" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_status_gallery(this)"' + ch + '>'
            }
        },
        {
            width: '5%',
            searchable: false,
            sortable: false,
            title: 'عملیات',
            mRender: function (data, type, full) {
                return '' +
                    '<a class="btn_edit_gallery pointer" data-item_id="' + full.id + '" data-title="' + full.title + '">' +
                    '   <i class="fa fa-edit"></i>' +
                    '</a>' +
                    '<a class="btn_trash_gallery pointer" style="color: red" data-item_id="' + full.id + '" data-title="' + full.title +'">' +
                    '   <i class="fa fa-trash"></i>' +
                    '</a>'
            }
        }
    ];
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
            visible:false
        },
        {
            data: 'file_id',
            name: 'file_id',
            title: 'فایل',
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
                return '<input class="styled " id="change_gallery_status_'+full.id+'" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_status_gallery(this)"' + ch + '>'
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
                    '<a class="btn_trash_gallery_item pointer" style="color: red" data-item_id="' + full.id + '" data-title="' + full.title +'">' +
                    '   <i class="fa fa-trash"></i>' +
                    '</a>'
            }
        }
    ];

    $(document).ready(function () {
        var getGalleryRoute = '{{ route('LGS.getGallery') }}';
        var fixedColumn =  {
            leftColumns: 0,
            rightColumns: 1
        };
        dataTablesGrid('#GalleryManagerGridData', 'GalleryManagerGridData', getGalleryRoute, gallery_grid_columns, null, null, true, null, null, 1, 'desc',false,fixedColumn);
    });

    /*________________________________________________________________________________________________________________________*/

    function showDefaultImg(res) {
        $('#show_area_medium_default_img').html(res.defaultImg.view.medium) ;
    }

    /*___________________________________________________Add Gallery_____________________________________________________________________*/
    $(document).off("click", ".cancel_add_close_btn");
    $(document).on("click", ".cancel_add_close_btn", function () {
        clear_form_elements('#frm_create_gallery');
        $('a[href="#manage_tab"]').click();
    });
    var create_gallery_constraints = {
        title: {
            presence: {message: '^<strong>عنوان فرم ضروریست.</strong>'}
        }
    };
    var create_gallery_form_id = document.querySelector("#frm_create_gallery");
    init_validatejs(create_gallery_form_id, create_gallery_constraints, ajax_func_create_gallery);
    function ajax_func_create_gallery(formElement) {
        var formData = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.saveGallery')}}',
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#frm_create_gallery .total_loader').remove();
                if (data.status == -1) {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
                else {
                    clear_form_elements('#frm_create_gallery');
                    menotify('success', data.title, data.message);
                    GalleryManagerGridData.ajax.reload(null,false);
                    $('a[href="#manage_tab"]').click();
                    $('#show_area_medium_default_img').html('');
                   /* if (typeof data.section+'_available' === 'undefined')
                    {

                    }*/
                }
            }
        });
    }

    /*___________________________________________________Add Gallery_____________________________________________________________________*/
    $(document).off("click", ".btn_edit_gallery");
    $(document).on("click", ".btn_edit_gallery", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('.span_edit_gallery_tab').html('ویرایش گالری: ' + title);
        get_edit_gallery_form(item_id) ;
    });

    function get_edit_gallery_form(item_id) {
        $('#edit_gallery').children().remove();
        $('#edit_gallery').append(generate_loader_html('لطفا منتظر بمانید...'));
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.getEditGalleryForm')}}',
            dataType: "json",
            data: {
                item_id: item_id
            },
            success: function (result) {
                $('#edit_gallery .total_loader').remove();
                if (result.status == true) {
                    $('#edit_gallery').append(result.gallery_edit_view);
                    $('.edit_gallery_tab').removeClass('hidden');
                    $('a[href="#edit_gallery"]').click();

                    var edit_gallery_form_id = document.querySelector("#frm_edit_gallery");
                    init_validatejs(edit_gallery_form_id, create_gallery_constraints, ajax_func_edit_gallery);
                }
                else {}
            }
        });
    }

    function ajax_func_edit_gallery(formElement) {
        var formData = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.editGallery')}}',
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
                    GalleryManagerGridData.ajax.reload(null,false);
                    $('a[href="#manage_tab"]').click();
                }
            }
        });
    }
    /*___________________________________________________Edit Gallery_____________________________________________________________________*/

    $(document).off("click", ".cancel_edit_gallery");
    $(document).on("click", ".cancel_edit_gallery", function () {
        $('a[href="#manage_tab"]').click();
        $('.edit_gallery_tab').addClass('hidden');
    });
    /*___________________________________________________init select2_____________________________________________________________________*/
    init_select2_data('#gallery_parrent');

    /*___________________________________________________Edit Gallery_____________________________________________________________________*/

    $(document).off("click", ".btn_trash_gallery");
    $(document).on("click", ".btn_trash_gallery", function () {
        var item_id = $(this).data('item_id');console.log(item_id);
        var parameters = {item_id:item_id};
        yesNoAlert('حذف گالری', 'از حذف گالری مطمئن هستید ؟', 'warning', 'بله، گالری را حذف کن!', 'لغو', trash_gallery, parameters);
    });

    function trash_gallery(params) {
        console.log('ddd');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LGS.trashGallery') !!}',
            data: params,
            success: function (data) {
                if (data.status == -1) {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
                else {
                    menotify('success', data.title, data.message);
                    GalleryManagerGridData.ajax.reload(null,false);
                }
            }
        });
    }
    /*___________________________________________________Edit Gallery_____________________________________________________________________*/
    $(document).off("click", ".show_gallery_item");
    $(document).on("click", ".show_gallery_item", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('a[href="#manage_tab_item"]').click();
        $('.manage_gallery_item_tab').removeClass('hidden');
        var html = '' +
            '<div class="space-20"></div>' +
            '<table id="GalleryItemGridData" class="table" width="100%"></table>' ;
        $('.span_manage_gallery_item_tab').html('گالری تصاویر : ' + title);
        $('#manage_tab_gallery_item').html(html);
        dataTablesGrid('#GalleryItemGridData', 'GalleryItemGridData', '{{ route('LGS.getGalleryItem') }}', gallery_item_columns, {item_id: item_id}, null, true, null, null, 1, 'desc');
    });
    /*___________________________________________________Change Status_____________________________________________________________________*/
    function change_status_gallery(input) {
        var checked = input.checked ;
        var item_id = input.id ;
        var parameters = { status: checked,item_id:item_id};
        console.log(parameters);
        yesNoAlert('تغییر وضعیت کاربر', 'از تغییر وضعیت کاربر مطمئن هستید ؟', 'warning', 'بله، وضعیت کاربر را تغییر بده!', 'لغو', set_gallery_status, parameters,remove_checked,parameters);
    }
    function set_gallery_status(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LGS.setGalleryStatus') !!}',
            data: params,
            success: function (result) {
                if (result.success) {
                    swal({
                        position: 'top-end',
                        type: 'success',
                        title: result.title,
                        text: result.message,
                        showConfirmButton: true,
                    })
                }
            }
        });
    }
    function remove_checked (params) {
        var $this =$('#'+params.item_id) ;
        if(params.status)
        {
            $this.prop('checked', false);
        }
        else
        {
            $this.prop('checked', true);
        }
    }
</script>