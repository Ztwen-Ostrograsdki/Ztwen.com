<div class="m-0 p-0 w-100">
    <div class="z-justify-relative-top-100 w-100" style="width: 90%;" >
       <div class="w-100 m-0 p-0">
          <div class="m-0 p-0 w-100"> 
             <div class="mx-auto w-75 border p-3 m-0 z-bg-secondary-light-opac border rounded z-border-orange" style="opacity: 0.8;">
                @if(!$error)
                <div class="zw-85 mx-auto m-0 p-0 text-white" style="">
                   <div class="mx-auto w-100 mb-3">
                        <div class="w-100 z-color-orange">
                            <h5 class="text-center w-100">
                                <span class="fa fa-unlock fa-3x "></span>
                                <h4 class="w-100 text-uppercase text-center">
                                    <span class="bi-check-all text-success fa fa-2x mr-2"></span>
                                    <strong>
                                        Processus de confirmation de compte @if($email) de l'adresse mail : <span class="text-warning text-lowercase"> {{$email}}</span> @endif
                                    </strong>
                                </h4>
                                <small class="w-100 text-center text-warning d-block">Une clé vous a été envoyé par courriel. Veuillez vérifier votre boite mail.</small>
                            </h5>
                            <hr class="w-100 z-border-orange mx-auto my-2">
                        </div>
                        @if(!$confirmed && !$resentToken)
                        <div class="mx-auto w-100 mt-3">
                            <h5>
                                @if($email) <span class="text-warning">{{$email}}</span>
                                Mr/Mme ... votre incription a bien été finalisé.
                                @endif
                                Veuillez vérifier vote boite mail, un courriel vous été certainement envoyé afin de confirmé votre compte
                            </h5>
                            <h5 class="my-2">
                                Pour confirmer votre compte veuillez choisir l'une des options suivantes:
                                <ul>
                                    <li>
                                        <span class="fa fa-check"></span>
                                        Saisisser la clé qui vous a été envoyé par courriel
                                    </li>
                                    <li>
                                        <span class="fa fa-check"></span>
                                        Cliquer sur le boutton de confirmation présent dans le courreil
                                    </li>
                                </ul>
                            </h5>
                        </div>
                        <div class="mx-auto w-100 mt-3 d-flex justify-content-center border border-secondary px-2">
                            <form autocomplete="off" class="mt-3 pb-3 w-100" wire:submit.prevent="verify">
                                @csrf
                                <div class="w-100 m-0 p-0 mx-auto d-flex flex-column justify-content-around">
                                    <input placeholder="Saisissez l'adress mail de l'inscription..." style="font-family: cursive !important;" wire:model.defer="email" class="form-control border w-90 py-3 my-1 text-white bg-transparent @error('email') border-danger @enderror" name="email" id="email" >
                                    @error('email') 
                                        <div class="w-75 m-0 p-0">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>
                                    @enderror
                                    <input placeholder="Saisissez la clé..." style="font-family: cursive !important;" wire:model.defer="code" class="form-control border w-90 py-3 my-1 text-white bg-transparent @error('code') border-danger @enderror" name="code" id="code" >
                                    @error('code') 
                                        <div class="w-75 m-0 p-0 mb-2">
                                            <span class="text-danger">{{$message}}</span>
                                        </div>
                                    @enderror
                                    <button id="" class="btn rounded z-bg-orange border border-white d-flex mx-auto justify-content-center w-50 mt-2">
                                        <span class="d-none d-lg-inline d-md-inline d-xl-inline mr-lg-2 mr-md-2 mr-xl-2 m-0">Confirmer mon compte</span>
                                        <span class="fa fa-send mt-2"></span>
                                    </button>
                                </div>
                           </form>
                        </div>
                        <div class="mx-auto w-100 mt-3">
                            <div class="mx-auto w-100 d-flex justify-content-center my-1">
                                <h4 class="text-center">Je n'ai pas reçu de courriel</h4>
                            </div>
                            <div class="mx-auto w-100 d-flex justify-content-center">
                                <span wire:click="prepareResentVerificationEmailToken" class="btn cursor-pointer btn-info py-1 px-4 z-word-break-break w-85">
                                    Renvoyez le courriel
                                </span>
                            </div>
                        </div>
                        @elseif($confirmed && !$resentToken)
                        <div class="mx-auto w-100 mt-5 p-2">
                            <h5>
                                @if($email) 
                                Bravo Mr|Mme <span class="text-warning">{{$user->name}}</span> a bien été finalisé et confirmé.
                                @endif
                            </h5>
                            <h5 class="my-2">
                                Vous pouvez vous connecter juste en cliquant sur le boutton
                            </h5>
                            <div class="mx-auto w-75 d-flex my-2 justify-content-center">
                                <a href="{{route('login')}}" class="btn btn-success py-1 cursor-pointer px-4 z-word-break-break w-85">
                                    Se connecter
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                    @if($resentToken)
                    <div class="mx-auto w-100 mt-3 d-flex justify-content-center border border-secondary px-2">
                        <form autocomplete="off" class="mt-3 pb-3 w-100" wire:submit.prevent="resentVerificationEmailToken">
                            @csrf
                            <div class="w-100 m-0 p-0 mx-auto d-flex flex-column justify-content-around">
                                <input placeholder="Saisissez l'adresse mail de l'inscription..." style="font-family: cursive !important;" wire:model.defer="email_for_resent" class="form-control border w-90 py-3 my-1 text-white bg-transparent @error('email_for_resent') border-danger @enderror" name="email_for_resent" id="email_for_resent" >
                                @error('email_for_resent') 
                                    <div class="w-75 m-0 p-0">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror
                                <button id="" class="btn btn-primary d-flex mx-auto justify-content-center w-50 mt-2">
                                    <span class="d-none d-lg-inline d-md-inline d-xl-inline mr-lg-2 mr-md-2 mr-xl-2 m-0">Envoyez</span>
                                    <span class="fa fa-send mt-2"></span>
                                </button>
                            </div>
                       </form>
                    </div>
                    @endif
                </div>
                @else
                <div class="zw-85 mx-auto m-0 p-0 text-white" style="">
                    <div class="mx-auto w-100 mb-3">
                        <h5 class="w-75">
                            <h4 class="border-bottom text-uppercase text-warning">
                                <span class="fa fa-lock text-warning mx-2"></span>
                                {{$error}}
                            </h4>
                        </h5>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
