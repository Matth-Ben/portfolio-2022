<div class="f-media f-media--{{ $data['media'] }}">
  @if ($data['media'] === 'image')
    <div class="f-media__image">
      @include('elements/image', ['data' => $data['image']])
    </div>
  @else
    <div class="f-media__video">
      @include('components/video', ['data' => $data['video']])
    </div>
  @endif
</div>
