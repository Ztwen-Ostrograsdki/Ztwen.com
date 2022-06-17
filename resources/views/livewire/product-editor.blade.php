
<div>
 <div wire:loaded='product' wire:ignore.self class="modal fade lug" id="updateProductModal" role="dialog" >
    <div class="modal-dialog modal-z-xlg" role="document">
       <div class="modal-content z-bg-secondary border" style="position: absolute; top:100px; z-index: 2010">
          <div class="modal-header">
             <div class="d-flex justify-content-between w-100">
                <span class="text-uppercase mr-2 mt-1 text-white-50 d-block">
                    Edition de la galery d'article 
                    <span class="ml-3 text-warning text-italic" wire:loading wire:target="product_image" >Chargement de l'image en cours, veuillez patienter...</span>
                </span>
                <div class="d-flex justify-content-end w-20">
                   <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                </div>
             </div>
          </div>
          <div class="modal-body m-0 p-0 z-bg-secondary">
            <div class="">
                <div class="">
                   <div class="bg-transparent w-100 p-0 m-0">
                       @if($product_image)
                       <div class="m-0 p-0 d-flex justify-center bg-transparent">
                           <img width="250" class="border mt-2 p-0" src="{{$product_image->temporaryUrl()}}" alt="image en chargement">
                       </div>
                        @else
                        <label class="m-0 p-0 text-center z-bg-secondary w-100 d-flex flex-column justify-content-between" for="product_photo">
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
                               <form autocomplete="off" class="mt-3 pb-3 px-2 mx-auto form-group bg-transparent zw-90" wire:submit.prevent="updateProductGalery">
                                   <div class="input-group mt-0 mb-2">
                                       <label class="text-white-50 @error('product_image') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="product_photo"><strong>Choisissez une image</strong></label>
                                       <hr class="m-0 p-0 bg-info w-100 mb-1">
                                       <input class="form-control bg-transparent w-100 text-white-50 border border-dark @error('product_image') text-warning border border-danger @enderror" wire:model.defer="product_image" id="product_photo" type="file" name="product_image">
                                       @error('product_image')
                                           <small class="py-1 z-text-orange d-block">{{$message}}</small>
                                       @enderror
                                   </div>
                                   <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
                                       <button class="w-50 border border-white btn z-bg-orange py-2" type="submit">Editer</button>
                                   </div>
                                   <div class="m-0 p-0 w-50 text-center mx-auto pb-2">
                                      <span data-toggle="modal" data-dismiss="modal" class="text-warning" style="cursor: pointer">Non c'est bon</span>
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