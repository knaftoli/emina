@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ Storage::disk('s3')->url('logo.png') }}" class="logo" alt="{{ $slot }}">
{{-- <img class="h-14 w-auto" src="{{ Storage::disk('s3')->url('logo.svg') }}" alt="Emina" {{ $attributes }}> --}}
@else
<img class="" src="{{ Storage::disk('s3')->url('logo.png') }}" class="logo" alt="{{ $slot }}" style="width: 200x; height: 100px; margin: auto; display: block;">
@endif
</a>
</td>
</tr>
