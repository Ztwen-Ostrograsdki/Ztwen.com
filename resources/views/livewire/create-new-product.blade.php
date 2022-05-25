
 {{-- Photo Modal --}}
 <div>
    {{--  --}}
 <div wire:loaded='product' wire:ignore.self class="modal fade lug" id="createProductModal" role="dialog" >
    <div class="modal-dialog modal-z-xlg" role="document">
       <!-- Modal content-->


       {{-- Product images  --}}
       <div class="modal-content" style="position: absolute; top:100px; z-index: 2010">
          <div class="modal-header">
             <div class="d-flex justify-content-between w-100">
                <h4 class="text-uppercase mr-2 mt-1">
                    @error('product_image')
                        <span class="text-danger">Erreur d'insertion ...</span>
                        <span class="bi-exclamation-triangle text-danger mx-2"></span>
                    @else
                        Creation d'un nouvel article
                         @if (session()->has('alert'))
                             <span class="alert text-capitalize alert-{{session('type')}} ml-4">{{session('alert')}}</span>
                        @endif
                    @enderror
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
             <div class="page-wrapper bg-gra-01 font-poppins">
                 <div class="wrapper wrapper--w780 ">
                    <div class="card card-3 border border-danger row w-100 p-0 m-0">
                         <div class="card-body border p-0 border-success col-12 col-lg-8 col-xl-8">
                            <h5 class="z-title text-white text-center p-1 m-0 "> Création d'un nouvel article
                                <br>
                                <span class="text-capitalize">
                                    {{ 'En cours... '}}
                                </span>
                            </h5>
                            <hr class="m-0 p-0 bg-white">
                            <hr class="m-0 p-0 bg-warning">
                            <hr class="m-0 p-0 bg-info">
                                <form autocomplete="off" class="mt-3 pb-3" wire:submit.prevent="create">
                                    <div class="input-group m-0 p-0 mt-0 mb-2 d-flex">
                                        <div class="input-group mt-0 mb-2 zw-33">
                                            <label class="text-white @error('slug') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="product_new_slug">Le Slug</label>
                                            <hr class="m-0 p-0 bg-info w-100 mb-1">
                                            <input class="input--style-3 px-2 @error('slug') text-danger border border-danger @enderror" wire:model.defer="slug" type="text" name="product_slug" id="product_new_slug">
                                            @error('slug')
                                                <small class="py-1 text-warning">{{$message}}</small>
                                            @enderror
                                        </div>
                                        <div class="input-group mt-0 mb-2 zw-33">
                                            <label class="text-white @error('slug') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="product_new_slug">La catégorie</label>
                                            <hr class="m-0 p-0 bg-info w-100 mb-1">
                                            <select class="input--style-3 px-2 form-select text-dark @error('slug') text-danger border border-danger @enderror" wire:model.defer="category_id" name="product_id" id="product_new_category">
                                                <option class="" value="">Choisissez une catégorie</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('slug')
                                                <small class="py-1 text-warning">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="input-group mt-0 mb-2">
                                        <label class="text-white @error('description') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="product_new_description">Le description</label>
                                        <hr class="m-0 p-0 bg-info w-100 mb-1">
                                        <input class="input--style-3 px-2 @error('description') text-danger border border-danger @enderror" wire:model.defer="description" type="text" name="product_description" id="product_new_description">
                                        @error('description')
                                            <small class="py-1 text-warning">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="input-group m-0 p-0 mt-0 mb-2 d-flex">
                                        <div class="input-group mt-0 mb-2 zw-30">
                                            <label class="text-white @error('price') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="product_new_price">Le Prix</label>
                                            <hr class="m-0 p-0 bg-info w-100 mb-1">
                                            <input class="input--style-3 px-2 @error('price') text-danger border border-danger @enderror" wire:model.defer="price" type="text" name="product_price" id="product_new_price">
                                            @error('price')
                                                <small class="py-1 text-warning">{{$message}}</small>
                                            @enderror
                                        </div>
                                        <div class="input-group mt-0 mb-2 zw-30">
                                            <label class="text-white @error('total') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="product_new_total">Quantité disponible</label>
                                            <hr class="m-0 p-0 bg-info w-100 mb-1">
                                            <input class="input--style-3 px-2 @error('total') text-danger border border-danger @enderror" wire:model.defer="total" type="text" name="product_total" id="product_new_total">
                                            @error('total')
                                                <small class="py-1 text-warning">{{$message}}</small>
                                            @enderror
                                        </div>
                                        <div class="input-group mt-0 mb-2 zw-30">
                                            <label class="text-white @error('reduction') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="product_new_reduction">Réduction</label>
                                            <hr class="m-0 p-0 bg-info w-100 mb-1">
                                            <input class="input--style-3 px-2 @error('reduction') text-danger border border-danger @enderror" wire:model.defer="reduction" type="text" name="product_reduction" id="product_new_reduction">
                                            @error('reduction')
                                                <small class="py-1 text-warning">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
                                        <button class="w-50 border border-white btn btn--pill btn--green" type="submit">Ajouter</button>
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
 </div>