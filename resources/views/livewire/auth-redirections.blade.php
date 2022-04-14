
@if($target == 'login')
<div class="modal-content w-75 mx-auto @if(session()->has('message')) border border-{{session('type')}} @endif" style="top:100px;">
    <div class="modal-header">
        <div class="d-flex justify-content-between w-100">
            <h4 class="text-uppercase mr-2 mt-2">
                Connexion 
                @if (session()->has('message'))
                    <b class="text-capitalize text-{{session('type')}} ml-4">
                        <span class="fa fa-warning"></span>
                        {{session('message')}}
                    </b>
                @endif
            </h4>
            <div class="d-flex justify-content-end w-20">
                <div class="w-15 mx-0 px-0">
                    <ul class="d-flex mx-0 px-0 mt-1 justify-content-between w-100">
                        <li class=" mx-1"><a href="#"><img src="images/flag-up-1.png" width="70" alt="" /> </a></li>
                        <li><a href="#"><img src="images/flag-up-2.png" width="70" alt="" /></a></li>
                    </ul>
                </div>
                <div class="w-25"></div>
            </div>
        </div>
    </div>
    <div class="modal-body m-0 p-0 border border-warning">
        <div class="page-wrapper bg-gra-01 font-poppins">
            <div class="wrapper wrapper--w780 ">
                <div class="card card-3 border border-danger row w-100 p-0 m-0">
                    <div class="bg-image-reg m-0 p-0 border border-info col-6"></div>
                    <div class="card-body border p-0 border-success col-12 col-lg-6 col-xl-6">
                    <h3 class="z-title text-white text-center p-1 m-0 ">Vos Coordonnées</h3>
                    <hr class="m-0 p-0 bg-white">
                    <hr class="m-0 p-0 bg-warning">
                    <hr class="m-0 p-0 bg-info">
                        <form  class="mt-3" wire:submit.prevent="login" >
                            @csrf
                            <div class="input-group mt-0 mb-2">
                                <label class="z-text-cyan @error('email_auth') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="email_log_auth">Votre adresse mail</label>
                                <hr class="m-0 p-0 bg-info w-100 mb-1">
                                <input class="input--style-3 @error('email_auth') text-danger border border-danger @enderror" wire:model.defer="email_auth" id="email_log_auth" type="email" placeholder="Votre adresse mail..." name="email_auth">
                                @error('email_auth')
                                    <small class="py-1 text-warning">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="input-group mt-0 mb-2">
                                <label class="z-text-cyan @error('password_auth') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="password_log_auth">Votre mot de passe</label>
                                <hr class="m-0 p-0 bg-info w-100 mb-1">
                                <input class="input--style-3 @error('password_auth') text-danger border border-danger @enderror" wire:model.defer="password_auth" id="password_log_auth" type="password" placeholder="Votre mot de passe..." name="password_auth">
                                @error('password_auth')
                                    <small class="py-1 text-warning">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
                                <button class="w-50 border border-white btn btn--pill btn--green" type="submit">Connexion</button>
                            </div>
                            <div class="m-0 p-0 w-50 text-center mx-auto pr-3 pb-2">
                                <span data-toggle="modal" data-dismiss="modal" data-target="#forgotPasswordModal" class="text-white-50" style="cursor: pointer">Mot de passe oublié</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
