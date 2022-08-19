<div>
    @if($target == 'login')
<div class="zw-90 row mx-auto" style="position: relative; top:200px;">
    <div class="col-12 col-lg-6 col-xl-6 col-md-6 mx-auto z-bg-secondary-light-opac border rounded z-border-orange" style="opacity: 0.8;">
        <div class="w-100 mx-auto p-3">
            <div class="w-100 z-color-orange">
                <h5 class="text-center w-100">
                    <span class="fa fa-user-secret fa-3x "></span>
                    <h5 class="w-100 text-uppercase text-center">Authentification</h5>
                </h5>
                <hr class="w-100 z-border-orange mx-auto my-2">
            </div>
            <div class="w-100">
                <form autocomplete="false" method="post" class="mt-3 mx-auto" wire:submit.prevent="login" >
                    @csrf
                    <div class="w-100">
                        <div class="w-100 d-flex justify-content-between border rounded">
                            <strong class="bi-person zw-15 text-center z-color-orange" style="font-size: 1.5rem"></strong>
                            <input name="email_auth" wire:model.defer="email_auth"  type="email" class="form-control  @error('email_auth') text-danger border border-danger @enderror text-white zw-85 p-3 z-bg-secondary-dark border-left" placeholder="Veuillez renseigner votre adresse mail...">
                        </div>
                        @error('email_auth')
                            <span class="py-1 mb-3 z-color-orange">{{$message}}</span>
                        @enderror
                    </div>  

                    <div class="w-100 mt-2">
                        <div class="w-100 d-flex justify-content-between border rounded">
                            <strong class="bi-unlock zw-15 text-center z-color-orange" style="font-size: 1.5rem"></strong>
                            <input name="password_auth" wire:model.defer="password_auth"  type="password" class="form-control  @error('password_auth') text-danger border border-danger @enderror text-white zw-85 p-3 z-bg-secondary-dark border-left" placeholder="Veuillez renseigner votre mot de passe...">
                        </div>
                        @error('password_auth')
                            <span class="py-1 mb-3 z-color-orange">{{$message}}</span>
                        @enderror
                    </div>

                    @if(!$userNoConfirm)
                    <div class="w-100 mt-3 d-flex justify-center">
                        <button type="submit" class="z-bg-orange border rounded px-3 py-2 w-75">Se connecter</button>
                    </div>
                    <div class="w-100 mt-3 d-flex justify-center">
                        <a class="text-warning text-center px-3 py-2 w-75" href="{{route('password-forgot')}}">
                            <strong class="">Mot de passe oublié ?</strong>
                        </a>
                    </div>
                    @else
                    <div class="w-100 mt-3 d-flex justify-center">
                        <span wire:click="forcedEmailVerification" class="text-white cursor-pointer text-center bg-success border rounded px-3 py-2 w-75" >
                            <span class="bi-key mx-2"></span>
                            <span>Confirmer mon compte</span>
                        </span>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

@elseif($target == 'registration')

