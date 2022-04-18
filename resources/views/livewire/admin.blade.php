<div class="m-0 p-0 w-100">
   <div class="z-justify-relative-top-80 w-100" style="width: 90%;">
      <div class="w-100 border m-0 p-0">
         <div class="m-0 p-0 w-100">
            <div class="row w-100 m-0">
               <div class="col-3 m-0 text-capitalize border border-dark bg-dark p-0 text-white" style="min-height: 650px;">
                  <div class="d-fex flex-column w-100 mb-3">
                     <div class="m-0 py-2 @if($adminTagName == 'notifications') z-admin-active @endif  px-4">
                        <div wire:click="setActiveTag('notifications', 'Les Notifications')" class="d-flex w-100 cursor-pointer m-0 p-0">
                           <span class="fa fa-2x fa-inbox"></span>
                           <h4 class="w-100 m-0 mt-2 ml-3">Notifications</h4>
                           <span class="fa fa-2x">255</span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 @if($adminTagName == 'admins') z-admin-active @endif px-4">
                        <div wire:click="setActiveTag('admins', 'Les administrateurs')" class="d-flex w-100 cursor-pointer m-0 p-0">
                           <span class="fa fa-user-secret fa-2x"></span>
                           <h4 class="w-100 m-0 mt-2 ml-3">Les administrateurs</h4>
                           @if ($admins->count() > 9)
                              <span class="fa fa-2x">{{$admins->count()}}</span>
                           @else
                              <span class="fa fa-2x">0{{$admins->count()}}</span>
                           @endif
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-4 @if($adminTagName == 'users') z-admin-active @endif">
                        <div wire:click="setActiveTag('users', 'Les Utilisateurs')" class="d-flex w-100 cursor-pointer m-0 p-0">
                           <span class="fa fa-user fa-2x"></span>
                           <h4 class="w-100 m-0 mt-2 ml-3">Les utilisateurs</h4>
                           @if ($users->count() > 9)
                              <span class="fa fa-2x">{{$users->count()}}</span>
                           @else
                              <span class="fa fa-2x">0{{$users->count()}}</span>
                           @endif
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-4 @if($adminTagName == 'categories') z-admin-active @endif">
                        <div wire:click="setActiveTag('categories', 'Les Catégories')" class="d-flex w-100 cursor-pointer m-0 p-0">
                           <span class="fa bi-list-check fa-2x"></span>
                           <h4 class="w-100 m-0 mt-2 ml-3">Les Catégories</h4>
                           @if ($categories->count() > 9)
                              <span class="fa fa-2x">{{$categories->count()}}</span>
                           @else
                              <span class="fa fa-2x">0{{$categories->count()}}</span>
                           @endif
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 @if($adminTagName == 'products') z-admin-active @endif px-4">
                        <div wire:click="setActiveTag('products', 'Les Articles')" class="d-flex w-100 cursor-pointer m-0 p-0">
                           <span class="fa fa-desktop fa-2x"></span>
                           <h4 class="w-100 m-0 mt-2 ml-3">Les articles</h4>
                           @if ($products->count() > 9)
                              <span class="fa fa-2x">{{$products->count()}}</span>
                           @else
                              <span class="fa fa-2x">0{{$products->count()}}</span>
                           @endif
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                  </div>
               </div>
               <div class="col-9 border-left border-white bg-dark pb-3">
                  <div class="w-100 mx-auto mt-2 border">
                    <div class="mx-auto d-flex w-100 justify-content-between">
                        <div class="col-9">
                           <h4 class="text-center text-white text-uppercase mt-4">
                              {{$adminTagTitle}}
                           </h4>
                        </div>
                        @isAdmin()
                           @if ($adminTagName == 'users' || $adminTagName == 'admins')
                                <div class="text-white-50 cursor-pointer border-left p-3 col-3" data-toggle="modal" data-target="#registerModal" data-dismiss="modal">
                                    <span class="">
                                    <span class="fa fa-user-plus fa-2x"></span>
                                    <span class="">Ajouter un utilisateur</span>
                                    </span>
                                </div>
                            @elseif($adminTagName == 'categories')
                                <div class="text-white-50 cursor-pointer border-left p-3 col-3" data-toggle="modal" data-target="#createCategoryModal" data-dismiss="modal">
                                    <span class="">
                                    <span class="fa bi-list-check fa-2x"></span>
                                    <span class="">Ajouter une categorie</span>
                                    </span>
                                </div>
                            @elseif($adminTagName == 'products')
                                <div class="text-white-50 cursor-pointer border-left p-3 col-3" data-toggle="modal" data-target="#createProductModal" data-dismiss="modal">
                                    <span class="">
                                    <span class="fa bi-cart-plus fa-2x"></span>
                                    <span class="">Ajouter un article</span>
                                    </span>
                                </div>
                           @endif
                        @endisAdmin
                    </div>
                  </div>
                  @include('livewire.components.admin.thelister', 
                        [
                           'tag' => $adminTagName, 
                           'users' => $users,
                           'categories' => $categories
                        ])
               </div>
            </div>
         </div>   
      </div>
   </div>
   
</div>
