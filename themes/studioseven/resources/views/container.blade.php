{{--
  Template Name: Conteneur
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    <div data-router-view="page">
      <div class="template-container">
        <section class="b-gutenberg">
          <div class="container-fluid">
            <div class="row">
              <div class="offset-md-2 col-md-20">
                {!! the_content() !!}
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  @endwhile
@endsection
