 <div>
 <div wire:loaded='product'  class="modal fade lug" id="editProductModal" role="dialog" >
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
                                            <x-z-input :width="'col-6'"  :error="$errors->first('slug')" :modelName="'slug'" :labelTitle="'Le Slug'" ></x-z-input>
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
                                        <x-z-input :error="$errors->first('description')" :modelName="'description'" :labelTitle="'La description'" ></x-z-input>
                                        <div class="m-0 p-0 mt-0 mb-2 d-flex row justify-between w-100">
                                            <x-z-input :width="'col-4'" :error="$errors->first('price')" :modelName="'price'" :labelTitle="'Le prix'" ></x-z-input>
                                            <x-z-input :width="'col-4'" :error="$errors->first('total')" :modelName="'total'" :labelTitle="'La quantité disponible'" ></x-z-input>
                                            <x-z-input :width="'col-4'" :error="$errors->first('reduction')" :modelName="'reduction'" :labelTitle="'La réduction effectuée'" ></x-z-input>
                                        </div>
                                        <x-z-button>Mettre à jour</x-z-button>
                                        <x-z-modal-dismisser>Annuler</x-z-modal-dismisser>
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
