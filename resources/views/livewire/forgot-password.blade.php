<div wire:ignore.self class="modal fade lug" id="forgotPasswordModal" role="dialog" >
    <div class="modal-dialog modal-z-xlg" role="document">
       <!-- Modal content-->
       <div class="modal-content z-bg-secondary border" style="position: absolute; top:150px;">
          <div class="modal-header">
             <div class="d-flex justify-content-between w-100">
                <h6 class="text-uppercase text-white-50 mr-2 mt-1">
                    Récupération de compte 
                </h6>
                <div class="d-flex justify-content-end w-20">
                   <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                </div>
             </div>
          </div>
          <div class="modal-body m-0 p-0 bg-transparent">
             <div class="">
                 <div class="">
                     <div class="z-bg-secondary row w-100 p-0 m-0">
                        <div class="w-100 z-color-orange m-0 p-0">
                            <h5 class="text-center w-100 p-0 m-0 mt-1">
                                <span class="fa fa-unlock fa-2x "></span>
                                <h6 class="w-100 text-uppercase text-center">Réinitialisation de mot de passe</h6>
                            </h5>
                            
                        </div>
                         <div class="p-0col-12">
                                <form autocomplete="false" method="post" class="mt-3 form-group bg-transparent" wire:submit.prevent="submit" >
                                    <div class="p-0 m-0 mt-0 mb-2 row w-100 px-2">
                                        <label class="z-text-cyan m-0 p-0 w-100 cursor-pointer" for="email_fgt">Votre adresse mail</label>
                                        <input placeholder="Veuillez renseigner votre address mail..." class="text-white form-control bg-transparent border border-white px-2 @error('email') text-danger border-danger @enderror" wire:model.defer="email" type="email" name="email" id="email_fgt">
                                        @error('email')
                                            <small class="py-1 z-text-orange">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
                                        <button class="w-50 border border-white btn z-bg-orange" type="submit">Lancer le processus</button>
                                    </div>
                                    <div class="m-0 p-0 w-50 text-center mx-auto pr-3 pb-2">
			                           <span data-toggle="modal" data-dismiss="modal" data-target="#loginModal" class="text-warning" style="cursor: pointer">Non c'est déja bon, j'm souviens</span>
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
