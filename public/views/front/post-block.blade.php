{{-- <article class="brick entry format-standard animate-this">

    <div class="entry-thumb">
        <a href="{{ url('posts/' . $post->slug) }}" class="thumb-link"><img src="{{ $post->image }}"></a>
    </div>

    <div class="entry-text">
        <div class="entry-header">
            <h1 class="entry-title"><a href="{{ url('posts/' . $post->slug) }}">{{ $post->title }}</a></h1>
        </div>
        <div class="entry-excerpt">
            {{ $post->excerpt }}
        </div>
    </div>

</article> --}}
<script>
    console.log("_____");

    <?php
$myJSON = json_encode($post->tags);
?>
    console.log(<?php echo $myJSON; ?>)
</script>

<div class="single-post">
    <div class="text-truncate bd-highlight text-monospace" style="padding: 15px;">
        <a href="{{ url('posts/' . $post->slug) }}">{{ $post->title }}</a>
    </div>
    <div class="row">
        <div class="content-center col-4">
            <div class="content-center-child">

                @foreach($post->tags as $tag)
                    <a class="tag" href="/tags/{{ $tag->id }}">{{ $tag->tag }}</a>
                @endforeach
            </div>

        </div>
        <div class="content-center col-4">
            <div class="content-center-child">
                <span class="date-time" href="#">{{ $post->created_at }}</span>
            </div>

        </div>
        <div class="content-center col-4">
            <div class="row">
                <div class="col-4" style="height: 100%;">
                    <div class="content-center" style="height: 60%">
                        7
                    </div>
                    <div style="height: 40%; font-size: 12px">
                        Comments
                    </div>
                </div>
                <div class="col-4" style="height: 100%;">
                    <div class="content-center" style="height: 60%">
                        16
                    </div>
                    <div style="height: 40%; font-size: 12px">
                        Votes
                    </div>
                </div>
                <div class="col-4" style="height: 100%;">
                    <div class="content-center" style="height: 60%">
                        25
                    </div>
                    <div style="height: 40%; font-size: 12px">
                        Views
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>