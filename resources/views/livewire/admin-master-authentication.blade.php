<div>
    <div wire:ignore.self class="modal fade lug" id="adminAuthenticationModal" role="dialog" >
       <div class="modal-dialog modal-z-xlg" role="document">
          <!-- Modal content-->
          <div class="modal-content modal-fullscreen border @if('errorTexto') border-danger @endif" style="z-index: 2010; top: 80px;">
             <div class="modal-header">
                <div class="d-flex justify-content-between w-100">
                   <h4 class="text-uppercase mr-2 mt-1 d-flex justify-content-between">
                        Veuillez vous authentifier
                   </h4>
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
                    <div class="wrapper wrapper--w780 ">
                       <div class="card card-3 border row w-100 p-0 m-0 z-bg-hover-secondary">
                            <div class="card-body border p-0 col-12 p-3">
                                <div>
                                    <div class="w-100 p-0 m-0 mx-auto d-flex flex-column "> 
                                        <form autocomplete="off" class="mt-3 pb-3" wire:submit.prevent="authenticate">
                                            @csrf
                                            <div class="w-100 m-0 p-0 mx-auto d-flex justify-content-between">
                                                <input type="password" placeholder="Taper la clé d'authentification..." style="font-family: cursive !important;" wire:model.defer="key" class="form-control py-3 border zw-70 text-white bg-transparent @error('key') border-danger @enderror" name="key" id="key" >
                                                <button id="" class="btn btn-primary d-flex justify-content-between zw-20">
                                                    <span class="d-none d-lg-inline d-md-inline d-xl-inline mr-lg-2 mr-md-2 mr-xl-2 m-0">Authentifier</span>
                                                    <span class="fa bi-unlock mt-2"></span>
                                                </button>
                                            </div>
                                            @error('key') 
                                              <span class="text-danger">{{$message}}</span>
                                             @enderror
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