@php
if (Route::has($routeName)) {
    if ($isActive) {
        $classes = "nav-item active cursor-pointer z-text-orange";
    }
    else{
        $classes =  "nav-item text-white cursor-pointer";
    }
}
else{
    $classes = "";
}


@endphp
<li {{ $attributes->merge(['class' => $classes]) }}>
    <a class="nav-link text-white-50" href="{{ Route::has($routeName) ? ($params ? route($routeName, $params) : route($routeName)) : '#'}}">
        {{$slot}}
        <span class="sr-only">(current)</span>
    </a>
</li> 
