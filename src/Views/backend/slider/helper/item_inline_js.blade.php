<script>
    window['slider_item_grid_columns'] = [
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
        },
        {
            width: '25%',
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
            width: '10%',
            data: 'is_active',
            name: 'is_active',
            title: 'وضعیت',
            mRender: function (data, type, full) {
                var ch = '';
                if (parseInt(full.is_active))
                    ch = 'checked';
                else
                    ch = '';
                return '<input class="styled " id="' + full.id + '" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_is_active_slider_item(this)"' + ch + '>'
            }
        },
        {
            width: '7%',
            searchable: false,
            sortable: false,
            data: 'action', name: 'action', 'title': 'عملیات',
            mRender: function (data, type, full) {
                return '' +
                    '<div class="gallerty_menu float-right" onclick="set_fixed_dropdown_menu(this)">' +
                    '<span>' +
                    '   <em class="fas fa-caret-down"></em>' +
                    '   <i class="fas fa-bars"></i> ' +
                    '</span>' +
                    '  <div class="dropdown_gallery hidden">' +
                    '   <a class="btn_edit_slider_item pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + '">' +
                    '       <i class="fa fa-edit"></i><span class="ml-2">ویرایش</span>' +
                    '   </a>' +
                    '  </div>' +
                    '</div>';

            }
        }
    ];
    window['create_slider_item_constraints']   = {

    };
    $(document).off("click", ".show_slider_item");
    $(document).on("click", ".show_slider_item", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('a[href="#manage_tab_item"]').click();
        $('.manage_slider_item_tab').removeClass('hidden');
        $('#slider_id_in_item').val(item_id);
        var html = '' +
            '<div class="space-20"></div>' +
            '<table id="SliderItemManagerGridData" class="table" width="100%"></table>';
        $('.span_manage_slider_item_tab').html('آیتم : ' + title);
        $('#manage_tab_slider_item').html(html);
        datatable_load_slider_item(item_id);
        $(document).off("click", "#add_slider_item_tab");
        $(document).on("click", "#add_slider_item_tab", function () {
            //-------------------------------------------------select2 ajax for select gallery -----------------------
            init_select2_ajax('#slider_id', '{{route('LGS.Slider.autoCompleteGallery')}}', true);

            //show items after select2 select
            $(document).off('select2:selecting','#slider_id') ;
            $(document).on('select2:selecting', '#slider_id', function (e) {
               var gallery_id = e.params.args.data.id ;
               get_selected_gallery_item(gallery_id);

               //---------------------------------get gallery item ---------------------------
                function get_selected_gallery_item(gallery_id) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('LGS.Slider.getViewGalleryItem')}}',
                        dataType: "json",
                        data: {gallery_id:gallery_id},
                        success: function (data) {
                            if (data.success == true) {
                               $('.show_slider_items').html(data.view_get_gallery_item) ;
                            }
                        }
                    });
                }
            });
        });
    });

    function datatable_load_slider_item(item_id,filter_title, filter_is_active) {
        item_id = item_id || false;
        filter_item_title = filter_title || '';
        filter_item_is_active = filter_is_active || false;
        var getSliderItemRoute = '{{ route('LGS.Slider.getSliderItem') }}';
        var fixedColumn = {
            leftColumns: 3,
            rightColumns: 2
        };
        data = {
            item_id: item_id,
            filter_item_title: filter_item_title,
            filter_item_is_active: filter_item_is_active,
        };
        dataTablesGrid('#SliderItemManagerGridData', 'SliderItemManagerGridData', getSliderItemRoute, slider_item_grid_columns, data);

        $('#SliderItemManagerGridData').find('thead').first().append
        (
            '<tr role="row">' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <input type="text" class="form-control filter_title" name="filter_title" value="' + filter_item_title + '" style="width: 100%;">' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '    <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_is_active" name="filter_item_is_active" style="width:150px">' +
            '           <option value="-1">انتخاب وضعیت</option>' +
            '           <option value="0" ' + ('0' === filter_item_is_active ? 'selected="selected"' : '') + '>غیرفعال</option>' +
            '           <option value="1" ' + ('1' === filter_item_is_active ? 'selected="selected"' : '') + '>فعال</option>' +
            '       </select>' +
            '   </td>' +
            '    <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '</tr>'
        );
    }

    //-------------------------------------------------Add slider items ------------------------------------------
    var frm_slider_add_item = document.querySelector("#frm_create_slider_item");
    init_validatejs(frm_slider_add_item, create_slider_item_constraints, ajax_func_add_slider_item);

    function ajax_func_add_slider_item(formElement) {
        var formData = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.Slider.addSliderItem')}}',
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#frm_create_slider_item .total_loader').remove();
                if (!data.success) {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
                else {
                    clear_form_elements('#frm_create_slider_item');
                    menotify('success', data.title, data.message);
                    SliderItemManagerGridData.ajax.reload(null, false);
                    $('a[href="#manage_tab_slider_item"]').click();
                    $('.show_slider_items').html('');
                }
            }
        });
    }


    //-------------------------------------------------cancel show items--------------------------------------
    $(document).off("click", ".cancel_manage_slider_item");
    $(document).on("click", ".cancel_manage_slider_item", function () {
        $('a[href="#manage_tab"]').click();
        $('.manage_slider_item_tab').addClass('hidden');
        $('#manage_tab_slider_item').html('');
    });

    $(document).off("click", ".cancel_add_slider_item");
    $(document).on("click", ".cancel_add_slider_item", function () {
        $('a[href="#manage_tab_slider_item"]').click();
        $('.show_slider_items').html('');
        $('#slider_id').val('');
    });

    //-------------------------------------------------Edit items--------------------------------------
    $(document).off("click", ".btn_edit_slider_item");
    $(document).on("click", ".btn_edit_slider_item ", function () {
        $('a[href="#manage_tab"]').click();
        $('.manage_slider_item_tab').addClass('hidden');
        $('#manage_tab_slider_item').html('');
    });

    //--------------------set status ----------------------------------------------------------------//
    function change_is_active_slider_item (input) {
        var checked = input.checked;
        var item_id = input.id;
        var parameters = {is_active: checked, item_id: item_id};
        yesNoAlert('تغییر وضعیت تصویر', 'از تغییر وضعیت تصویر مطمئن هستید ؟', 'warning', 'بله، وضعیت تصویر را تغییر بده!', 'لغو', set_slider_item_is_active, parameters, remove_checked, parameters);
    }

    function set_slider_item_is_active(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LGS.Slider.setSliderItemStatus') !!}',
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
        if (params.is_active) {
            $this.prop('checked', false);
        }
        else {
            $this.prop('checked', true);
        }
    }

    //---------------------------------------------------Edit slider-------------------------------------------------------------------------------------
    $(document).off("click", ".btn_edit_slider_item");
    $(document).on("click", ".btn_edit_slider_item", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('#span_edit_slider_item_tab').html('ویرایش : ' + title);
        get_edit_slider_item_form(item_id);
    });

    function get_edit_slider_item_form(item_id) {
        $('#edit_slider_item').children().remove();
        $('#edit_slider_item').append(generate_loader_html('لطفا منتظر بمانید...'));
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.Slider.getEditSliderForm')}}',
            dataType: "json",
            data: {
                item_id: item_id
            },
            success: function (result) {
                $('#edit_slider_item .total_loader').remove();
                if (result.success) {
                    $('#edit_slider_item').append(result.slider_item_edit_view);
                    $('.edit_slider_item_tab').removeClass('hidden');
                    $('a[href="#edit_slider_item"]').click();
                }
            }
        });
    }


</script>