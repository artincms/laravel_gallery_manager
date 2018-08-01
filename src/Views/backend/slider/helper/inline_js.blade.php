<script>
    window['slider_grid_columns'] = [
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
                return '<a href="#" class="show_slider_item pointer" data-title="' + full.title + '"  data-item_id="' + full.id +'">'+full.title+'</a>' ;
            }
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
                return '<input class="styled " id="' + full.id + '" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_is_active_slider(this)"' + ch + '>'
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
                    '   <a class="btn_edit_slider pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + '">' +
                    '       <i class="fa fa-edit"></i><span class="ml-2">ویرایش</span>' +
                    '   </a>' +
                    '    <a class="btn_trash_slider pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + ' ">' +
                    '       <i class="fa fa-trash"></i><span class="ml-2">خذف</span>' +
                    '   </a>'
                '  </div>' +
                '</div>';

            }
        }
    ];
    $(document).ready(function () {
        datatable_load_fun();
    });
    window['create_slider_constraints']   = {
        title: {
            presence: {message: '^<strong>عنوان فرم ضروریست.</strong>'}
        },
    };

    function datatable_load_fun(filter_title, filter_is_active) {
        filter_title = filter_title || '';
        filter_is_active = filter_is_active || false;
        var getSlideryRoute = '{{ route('LGS.Slider.getSlider') }}';
        var fixedColumn = {
            leftColumns: 3,
            rightColumns: 2
        };
        data = {
            filter_title: filter_title,
            filter_is_active: filter_is_active,
        };
        dataTablesGrid('#SliderManagerGridData', 'SliderManagerGridData', getSlideryRoute, slider_grid_columns, data);

        $('#SliderManagerGridData').find('thead').first().append
        (
            '<tr role="row">' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <input type="text" class="form-control filter_title" name="filter_title" value="' + filter_title + '" style="width: 100%;">' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '    <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_is_active" name="filter_is_active" style="width:150px">' +
            '           <option value="-1">انتخاب وضعیت</option>' +
            '           <option value="0" ' + ('0' === filter_is_active ? 'selected="selected"' : '') + '>غیرفعال</option>' +
            '           <option value="1" ' + ('1' === filter_is_active ? 'selected="selected"' : '') + '>فعال</option>' +
            '       </select>' +
            '   </td>' +
            '    <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '</tr>'
        );
    }

    //------------------------------------------------add summernote-------------------------------------------------------------------
    var init_summernote_for_add_slider = false;

    //--------------------------------------------------create slider-----------------------------------------------------------------
    $(document).off('click', '.add_slider_tab a');
    $(document).on('click', '.add_slider_tab a', function () {

        //------------------------------------------add summernote to textarea-------------------------------------------------------
        var init_summernote_for_add_slider = false;
        if (!init_summernote_for_add_slider) {
            $('#slider_description').summernote({
                height: 150,
            });
            init_summernote_for_add_slider = true;
        }

        //------------------------------------------ add advance option depend on wich style select ---------------------------------
        $(document).off('click', '#add_slider_advance_tab a');
        $(document).on('click', '#add_slider_advance_tab a', function () {
            var style_id = $('#style').val();
            var title = $('#slider_type_'+style_id).text();
            var text = 'تنظیمات پیشرفته ('+title+')' ;
            $('#span_advance_setting').text(text);
            get_slider_advance_options(style_id);
        });

        //get advance options depend on wich slider selected
        function get_slider_advance_options(style_id){
            $.ajax({
                type: "POST",
                url: '{{ route('LGS.Slider.getAdvanceStyleOptoins')}}',
                dataType: "json",
                data: {style_id:style_id},
                success: function (data) {
                    if (data.success == true) {
                        $('#add_slider_advance').html(data.slider_create_style_options);
                    }
                }
            });
        }

        //-----------------------------ajax to create slider------------------------------------------
        function ajax_func_add_slider(formElement) {
            var formData = new FormData(formElement);
            $.ajax({
                type: "POST",
                url: '{{ route('LGS.Slider.createSlider')}}',
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#frm_create_slider .total_loader').remove();
                    if (data.status == false) {
                        showMessages(data.message, 'form_message_box', 'error', formElement);
                        showErrors(formElement, data.errors);
                    }
                    else {
                        clear_form_elements('#frm_create_slider');
                        menotify('success', data.title, data.message);
                        SliderManagerGridData.ajax.reload(null, false);
                        $('a[href="#manage_tab"]').click();
                    }
                }
            });
        }

        //--------------------validate and submit form --------------------------------
        var add_slider_form_id = document.querySelector("#frm_create_slider");
        init_validatejs(add_slider_form_id, create_slider_constraints, ajax_func_add_slider);
    });

    //--------------------set status ----------------------------------------------------------------//
    function change_is_active_slider (input) {
        var checked = input.checked;
        var item_id = input.id;
        var parameters = {is_active: checked, item_id: item_id};
        yesNoAlert('تغییر وضعیت اسلایدر', 'از تغییر وضعیت اسلایدر مطمئن هستید ؟', 'warning', 'بله، وضعیت اسلایدر را تغییر بده!', 'لغو', set_slider_is_active, parameters, remove_checked, parameters);
    }

    function set_slider_is_active(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LGS.Slider.setStatusSlider') !!}',
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

    //----------------------------callback function-------------------------------------------------
    function showDefaultImg(res) {
        $('#show_area_medium_default_img').html(res.defaultImg.view.medium) ;
    }
    //-----------------------trash files -----------------------------------------------------------
    $(document).off("click", ".btn_trash_slider");
    $(document).on("click", ".btn_trash_slider", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        desc = 'بله اسلایدر( ' + title + ' ) را حذف کن !';
        var parameters = {item_id: item_id};
        yesNoAlert('حذف گالری', 'از حذف اسلایدر مطمئن هستید ؟', 'warning', desc, 'لغو', trash_slider, parameters);
    });

    function trash_slider(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LGS.Slider.trashSlider') !!}',
            data: params,
            success: function (data) {
                if (!data.success) {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
                else {
                    menotify('success', data.title, data.message);
                    SliderManagerGridData.ajax.reload(null, false);
                }
            }
        });
    }

    //---------------------------------------------------Edit slider-------------------------------------------------------------------------------------
    $(document).off("click", ".btn_edit_slider");
    $(document).on("click", ".btn_edit_slider", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('.span_edit_slider_tab').html('ویرایش : ' + title);
        get_edit_slider_form(item_id);
    });

    function get_edit_slider_form(item_id) {
        $('#edit_slider').children().remove();
        $('#edit_slider').append(generate_loader_html('لطفا منتظر بمانید...'));
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.Slider.getEditSliderForm')}}',
            dataType: "json",
            data: {
                item_id: item_id
            },
            success: function (result) {
                $('#edit_slider .total_loader').remove();
                if (result.success) {
                    $('#edit_slider').append(result.slider_edit_view);
                    $('.edit_slider_tab').removeClass('hidden');
                    $('a[href="#edit_slider"]').click();
                    //-------------------------------------------------add summernote to edit -----------------------------
                    var init_summernote_for_edit_slider = false;
                    if (!init_summernote_for_edit_slider) {
                        $('#edit_slider_description').summernote({
                            height: 150,
                        });
                        init_summernote_for_edit_slider = true;
                    }

                    //-------------------------------------------------cancel edit form--------------------------------------
                    $(document).off("click", ".cancel_edit_slider");
                    $(document).on("click", ".cancel_edit_slider", function () {
                        $('a[href="#manage_tab"]').click();
                        $('.edit_slider_tab').addClass('hidden');
                        $('#edit_slider').html('');
                    });
                    
                    //------------------------------------------------change advance form -------------------------------------
                    $(document).off('change', '#edit_style');
                    $(document).on('change', '#edit_style', change_advance_form);
                    
                    function change_advance_form() {
                        $('#edit_slider_advance').html('');
                        get_edit_slider_advance_form(this.value);
                    }

                    function get_edit_slider_advance_form (style_id) {
                        $.ajax({
                            type: "POST",
                            url: '{{ route('LGS.Slider.getAdvanceStyleOptoins')}}',
                            dataType: "json",
                            data: {style_id:style_id},
                            success: function (data) {
                                if (data.success == true) {
                                    $('#edit_slider_advance').html(data.slider_create_style_options);
                                }
                            }
                        });
                    }

                    //--------------------------------------------------save edit form ---------------------------------------
                    var edit_slider_form_id = document.querySelector("#frm_edit_slider");
                    init_validatejs(edit_slider_form_id, create_slider_constraints, ajax_func_edit_slider);

                    function ajax_func_edit_slider(formElement) {
                        var formData = new FormData(formElement);
                        $.ajax({
                            type: "POST",
                            url: '{{ route('LGS.Slider.editSlider')}}',
                            dataType: "json",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                $('#frm_edit_slider .total_loader').remove();
                                if (!data.success) {
                                    showMessages(data.message, 'form_message_box', 'error', formElement);
                                    showErrors(formElement, data.errors);
                                }
                                else {
                                    menotify('success', data.title, data.message);
                                    SliderManagerGridData.ajax.reload(null, false);
                                    $('a[href="#manage_tab"]').click();
                                    $('.edit_slider_tab').addClass('hidden');
                                    $('#edit_slider').html('');
                                }
                            }
                        });
                    }
                }
                else {
                }
            }
        });
    }
    //-------------------------------------------------cancel add slider form--------------------------------------
    $(document).off("click", ".cancel_add_slider");
    $(document).on("click", ".cancel_add_slider", function () {
        $('a[href="#manage_tab"]').click();
        clear_form_elements('#frm_create_slider');
    });
</script>