<div class="zw-90 row mx-auto" style="position: relative; top:150px;">
    <div class="col-12 col-lg-6 col-xl-6 col-md-6 mx-auto z-bg-secondary-light-opac border rounded z-border-orange" style="opacity: 0.8;">
        <div class="w-100 mx-auto p-3">
            <div class="w-100 z-color-orange">
                <h5 class="text-center w-100">
                    <span class="fa fa-user-plus fa-3x "></span>
                    <h5 class="w-100 text-uppercase text-center">Inscription</h5>
                </h5>
                <hr class="w-100 z-border-orange mx-auto my-2">
            </div>
            <div class="w-100">
                <form autocomplete="false" method="post" class="mt-3 mx-auto" wire:submit.prevent="register" >
                    @csrf
                    <div class="w-100">
                        <div class="w-100 d-flex justify-content-between border rounded">
                            <strong class="bi-person zw-15 text-center z-color-orange" style="font-size: 1.5rem"></strong>
                            <input name="name" wire:model.defer="name"  type="text" class="form-control  @error('name') text-danger border border-danger @enderror text-white zw-85 p-3 z-bg-secondary-dark border-left" placeholder="Veuillez renseigner votre nom...">
                        </div>
                        @error('name')
                            <span class="py-1 mb-3 z-color-orange">{{$message}}</span>
                        @enderror
                    </div>  
                    <div class="w-100 mt-2">
                        <div class="w-100 d-flex justify-content-between border rounded">
                            <strong class="bi-envelope-check zw-15 text-center z-color-orange" style="font-size: 1.5rem"></strong>
                            <input name="email" wire:model.defer="email"  type="email" class="form-control  @error('email') text-danger border border-danger @enderror text-white zw-85 p-3 z-bg-secondary-dark border-left" placeholder="Veuillez renseigner votre adresse mail...">
                        </div>
                        @error('email')
                            <span class="py-1 mb-3 z-color-orange">{{$message}}</span>
                        @enderror
                    </div>  

                    <div class="w-100 mt-2">
                        <div class="w-100 d-flex justify-content-between border rounded">
                            <strong class="bi-unlock zw-15 text-center z-color-orange" style="font-size: 1.5rem"></strong>
                            @if ($showPassword)
                            <input name="password" wire:model.defer="password"  type="text" class="form-control  @error('password') text-danger border border-danger @enderror text-white zw-85 p-3 z-bg-secondary-dark border-left" placeholder="Veuillez renseigner votre mot de passe...">
                            @else
                            <input name="password" wire:model.defer="password"  type="password" class="form-control  @error('password') text-danger border border-danger @enderror text-white zw-85 p-3 z-bg-secondary-dark border-left" placeholder="Veuillez renseigner votre mot de passe...">
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
                        <button type="submit" class="z-bg-orange border rounded px-3 py-2 w-75">S'inscrire</button>
                    </div>
                    <div class="w-100 mt-3 d-flex justify-center">
                        <a class="text-white text-center px-3 py-2 w-75" href="{{route('login')}}">
                            <span class="bi-user mx-2"></span>
                            <strong class="text-warning text-center w-100">J'ai déjà un compte</strong>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- PASSWORD FORGOT --}}

@elseif($target == 'reset_password')
<div class="zw-90 row mx-auto" style="position: relative; top:200px;">
    <div class="col-12 col-lg-6 col-xl-6 col-md-6 mx-auto z-bg-secondary-light-opac border rounded z-border-orange" style="opacity: 0.8;">
        <div class="w-100 mx-auto p-3">
            <div class="w-100 z-color-orange">
                <h5 class="text-center w-100">
                    <span class="fa fa-user-secret fa-3x "></span>
                    <h5 class="w-100 text-uppercase text-center">Reccupération de compte</h5>
                </h5>
                <hr class="w-100 z-border-orange mx-auto my-2">
            </div>
            <div class="w-100">
                <form autocomplete="false" method="post" class="mt-3 mx-auto" wire:submit.prevent="sendCode" >
                    @csrf
                    <div class="w-100">
                        <div class="w-100 d-flex justify-content-between border rounded">
                            <strong class="bi-person zw-15 text-center z-color-orange" style="font-size: 1.5rem"></strong>
                            <input name="email_for_reset" wire:model.defer="email_for_reset"  type="email" class="form-control  @error('email_for_reset') text-danger border border-danger @enderror text-white zw-85 p-3 z-bg-secondary-dark border-left" placeholder="Veuillez renseigner votre adresse mail...">
                        </div>
                        @error('email_for_reset')
                            <span class="py-1 mb-3 z-color-orange">{{$message}}</span>
                        @enderror
                    </div> 
                    @if(!$userNoConfirm)
                    <div class="w-100 mt-3 d-flex justify-center">
                        <button type="submit" class="z-bg-orange border rounded px-3 py-2 w-75">Lancer</button>
                    </div> 
                    <div class="w-100 mt-3 d-flex justify-center">
                        <a href="{{route('login')}}" class="text-warning text-center px-3 py-2 w-75">
                            <strong class="">Annuler le processus ?</strong>
                        </a>
                    </div>
                    @else
                    <div class="w-100 mt-3 d-flex justify-center">
                        <span wire:click="forcedEmailVerification" class="text-white text-center bg-success border rounded px-3 py-2 w-75" >
                            <span class="bi-key mx-2"></span>
                            <span>Confirmer mon compte</span>
                        </span>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endif

</div>