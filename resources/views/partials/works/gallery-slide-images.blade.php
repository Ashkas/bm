@if ($image_id)
  <div class="item">
    <a href="{!! $image_full_src[0] !!}" data-fancybox="work-gallery"  data-caption="{{ wp_strip_all_tags( $identifier, true) }}">
      <figure>
        {!! wp_get_attachment_image($image_id,'medium', false, array( 'class' => 'lazyload', 'data-sizes' => 'auto', 'alt' => wp_strip_all_tags( $identifier, true) ) ) !!}
      </figure>
    </a>
    @if($identifier)
      <div class="slide-description my-2">{!! $identifier !!}</div>
    @endif
  </div>
@endif
