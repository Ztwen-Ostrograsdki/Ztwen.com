@php
    $inputId = Str::random(15);
    if($hasLabel){
        $placeholder = "Veuillez renseigner " . $labelTitle . ' ...';
    }
@endphp

<div class="p-0 m-0 mt-0 mb-2 row {{$width}} px-2">
    <label class="z-text-cyan m-0 p-0 w-100 cursor-pointer" for="{{$inputId}}">{{$labelTitle}}</label>
    <input placeholder="{{$placeholder}}" class="text-white form-control bg-transparent border border-white px-2 @error('{{$modelName}}') text-danger border-danger @enderror" wire:model.defer="{{$modelName}}" type="{{$type}}" name="{{$modelName}}" id="{{$inputId}}">
    @if($error)
        <small class="py-1 z-text-orange">{{$error}}</small>
    @endif
</div>