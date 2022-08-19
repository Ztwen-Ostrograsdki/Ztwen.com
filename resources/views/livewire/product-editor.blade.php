<div>
    <x-z-galery-manager-component 
    :modalName="'updateProductGaleryModal'"
    :modalHeaderTitle="'Edition de la galerie'"
    :modelName="'product_image'"
    :theModel="$product_image"
    :labelTitle="'Veuillez selectionner une image'"
    :submitMethodName="'updateProductGalery'"
    :error="$errors->first('product_image')"
    >
    </x-z-galery-manager-component>
</div>
