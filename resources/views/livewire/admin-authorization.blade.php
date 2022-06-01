<div class="zw-90 row mx-auto" style="position: relative; top:200px;">
    <div class="col-12 col-lg-6 col-xl-6 col-md-6 mx-auto z-bg-secondary-light-opac border rounded z-border-orange" style="opacity: 0.8;">
        <div class="w-100 mx-auto p-3">
            <div class="w-100 z-color-orange">
                <h5 class="text-center w-100">
                    <span class="fa fa-user-secret fa-3x "></span>
                    <h4 class="w-100 text-uppercase text-center">Authentication d'accessibilitité</h4>
                    <hr class="w-100 z-border-orange mx-auto my-2">
                    <small class="text-warning w-100 d-inline-block text-center">Nous procedons à la vérification à l'accès à la page d'administration. Veuillez donc renseigner la clé secrète, avant de continuer!</small>
                </h5>
                <hr class="w-100 z-border-orange mx-auto my-2">
            </div>
            <div class="w-100">
                <form autocomplete="false" method="post" class="mt-3 mx-auto" wire:submit.prevent="authentify" >
                    @csrf
                    <div class="w-100">
                        <div class="w-100 d-flex justify-content-between border rounded">
                            <strong class="bi-unlock zw-15 text-center z-color-orange" style="font-size: 1.5rem"></strong>
                            <input name="code" wire:model="code"  type="password" class="form-control  @error('code') text-danger border border-danger @enderror text-white zw-85 p-3 z-bg-secondary-dark border-left" placeholder="Veuillez renseigner la clé...">
                        </div>
                        @error('code')
                            <span class="py-1 mb-3 z-color-orange">{{$message}}</span>
                        @enderror
                    </div> 
                    <div class="w-100 mt-3 d-flex justify-center">
                        <button type="submit" class="z-bg-orange border rounded px-3 py-2 w-75">Lancer</button>
                    </div> 
                    <div class="w-100 mt-3 d-flex justify-center">
                        <a href="{{route('user-profil', ['id' => $user->id])}}" class="text-warning text-center px-3 py-2 w-75">
                            <strong class="">Annuler le processus ?</strong>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>