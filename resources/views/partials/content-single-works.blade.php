<article @php post_class() @endphp>
	<div>

    <div class="container-fluid single-work content-frame">
      <div class="title-content">
        <div class="grid-x grid-padding-x">
            <div class="cell small-6">
              <header class="ui header">
                <h1 class="ui header work-title">{!! get_the_title() !!}</h1>
                <p class="work-title-date">
                  @if($main_catalogue->date_description)
                    {!! App\remove_content_formatting('c_date_description') !!}</dd>
                  @endif
                </p>
              </header>
            </div>
            <div class="cell small-6">
              <nav class="work_pagination dont-print-work">
                {!! App\custom_post_nav('works', 'c_catalogue_number', $main_catalogue->catalogue_number ) !!}
              </nav>

              <div class="ui divider"></div>
            </div>
        </div>
      </div>

      <div class="top-content" id="work-image">
        <div class="grid-x grid-padding-x">
          <div class="cell small-6 medium-5 large-6">
            <div class="grid-x align-middle grid-padding-x">
              <div class="cell small-10">

                <div class="gallery">

                    @if($main_catalogue->feat_image_id)

                      <div class="owl-carousel work-slider"  id="work-slider">

                        <div class="item">
                          <a href="{!! $main_catalogue->feat_image_full_src[0] !!}" data-fancybox="work-gallery"  data-caption="{{ wp_strip_all_tags( $main_catalogue->desc_feat_img, true) }}">
                            <figure>
                              {!! wp_get_attachment_image($main_catalogue->feat_image_id,'medium', false, array( 'class' => 'lazyload', 'data-sizes' => 'auto' ) ) !!}
                            </figure>
                          </a>
                          @if($main_catalogue->desc_img)
                            <div class="slide-description my-3">{!! $main_catalogue->desc_img !!}</div>
                          @endif
                        </div>

                        @if($comp_parts)
                          @foreach($comp_parts as $comp_part)
                            @include('partials.works.gallery-slide-images', $comp_part)
                          @endforeach
                        @endif

                        @if($states)
                          @foreach($states as $state)
                            @include('partials.works.gallery-slide-images', $state)
                          @endforeach
                        @endif

                        @if($pages)
                          @foreach($pages as $page)
                            @include('partials.works.gallery-slide-images', $page)
                          @endforeach
                        @endif

                    </div>

                    @if($comp_parts || $states || $pages)
                      <div class="owl-carousel work-slider-nav" id="work-slider-nav">

                        <div class="item">
                          <img src="{!! $main_catalogue->feat_image_thumb_src[0] !!}" alt="{{ wp_strip_all_tags( $main_catalogue->desc_feat_img, true) }}" />
                        </div>

                        @if($comp_parts)
                          @foreach($comp_parts as $comp_part)
                            @include('partials.works.gallery-nav-images', $comp_part)
                          @endforeach
                        @endif

                        @if($states)
                          @foreach($states as $state)
                            @include('partials.works.gallery-nav-images', $state)
                          @endforeach
                        @endif

                        @if($pages)
                          @foreach($pages as $page)
                            @include('partials.works.gallery-nav-images', $page)
                          @endforeach
                        @endif

                      </div>
                    @endif

                  @endif

                  @if($comp_parts || $states || $pages)
                    <button class="button fluid work-overlay-button cursor-pointer" type="button" id="open_modal">View {{ $main_catalogue->state_type }}s</button>

                    <div class="ui fullscreen modal">
                      <div class="scrolling content">
                        <div class="actions">
                          <div class="ui cancel p-1 icon cursor-pointer float-right">
                            <i class="icon-cross" aria-hidden="true" title="Close states window"></i>
                          </div>
                        </div>
                        @if($comp_parts)
                          <div class="container-fluid">
                            <div class="row justify-content-center">
                              @foreach($comp_parts as $comp_part)
                                @include('partials.works.component-part', $comp_part)
                              @endforeach
                            </div>
                          </div>
                        @endif

                        @if($states)
                          <div class="container-fluid">
                            <div class="row justify-content-center">
                              @foreach($states as $state)
                                @include('partials.works.component-part', $state)
                              @endforeach
                            </div>
                          </div>
                        @endif

                        @if($pages)
                          <div class="container-fluid">
                            <div class="row justify-content-center">
                              @foreach($pages as $page)
                                @include('partials.works.component-part', $page)
                              @endforeach
                            </div>
                          </div>
                        @endif

                      </div>
                    </div>
                  @endif

                </div> <!-- gallery -->

              </div>
            </div>

          </div>

          <div class="cell small-6 medium-5 large-6">

            <dl>
              @if($main_catalogue->catalogue_number)
                <div class="segment">
                  <dt>Catalogue Number</dt>
                  <dd>{{ $main_catalogue->catalogue_number }}</dd>
                </div>
              @endif

              @if($main_catalogue->series_set_title)
                <div class="segment">
                  <dt>Series or Set Title</dt>
                  <dd>
                    <a href="{{ esc_url( get_term_link($main_catalogue->series_set_title->slug, $main_catalogue->series_set_title->taxonomy) )}}" title="{{ $main_catalogue->series_set_title->name }}">
                      {{ $main_catalogue->series_set_title->name }}
                    </a>
                  </dd>
                </div>
              @endif

              @if($main_catalogue->series_set_number)
                <div class="segment">
                  <dt>Series or Set Number</dt>
                  <dd>{{ $main_catalogue->series_set_number }}</dd>
                </div>
              @endif

              @if($studio_summary_info->where_made)
                <div class="segment">
                  <dt>Where Made</dt>
                  <dd>
                    @foreach($studio_summary_info->where_made as $item)
                      <a href="{{ esc_url( get_term_link($item->slug, $item->taxonomy) )}}" title="View {{ $item->name }}">
                        {{ $item->name }}
                      </a>@if(!$loop->last)<br>@endif
                    @endforeach
                  </dd>
                </div>
              @endif

              @if($main_catalogue->artist_number)
                <div class="segment">
                  <dt>Artist's Record Number(s)</dt>
                  <dd>{!! App\remove_content_formatting('c_artist_number') !!}</dd>
                </div>
              @endif

              @if($main_catalogue->technique_desc)
                <div class="segment">
                  <dt>Medium Category and Technique</dt>
                  <dd>{!! App\remove_content_formatting('c_technique_description') !!}</dd>
                </div>
              @endif

              @if($main_catalogue->support_desc)
                <div class="segment">
                  <dt>Support</dt>
                  <dd>{!! App\remove_content_formatting('c_support_description') !!}</dd>
                </div>
              @endif

              @if($main_catalogue->dimensions)
                <div class="segment">
                  <dt>Dimensions</dt>
                  <dd>{!! $main_catalogue->dimensions !!}</dd>
                </div>
              @endif

              @if($main_catalogue->text_num_comp)
                <div class="segment">
                  <dt>Textual and/or Numerical Component of Image</dt>
                  <dd>{!! App\remove_content_formatting('c_textual_numerical_component_of_image') !!}</dd>
                </div>
              @endif

              @if($main_catalogue->inscriptions)
                <div class="segment">
                  <dt>Inscription(s)</dt>
                  <dd>{!! App\remove_content_formatting('c_inscriptions') !!}</dd>
                </div>
              @endif

              {{-- @if($main_catalogue->date)
                <div class="segment">
                  <dt>Date</dt>
                    @php
                      $date = $main_catalogue->date;
                      $date = new DateTime($date);
                      $date = $date->format('j M Y');
                    @endphp
                  <dd>{{ $date }}</dd>
                </div>
              @endif --}}

              @if($main_catalogue->technique_new)
                <div class="segment">
                  <dt>Technique Matrix</dt>
                  <dd>
                    @foreach($main_catalogue->technique_new as $term)
                      <a href="{{ esc_url( get_term_link($term->slug, $term->taxonomy) )}}" title="{{ $term->name }}">{{ $term->name }}</a>@if(!$loop->last), @endif
                    @endforeach
                  </dd>
                </div>
              @endif

              @if($verso_recto)
                <div class="segment">
                  <dt>Verso/Recto</dt>

                  @foreach($verso_recto as $v_r => $w)

                    <dd>
                      @if($w->image_id )
                        <figure>
                            <a href="{{ $w->permalink }}" title="View {{ $w->title }}">
                              <img src="{!! $w->image_thumb_src[0] !!}" alt="{{ wp_strip_all_tags( $w->title, true) }}" class="ui image small" />
                            </a>
                          </figure>
                      @else
                        <a href="{{ $w->permalink }}" title="View {{ $w->title }}">{{ $w->title }}</a>
                      @endif
                    </dd>

                  @endforeach
                </div>

              @endif

              @if($main_catalogue->desc_work)
                <div class="segment">
                  <dt>Description of Work</dt>
                  <dd>{!! $main_catalogue->desc_work !!}</dd>
                </div>
              @endif

              @if($main_catalogue->desc_feat_img)
                <div class="segment">
                  <dt>Description of Featured Image</dt>
                  <dd>{!! $main_catalogue->desc_feat_img !!}</dd>
                </div>
              @endif

              @if($studio_summary_info->printer_notes)
                <div class="segment">
                  <dt>Printer(s), Assistant and Studio(s)</dt>
                  <dd>{!! App\remove_content_formatting('c_printer_notes') !!}</dd>
                </div>
              @endif

              @if($studio_summary_info->sum_edition)
                <div class="segment">
                  <dt>Summary Edition Information</dt>
                  <dd>{!! App\remove_content_formatting('c_sum_edition_information') !!}</dd>
                </div>
              @endif

              @if($main_catalogue->comment)
                <div class="segment">
                  <dt>Comment</dt>
                  <dd class="work-comment">{!! $main_catalogue->comment !!}</dd>
                </div>
              @endif

              @if($main_catalogue->artist_comment)
                <div class="segment">
                  <dt>Artist's Comment</dt>
                  <dd>{!! $main_catalogue->artist_comment !!}</dd>
                </div>
              @endif

              @if($main_catalogue->special_notes)
                <div class="segment">
                  <dt>Special Notes</dt>
                  <dd class="work-special-notes">{!! $main_catalogue->special_notes !!}</dd>
                </div>
              @endif

              @if($main_catalogue->keywords)
                <div class="segment">
                  <dt>Keywords</dt>
                  <dd>
                    @foreach($main_catalogue->keywords as $term)
                      <a href="{{ esc_url( get_term_link($term->slug, $term->taxonomy) )}}" title="{{ $term->name }}">
                        {{ $term->name }}
                      </a>@if(!$loop->last), @endif
                    @endforeach
                  </dd>
                </div>
              @endif

              @if($related_works)
                <div class="segment">
                  <dt>Related Works</dt>

                  @foreach($related_works as $work => $w)

                    <dd>
                      @if($w->image_id)
                        {!! App\do_related_picturefill($w->image_id, $w->title, $w->permalink) !!}
                      @endif
                      <a href="{{ $w->permalink }}" title="View {{ $w->title }}">{{ $w->title }}</a>
                    </dd>

                  @endforeach
                </div>

              @endif

            </dl>

            {{-- <div class="ui styled fluid accordion">
              @if($exhibitions)
                <div class="active title">
                  <h3>Exhibitions <span class="arrow-down"></span></h3>
                </div>
                <div class="active content">
                  @foreach($exhibitions as $item)
                    @include('partials.works.tab-repeater', $item)
                  @endforeach
                </div>
              @endif

              @if($bib_sources)
                <div class="title">
                  <h3>Bibliographic Source <span class="arrow-down"></span></h3>
                </div>
                <div class="content">
                  @foreach($bib_sources as $item)
                    @include('partials.works.tab-repeater', $item)
                  @endforeach
                </div>
              @endif

              @if($collections)
                <div class="title">
                  <h3>Collection(s) <span class="arrow-down"></span></h3>
                </div>
                <div class="content">
                  @foreach($collections as $item)
                    @include('partials.works.tab-repeater', $item)
                  @endforeach
                </div>
              @endif

              @if($series_set)
                <div class="title">
                  <h3>Series or Set <span class="arrow-down"></span></h3>
                </div>
                <div class="content">
                  @foreach($series_set as $item)
                    @include('partials.works.tab-repeater', $item)
                  @endforeach
                </div>
              @endif

              @if($additional_material)
                <div class="title">
                  <h3>Additional Material <span class="arrow-down"></span></h3>
                </div>
                <div class="content">
                  <dl>
                    @foreach($additional_material as $item)
                      @include('partials.works.additional-material', $item)
                    @endforeach
                  </dl>
                </div>
              @endif
            </div> --}}

          </div> <!-- col -->

        </div> <!-- row -->
      </div> {{-- top-content --}}

      @if($exhibitions || $bib_sources || $collections || $series_set || $additional_material)

        @switch(true)
          @case($bib_sources)
            @php $bib_active = 'is-active' @endphp
            @php $aria_selected = 'true' @endphp
            @break

          @case($exhibitions)
            @php $ex_active = 'is-active' @endphp
            @php $aria_selected = 'true' @endphp
            @break

          @case($collections)
            @php $col_active = 'is-active' @endphp
            @php $aria_selected = 'true' @endphp
            @break

          @case($series_set)
            @php $ss_active = 'is-active' @endphp
            @php $aria_selected = 'true' @endphp
            @break

          @case($additional_material)
            @php $am_active = 'is-active' @endphp
            @php $aria_selected = 'true' @endphp
            @break

          @default
            @php $active = '' @endphp
            @php $aria_selected = 'false' @endphp
        @endswitch

        <div class="bottom-content">
          <div class="row justify-content-md-center">
            <div class="col-12 md-tabs">

              @if($bib_sources or $exhibitions or $collections or $series_set or$additional_material)

                <ul class="tabs" data-responsive-accordion-tabs="tabs small-accordion medium-tabs large-tabs" id="collapsing-tabs" data-allow-all-closed="true" data-multi-expand="true">
                  @if($bib_sources)
                  <li class="tabs-title {{ $bib_active }}">
                    <a href="#bib_sources" aria-selected="{{ $aria_selected }}">Bibliographical Source(s)</a></li>
                  @endif
                  @if($exhibitions)
                    <li class="tabs-title {{ $ex_active }}"><a href="#exhibitions">Exhibitions</a></li>
                  @endif
                  @if($collections)
                    <li class="tabs-title {{ $col_active }}"><a href="#collections">Collections</a></li>
                  @endif
                  @if($series_set)
                    <li class="tabs-title {{ $ss_active }}"><a href="#series_set">Series or Set</a></li>
                  @endif
                  @if($additional_material)
                    <li class="tabs-title {{ $am_active }}"><a href="#additional_material">Additional Material</a></li>
                  @endif
                  <div class="slide"></div>
                </ul>

                <div class="tabs-content" data-tabs-content="collapsing-tabs">
                  @if($bib_sources)

                    <div class="tabs-panel {{ $bib_active }}" id="bib_sources">
                      <div class="grid-x">
                        <div class="cell medium-10 large-8">
                          @foreach($bib_sources as $item)
                            @include('partials.works.tab-repeater', $item)
                          @endforeach
                        </div>
                      </div?
                    </div>
                  @endif
                  @if($exhibitions)
                    <div class="tabs-panel {{ $ex_active }}" id="exhibitions">
                      <div class="grid-x">
                        <div class="cell medium-10 large-8">
                          @foreach($exhibitions as $item)
                            @include('partials.works.tab-repeater', $item)
                          @endforeach
                        </div>
                      </div>
                    </div>
                  @endif
                  @if($collections)
                    <div class="tabs-panel {{ $col_active }}" id="collections">
                      <div class="grid-x">
                        <div class="cell medium-10 large-8">
                          @foreach($collections as $item)
                            @include('partials.works.tab-repeater', $item)
                          @endforeach
                        </div>
                      </div>
                    </div>
                  @endif
                  @if($series_set)
                    <div class="tabs-panel {{ $ss_active }}" id="series_set">
                      <div class="grid-x">
                        <div class="cell medium-10 large-8">
                          @foreach($series_set as $item)
                            @include('partials.works.tab-repeater', $item)
                          @endforeach
                        </div>
                      </div>
                    </div>
                  @endif
                  @if($additional_material)
                    <div class="tabs-panel {{ $am_active }}" id="additional_material">
                      <div class="grid-x">
                        <div class="cell medium-10 large-8">
                          @foreach($additional_material as $item)
                            @include('partials.works.tab-repeater', $item)
                          @endforeach
                        </div>
                      </div>
                    </div>
                  @endif
                </div>

              @endif

            </div> <!-- col -->
          </div> <!-- row -->
        </div> {{-- bottom-content --}}
      @endif

		  <footer>
		    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
		  </footer>

		</div>
	</div>
</article>
