



<label class="z-text-cyan m-0 p-0 w-100 cursor-pointer" for="product_new_description">{{$label}}</label>
<input placeholder="Veuillez decrire brièvement cet article..." class="form-control bg-transparent border border-white px-2 @error('description') text-danger border-danger @enderror" wire:model.defer="description" type="text" name="product_description" id="product_new_description">
