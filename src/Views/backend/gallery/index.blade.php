@extends('backend.layouts.master')
@section('page_title')
    Laravel Gallery Manager
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-flat">
                <div class="panel-body">
                    <div class="tabbable">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="active"><a href="#manage_tab" data-toggle="tab">Manager</a></li>
                            <li class="add_gallery_tab"><a href="#add_gallery" data-toggle="tab">Add New Gallery</a></li>
                            <li class="edit_gallery_tab hide">
                                <button class="close closeTab cancel_edit_gallery" type="button">×</button>
                                <span class="divider">|</span>
                                <a href="#edit_tab" style="margin-left:10px" data-toggle="tab">Edit Gallery Manager</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="manage_tab">
                                <div>
                                    <div class="col-xs-12 gallery_manager_parrent_div">
                                        <table id="GalleryManagerGridData" class="table" width="100%"></table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="edit_tab"></div>
                            <div class="tab-pane" id="edit_tab"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection