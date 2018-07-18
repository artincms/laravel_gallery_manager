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
                    return '<a class="show_gallery_items"  data-gallery_id="' + full.parent_id + '">' + full.parent.title + '</a>';
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
                    '<a class="btn_edit_gallery" data-id="' + full.id + '">' +
                    '   <i class="fa fa-edit"></i>' +
                    '</a>' +
                    '<a class="btn_trash_gallery" style="color: red" data-id="' + full.id + '">' +
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
                }
            }
        });
    }


    /*___________________________________________________init select2_____________________________________________________________________*/
    init_select2_data('#gallery_parrent');
</script>