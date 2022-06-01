<div>
    <div class="zw-90 row mx-auto" style="position: relative; top:200px;">
        <div class="col-12 col-lg-6 col-xl-6 col-md-6 mx-auto z-bg-secondary-light-opac border rounded z-border-orange" style="opacity: 0.8;">
            <div class="w-100 mx-auto p-3">
                <div class="w-100 z-color-orange">
                    <h5 class="text-center w-100">
                        <span class="fa fa-unlock fa-3x "></span>
                        <h4 class="w-100 text-uppercase text-center">Reccupération de compte</h4>
                        <small class="w-100 text-center text-warning d-block">Une clé vous a été envoyé par courriel. Veuillez vérifier votre boite mail.</small>
                    </h5>
                    <hr class="w-100 z-border-orange mx-auto my-2">
                </div>
                <div class="w-100">
                    <form autocomplete="false" method="post" class="mt-3 mx-auto" wire:submit.prevent="resetThePassword" >
                        @csrf
                        @if(!$from_email)
                        <div class="w-100 mt-2">
                            <div class="w-100 d-flex justify-content-between border rounded">
                                <strong class="bi-code zw-15 text-center z-color-orange" style="font-size: 1.5rem"></strong>
                                <input name="code" wire:model.defer="code"  type="text" class="form-control  @error('code') text-danger border border-danger @enderror text-white zw-85 p-3 z-bg-secondary-dark border-left" placeholder="Veuillez renseigner la clé...">
                            </div>
                            @error('code')
                                <span class="py-1 mb-3 z-color-orange">{{$message}}</span>
                            @enderror
                        </div>
                        @endif
                        <div class="w-100 mt-2">
                            <div class="w-100 d-flex justify-content-between border rounded">
                                <strong class="bi-unlock zw-15 text-center z-color-orange" style="font-size: 1.5rem"></strong>
                                @if ($showPassword)
                                <input name="password" wire:model.defer="password"  type="text" class="form-control  @error('password') text-danger border border-danger @enderror text-white zw-85 p-3 z-bg-secondary-dark border-left" placeholder="Veuillez renseigner le nouveau mot de passe...">
                                @else
                                <input name="password" wire:model.defer="password"  type="password" class="form-control  @error('password') text-danger border border-danger @enderror text-white zw-85 p-3 z-bg-secondary-dark border-left" placeholder="Veuillez renseigner le nouveau mot de passe...">
                                @endif
                            </div>
                            @error('password')
                                <span class="py-1 mb-3 z-color-orange">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="w-100 mt-2">
                            <div class="w-100 d-flex justify-content-between border rounded">
                                <strong class="bi-unlock-fill zw-15 text-center z-color-orange" style="font-size: 1.5rem"></strong>
                                @if ($showPassword)
                                <input name="password_confirmation" wire:model.defer="password_confirmation"  type="text" class="form-control  @error('password_confirmation') text-danger border border-danger @enderror text-white zw-80 p-3 z-bg-secondary-dark border-left" placeholder="Veuillez confirmer votre mot de passe...">
                                @else
                                <input name="password_confirmation" wire:model.defer="password_confirmation"  type="password" class="form-control  @error('password_confirmation') text-danger border border-danger @enderror text-white zw-80 p-3 z-bg-secondary-dark border-left" placeholder="Veuillez confirmer votre mot de passe...">
                                @endif
                                @if ($showPassword)
                                    <span title="Masquer le mot de passe" wire:click="toogleShowPassword" class="bi-eye-slash z-bg-secondary-dark text-white p-2 cursor-pointer"></span>
                                @else
                                    <span title="Afficher le mot de passe" wire:click="toogleShowPassword" class="bi-eye z-bg-secondary-dark text-white p-2 cursor-pointer"></span>
                                @endif
                            </div>
                            @error('password_confirmation')
                                <span class="py-1 mb-3 z-color-orange">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="w-100 mt-3 d-flex justify-center">
                            <button type="submit" class="z-bg-orange border rounded px-3 py-2 w-75">Confirmer</button>
                        </div>
                        <div class="w-100 mt-3 d-flex justify-center">
                            <span wire:click="cancelResetPassword" class="text-warning text-center px-3 py-2 w-75">
                                <strong class="">Annuler le processus ?</strong>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
</div>