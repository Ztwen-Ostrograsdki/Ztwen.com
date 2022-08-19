@php
    $defaultClasses = 'text-warning w-25';
@endphp


<div class="m-0 p-0 w-100 text-center mx-auto pr-3 pb-2 {{$classes}}">
    <strong data-target="{{$targetModal ? '#' . $targetModal : ''}}" data-toggle="modal" data-dismiss="modal" class="{{$defaultClasses}}" style="cursor: pointer">
    {{$slot}}
    </strong>
</div>