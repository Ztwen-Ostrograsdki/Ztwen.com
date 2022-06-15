@props(['active', 'routes'])

@php
foreach ($routes as $route) {
    if (Route::has($route)) {
        if (in_array(Route::currentRouteName(), $routes)) {
            $classes = "nav-item active cursor-pointer";
        }
        else{
            $classes =  "nav-item text-white-50 cursor-pointer";
        }
    }
    else{
        $classes = "d-none";
    }
}
@endphp
<li {{ $attributes->merge(['class' => $classes]) }}>
    <span class="nav-link text-white-50">
        {{$slot}}
        <span class="sr-only">(current)</span>
    </span>
</li> 
