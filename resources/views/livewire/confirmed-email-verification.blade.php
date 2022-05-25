<div class="m-0 p-0 w-100">
    <div class="z-justify-relative-top-150 w-100" style="width: 90%;" >
       <div class="w-100 m-0 p-0">
          <div class="m-0 p-0 w-100"> 
             <div class="mx-auto w-75 border p-3 m-0 z-bg-hover-secondary">
                @if($user)
                <div class="w-75 mx-auto m-0 p-0 text-white" style="">
                   <div class="mx-auto w-100 my-3">
                        <h5 class="w-75">
                            <h4 class="border py-2 text-uppercase">
                                <span class="bi-check-all text-success mx-2"></span>
                                BRAVO!!! <span class="text-warning">{{$user->name}}</span> le processus de confirmation de votre compte s'est bien déroulée!
                            </h4>
                        </h5>
                        <div class="mx-auto w-100 mt-5 p-2">
                            <h5 class="my-2">
                                Vous pouvez vous connecter juste en cliquant sur le boutton
                            </h5>
                            <div class="mx-auto w-75 d-flex my-2 justify-content-center">
                                <span class="btn btn-success py-1 cursor-pointer px-4 z-word-break-break w-85" wire:click="forceLogin">
                                    Se connecter
                                </span>
                            </div>
                        </div>
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
