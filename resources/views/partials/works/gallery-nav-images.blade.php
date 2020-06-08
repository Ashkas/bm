@if ($image_thumb)
	<div class="item">
		<img src="{!! $image_thumb[0] !!}" alt="{{ wp_strip_all_tags( $description, true) }}" />
	</div>
@endif
