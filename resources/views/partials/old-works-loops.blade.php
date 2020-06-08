            @if($main_catalogue->medium)
              <dt>Medium Category</dt>
              <dd>
                @foreach($main_catalogue->medium as $term)
                  <a href="{{ esc_url( get_term_link($term->slug, $term->taxonomy) )}}" title="{{ $term->name }}">
                    {{ $term->name }}
                  </a>@if(!$loop->last), @endif
                @endforeach
              </dd>
            @endif

            @if($studio_summary_info->printers_workshops)
              <dt>Printer(s), Assistant(s) and Studio(s)</dt>
              <dd>
                @foreach($studio_summary_info->printers_workshops as $item)
                  <a href="{{ esc_url( get_term_link($item->slug, $item->taxonomy) )}}" title="View {{ $item->name }}">
                    {{ $item->name }}
                  </a>@if(!$loop->last)<br>@endif
                @endforeach
              </dd>
            @endif
