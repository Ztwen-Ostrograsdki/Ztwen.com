<x-z-modal-generator :icon="'fa bi-tags fa-2x'" :modalName="'editCategoryModal'" :modalHeaderTitle="'Edition d\'une catégogie'" :modalBodyTitle=" $name ? 'Edition de la catégorie ' . $name : 'Edition de la catégorie '">
<form autocomplete="off" class="mt-3 pb-3 form-group bg-transparent" wire:submit.prevent="update">
    <x-z-input  :error="$errors->first('name')" :modelName="'name'" :labelTitle="'Le nom de la catégogie'" ></x-z-input>
    <x-z-input :error="$errors->first('description')" :modelName="'description'" :labelTitle="'Le nom de la catégogie'" ></x-z-input>
    <x-z-button>Mettre à jour</x-z-button>
    <x-z-modal-dismisser>Annuler</x-z-modal-dismisser>
</form>
</x-z-modal-generator>