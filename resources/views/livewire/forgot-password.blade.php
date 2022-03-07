<div wire:ignore.self class="modal fade lug" id="forgotPasswordModal" role="dialog" >
    <div class="modal-dialog modal-z-xlg" role="document">
       <!-- Modal content-->
       <div class="modal-content" style="position: absolute; top:80px;">
          <div class="modal-header">
             <div class="d-flex justify-content-between w-100">
                <h4 class="text-uppercase mr-2 mt-1">
                    Récupération de compte 
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
                            <h3 class="z-title text-white text-center p-1 m-0 ">Votre adresse mail de recupération </h3>
                            <hr class="m-0 p-0 bg-white">
                            <hr class="m-0 p-0 bg-warning">
                            <hr class="m-0 p-0 bg-info">
                                <form autocomplete="false" method="post" class="mt-3" wire:submit.prevent="submit()" >
                                    <div class="input-group mt-0 mb-2">
                                        <label class="text-white @error('email') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="email_fgt">Votre adresse mail</label>
                                        <hr class="m-0 p-0 bg-info w-100 mb-1">
                                        <input class="input--style-3 @error('email') text-danger border border-danger @enderror" wire:model.lazy="email" id="email_fgt" type="email" placeholder="Votre adresse mail..." name="email">
                                        @error('email')
                                            <small class="py-1 text-warning">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
                                        <button class="w-50 border border-white btn btn--pill btn--green" type="submit">Lancer le processus</button>
                                    </div>
                                    <<div class="m-0 p-0 w-50 text-center mx-auto pr-3 pb-2">
			                           <span data-toggle="modal" data-dismiss="modal" data-target="#loginModal" class="text-white-50" style="cursor: pointer">Non c'est déja bon, j'm souviens</span>
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
