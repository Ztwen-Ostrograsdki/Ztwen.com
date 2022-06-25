@auth
 {{-- Photo Modal --}}
 <div wire:ignore.self class="modal fade lug" id="editPhotoProfilModal" role="dialog" >
    <div class="modal-dialog modal-z-xlg" role="document">
       <!-- Modal content-->
       <div class="modal-content z-bg-secondary border" style="position: absolute; top:80px;">
          <div class="modal-header">
             <div class="d-flex justify-content-between w-100">
                <span class="text-uppercase mr-2 mt-1 text-white-50 d-block">
                    Edition de la photo de profil 
                    <span class="ml-3 text-warning text-italic" wire:loading wire:target="user_profil" >Chargement de l'image en cours, veuillez patienter...</span>
                </span>
                <div class="d-flex justify-content-end w-20">
                   <div class="w-25"></div>
                   <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                </div>
             </div>
          </div>
          <div class="modal-body m-0 p-0 z-bg-secondary">
             <div class="">
                 <div class="">
                    <div class="bg-transparent w-100 p-0 m-0">
                        @if($user_profil)
                        <div class="m-0 p-0 d-flex justify-center bg-transparent">
                            <img width="250" class="border mt-2 p-0" src="{{$user_profil->temporaryUrl()}}" alt="image en chargement">
                        </div>
                         @else
                         <label class="m-0 p-0 text-center z-bg-secondary w-100 d-flex flex-column justify-content-between" for="photo_prf">
                            <div class="w-100">
                               <h4 class="px-2 text-secondary w-100 text-bold py-2 mt-2 align-content-center" >
                                   Veuillez choisir une image
                                   <span class="fa fa-download"></span>
                               </h4>
                               <span></span>
                            </div>
                        </label>
                        @endif
                         <div class="z-bg-secondary-dark p-0 col-12">
                                <form autocomplete="off" class="mt-3 pb-3 px-2 mx-auto form-group bg-transparent zw-90" wire:submit.prevent="editUserProfilPhoto" >
                                    <div x-data="{isUploading:false, progress: 0 }"
                                        x-on:livewire-upload-start="isUploading = true"
                                        x-on:livewire-upload-finish="isUploading = false"
                                        x-on:livewire-upload-error="isUploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                                    >
                                    <div class="input-group mt-0 mb-2">
                                        <label class="text-white-50 @error('user_profil') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="photo_prf"><strong>Votre photo de profil</strong></label>
                                        <hr class="m-0 p-0 bg-info w-100 mb-1">
                                        <input class="form-control bg-transparent w-100 text-white-50 border border-dark @error('user_profil') text-warning border border-danger @enderror" wire:model.defer="user_profil" id="photo_prf" type="file" name="user_profil">
                                        @error('user_profil')
                                            <small class="py-1 z-text-orange d-block">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
                                        <button class="w-50 border border-white btn z-bg-orange py-2" type="submit">Editer</button>
                                    </div>
                                    <div class="m-0 p-0 w-50 text-center mx-auto pb-2">
			                           <span data-toggle="modal" data-dismiss="modal" class="text-warning" style="cursor: pointer">Non c'est bon</span>
			                        </div>
                                    <div x-show="isUploading" class="my-2 progress rounded">
                                        <div class="progress-bar bg-primary progress-bar-stripped py-1" role="progressbar" aria-valuenow="40" aria-valuemax="100" aria-valuemin="0" x-bind:style="'width:$(progres)%'" >

                                        </div>
                                    </div>
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