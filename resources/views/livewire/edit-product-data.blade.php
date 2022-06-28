<x-z-modal-generator :icon="'fa bi-tag fa-2x'" :modalName="'editProductModal'" :modalHeaderTitle="'Edition d\'un article'" :modalBodyTitle="'Edition d\'un article'">
    <form autocomplete="off" class="mt-3 pb-3 form-group bg-transparent" wire:submit.prevent="updateData">
        <div class=" m-0 p-0 mt-0 mb-2 row w-100 d-flex justify-between">
            <x-z-input :width="'col-6'"  :error="$errors->first('slug')" :modelName="'slug'" :labelTitle="'Le Slug'" ></x-z-input>
            <div class="mt-0 mb-2 col-5">
                <label class="z-text-cyan m-0 p-0 w-100 cursor-pointer" for="product_edit_category">La catégorie</label>
                <select class="px-2 form-select text-white z-bg-secondary w-100 @error('category_id') text-danger border border-danger @enderror" wire:model.defer="category_id" name="product_id" id="product_edit_category">
                    <option class="" value="">Choisissez une catégorie</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <small class="py-1 z-text-orange">{{$message}}</small>
                @enderror
            </div>
        </div>
        <x-z-input :error="$errors->first('description')" :modelName="'description'" :labelTitle="'La description'" ></x-z-input>
        <div class="m-0 p-0 mt-0 mb-2 d-flex row justify-between w-100">
            <x-z-input :width="'col-4'" :error="$errors->first('price')" :modelName="'price'" :labelTitle="'Le prix'" ></x-z-input>
            <x-z-input :width="'col-4'" :error="$errors->first('total')" :modelName="'total'" :labelTitle="'La quantité disponible'" ></x-z-input>
            <x-z-input :width="'col-4'" :error="$errors->first('reduction')" :modelName="'reduction'" :labelTitle="'La réduction effectuée'" ></x-z-input>
        </div>
        <x-z-button>Mettre à jour</x-z-button>
        <x-z-modal-dismisser>Annuler</x-z-modal-dismisser>
    </form>
</x-z-modal-generator>
