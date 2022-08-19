
<x-z-modal-generator :header_color="'text-orange'" :hasHeader="true" :width="6" :modalName="'forgotPasswordModal'" :modalHeaderTitle="'Mot de passe oublié'">
    <form autocomplete="off" class="form-group pb-3 px-2 bg-transparent mt-2" wire:submit.prevent="submit">
        <x-z-input :type="'email'" :error="$errors->first('email_fgt')" :modelName="'email_fgt'" :labelTitle="'Votre address mail...'"  ></x-z-input>
        <x-z-button>Lancer le processus</x-z-button>
        <div class="m-0 p-0 w-50 text-center mx-auto pr-3 pb-2">
            <span data-toggle="modal" data-dismiss="modal" data-target="#loginModal" class="text-warning" style="cursor: pointer">Non c'est déja bon, j'm souviens</span>
        </div>
    </form>
</x-z-modal-generator>
