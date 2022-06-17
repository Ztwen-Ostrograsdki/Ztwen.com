<div>
    <div class="mx-auto justify-center text-white d-flex w-100">
        <div class="d-flex mx-100 text-center p-2 mt-4 w-100">
            <div class="w-100">
                <div class="w-100">
                    @if($edit_name)
                        <form wire:submit.prevent="renamed" autocomplete="off" class="my-1 d-flex p-2 cursor-pointer w-100 shadow">
                            <div class="d-flex justify-between zw-80">
                                <div class="w-100">
                                    <label class="z-text-cyan float-left text-left" for="my_name">Veuillez saisir votre nouveau nom</label>
                                    <input type="text" placeholder="Saisissez votre nouveau nom..." style="font-family: cursive !important;" wire:model="name" class="form-control py-3 border zw-95 text-white bg-transparent @error('name') border-danger text-danger @enderror" name="my_name" id="my_name" >
                                    @error('name')
                                        <span class="text-danger mx-2 mt-1 float-left text-left">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-inline-block float-right text-right zw-20">
                                <span wire:click="editMyName" title="Fermer la fenêtre d'édition" class="fa fa-close cursor-pointer text-danger p-2 border border-danger"></span>
                            </div>
                        </form>
                    @else
                        <span class="my-1 d-flex py-2 cursor-pointer">
                            <strong class="text-bold text-white-50 mt-2">Nom : </strong>
                            <span class="mx-2 mt-2">{{$user->name}}</span>
                            <span class="bi-pen mx-2 ml-3 p-2 float-end" wire:click="editMyName"></span>
                        </span>
                        <hr class="bg-secondary">
                    @endif
                </div>
                <div class="w-100">
                    @if($edit_email)
                        @if(!$confirm_email_field)
                        <form wire:submit.prevent="changeEmail" autocomplete="off" class="my-1 d-flex p-2 cursor-pointer w-100 shadow">
                            <div class="d-flex justify-between zw-80">
                                <div class="w-100">
                                    <small class="text-warning float-left text-left d-block w-100">Votre actuelle adresse email est : 
                                        <strong>{{$this->user->email}}</strong>
                                    </small>
                                    <label class="z-text-cyan float-left text-left" for="my_email">Veuillez saisir votre nouvelle adresse email</label>
                                    <input type="text" placeholder="Saisissez votre nouvelle adresse mail..." style="font-family: cursive !important;" wire:model="new_email" class="form-control py-3 border zw-95 text-white bg-transparent @error('new_email') border-danger text-danger @enderror" name="my_email" id="my_email" >
                                    @error('new_email')
                                        <span class="text-danger mx-2 mt-1 float-left text-left">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-inline-block float-right text-right zw-20">
                                <span wire:click="editMyEmail" title="Fermer la fenêtre d'édition" class="fa fa-close cursor-pointer text-danger p-2 border border-danger"></span>
                            </div>
                        </form>
                        @else
                        <form wire:submit.prevent="confirmedEmail" autocomplete="off" class="my-1 d-flex p-2 cursor-pointer w-100 shadow">
                            <div class="d-flex justify-between zw-80">
                                <div class="w-100">
                                    <label class="z-text-cyan float-left text-left" for="code">Veuillez saisir le code qui vous a été envoyé sur {{$email}}</label>
                                    <div class="d-flex justify-content-between w-100">
                                        <input type="text" placeholder="Saisissez le code qui vous a été envoyé..." style="font-family: cursive !important;" wire:model="code" class="form-control py-3 border w-75 text-white bg-transparent @error('code') border-danger text-danger @enderror" name="code" id="code" >
                                        <span class="btn-primary w-auto px-2 py-2 border border-white">Je n'ai pas reçu de courriel</span>
                                    </div>
                                    @error('code')
                                        <span class="text-danger mx-2 mt-1 float-left text-left">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-inline-block float-right text-right zw-20">
                                <span wire:click="editMyEmail" title="Annuler l'édition de l'adresse mail" class="fa fa-close cursor-pointer text-danger p-2 border border-danger"></span>
                            </div>
                        </form>
                        @endif
                    @else
                        <span class="my-1 d-flex py-2 cursor-pointer">
                            <strong class="text-bold text-white-50 mt-2">Adresse mail : </strong>
                            <span class="mx-2 mt-2">{{$user->email}}</span>
                            <span class="bi-pen mx-2 ml-3 p-2 float-end" wire:click="editMyEmail"></span>
                        </span>
                        <hr class="bg-secondary">
                    @endif
                </div>

                <div class="w-100">
                    @if($edit_password)
                        @if($psw_step_1)
                        <form wire:submit.prevent="verifiedOldPassword" autocomplete="off" class="my-1 d-flex p-2 cursor-pointer w-100 shadow">
                            <div class="d-flex justify-between zw-90">
                                <div class="w-100">
                                    <label class="z-text-cyan float-left text-left" for="old_pwd">Veuillez saisir votre ancien mot de passe</label>
                                    <div class="d-flex w-100 justify-center">
                                        <div class="row w-100">
                                            @if($show_old_pwd)
                                                <input type="text" placeholder="Taper l'ancien mot de passe ..." style="font-family: cursive !important;" wire:model="old_pwd" class="col-10 col-lg-7 col-xl-7 mr-lg-2 mr-xl-2 form-control py-3 border zw-60 text-white bg-transparent @error('old_pwd') border-danger text-danger @enderror" name="old_pwd" id="old_pwd" >
                                                <span  style="font-size: 18px;" title="Masquer le mot de passe" wire:click="toogleShowOldPassword" class="bi-eye-slash float-right text-right p-2 cursor-pointer"></span>
                                            @else
                                                <input type="password" placeholder="Taper l'ancien mot de passe ..." style="font-family: cursive !important;" wire:model="old_pwd" class="col-10 col-lg-7 col-xl-7 mr-lg-2 mr-xl-2 form-control py-3 border zw-60 text-white bg-transparent @error('old_pwd') border-danger text-danger @enderror" name="old_pwd" id="old_pwd" >
                                                <span  style="font-size: 18px;" title="Afficher le mot de passe" wire:click="toogleShowOldPassword" class="bi-eye float-right text-right p-2 cursor-pointer"></span>
                                            @endif
                                        </div>
                                    </div>
                                    @error('old_pwd')
                                        <span class="text-danger mx-2 mt-1 d-block mt-1 mb-2 float-left text-left">{{$message}}</span>
                                    @enderror
                                    <div class="w-100 mt-3">
                                        <button wire:click="verifiedOldPassword" type="button" class="btn-primary mt-2 rounded text-center w-75 px-4 py-2 border border-white">Confirmer</button>
                                        <strong class="text-center text-warning d-block mt-2 cursor-pointer">
                                            Mot de passe oublié ?
                                        </strong>
                                    </div>
                                </div>
                            </div>
                            <div class="d-inline-block float-right text-right zw-10">
                                <span wire:click="cancelPasswordEdit" title="Fermer la fenêtre d'édition" class="fa fa-close cursor-pointer text-danger p-2 border border-danger"></span>
                            </div>
                        </form>
                        @elseif($psw_step_2)
                        <form wire:submit.prevent="changePassword" autocomplete="off" class=" my-1 p-2 cursor-pointer w-100 shadow">
                            <div class="w-100 d-flex justify-content-between">
                                <div class="zw-80">
                                    <div class="w-100">
                                        <label class="z-text-cyan float-left text-left" for="my_password">Votre nouveau mot de passe</label>
                                        <div class="d-flex justify-content-between w-100">
                                            @if($show_new_pwd)
                                                <input type="text" placeholder="Saisissez votre nouveau mot de passe ..." style="font-family: cursive !important;" wire:model="new_password" class="form-control py-3 border w-100 text-white bg-transparent @error('new_password') border-danger text-danger @enderror" name="new_password" id="new_password" >
                                            @else
                                                <input type="password" placeholder="Saisissez votre nouveau mot de passe ..." style="font-family: cursive !important;" wire:model="new_password" class="form-control py-3 border w-100 text-white bg-transparent @error('new_password') border-danger text-danger @enderror" name="new_password" id="new_password" >
                                            @endif
                                        </div>
                                        @error('new_password')
                                            <span class="text-danger mx-2 mt-1 mb-2 d-block w-100 float-left text-left">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="w-100 mt-2">
                                        <label class="z-text-cyan d-block w-100 float-left text-left" for="pwd_confirmation">Confirmer mot de passe</label>
                                        <div class="d-flex justify-content-between w-100">
                                            @if($show_new_pwd)
                                                <input type="text" placeholder="Confirmer votre mot de passe..." style="font-family: cursive !important;" wire:model="new_password_confirmation" class="form-control py-3 border w-85 text-white bg-transparent @error('new_password_confirmation') border-danger text-danger @enderror" name="new_password_confirmation" id="pwd_confirmation" >
                                                <span title="Masquer le mot de passe" wire:click="toogleShowNewPassword" class="bi-eye-slash float-right text-right p-2 cursor-pointer" style="font-size: 18px;"></span>
                                            @else
                                                <input type="password" placeholder="Confirmer votre mot de passe..." style="font-family: cursive !important;" wire:model="new_password_confirmation" class="form-control py-3 border w-85 text-white bg-transparent @error('new_password_confirmation') border-danger text-danger @enderror" name="new_password_confirmation" id="pwd_confirmation" >
                                                <span title="Afficher le mot de passe" wire:click="toogleShowNewPassword" class="bi-eye float-right text-right p-2 cursor-pointer"  style="font-size: 18px;"></span>
                                            @endif
                                        </div>
                                        @error('new_password_confirmation')
                                            <span class="text-danger mx-2 mt-1 float-left text-left">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-inline-block float-right text-right zw-15">
                                    <span wire:click="cancelPasswordEdit" title="Annuler l'édition du mot de passe" class="fa fa-close cursor-pointer text-danger p-2 border border-danger"></span>
                                </div>
                            </div>
                            <div class="mt-2 w-100">
                                <button wire:click="changePassword" type="button" class="btn-primary w-75 rounded px-4 py-2 border border-white">Confirmer</button>
                            </div>
                        </form>
                        @endif
                    @else
                        <span class="my-1 d-flex py-2 cursor-pointer">
                            <strong class="text-bold text-white-50 mt-2">Sécurité : </strong>
                            <span class="mx-2 mt-2">Changer mon mot de passe</span>
                            <span class="bi-pen mx-2 ml-3 p-2 float-end" wire:click="editMyPassword"></span>
                        </span>
                        <hr class="bg-secondary">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>