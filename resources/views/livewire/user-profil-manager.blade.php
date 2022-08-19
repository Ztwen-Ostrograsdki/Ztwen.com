@auth
<div>
    <x-z-galery-manager-component 
    :modalName="'editPhotoProfilModal'" 
    :modalHeaderTitle="'Edition de la photo de profil'"
    :modelName="'user_profil'"
    :theModel="$user_profil"
    :labelTitle="'Veuillez selectionner une image '"
    :submitMethodName="'updateUserProfilPhoto'"
    :error="$errors->first('user_profil')"
    >
    </x-z-galery-manager-component>
</div>

@endauth