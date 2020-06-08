<!-- 	Years -->
	{{-- @if($item['type'])
		{{ $item['type'] }}
	@endif --}}

	{{-- @if($item['year'])
		{{ $item['year'] }}
	@endif

	@if($item['year_start'] || $item['year_end'])
		@if($item['year_start'] == $item['year_end'])
			{{ $item['year_start'] }}
		@else
			{{ $item['year_start'] }} -{{ $item['year_end'] }}
		@endif
	@endif --}}

<!-- 	Reference -->
	@if($item['abb_ref'])
		<a href="{{ esc_url( get_term_link($item['abb_ref']->slug, $item['abb_ref']->taxonomy) )}}" title="View {!! $item['abb_ref']->name !!}">
			{!! $item['abb_ref']->name !!}
		</a>
	@endif

<!-- 	Location -->
	@if($item['location'])
		<a href="{{ esc_url( get_term_link($item['location']->slug, $item['location']->taxonomy) )}}" title="View {!! $item['location']->name !!}">
			{!! $item['location']->name !!}
		</a>
	@endif

<!-- 	Acquisition Details -->
	@if($item['details'])
		{!! $item['details'] !!}
	@endif

	@if($item['series'])
		<a href="{{ esc_url( get_term_link($item['series']->slug, $item['series']->taxonomy) )}}" title="View {!! $item['series']->name !!}">
			{!! $item['series']->name !!}
		</a>
	@endif

<!-- 	Series Description -->
	@if($item['description'])
		{!! $item['description'] !!}
	@endif

<!-- 	Citation -->
	@if($item['citation'])
		{!! $item['citation'] !!}
	@endif
