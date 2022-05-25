<div class="m-0 p-0 w-100">
    <div class="z-justify-relative-top-150 w-100" style="width: 90%;" >
       <div class="w-100 m-0 p-0">
          <div class="m-0 p-0 w-100"> 
             <div class="mx-auto w-75 border p-3 m-0 z-bg-hover-secondary">
                @if(!$error)
                <div class="w-75 mx-auto m-0 p-0 text-white" style="">
                   <div class="mx-auto w-100 mb-3">
                        <h5 class="w-75">
                            <h4 class="border-bottom text-uppercase">
                                <span class="bi-check-all text-success mx-2"></span>
                                Bravo Mr/Mme <span class="text-warning">{{$user->name}}</span> ... encore une petite étape
                            </h4>
                        </h5>
                        @if(!$confirmed)
                        <div class="mx-auto w-100 mt-3">
                            <h5>
                                Mr/Mme <span class="text-warning">{{$user->name}}</span>, votre incription a bien été finalisé.
                                Cependant, un courriel vous été envoyé afin de confirmer votre compte
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
                                        Cliquer sur le boutton de confirmation présent dans le courriel
                                    </li>
                                </ul>
                            </h5>
                        </div>
                        <div class="mx-auto w-100 mt-3 d-flex justify-content-center border border-secondary">
                            <form autocomplete="off" class="mt-3 pb-3 w-100" wire:submit.prevent="verify">
                                @csrf
                                <div class="w-100 m-0 p-0 mx-auto d-flex justify-content-around">
                                    <input placeholder="Saisissez la clé..." style="font-family: cursive !important;" wire:model.defer="token" class="form-control border w-50 py-3 text-white bg-transparent @error('token') border-danger @enderror" name="token" id="token" >
                                    <button id="" class="btn btn-primary d-flex justify-content-between w-33">
                                        <span class="d-none d-lg-inline d-md-inline d-xl-inline mr-lg-2 mr-md-2 mr-xl-2 m-0">Confirmer mon compte</span>
                                        <span class="fa fa-send mt-2"></span>
                                    </button>
                                </div>
                                @error('token') 
                                    <div class="w-85 m-0 p-0 mx-auto">
                                        <span class="text-danger ml-5">{{$message}}</span>
                                    </div>
                                 @enderror
                           </form>
                        </div>
                        <div class="mx-auto w-100 mt-3">
                            <div class="mx-auto w-100 d-flex justify-content-center my-1">
                                <h4 class="text-center">Je n'ai pas reçu de courriel</h4>
                            </div>
                            <div class="mx-auto w-100 d-flex justify-content-center">
                                <span class="btn btn-info py-1 px-4 z-word-break-break w-85">
                                    Renvoyez le courriel
                                </span>
                            </div>
                        </div>
                        @else
                        <div class="mx-auto w-100 mt-5 p-2">
                            <h5>
                                Bravo Mr|Mme <span class="text-warning">{{$user->name}}</span> a bien été finalisé et confirmé.
                            </h5>
                            <h5 class="my-2">
                                Vous pouvez vous connecter juste en cliquant sur le boutton
                            </h5>
                            <div class="mx-auto w-75 d-flex my-2 justify-content-center">
                                <span class="btn btn-success py-1 cursor-pointer px-4 z-word-break-break w-85" wire:click="forceLogin">
                                    Se connecter
                                </span>
                            </div>
                        </div>
                        @endif
                   </div>
                </div>
                @else
                <div class="w-75 mx-auto m-0 p-0 text-white" style="">
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
