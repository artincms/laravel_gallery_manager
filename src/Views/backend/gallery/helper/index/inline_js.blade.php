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
            visible: false
        },
        {
            width: '20%',
            data: 'title',
            name: 'title',
            title: 'عنوان',
            mRender: function (data, type, full) {
                var img = full.default_img;
                if (typeof img === 'undefined' || img === null || img === '') {
                    var img_item = '<img id="LGS_showThumbImage" src="{{ route('LFM.DownloadFile',['ID',''])}}/' + 0 + '/small/404.png/100/30/30?0"  data-image="{{ route('LFM.DownloadFile',['ID',''])}}/' + 0 + '/original/404.png?0"  class="img-rounded img-preview">';
                }
                else {
                    var img_item = '<img id="LGS_showThumbImage" src="{{ route('LFM.DownloadFile',['ID',''])}}/' + img + '/small/404.png/100/30/30?0" data-image="{{ route('LFM.DownloadFile',['ID',''])}}/' + img + '/original/404.png?0"  class="img-rounded img-preview">';
                }
                return '<div><div class="span_image_container">' + img_item + '</div><a class="show_gallery_item pointer" data-title="' + full.title + '"  data-item_id="' + full.id + '">' + full.title + '</a></div>';
            }
        },
        {
            width: '20%',
            data: 'description',
            name: 'description',
            title: 'توضیحات',
            mRender: function (data, type, full) {
                if (full.description) {
                    return '<div class="text_over_flow pointer td_description" onclick="hide_text_over_flow(this)">' + full.description + '</div>'
                }
                else {
                    return '';
                }
            }
        },
        {
            width: '15%',
            data: 'parent_id',
            name: 'parent_id',
            title: 'گالری والد',
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
                return '<input class="styled " id="' + full.id + '" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_status_gallery(this)"' + ch + '>'
            }
        },
        {
            width: '10%',
            searchable: false,
            sortable: false,
            data: 'action', name: 'action', 'title': 'عملیات',
            mRender: function (data, type, full) {
                return '' +
                    '<a class="btn_edit_gallery pointer" data-item_id="' + full.id + '" data-title="' + full.title + '" title="ویرایش">' +
                    '   <i class="fa fa-edit color_orange"></i>' +
                    '</a>' +
                    '<a class="btn_trash_gallery pointer" style="color: red" data-item_id="' + full.id + '" data-title="' + full.title + ' title="حذف">' +
                    '   <i class="fa fa-trash"></i>' +
                    '</a>' ;
            }
        }
    ];
    $(document).ready(function () {

        //dataTablesGrid('#GalleryManagerGridData', 'GalleryManagerGridData', getGalleryRoute, gallery_grid_columns, null, null, true, null, null, 1, 'desc', false, fixedColumn);
        datatable_load_fun();
        $('.filter_parrent ').on("select2:select",datatable_reload_fun);
    });

    /*________________________________________________________________________________________________________________________*/

    function showDefaultImg(res) {
        $('#show_area_medium_default_img').html(res.defaultImg.view.medium);
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
        },
        order: {
            numericality: {
                onlyInteger: true,
                message: '^<strong>ترتیب نامعتبر است .</strong>'
            }
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
                    GalleryManagerGridData.ajax.reload(null, false);
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
        $('.span_edit_gallery_tab').html('ویرایش : ' + title);
        get_edit_gallery_form(item_id);
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
                else {
                }
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
                    GalleryManagerGridData.ajax.reload(null, false);
                    $('a[href="#manage_tab"]').click();
                    $('.edit_gallery_tab').addClass('hidden');
                    $('#edit_gallery').html('');
                }
            }
        });
    }

    /*___________________________________________________Edit Gallery_____________________________________________________________________*/

    $(document).off("click", ".cancel_edit_gallery");
    $(document).on("click", ".cancel_edit_gallery", function () {
        $('a[href="#manage_tab"]').click();
        $('.edit_gallery_tab').addClass('hidden');
        $('#edit_gallery').html('');
    });
    /*___________________________________________________init select2_____________________________________________________________________*/
    init_select2_data('#gallery_parrent',{!! $parrents !!});

    /*___________________________________________________Trash Gallery_____________________________________________________________________*/

    $(document).off("click", ".btn_trash_gallery");
    $(document).on("click", ".btn_trash_gallery", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        desc = 'بله گالری( ' + title + ' ) را حذف کن !';
        var parameters = {item_id: item_id};
        yesNoAlert('حذف گالری', 'از حذف گالری مطمئن هستید ؟', 'warning', desc, 'لغو', trash_gallery, parameters);
    });

    function trash_gallery(params) {
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
                    GalleryManagerGridData.ajax.reload(null, false);
                }
            }
        });
    }

    /*___________________________________________________Change Status_____________________________________________________________________*/
    function change_status_gallery(input) {
        var checked = input.checked;
        var item_id = input.id;
        var parameters = {status: checked, item_id: item_id};
        yesNoAlert('تغییر وضعیت کاربر', 'از تغییر وضعیت کاربر مطمئن هستید ؟', 'warning', 'بله، وضعیت کاربر را تغییر بده!', 'لغو', set_gallery_status, parameters, remove_checked, parameters);
    }

    function set_gallery_status(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LGS.setGalleryStatus') !!}',
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

    function remove_checked(params) {
        var $this = $('#' + params.item_id);
        if (params.status) {
            $this.prop('checked', false);
        }
        else {
            $this.prop('checked', true);
        }
    }

    $('#LGS_showThumbImage').tooltip({
        animated: 'fade',
        placement: 'bottom',
        html: true
    });
    /*___________________________________________________Tooltip_____________________________________________________________________*/
    $(document).on('mouseenter', '#LGS_showThumbImage', function () {
        console.log('dd');
        var image_name = $(this).data('image');
        var imageTag = '<div style="position:fixed;">' + '<img src="' + image_name + '" alt="image" height="100" />' + '</div>';
        $(this).parent('div').append(imageTag);
    });
    $(document).on('mouseleave', '#LGS_showThumbImage', function () {
        $(this).parent('div').children('div').remove();
    });

    /*___________________________________________________FixedColumn_____________________________________________________________________*/
    function set_fixed_dropdown_menu(e)
    {
        var position = $(e).offset() ;
        var scrollTop  = $(document).scrollTop() ;
        var drop_height = $(e).find('.dropdown-menu').height() +16;
        if(($(window).height() - position.top)>drop_height)
        {
            $(e).find('.gallery_dropdown_menu').css({'position':'fixed','top':position.top-scrollTop+16,'left':position.left+22,'height':'fit-content'});
            window.addEventListener("scroll", function (event) {
                var scroll = this.scrollY;
                $(e).find('.gallery_dropdown_menu').css('top',position.top-scroll+16)
            });
        }
        else
        {
            $(e).find('.gallery_dropdown_menu').css({'position':'fixed','top':position.top-scrollTop+16-drop_height,'left':position.left+22,'height':'fit-content'});
            window.addEventListener("scroll", function (event) {
                var scroll = this.scrollY;
                $(e).find('.gallery_dropdown_menu').css('top',position.top-scroll+16-drop_height)
            });
        }
    }
    /*___________________________________________________SummerNote_____________________________________________________________________*/

    var init_summernote_for_add_gallery = false ;
    $(document).off('click','.add_gallery_tab a') ;
    $(document).on('click','.add_gallery_tab a',function () {
        if(!init_summernote_for_add_gallery)
        {
            $('#gallery_description').summernote({
                height: 150,
            } );
            init_summernote_for_add_gallery = true ;
        }
    });

    /*___________________________________________________DataTable_____________________________________________________________________*/

    function datatable_load_fun(filter_parrent_id) {
        filter_parrent_id = filter_parrent_id || false;
        var getGalleryRoute = '{{ route('LGS.getGallery') }}';
        var fixedColumn = {
            leftColumns: 2,
            rightColumns: 2
        };
        data =
            {
                filter_parrent_id: filter_parrent_id,
            };
        dataTablesGrid('#GalleryManagerGridData', 'GalleryManagerGridData', getGalleryRoute, gallery_grid_columns);
        $('#GalleryManagerGridData thead').append
        (
            '<tr role="row">' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_parrent" style="width:100px">' +
            '       </select>' +
            '   </td>' +
            '    <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '    <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '    <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '</tr>'
        );
        init_select2_ajax('.filter_parrent', '{{route('LGS.autoCompleteGalleryParrent')}}',true) ;
    }

</script>