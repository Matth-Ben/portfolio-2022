{{--
  Title: Example
  Description: Description of example
  Category: template-blocks
  Icon: hammer
  Post-Type: page post
  Keywords: example
--}}

{{-- @php
  $data = Block::example($block['data']);
@endphp

<div class="b-example">
  <div class="b-example__title">@include('elements/title', ['data' => $data['title']])</div>
  <div class="b-example__image">@include('elements/image', ['data' => $data['image']])</div>
</div> --}}