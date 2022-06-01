@auth
 {{-- Photo Modal --}}
 <div wire:ignore.self class="modal fade lug" id="editPhotoProfilModal" role="dialog" >
    <div class="modal-dialog modal-z-xlg" role="document">
       <!-- Modal content-->
       <div class="modal-content" style="position: absolute; top:80px;">
          <div class="modal-header">
             <div class="d-flex justify-content-between w-100">
                <h4 class="text-uppercase mr-2 mt-1">
                    Edition de la photo de profil 
                    <span class="ml-3 text-warning text-italic" wire:loading wire:target="user_profil" >Chargement de l'image en cours, veuillez patienter...</span>
                </h4>
                <div class="d-flex justify-content-end w-20">
                   <div class="w-15 mx-0 px-0">
                        <ul class="d-flex mx-0 px-0 mt-1 justify-content-between w-100">
                           <li class=" mx-1"><a href="#"><img src="/images/flag-up-1.png" width="100" alt="" /> </a></li>
                           <li><a href="#"><img src="/images/flag-up-2.png" width="100" alt="" /></a></li>
                        </ul>
                   </div>
                   <div class="w-25"></div>
                   <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                </div>
             </div>
          </div>
          <div class="modal-body m-0 p-0 border border-warning">
             <div class="page-wrapper bg-gra-01 font-poppins            ">
                 <div class="wrapper wrapper--w780 ">
                    <div class="card card-3 border border-danger row w-100 p-0 m-0">
                        @if($user_profil)
                        <div class="m-0 p-0 border border-info col-4" 
                            style="
                                background: url('{{ $user_profil->temporaryUrl() }}') top left/cover no-repeat;
                                background-position: ;
                                border-bottom: thin solid white;
                                border-left: thin solid white;
                                display: table-cell;
                                width: 50%;
                             ">
                        </div>
                         @else
                         <div class="m-0 p-0 text-center w-100 d-flex flex-column justify-content-between">
                             <span></span>
                            <h4 class="px-2 text-secondary w-100 text-bold h3 pt-4 mt-3 align-content-center" id="focus_photo_prf">
                                Veuillez choisir une image
                                <span class="fa fa-download"></span>
                            </h4>
                            <span></span>
                         </div>
                         @endif
                         <div class="card-body border p-0 border-success col-12 col-lg-8 col-xl-8">
                            <h3 class="z-title text-white text-center p-1 m-0 "> Photo de profil de {{ $user->name }} </h3>
                            <hr class="m-0 p-0 bg-white">
                            <hr class="m-0 p-0 bg-warning">
                            <hr class="m-0 p-0 bg-info">
                                <form autocomplete="off" class="mt-3 pb-3" wire:submit.prevent="editUserProfilPhoto" >
                                    <div class="input-group mt-0 mb-2">
                                        <label class="text-white @error('user_profil') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="photo_prf">Votre photo de profil {{$user->name}}</label>
                                        <hr class="m-0 p-0 bg-info w-100 mb-1">
                                        <input class="input--style-3 @error('user_profil') text-danger border border-danger @enderror" wire:model.defer="user_profil" id="photo_prf" type="file" name="user_profil">
                                        @error('user_profil')
                                            <small class="py-1 text-warning">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
                                        <button class="w-50 border border-white btn btn--pill btn--green" type="submit">Editer</button>
                                    </div>
                                    <div class="m-0 p-0 w-50 text-center mx-auto pr-3 pb-2">
			                           <span data-toggle="modal" data-dismiss="modal" class="text-white-50" style="cursor: pointer">Non c'est bon</span>
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
 @endauth