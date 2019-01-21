@extends('front.layout')
@section('main')
<div id="post-section" style="height:calc(100% - 300px); width: 100%;">
    {{-- <div style="height:300px; background: white;">
        <div>
            <div class="text-center">

                <p class="mb-0">
                    <h3 style="margin:auto;">New to PRO-MAN system?</h3>
                </p>
            </div>
            <div>
                Check out this tutorial! It features
            </div>
        </div>
    </div> --}}
    @foreach($posts as $post)
        @include('front.post-block', compact('$post'))
        {{--
        <@php error_log($post); </blade endphp|%20>
            --}}
    @endforeach
</div>

<div class="row">
    {{ $posts->appends(Illuminate\Support\Facades\Input::except('page'))->links('front.pagination') }}
</div>

{{--
<!-- masonry
    ================================================== 
    <section id="bricks">

        <div class="row masonry">
@isset($info)
@component('front.components.alert')
@slot('type')
                        info
@endslot
                    {!! $info !!}
@endcomponent
@endisset
@if($errors->has('search'))
@component('front.components.alert')
@slot('type')
                        error
@endslot
                    {{ $errors->first('search') }}
@endcomponent
@endif
            <div class="bricks-wrapper">

                <div class="grid-sizer"></div>

@foreach($posts as $post)
@include('front.brick-standard', compact('$post'))

@endforeach

            </div>

        </div>

        <div class="row">

            {{ $posts->links('front.pagination') }}

        </div>
    </section> end bricks -->
--}}
@endsection