 <div>
 <div wire:loaded='product' wire:ignore.self class="modal fade lug" id="editProductModal" role="dialog" >
    <div class="modal-dialog modal-z-xlg" role="document">
       <div class="modal-content z-bg-secondary border" style="position: absolute; top:100px; z-index: 2010">
          <div class="modal-header">
             <div class="d-flex justify-content-between w-100">
                <h6 class="text-uppercase  text-white-50 mr-2 mt-1">
                    @error('product_image')
                        <span class="text-danger">Erreur de mise à jour ...</span>
                        <span class="bi-exclamation-triangle text-danger mx-2"></span>
                    @else
                        Mise à jour d'article
                         @if (session()->has('alert'))
                             <span class="alert text-capitalize alert-{{session('type')}} ml-4">{{session('alert')}}</span>
                        @endif
                    @enderror
                </h6>
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
          <div class="modal-body m-0 p-0 z-bg-secondary">
             <div class="">
                 <div class="">
                    <div class="z-bg-secondary w-100 p-0 m-0">
                         @if($product)
                         <div class="">
                            <h6 class="z-title text-white-50 text-center p-1 m-0 "> Edition de l'article : 
                                <br>
                                <span class="bi-tag mx-1"></span>
                                <span class="text-capitalize">
                                    {{ $product->getName() }}
                                </span>
                                <span class="bi-tag mx-1"></span>
                            </h6>
                            <hr class="bg-secondary text-white p-0 w-75 mx-auto">
                                <form autocomplete="off" class="form-group mt-3 pb-3 px-2 bg-transparent" wire:submit.prevent="updateData">
                                        <div class=" m-0 p-0 mt-0 mb-2 row w-100 d-flex justify-between">
                                            <div class="mt-0 mb-2 col-6">
                                                <label class="z-text-cyan m-0 p-0 w-100 cursor-pointer" for="edit_product_slug">Le Slug</label>
                                                <input placeholder="Veuillez renseigner le slug" class="text-white border border-white form-control bg-transparent w-100 px-2 @error('slug') text-danger border-danger @enderror" wire:model.defer="slug" type="text" name="product_slug" id="edit_product_slug">
                                                @error('slug')
                                                    <small class="py-1 z-text-orange">{{$message}}</small>
                                                @enderror
                                            </div>
                                            <div class="mt-0 mb-2 col-5">
                                                <label class="z-text-cyan m-0 p-0 w-100 cursor-pointer" for="edit_product_category">La catégorie</label>
                                                <select class="px-2 form-select text-white z-bg-secondary w-100 @error('category_id') text-danger border border-danger @enderror" wire:model.defer="category_id" name="product_id" id="edit_product_category">
                                                    <option class="" value="">Choisissez une catégorie</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <small class="py-1 z-text-orange">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="p-0 m-0 mt-0 mb-2 row w-100 px-2">
                                            <label class="z-text-cyan m-0 p-0 w-100 cursor-pointer" for="edit_product_description">Le description</label>
                                            <input placeholder="Veuillez decrire brièvement cet article..." class="text-white form-control bg-transparent border border-white px-2 @error('description') text-danger border-danger @enderror" wire:model.defer="description" type="text" name="product_description" id="edit_product_description">
                                            @error('description')
                                                <small class="py-1 z-text-orange">{{$message}}</small>
                                            @enderror
                                        </div>
                                        <div class="m-0 p-0 mt-0 mb-2 d-flex row justify-between w-100">
                                            <div class="mt-0 mb-2 col-4">
                                                <label class="z-text-cyan m-0 p-0 w-100 cursor-pointer" for="edit_product_price">Le Prix</label>
                                                <input placeholder="Veuillez renseigner le prix..." class="text-white form-control bg-transparent border border-white px-2 @error('price') text-danger border-danger @enderror" wire:model.defer="price" type="text" name="product_price" id="edit_product_price">
                                                @error('price')
                                                    <small class="py-1 z-text-orange">{{$message}}</small>
                                                @enderror
                                            </div>
                                            <div class="mt-0 mb-2 col-4">
                                                <label class="z-text-cyan m-0 p-0 w-100 cursor-pointer" for="edit_product_total">Quantité disponible</label>
                                                <input placeholder="Veuillez renseigner la quantité disponible" class="text-white form-control bg-transparent border border-white px-2 @error('total') text-danger border-danger @enderror" wire:model.defer="total" type="text" name="product_total" id="edit_product_total">
                                                @error('total')
                                                    <small class="py-1 z-text-orange">{{$message}}</small>
                                                @enderror
                                            </div>
                                            <div class="mt-0 mb-2 col-4">
                                                <label class="z-text-cyan m-0 p-0 w-100 cursor-pointer" for="edit_product_reduction">Réduction</label>
                                                <input placeholder="Veuillez renseigner la réduction" class="text-white form-control bg-transparent border border-whit px-2 @error('reduction') text-danger border-danger @enderror" wire:model.defer="reduction" type="text" name="product_reduction" id="edit_product_reduction">
                                                @error('reduction')
                                                    <small class="py-1 z-text-orange">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
                                            <button class="w-50 border border-white btn z-bg-orange" type="submit">Editer</button>
                                        </div>
                                        <div class="m-0 p-0 w-50 text-center mx-auto pr-3 pb-2">
                                           <strong data-toggle="modal" data-dismiss="modal" class="text-warning" style="cursor: pointer">Non c'est bon</strong>
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