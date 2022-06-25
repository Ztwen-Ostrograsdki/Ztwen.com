@props(['classes' => 'z-bg-orange w-50' ])
<div class="p-0 m-0 w-100 mx-auto d-flex justify-content-center mt-2 pb-1 pt-1">
    <button class="btn {{$classes}}" type="submit">{{$slot}}</button>
</div>