@props(['active', 'route', 'params' => null])

@php
if (Route::has($route)) {
    if ($active) {
        $classes = "nav-item active cursor-pointer";
    }
    else{
        $classes =  "nav-item text-white-50 cursor-pointer";
    }
}
else{
    $classes = "d-none";
}
@endphp
<li {{ $attributes->merge(['class' => $classes]) }}>
    <a class="nav-link text-white-50" href="{{ Route::has($route) ? ($params ? route($route, $params) : route($route)) : '#'}}">
        {{$slot}}
        <span class="sr-only">(current)</span>
    </a>
</li> 
