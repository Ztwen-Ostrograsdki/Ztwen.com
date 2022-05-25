<div>
    <div wire:ignore.self class="modal fade lug" id="addNewCommentModal" role="dialog" >
       <div class="modal-dialog modal-z-xlg" role="document">
          <!-- Modal content-->
          <div class="modal-content  border @error('comment') border-danger @enderror" style="position: absolute; top:100px; z-index: 2010;">
             <div class="modal-header">
                <div class="d-flex justify-content-between w-100">
                   <h4 class="text-uppercase mr-2 mt-1">
                       Poster un nouveau commentaire
                           @if (session()->has('alert'))
                               <span class="alert text-capitalize alert-{{session('type')}} ml-4">{{session('alert')}}</span>
                       @endif
                   </h4>
                   <div class="d-flex justify-content-end w-20">
                      <div class="w-15 mx-0 px-0">
                      </div>
                      <div class="w-25"></div>
                      <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                   </div>
                </div>
             </div>
             @if($product)
             <div class="modal-body m-0 p-0">
                <div class="">
                    <div class="wrapper wrapper--w780 ">
                       <div class="card card-3 border row w-100 p-0 m-0 z-bg-hover-secondary">
                            <div class="card-body border p-0 col-12 col-lg-8 col-xl-8 p-3">
                               <h5 class="z-title text-white text-center p-1 m-0 text-capitalize"> Article : {{$product->getName()}}</h5>
                                   <form autocomplete="off" class="mt-3 pb-3" wire:submit.prevent="create">
                                    @csrf
                                    <div class="w-100 m-0 p-0 mx-auto d-flex justify-content-between">
                                        <input placeholder="Taper votre commentaire..." style="font-family: cursive !important;" wire:model.defer="comment" class="form-control border zw-83 text-white bg-transparent @error('comment') border-danger @enderror" name="comment" id="comment" >
                                        <button id="" class="btn btn-primary d-flex justify-content-between zw-15">
                                            <span class="d-none d-lg-inline d-md-inline d-xl-inline mr-lg-2 mr-md-2 mr-xl-2 m-0">Poster</span>
                                            <span class="fa fa-send mt-2"></span>
                                        </button>
                                    </div>
                                    @error('comment') 
                                      <span class="text-danger">{{$message}}</span>
                                     @enderror
                               </form>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
             @endif
          </div>
       </div>
    </div>
    </div>