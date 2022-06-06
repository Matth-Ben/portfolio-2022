{{--
  Title: Contenu Flexible
  Description: Une ou deux colonnes : contenu / médias
  Category: template-blocks
  Icon: columns
  Post-Type: post page
  Keywords: contenu colonnes flexible image vidéo média
--}}

@php
  $data = Block::flexibleContent($block['data']);
@endphp

<section class="b-flexible-content">
  <div class="container-fluid">
    <div class="row">
      @foreach ($data['components'] as $component)
        @php
          $col = 'col-xl-9 offset-md-2';

          if (count($data['components']) === 1) $col = $component['name'] === 'flexible-classic-content' ? 'col-xl-14 offset-xl-5 offset-md-2' : 'offset-md-2';
        @endphp
        <div class="col-md-20 {{ $col }} @if($loop->index === 0 && $component['name'] === 'flexible-classic-content'){{ 'u-o1' }}@endif">
          @include('components/' . $component['name'], ['data' => $component['data']])
        </div>
      @endforeach
    </div>
  </div>
</section>
