
 {{-- Photo Modal --}}
<div>
    {{--  --}}
 <div wire:loaded='product' wire:ignore.self class="modal fade lug" id="updateProductModal" role="dialog" >
    <div class="modal-dialog modal-z-xlg" role="document">
       <!-- Modal content-->


       {{-- Product images  --}}
       <div class="modal-content" style="position: absolute; top:100px; z-index: 2010">
          <div class="modal-header">
             <div class="d-flex justify-content-between w-100">
                <h4 class="text-uppercase mr-2 mt-1">
                    @error('product_image')
                        <span class="text-danger">Erreur de mise à jour ...</span>
                        <span class="bi-exclamation-triangle text-danger mx-2"></span>
                    @else
                        Mise à jour d'article
                         @if (session()->has('alert'))
                             <span class="alert text-capitalize alert-{{session('type')}} ml-4">{{session('alert')}}</span>
                        @endif
                    @enderror
                    <span class="ml-3 text-warning text-capitalize text-italic" wire:loading wire:target="product_image" >Chargement de l'image en cours, veuillez patienter...</span>
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
                        @if($product_image)
                        <div class="m-0 p-0 border border-info col-4" 
                            style="
                                background: url('{{ $product_image->temporaryUrl() }}') top left/cover no-repeat;
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
                            <h4 class="px-2 text-secondary w-100 text-bold h3 pt-4 mt-3 align-content-center" id="">
                                Veuillez choisir une image
                                <span class="fa fa-download"></span>
                            </h4>
                            <span></span>
                         </div>
                         @endif
                         @if($product)
                         <div class="card-body border p-0 border-success col-12 col-lg-8 col-xl-8">
                            <h5 class="z-title text-white text-center p-1 m-0 "> Mise à jour de la galerie
                                <br>
                                <span class="text-capitalize">
                                    {{ $product->getName() }}
                                </span>
                            </h5>
                            <hr class="m-0 p-0 bg-white">
                            <hr class="m-0 p-0 bg-warning">
                            <hr class="m-0 p-0 bg-info">
                                <form autocomplete="off" class="mt-3 pb-3" wire:submit.prevent="updateProductGalery" >
                                    <div class="input-group mt-0 mb-2">
                                        <label class="text-white @error('product_image') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="image">Veuillez choisir l'image à importer </label>
                                        <hr class="m-0 p-0 bg-info w-100 mb-1">
                                        <input class="input--style-3 @error('product_image') text-danger border border-danger @enderror" wire:model.defer="product_image" id="image" type="file" name="image">
                                        @error('product_image')
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
                         @endif
                     </div>
                 </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 </div>