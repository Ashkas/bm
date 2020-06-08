<article class="col-sm-4 col-md-3 small_margin_bottom grid_item">

  @if (get_the_post_thumbnail($post->ID))
    <div class="small_margin_bottom">
      <a href="{{ the_permalink() }}" title="Information about {!! the_title() !!}">
        {!! wp_get_attachment_image(get_post_thumbnail_id(),'medium', false, array( 'class' => 'lazyload archive-image', 'data-sizes' => 'auto' ) ) !!}
      </a>
    </div>
  @endif

  <header>
    <h3 class="entry-title"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h3>
  </header>
  @if($main_catalogue->catalogue_number)
    <div class="segment">
      <ul class="no_bullets">
        <li>Catalogue Number: {{ $main_catalogue->catalogue_number }}</li>
      </ul>
    </div>
  @endif
</article>
