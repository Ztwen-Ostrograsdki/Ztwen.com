<div wire:ignore.self class="modal fade lug" id="loginModal" role="dialog" >
    <div class="modal-dialog modal-z-xlg" role="document">
       <!-- Modal content-->
       <div class="modal-content" style="position: absolute; top:80px;">
          <div class="modal-header">
             <div class="d-flex justify-content-between w-100">
                <h4 class="text-uppercase mr-2 mt-1">
                    Connexion 
                    @if (session()->has('message'))
                        <span class="alert text-capitalize alert-{{session('type')}} ml-4">{{session('message')}}</span>
                    @endif
                </h4>
                <div class="d-flex justify-content-end w-20">
                   <div class="w-15 mx-0 px-0">
                      <ul class="d-flex mx-0 px-0 mt-1 justify-content-between w-100">
                         <li class=" mx-1"><a href="#"><img src="images/flag-up-1.png" width="100" alt="" /> </a></li>
                         <li><a href="#"><img src="images/flag-up-2.png" width="100" alt="" /></a></li>
                      </ul>
                   </div>
                   <div class="w-25"></div>
                   <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
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
                                <form autocomplete="false" class="mt-3" wire:submit.prevent="login" >
                                    <div class="input-group mt-0 mb-2">
                                        <label class="z-text-cyan @error('email') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="email_log">Votre adresse mail</label>
                                        <hr class="m-0 p-0 bg-info w-100 mb-1">
                                        <input class="input--style-3 @error('email') text-danger border border-danger @enderror" wire:model.defer="email" id="email_log" type="email" placeholder="Votre adresse mail..." name="email">
                                        @error('email')
                                            <small class="py-1 text-warning">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="input-group mt-0 mb-2">
                                        <label class="z-text-cyan @error('password') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="password_log">Votre mot de passe</label>
                                        <hr class="m-0 p-0 bg-info w-100 mb-1">
                                        <input class="input--style-3 @error('password') text-danger border border-danger @enderror" wire:model.defer="password" id="password_log" type="password" placeholder="Votre mot de passe..." name="password">
                                        @error('password')
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
    </div>
 </div>
