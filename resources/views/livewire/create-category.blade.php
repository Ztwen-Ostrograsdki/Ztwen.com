<x-z-modal-generator :icon="'fa bi-tags fa-2x'" :modalName="'createCategoryModal'" :modalHeaderTitle="'Creation d\'une nouvelle catégogie'" :modalBodyTitle="'Création d\'une nouvelle catégorie'">
<form autocomplete="off" class="mt-3 pb-3 form-group bg-transparent" wire:submit.prevent="create">
    <x-z-input  :error="$errors->first('name')" :modelName="'name'" :labelTitle="'Le nom de la catégogie'" ></x-z-input>
    <x-z-input :error="$errors->first('description')" :modelName="'description'" :labelTitle="'Le nom de la catégogie'" ></x-z-input>
    <div class="p-0 m-0 mx-auto d-flex justify-content-center mt-2 pb-1 pt-1">
        <button class="w-50 border border-white btn z-bg-orange" type="submit">Ajouter</button>
    </div>
    <div class="m-0 p-0 w-50 text-center mx-auto pr-3 pb-2">
        <strong data-toggle="modal" data-dismiss="modal" class="text-warning" style="cursor: pointer">Non c'est bon</strong>
    </div>
</form>
</x-z-modal-generator>
