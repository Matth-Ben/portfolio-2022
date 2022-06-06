@extends('layouts.app')

@section('content')
  <div data-router-view="page" data-id={{ get_the_ID() }}>
    <section class="p404">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-xl-10">
            <div class="p404__content">
              <h1 class="p404__title">404</h1>
              <div class="p404__desc">{{ __('Page non trouvée', 'fullajax') }}</div>
              <a href="{{ get_bloginfo('url') }}"><span>{{ __('Retour à l\'accueil', 'studioseven') }}</span></a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
