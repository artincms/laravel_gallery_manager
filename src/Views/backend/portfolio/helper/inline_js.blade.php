<script>
    //get gallery
    window['portfolio_grid_columns'] = [
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
            title: 'عنوان'
        },
        {
            width: '20%',
            data: 'description',
            name: 'description',
            title: 'توضیحات',
            mRender: function (data, type, full) {
                return '<div class="text_over_flow">'+full.description+'</div>'
            }
        },
        {
            width: '15%',
            data: 'lang_name',
            name: 'lang_name',
            title: 'زبان'
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
            width: '5%',
            data: 'is_active',
            name: 'is_active',
            title: 'وضعیت',
            mRender: function (data, type, full) {
                var ch = '';
                if (parseInt(full.is_active))
                    ch = 'checked';
                else
                    ch = '';
                return '<input class="styled " id="' + full.id + '" type="checkbox" name="special" data-item_id="' + full.id + '"  onchange="change_status_portfolio(this)"' + ch + '>'
            }
        },
        {
            width: '15%',
            data: 'order',
            name: 'order',
            title: 'ترتیب',
            searchable: false,
            mRender: function (data, type, full) {
                var order = PortfolioManagerGridData.order();
                if (order[0][0] == 7) {
                    if (order[0][1] == 'desc') {
                        var result = '';
                        result += '' +
                            '<div class="input-group mb-3">' +
                            '   <div class="input-group-prepend ">' +
                            '       <button type="button" style="float: right;border-radius: 0px;" class="btn btn-outline-secondary reorder_portfolio_form_grid_data bg-info-400" ' +
                            '           data-order_type="increase" ' +
                            '           data-item_id="' + full.id + '"' +
                            '           data-lang_id="' + full.lang_id + '" >' +
                            '           <i class="fas fa-level-up-alt"></i>'  +
                            '       </button>' +
                            '   </div>' +
                            '   <input type="text" class="form-control text-center" style="width:30% " disabled value="'+full.order+'">' +
                            '    <div class="input-group-append">' +
                            '       <button type="button" style="border-radius: 0px;" class="btn btn-outline-secondary reorder_portfolio_form_grid_data bg-info-800" ' +
                            '           data-order_type="decrease"' +
                            '           data-item_id="' + full.id + '"' +
                            '           data-lang_id="' + full.lang_id + '" >' +
                            '       <i class="fas fa-level-down-alt fa-flip-horizontal"></i>' +
                            '   </button>';
                        '   </div>' +
                        '</div>';
                        return result;
                    }
                    else {
                        var result = ''+
                            '<div class="input-group mb-3">' +
                            '   <div class="input-group-prepend ">' +
                            '       <button type="button" style="float: right;border-radius: 0px;" class="btn btn-outline-secondary reorder_portfolio_form_grid_data bg-info-400" ' +
                            '           data-order_type="decrease" ' +
                            '           data-item_id="' + full.id + '"' +
                            '           data-lang_id="' + full.lang_id + '">' +
                            '           <i class="fas fa-level-up-alt"></i>'  +
                            '       </button>' +
                            '   </div>' +
                            '   <input type="text" class="form-control text-center" style="width:30% " disabled value="'+full.order+'">' +
                            '    <div class="input-group-append">' +
                            '       <button type="button" style="border-radius: 0px;" class="btn btn-outline-secondary reorder_portfolio_form_grid_data bg-info-800" ' +
                            '           data-order_type="increase"' +
                            '           data-item_id="' + full.id + '"' +
                            '           data-lang_id="' + full.lang_id + '">' +
                            '       <i class="fas fa-level-down-alt fa-flip-horizontal"></i>' +
                            '   </button>';
                        '   </div>' +
                        '</div>';
                        return result;
                    }
                }
                else {
                    return '<span class="order_number">' + full.order + '</span>';
                }
            }
        },
        {
            width: '7%',
            searchable: false,
            sortable: false,
            data: 'action', name: 'action', 'title': 'عملیات',
            mRender: function (data, type, full) {
                return '' +
                    '<div class="gallerty_menu float-right pointer" onclick="set_fixed_dropdown_menu(this)" data-toggle="dropdowns">' +
                    '<span>' +
                    '   <em class="fas fa-caret-down"></em>' +
                    '   <i class="fas fa-bars"></i> ' +
                    '</span>' +
                    '  <div class="dropdown_gallery hidden">' +
                    '   <a class="btn_edit_portfolio pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + '">' +
                    '       <i class="fa fa-edit"></i><span class="ml-2">ویرایش</span>' +
                    '   </a>' +
                    '    <a class="btn_related_portfolio pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + ' " data-lang_id="' + full.lang_id + '">' +
                    '       <i class="fa fa-edit"></i><span class="ml-2">نمونه کارهای مرتبط</span>' +
                    '   </a>' +
                    '    <a class="btn_trash_portfolio pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + ' ">' +
                    '       <i class="fa fa-trash"></i><span class="ml-2">خذف</span>' +
                    '   </a>'
                '  </div>' +
                '</div>';

            }
        }
    ];
    window['portfolio_related_grid_columns'] = [
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
            title: 'عنوان'
        },
        {
            width: '20%',
            data: 'description',
            name: 'description',
            title: 'توضیحات',
            mRender: function (data, type, full) {
                return '<div class="text_over_flow">'+full.description+'</div>'
            }
        },
        {
            width: '15%',
            data: 'lang_name',
            name: 'lang_name',
            title: 'زبان'
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
            width: '7%',
            searchable: false,
            sortable: false,
            data: 'action', name: 'action', 'title': 'عملیات',
            mRender: function (data, type, full) {
                return '' +
                    '<div class="gallerty_menu float-right pointer" onclick="set_fixed_dropdown_menu(this)" data-toggle="dropdowns">' +
                    '<span>' +
                    '   <em class="fas fa-caret-down"></em>' +
                    '   <i class="fas fa-bars"></i> ' +
                    '</span>' +
                    '  <div class="dropdown_gallery hidden">' +
                    '    <a class="btn_trash_portfolio_related pointer gallery_menu-item" data-item_id="' + full.id + '" data-title="' + full.title + ' ">' +
                    '       <i class="fa fa-trash"></i><span class="ml-2">خذف</span>' +
                    '   </a>'
                    '  </div>' +
                    '</div>';

            }
        }
    ];

    $(document).ready(function () {
        $(document).off('change', '.filter_is_active');
        $(document).off('select2:select', '.filter_lang');
        $(document).on('change', '.filter_is_active', datatable_reload_fun);
        $(document).on("select2:select",'.filter_lang ', datatable_reload_fun);
        init_doAfterStopTyping('.filter_title', datatable_reload_fun);
        datatable_load_fun();
        function datatable_reload_fun() {
            var filter_is_active = $('.filter_is_active').val();
            var filter_lang_id = $('.filter_lang').val();
            var filter_title = $('.filter_title').val();
            PortfolioManagerGridData.destroy();
            $('#PortfolioManagerGridData').empty();
            datatable_load_fun(filter_lang_id, filter_title,filter_is_active);
        }
    });

    /*___________________________________________________Add Gallery_____________________________________________________________________*/
    $(document).off("click", ".cancel_add_close_btn");
    $(document).on("click", ".cancel_add_close_btn", function () {
        clear_form_elements('#frm_create_portfolio');
        $('a[href="#manage_tab"]').click();
    });
    var create_portfolio_constraints = {
        title: {
            presence: {message: '^<strong>عنوان فرم ضروریست.</strong>'}
        },
    };
    var create_portfolio_form_id = document.querySelector("#frm_create_portfolio");
    init_validatejs(create_portfolio_form_id, create_portfolio_constraints, ajax_func_create_portfolio);

    function ajax_func_create_portfolio(formElement) {
        var formData = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.Portfolio.savePortfolio')}}',
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#frm_create_portfolio .total_loader').remove();
                if (data.success) {
                    var form_element = $("#frm_create_portfolio");
                    form_element.find('select').val('').trigger('change');
                    clear_form_elements('#frm_create_portfolio');
                    menotify('success', data.title, data.message);
                    PortfolioManagerGridData.ajax.reload(null, false);
                    $('a[href="#manage_tab"]').click();
                    $('#show_area_medium_default_img').html('');
                    $('#show_area_medium_other_img').html('');
                    defaultImg_available = 1;
                    OtherImg_available = 2;
                }
                else {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
            }
        });
    }

    /*-------------------------------------------------related porfolio-------------------------------------------------------------------*/
    $(document).off("click", ".btn_related_portfolio");
    $(document).on("click", ".btn_related_portfolio", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        var lang_id = $(this).data('lang_id');
        $('.span_manage_portfolio_related_item_tab').html('نمونه کارهای مرتبط : ' + title);
        $('.manage_portfolio_related_item_tab').removeClass('hidden');
        $('a[href="#manage_tab_related_item"]').click();
        $('.input_related_portfolio').val(item_id);
        $('.portfolio_manager_related_parrent_div').html('<table id="PortfolioManagerRelatedGridData" class="table " width="100%"></table>');
        data ={
          item_id:item_id
        };
        var getPortfolioRelatedRoute = '{{ route('LGS.Portfolio.getPortfolioRelatedItem') }}';
        dataTablesGrid('#PortfolioManagerRelatedGridData', 'PortfolioManagerRelatedGridData', getPortfolioRelatedRoute,portfolio_related_grid_columns,data);

        init_select2_ajax('#selectPortfolioRelated', '{{route('LGS.Portfolio.autoCompletePortfolio')}}', true,true,false,false,lang_id);

        //-----------------------------------------save related portfolio-------------------------------------------------------//

        var create_portfolio_related_constraints = {

        };
        var edit_portfolio_form_related_id = document.querySelector("#frm_edit_portfolio_related");
        init_validatejs(edit_portfolio_form_related_id, create_portfolio_related_constraints, ajax_func_edit_portfolio_related);

        function ajax_func_edit_portfolio_related(formElement) {
            var formData = new FormData(formElement);
            $.ajax({
                type: "POST",
                url: '{{ route('LGS.Portfolio.addRelatedPortfolio')}}',
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                $('#frm_edit_portfolio_related .total_loader').remove();
                if (data.success) {
                    menotify('success', data.title, data.message);
                    PortfolioManagerRelatedGridData.ajax.reload(null, false);
                    var form_element = $("#frm_edit_portfolio_related");
                    form_element.find('select').val('').trigger('change');
                }
                else {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
            }
        });
        }

        //---------------------------------------------------------------------delete related------------------------------------------
        $(document).off("click", ".btn_trash_portfolio_related");
        $(document).on("click", ".btn_trash_portfolio_related", function () {
            var item_id = $(this).data('item_id');
            var title = $(this).data('title');
            desc = 'بله گالری( ' + title + ' ) را حذف کن !';
            var parameters = {item_id: item_id};
            yesNoAlert('حذف گالری', 'از حذف گالری مطمئن هستید ؟', 'warning', desc, 'لغو', trash_portfolio_related, parameters);
        });

        function trash_portfolio_related(params) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '{!!  route('LGS.Portfolio.trashPortfolioRelated') !!}',
                data: params,
                success: function (data) {
                if (data.success) {
                    menotify('success', data.title, data.message);
                    PortfolioManagerRelatedGridData.ajax.reload(null, false);
                }
                else {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
            }
        });
        }
    });

   //------------------------------------------cancel button-----------------------------------------------------//
    $(document).off("click", ".cancel_manage_portfolio_related_item");
    $(document).on("click", ".cancel_manage_portfolio_related_item", function () {
        $('a[href="#manage_tab"]').click();
        $('.manage_portfolio_related_item_tab').addClass('hidden');
        $('.portfolio_manager_related_parrent_div').html('');
    });
    /*___________________________________________________Add Portfolio_____________________________________________________________________*/
    $(document).off("click", ".btn_edit_portfolio");
    $(document).on("click", ".btn_edit_portfolio", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        $('.span_edit_portfolio_tab').html('ویرایش : ' + title);
        get_edit_portfolio_form(item_id);
    });

    function get_edit_portfolio_form(item_id) {
        $('#edit_portfolio').children().remove();
        $('#edit_portfolio').append(generate_loader_html('لطفا منتظر بمانید...'));
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.Portfolio.getEditPortfolioForm')}}',
            dataType: "json",
            data: {
                item_id: item_id
            },
            success: function (result) {
                $('#edit_portfolio .total_loader').remove();
                if (result.success) {
                    $('#edit_portfolio').append(result.portfolio_edit_view);
                    $('.edit_portfolio_tab').removeClass('hidden');
                    $('a[href="#edit_portfolio"]').click();

                    var edit_portfolio_form_id = document.querySelector("#frm_edit_portfolio");
                    init_validatejs(edit_portfolio_form_id, create_portfolio_constraints, ajax_func_edit_portfolio);
                }
                else {
                }
            }
        });
    }

    function ajax_func_edit_portfolio(formElement) {
        var formData = new FormData(formElement);
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.Portfolio.editPortfolio')}}',
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $('#frm_edit_portfolio .total_loader').remove();
                if (data.success) {
                    menotify('success', data.title, data.message);
                    PortfolioManagerGridData.ajax.reload(null, false);
                    $('a[href="#manage_tab"]').click();
                    $('.edit_portfolio_tab').addClass('hidden');
                    $('#edit_portfolio').html('');

                }
                else {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
            }
        });
    }

    /*___________________________________________________Edit portfolio_____________________________________________________________________*/

    $(document).off("click", ".cancel_edit_portfolio");
    $(document).on("click", ".cancel_edit_portfolio", function () {
        $('a[href="#manage_tab"]').click();
        $('.edit_portfolio_tab').addClass('hidden');
        $('#edit_portfolio').html('');
    });
    /*___________________________________________________init select2_____________________________________________________________________*/

    /*___________________________________________________Trash portfolio_____________________________________________________________________*/

    $(document).off("click", ".btn_trash_portfolio");
    $(document).on("click", ".btn_trash_portfolio", function () {
        var item_id = $(this).data('item_id');
        var title = $(this).data('title');
        desc = 'بله گالری( ' + title + ' ) را حذف کن !';
        var parameters = {item_id: item_id};
        yesNoAlert('حذف گالری', 'از حذف گالری مطمئن هستید ؟', 'warning', desc, 'لغو', trash_portfolio, parameters);
    });

    function trash_portfolio(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LGS.Portfolio.trashPortfolio') !!}',
            data: params,
            success: function (data) {
                if (data.success) {
                    menotify('success', data.title, data.message);
                    PortfolioManagerGridData.ajax.reload(null, false);
                }
                else {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
                }
            }
        });
    }

    /*___________________________________________________Change is_active_____________________________________________________________________*/
    function change_status_portfolio(input) {
        var checked = input.checked;
        var item_id = input.id;
        var parameters = {is_active: checked, item_id: item_id};
        yesNoAlert('تغییر وضعیت تگ', 'از تغییر وضعیت تگ مطمئن هستید ؟', 'warning', 'بله، وضعیت تگ را تغییر بده!', 'لغو', set_portfolio_is_active, parameters, remove_checked, parameters);
    }

    function set_portfolio_is_active(params) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('LGS.Portfolio.setPortfolioStatus') !!}',
            data: params,
            success: function (result) {
                if (result.success) {
                    menotify('success', result.title, result.message);
                }
                else {
                    showMessages(data.message, 'form_message_box', 'error', formElement);
                    showErrors(formElement, data.errors);
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

    /*___________________________________________________FixedColumn_____________________________________________________________________*/
    function set_fixed_dropdown_menu(e) {
        $(e).find('.dropdown_gallery').toggleClass('hidden');
        var position = $(e).offset();
        var position2 = $(e).position();
        var scrollTop = $(document).scrollTop();
        var scrollLeft = $(document).scrollLeft();
        var drop_height = $(e).find('.dropdown_gallery').height() + 16;
        if (($(window).height() - position.top) > drop_height) {
            $(e).find('.dropdown_gallery').css({'position': 'fixed', 'top': position.top - scrollTop + 16, 'left': Math.abs(position.left) + 20, 'height': 'fit-content'});
            window.addEventListener("scroll", function (event) {
                var scroll = this.scrollY;
                $(e).find('.dropdown_gallery').css('top', position.top - scroll + 16)
            });
        }
        else {
            $(e).find('.dropdown_gallery').css({'position': 'fixed', 'top': position.top - scrollTop + 16 - drop_height, 'left': Math.abs(position.left) + 20, 'height': 'fit-content'});
            window.addEventListener("scroll", function (event) {
                var scroll = this.scrollY;
                $(e).find('.dropdown_gallery').css('top', position.top - scroll + 16 - drop_height)
            });
        }
    }
    $(window).click(function(e) {
        if (!$(e.target).closest(".gallerty_menu ").length > 0) {
            $('.dropdown_gallery').addClass('hidden');
        }
    });
    /*___________________________________________________DataTable_____________________________________________________________________*/

    function datatable_load_fun(filter_lang_id,filter_title,filter_is_active) {
        filter_lang_id = filter_lang_id || false;
        filter_title = filter_title || '';
        filter_is_active = filter_is_active || false;
        var getPortfolioRoute = '{{ route('LGS.Portfolio.getPortfolio') }}';
        var fixedColumn = {
            leftColumns: 3,
            rightColumns: 2
        };
        data ={
            filter_lang_id: filter_lang_id,
            filter_title: filter_title,
            filter_is_active: filter_is_active,
        };
        dataTablesGrid('#PortfolioManagerGridData', 'PortfolioManagerGridData', getPortfolioRoute,portfolio_grid_columns,data);
        PortfolioManagerGridData.columns([7]).visible(false);
        html_td = '' ;
        if(filter_lang_id)
        {
            PortfolioManagerGridData.columns([7]).visible(true);
            html_td = '   <td style="border: none; border-bottom: 1px lightgray solid;">' ;
        }
        $('#PortfolioManagerGridData').find('thead').first().append
        (
            '<tr role="row">' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <input type="text" class="form-control filter_title" name="filter_title" value="' + filter_title + '" style="width: 100%;">' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_lang" name="filter_lang" style="width:100px">' +
            '       </select>' +
            '   </td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '   <td style="border: none; border-bottom: 1px lightgray solid;">' +
            '       <select class="form-control filter_is_active" name="filter_is_active" style="width:150px">' +
            '           <option value="-1">انتخاب وضعیت</option>' +
            '           <option value="0" '+('0' === filter_is_active ? 'selected="selected"' : '')+'>غیرفعال</option>' +
            '           <option value="1" '+('1' === filter_is_active ? 'selected="selected"' : '')+'>فعال</option>' +
            '       </select>' +
            '   </td>' +
            html_td +
            '    <td style="border: none; border-bottom: 1px lightgray solid;">&nbsp;</td>' +
            '</tr>'
        );
        init_select2_ajax('.filter_lang', '{{route('LGS.Portfolio.autoCompletePortfolioLang')}}', true);
    }

    /*___________________________________________________init select2_____________________________________________________________________*/
    init_select2_data('#PortfolioSelectLang',{!! $multiLang !!});
    init_select2_ajax('#showSelectTag', '{{route('LTS.autoCompleteTag')}}', true,true,true);

    /*___________________________________________________SummerNote_____________________________________________________________________*/

    var init_summernote_for_add_portfolio = false;
    $(document).off('click', '.add_portfolio_tab a');
    $(document).on('click', '.add_portfolio_tab a', function () {
        if (!init_summernote_for_add_portfolio) {
            $('#portfolio_description').summernote({
                height: 150,
            });
            init_summernote_for_add_portfolio = true;
        }
    });

    function showDefaultImg(res) {
        $('#show_area_medium_default_img').html(res.defaultImg.view.medium);
    }
    function showOtherImg(res) {
        $('#show_area_medium_other_img').html(res.OtherImg.view.medium);
    }

    //------------------------------------------ordering----------------------------------------------------
    $(document).off("click", '.reorder_portfolio_form_grid_data');
    $(document).on('click', '.reorder_portfolio_form_grid_data', function () {
        var $this = $(this);
        var order_type = $this.data('order_type');
        var item_id = $this.data('item_id');
        var lang_id = $this.data('lang_id');
        reorder_portfolio_form_grid_data(order_type, item_id,lang_id);
    });
    function reorder_portfolio_form_grid_data(order_type, item_id,lang_id) {
        var result = false;
        $.ajax({
            type: "POST",
            url: '{{ route('LGS.Portfolio.saveOrderPortfolioForm')}}',
            dataType: "json",
            data: {item_id:item_id, order_type: order_type,lang_id:lang_id},
        success: function (data) {
            if (data.success == true) {
                window.PortfolioManagerGridData.ajax.reload(null,false);
                result = true;
            }
        }
    });
        return result;
    }

</script>