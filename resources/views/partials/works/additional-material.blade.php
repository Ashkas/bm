@if (($type = 'File') && $file && $file_name)

	<dt>File</dt>
	<dd><a href="{{ $file }}" title="Download {{ $file_name }}">{{ $file_name }}</a></dd>
	
@elseif ($type = 'Video' && $video)

	<dt>Video</dt>
	<dd>
		<div class="embed-container">
			{!! $video !!}
		</div>
	</dd>
	
@endif


@if ($caption)
	<dt>Caption</dt>
	<dd>{!! $caption !!}<dd>
@endif