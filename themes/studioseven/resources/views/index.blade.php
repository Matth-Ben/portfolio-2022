@extends('layouts.app')

@section('content')
  <div data-router-view="page">
    <div class="news">
      <div class="news__posts">
        {!! $content !!}
        @while(have_posts()) @php the_post() @endphp

        @endwhile
      </div>

      <div class="news__pagination">
        {{-- {!! posts_nav_link(' ',
          '<span class="prev">',
          '<span class="next">'
        ) !!} --}}
      </div>
    </div>
  </div>
@endsection
