<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>

    <!--- basic page needs -->
    <meta charset="utf-8">
    <title>{{ isset($post) && $post->seo_title ? $post->seo_title : __(lcfirst('Title')) }}</title>
    <meta name="description" content="{{ isset($post) && $post->meta_description ? $post->meta_description : __('description') }}">
    <meta name="author" content="@lang(lcfirst ('Author'))"> @if(isset($post) && $post->meta_keywords)
    <meta name="keywords" content="{{ $post->meta_keywords }}"> @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- mobile specific metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('fonts/font-awesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main_test.css') }}"> @yield('css') --}}
    <link rel="stylesheet" href="{{ asset('css/vendor/jquery/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/themify/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('pro/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('pro/css/prism.css') }}">

    <!-- script -->
    <script src="{{ asset('js/vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery/jquery-ui.js') }}"></script>
    <script src="{{ asset('pro/ace/src-noconflict/ace.js') }}"></script>
    <script>
        function error_msg(msg) {
    console.log("_______")
    console.log(msg)
    console.log("_______")
}
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            context: document.body,
            type: "POST",
            error: error_msg
        });
    </script>
    @yield('javascript')

    {{-- <script>
        var projectName = "{{ $project }}";
        var folder = {!!json_encode($folder - > toArray(), JSON_HEX_TAG) !!
        };
    </script>

    <script src="{{ asset('pro/js/app.js') }}"></script>
    <script src="{{ asset('pro/js/prism.js') }}"></script> --}}

</head>

<body>
    @yield('main')
    {{-- <div id="file-options-container">
        <div class="file-options">
            <button class="contextmenu-button">
                Download project
            </button>
            <button class="contextmenu-button">
                Download file tree
            </button>
            <button class="contextmenu-button">
                c
            </button>
        </div>
    </div> --}}
    {{-- <div id="toolbar-container">
        <button class="toolbar-button-logout">
            <div>Logout</div>
        </button>
        <button id="button-file-nav" class="toolbar-button">
            <div>File</div>
        </button>
        <button class="toolbar-button">
            <div>Options</div>
        </button>
        <button class="toolbar-button">
            <div>View</div>
        </button>
        <button class="toolbar-button">
            <div>About</div>
        </button>
    </div>
    <div id="explorer-container">

        <button class="sidebar-button" name="#navigator-tree-container">
            <span class="ti-package"><span class="sidebar-text">Explorer</span></span>
        </button>
        <button class="sidebar-button" name="#search-container">
            <span class="ti-search"><span class="sidebar-text">Search</span></span>
        </button>

        <div id="navigator-tree-container" class="tab-active">

            <div style="width: 100%; overflow: hidden; text-align: center; ">Explorer</div>
            <div class="tree">
                <ul id="navigator-tree">
                </ul>
            </div>

            <div id="navigator-tree-resize-bar">
            </div>
        </div>
    </div>
    <div id="footer-container">
        <ul id="footer-sortable">
        </ul>
    </div>
    <div id="app-main-container">

    </div> --}}
</body>

</html>