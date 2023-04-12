<p>Category Index</p>

{{ $page }}
<br>
{{ $itemsPerPage }}
<br>
<br>

@foreach($categories as $item)
    {{ $item->id }}
    <br>
@endforeach
