<div>
    <div wire:ignore.self class="modal fade lug" id="adminAuthenticationModal" role="dialog" >
       <div class="modal-dialog modal-z-xlg" role="document">
          <!-- Modal content-->
          <div class="modal-content modal-fullscreen border @if('errorTexto') border-danger @endif" style="z-index: 2010; top: 80px;">
             <div class="modal-header">
                <div class="d-flex justify-content-between w-100">
                   <h6 class="text-uppercase mr-2 mt-1 d-flex justify-content-between">
                        Veuillez vous authentifier
                        <span class="fa fa-user-secret ml-2"></span>
                   </h6>
                   <div class="d-flex justify-content-end w-20">
                      <div class="w-15 mx-0 px-0">
                      </div>
                      <div class="w-25"></div>
                      <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                   </div>
                </div>
             </div>
             <div class="modal-body m-0 p-0">
                <div class="">
                    <div class="">
                       <div class="row w-100 p-0 m-0 z-bg-hover-secondary">
                            <div class="border p-0 col-12 p-3">
                                <div>
                                    <div class="w-100 p-0 m-0 mx-auto p-2"> 
                                        <form autocomplete="off" class="mt-3 pb-3 form-group" wire:submit.prevent="authenticate">
                                            @csrf
                                            <div class="w-100 m-0 p-0 mx-auto row justify-content-center">
                                                <div class="col-11 mx-auto">
                                                    <input type="password" placeholder="Taper la clé d'authentification..." style="font-family: cursive !important;" wire:model.defer="key" class="form-control py-3 border w-100 text-white bg-transparent @error('key') border-danger @enderror" name="key" id="key" >
                                                    @error('key') 
                                                        <span class="text-danger d-block mt-1 mb-1">{{$message}}</span>
                                                    @enderror
                                                </div>
                                                <button id="" class="btn btn-primary mx-auto mt-2 d-flex justify-content-center col-6 border border-white">
                                                    <span class="d-none d-lg-inline d-md-inline d-xl-inline mr-2">S'authentifier</span>
                                                    <span class="fa bi-unlock mt-1"></span>
                                                </button>
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
    </div>
    </div>