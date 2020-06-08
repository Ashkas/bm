@extends('layouts.app')

@section('content')
  <div class="container-fluid archive-works taxonomy-archive archive grid content-frame">
    <div class="breadcrumb-wrapper">
      {!! App\the_breadcrumb() !!}
    </div>
    @include('partials.page-header')

    @if (term_description())
      <div class="row">
        <div class="col-sm-12 col-md-9 col-lg-7">
          <div class="archive-description">
            <div class="archive-description-read">
              {!! term_description() !!}
            </div>
          </div>
        </div>
      </div>
    @endif

    <div class="row">
      @if (!have_posts())
        <div class="alert alert-warning">
          {{ __('Sorry, no works were found.', 'sage') }}
        </div>
        {!! get_search_form(false) !!}
      @endif

      @while (have_posts()) @php the_post() @endphp

          @include('partials.works.archive-grid-item')

      @endwhile
    </div>

    @include('partials.pagination')

  </div>
@endsection
