@php
  $page_args = array(
    'prev_text' => '<span class="icon-chevron-small-left previous"></span>',
    'next_text' => '<span class="icon-chevron-small-right"></span>',
  );

  $paginate_links = paginate_links($page_args);
@endphp

@if($paginate_links)
  <div class="pagination">
    {!! $paginate_links !!}
  </div>
@endif
