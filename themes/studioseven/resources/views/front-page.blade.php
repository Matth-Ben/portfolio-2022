@extends('layouts.app')

@section('content')
  @while (have_posts()) @php the_post() @endphp
    <div data-router-view="page">
      <div class="home">
        {!! the_content() !!}
      </div>
    </div>
  @endwhile
@endsection
