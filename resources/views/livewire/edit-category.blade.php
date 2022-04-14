
 <div>
    <div wire:ignore.self class="modal fade lug" id="EditCategoryModal" role="dialog" >
       <div class="modal-dialog modal-z-xlg" role="document">
          <!-- Modal content-->
          <div class="modal-content" style="position: absolute; top:100px; z-index: 2010">
             <div class="modal-header">
                <div class="d-flex justify-content-between w-100">
                   <h4 class="text-uppercase mr-2 mt-1">
                       Edition de la  catégorie {{$category->name}}
                            @if (session()->has('alert'))
                               <span class="alert text-capitalize alert-{{session('type')}} ml-4">{{session('alert')}}</span>
                            @endif
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
                               <h5 class="z-title text-white text-center p-1 m-0 "> Edition de la catégorie
                                   <br>
                                   <span class="text-capitalize">
                                       {{ $category->name}}
                                   </span>
                               </h5>
                               <hr class="m-0 p-0 bg-white">
                               <hr class="m-0 p-0 bg-warning">
                               <hr class="m-0 p-0 bg-info">
                                   <form autocomplete="off" class="mt-3 pb-3" wire:submit.prevent="update">
                                       <div class="input-group zw-95 mt-0 mb-2">
                                           <label class="z-text-cyan @error('name') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="category_edit_name">Le nom de la catégorie</label>
                                           <hr class="m-0 p-0 bg-info w-100 mb-1">
                                           <input class="input--style-3 px-2 @error('name') text-danger border border-danger @enderror" wire:model.defer="name" type="text" placeholder="Le nom de la catégorie" name="category_name" id="category_edit_name">
                                           @error('name')
                                               <small class="py-1 text-warning">{{$message}}</small>
                                           @enderror
                                       </div>
                                       <div class="input-group mt-0 mb-2 zw-95">
                                           <label class="z-text-cyan @error('description') text-danger @enderror m-0 p-0 w-100 cursor-pointer" for="category_edit_description">Décrivez brièvement la catégorie</label>
                                           <hr class="m-0 p-0 bg-info w-100 mb-1">
                                           <input class="input--style-3 px-2 @error('description') text-danger border border-danger @enderror" placeholder="La description de la catégorie" wire:model.defer="description" type="text" name="category_description" id="category_edit_description">
                                           @error('description')
                                               <small class="py-1 text-warning">{{$message}}</small>
                                           @enderror
                                       </div>
                                       <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
                                           <button class="w-50 border border-white btn btn--pill btn--green" type="submit">Mettre à jour</button>
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