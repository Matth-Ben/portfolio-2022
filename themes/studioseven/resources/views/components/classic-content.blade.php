<div class="c-classic-content">
  @if(!empty($data['titles']))
    <div class="c-classic-content__title">
      @include('elements/title', ['data' => $data['titles']])
    </div>
  @endif

  @if(!empty($data['content']))
    <div class="c-classic-content__content">
      {!! wpautop($data['content']) !!}
    </div>
  @endif

  @if(!empty($data['button']))
    <div class="c-classic-content__button">
      <a href="{{ $data['button']['url'] }}" class="e-button btn" @if($data['button']['target']){{ 'target="_blank" rel="noopener"' }}@endif>{!! $data['button']['title'] !!}</a>
    </div>
  @endif
</div>
