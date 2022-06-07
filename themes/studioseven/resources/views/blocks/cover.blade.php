{{--
  Title: Cover
  Description: Description of cover
  Category: template-blocks
  Icon: hammer
  Post-Type: page post
  Keywords: cover
--}}

@php
  $data = Block::cover($block['data']);
@endphp

<div class="b-cover">
  <div class="b-cover__title">@include('elements/title', ['data' => $data['title']])</div>
</div>
