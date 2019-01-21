@extends('pro.layout')
@section('javascript')
<script>
    var projectName = "{{ $project }}";
    var folder = {!!json_encode($folder -> toArray(), JSON_HEX_TAG) !!};
</script>
<script src="{{ asset('pro/js/app.js') }}"></script>
<script src="{{ asset('pro/js/prism.js') }}"></script>
@endsection
@section('main')
    <div id="toolbar-container">
        <button class="toolbar-button-logout">
            <div><a class="nav-link" href="{{ route('logout') }}">@lang('Logout')</a></div>
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

    </div>
@endsection