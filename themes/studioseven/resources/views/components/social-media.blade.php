<div class="social-media">
  <div class="social-media__button">
    <div class="social-media__text">{{ __('Partager', 'studioseven') }}</div>
    <div class="social-media__item social-toggler">{!! display_svg('share') !!}</div>
  </div>
  <div class="social-media__list">
    <a class="social-media__item linkedin" target="_blank" rel="noopener" href="https://www.linkedin.com/shareArticle?mini=true&url={{ get_the_permalink() }}&title={{ get_the_title() }}&summary={{ get_the_excerpt() }}">{!! display_svg('linkedin') !!}</a>
    <a class="social-media__item facebook" target="_blank" rel="noopener" href="https://www.facebook.com/sharer/sharer.php?u={{ get_the_permalink() }}">{!! display_svg('facebook') !!}</a>
    <a class="social-media__item twitter" target="_blank" rel="noopener" href="http://twitter.com/share?text={{ get_the_title() }}&url={{ get_the_permalink() }}">{!! display_svg('twitter') !!}</a>
    <div class="social-media__item copy" data-link="{{ get_the_permalink() }}">
      {!! display_svg('copy') !!}
      <span class="msg"></span>
    </div>
  </div>
</div>
