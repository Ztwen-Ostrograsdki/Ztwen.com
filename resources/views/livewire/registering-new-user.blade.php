 <x-z-modal-generator :header_color="'text-orange'" :icon="'fa fa-user-plus fa-2x'" :modalName="'registerModal'" :modalHeaderTitle="'Inscription'" :modalBodyTitle="'Inscription'">
<form autocomplete="off" class="form-group pb-3 px-2 bg-transparent" wire:submit.prevent="submit">
    <x-z-input :type="'text'" :error="$errors->first('name')" :modelName="'name'" :labelTitle="'Votre nom et prénoms...'"  ></x-z-input>
    <x-z-input :type="'email'" :error="$errors->first('email')" :modelName="'email'" :labelTitle="'Votre adresse mail...'"  ></x-z-input>
    <x-z-input :type="'password'" :error="$errors->first('password')" :modelName="'password'" :labelTitle="'Votre mot de passe'" ></x-z-input>
    <x-z-input :type="'password'" :error="$errors->first('password_confirmation')" :modelName="'password_confirmation'" :labelTitle="'Veuillez confirmer votre mot de passe....'" ></x-z-input>
    <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
        <x-z-button>Valider</x-z-button>
    </div>
    <x-z-modal-dismisser :targetModal="'#loginModal'">J'ai déjà un compte</x-z-modal-dismisser>
</form>
</x-z-modal-generator>
