<div>
    <x-z-galery-manager-component 
    :modalName="'updateCategoryGaleryModal'" 
    :modalHeaderTitle="'Edition de la galerie de la catégorie'"
    :modelName="'category_image'"
    :theModel="$category_image"
    :labelTitle="'Veuillez selectionner une image '"
    :submitMethodName="'update'"
    :error="$errors->first('category_image')"
    >
    </x-z-galery-manager-component>
</div>