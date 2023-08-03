<x-mail::message>
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
# New Listing Found
{{-- @if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif --}}
@endif

{{-- Intro Lines --}}
{{-- @foreach ($introLines as $line)
{{ $line }}
We found a new listing that might intrest you!

@endforeach --}}

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$newListing->uri" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

<x-mail::table>
| Address       | Agent         |
|:------------- |:------------- |
|{{ $newListing->address }}|{{ $newListing->agent }}|
</x-mail::table>
<x-mail::table>
| Price    | Search |
|:-------- |:------ |
|{{ $newListing->price }}|{{ $newListing->search_term }}|
</x-mail::table>

<x-mail::button :url="$newListing->uri" color='primary'>
Open listing in new window
</x-mail::button>

{{-- Outro Lines --}}
{{-- @foreach ($outroLines as $line)
{{ $line }}

@endforeach --}}

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{-- {{ config('app.name') }} --}}
Emina Solutions
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
