<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title','Gallery Manager')</title>

    <!-- global stylesheets -->

    @yield('custom_plugin_style')
    @yield('custom_plugin_js')
<!-- /theme JS files -->
    @yield('inline_style')
</head>

<body>
<!-- Page container -->
<div class="page-container">
    <!-- Page content -->
    <!-- Content area -->
    <div class="content">
        <div id="form_message_box" class="form_message_area"></div>
        <div class="row">
            @yield('content')
        </div>
    </div>
<!-- /content area -->
</div>
</body>
</html>
