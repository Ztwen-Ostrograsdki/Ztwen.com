<x-z-modal-generator :hasHeader="false" :width="6" :icon="'fa fa-user fa-2x'" :modalName="'loginModal'" :modalBodyTitle="'Connexion'">
<form autocomplete="off" class="form-group pb-1 px-2 bg-transparent" wire:submit.prevent="login">
    <x-z-input :type="'email'" :error="$errors->first('email')" :modelName="'email'" :labelTitle="'Votre adresse mail'"  ></x-z-input>
    <x-z-input :type="'password'" :error="$errors->first('password')" :modelName="'password'" :labelTitle="'Votre mot de passe'" ></x-z-input>
    <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
        @if($userNoConfirm)
            <span class="w-50 border cursor-pointer border-white btn btn--pill btn--green">
                <a class="text-white" href="{{route('force-email-verification-notify')}}">Confirmer mon compte</a>
            </span>
        @else
            <x-z-button>Connexion</x-z-button>
        @endif
    </div>
    @if(!$userNoConfirm)
    <x-z-modal-dismisser :classes="'mt-2'">Annuler</x-z-modal-dismisser>
    <div class="m-0 p-0 w-50 text-center mx-auto pr-3 pb-2">
        <span data-toggle="modal" data-dismiss="modal" data-target="#forgotPasswordModal" class="text-white-50" style="cursor: pointer">Mot de passe oublié</span>
    </div>
    @endif
</form>
</x-z-modal-generator>
