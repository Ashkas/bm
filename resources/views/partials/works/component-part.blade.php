@php ($withImage = '')
@if ($image)
  @php ($withImage = 'with-image')
@endif


<div class="col-12 col-md-10 col-lg-9 col-xl-8 states">
  <div class="states-content {!! $withImage !!}">
    @if ($image)
      <div class="states-content-image">
        <img src="{!! $image[0] !!}" alt="{{ strip_tags($identifier) }}" />
      </div>
    @endif
    <div class="states-content-meta">
      <div class="lead">
        @if ($identifier)
          {!! $identifier !!}
        @endif
      </div>

      @if ($description)
        {!! $description !!}
      @endif

      @if ($component_of_image)
        {!! $component_of_image !!}
      @endif

      @if ($inscriptions)
        {!! $inscriptions !!}
      @endif

      {{-- @if ($bib_sources_set)
        @foreach($bib_sources as $item)
          @include('partials.works.tab-repeater', $item)
        @endforeach
      @endif --}}

      @if ($artists_comments)
        {!! $artists_comments !!}
      @endif

      @if ($authors_comments)
        {!! $authors_comments !!}
      @endif

      @if ($related_works)
        {!! $related_works !!}
      @endif
    </div>
  </div>
</div>
