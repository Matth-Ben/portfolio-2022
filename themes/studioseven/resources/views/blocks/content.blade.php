{{--
  Title: Content
  Description: Description of content
  Category: template-blocks
  Icon: hammer
  Post-Type: page post
  Keywords: content
--}}

@php
  $data = Block::content($block['data']);
@endphp

<div class="b-content" data-scroll-section>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-16"> 
        <div class="b-content__body">
          <div class="b-content__body-suptitle">{{ $data['suptitle'] }}</div>
          <div class="b-content__body-title">
            <{{ $data['hn'] }}>{{ $data['title'] }}</{{ $data['hn'] }}>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="b-content__image">
          @include('elements/image', ['data' => $data['image']])
        </div>
      </div>
    </div>
  </div>
</div>
