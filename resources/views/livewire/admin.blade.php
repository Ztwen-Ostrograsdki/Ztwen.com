<div class="m-0 p-0 w-100">
   <div class="z-justify-relative-top-80 w-100" style="width: 90%;">
      <div class="w-100 border m-0 p-0">
         <div class="m-0 p-0 w-100">
            <div class="row w-100 m-0">
               <div class="col-2 m-0 text-capitalize border border-dark bg-dark p-0  @if($adminTrashedData) text-danger @else text-white @endif" style="min-height: 650px;">
                  <div class="d-fex flex-column w-100 mb-3">
                     <div class="m-0 py-2 @if($adminTagName == 'notifications') z-admin-active @endif px-2">
                        <div wire:click="setActiveTag('notifications', 'Notifications')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="bi-envelope-fill mr-2"></span>
                           <h5 class="w-100 m-0 d-none d-xl-inline">Notifications</h5>
                           <span class="">255</span>
                           <span class="@if($adminTagName == 'notifications') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 @if($adminTagName == 'comments') z-admin-active @endif  px-2">
                        <div wire:click="setActiveTag('comments', 'Commentaires')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="mr-2 bi-chat-fill "></span>
                           <h5 class="w-100 m-0 d-none d-xl-inline">Commentaires</h5>
                           @if ($comments->count() > 9)
                              <span class="">{{$comments->count()}}</span>
                           @else
                              <span class="">0{{$comments->count()}}</span>
                           @endif
                           <span class="@if($adminTagName == 'comments') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 @if($adminTagName == 'admins') z-admin-active @endif px-2">
                        <div wire:click="setActiveTag('admins', Administrateurs')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="mr-2 bi-person-workspace"></span>
                           <h5 class="w-100 m-0 d-none d-xl-inline">Administrateurs</h5>
                           @if ($admins->count() > 9)
                              <span class="">{{$admins->count()}}</span>
                           @else
                              <span class="">0{{$admins->count()}}</span>
                           @endif
                           <span class="@if($adminTagName == 'admins') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-2 @if($adminTagName == 'users') z-admin-active @endif">
                        <div wire:click="setActiveTag('users', 'Utilisateurs')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="mr-2 bi-people-fill"></span>
                           <h5 class="w-100 m-0 d-none d-xl-inline">Utilisateurs</h5>
                           @if ($users->count() > 9)
                              <span class="">{{$users->count()}}</span>
                           @else
                              <span class="">0{{$users->count()}}</span>
                           @endif
                           <span class="@if($adminTagName == 'users') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-2 @if($adminTagName == 'categories') z-admin-active @endif">
                        <div wire:click="setActiveTag('categories', 'Catégories')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="mr-2 bi-list-check"></span>
                           <h5 class="w-100 m-0 d-none d-xl-inline">Catégories</h5>
                           @if ($categories->count() > 9)
                              <span class="">{{$categories->count()}}</span>
                           @else
                              <span class="">0{{$categories->count()}}</span>
                           @endif
                           <span class="@if($adminTagName == 'categories') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 @if($adminTagName == 'products') z-admin-active @endif px-2">
                        <div wire:click="setActiveTag('products', 'Articles')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="mr-2 bi-cart-check"></span>
                           <h5 class="w-100 m-0  d-none d-xl-inline">Articles</h5>
                           @if ($products->count() > 9)
                              <span class="">{{$products->count()}}</span>
                           @else
                              <span class="">0{{$products->count()}}</span>
                           @endif
                           <span class="@if($adminTagName == 'products') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                  </div>
               </div>
               <div class="col-10 border-left border-white bg-dark pb-5">
                  <div class="w-100 mx-auto mt-2 border">
                    <div class="mx-auto d-flex w-100 justify-content-between">
                        <div class="col-6 bg-info">
                           <h4 class="text-center text-white text-uppercase mt-4">
                              {{$adminTagTitle}}
                           </h4>
                        </div>
                        <div class="col-3 p-0 text-white flex-column border-left d-flex justify-content-between">
                           <span wire:click="getTheActiveData" class="py-2 px-2 cursor-pointer @if(!$adminTrashedData) bg-info @endif">
                              <span class="bi-minecart"></span>
                              <span>Actifs</span>
                           </span>
                           <hr class="bg-white p-0 m-0">
                           <span wire:click="getTheTrashedData" class="py-2 px-2 cursor-pointer @if($adminTrashedData) bg-info @endif">
                              <span class="bi-trash"></span>
                              <span>Corbeille</span>
                           </span>
                        </div>
                        @isAdmin()
                           @if ($adminTagName == 'users' || $adminTagName == 'admins')
                                <div class="text-white-50 cursor-pointer border-left p-3 col-3" data-toggle="modal" data-target="#registerModal" data-dismiss="modal">
                                    <span class="">
                                    <span class="fa fa-user-plus fa-2x"></span>
                                    <span class="d-none d-lg-inline d-xl-inline">Ajouter un utilisateur</span>
                                    </span>
                                </div>
                            @elseif($adminTagName == 'categories')
                                <div class="text-white-50 cursor-pointer border-left p-3 col-3" data-toggle="modal" data-target="#createCategoryModal" data-dismiss="modal">
                                    <span class="">
                                    <span class="fa bi-list-check fa-2x"></span>
                                    <span class="d-none d-lg-inline d-xl-inline">Ajouter une categorie</span>
                                    </span>
                                </div>
                            @elseif($adminTagName == 'products')
                                <div class="text-white-50 cursor-pointer border-left p-3 col-3" data-toggle="modal" data-target="#createProductModal" data-dismiss="modal">
                                    <span class="">
                                    <span class="fa bi-cart-plus fa-2x"></span>
                                    <span class="d-none d-lg-inline d-xl-inline">Ajouter un article</span>
                                    </span>
                                </div>
                            @elseif($adminTagName == 'comments')
                                <div class="text-white-50 border-left col-3">
                                 @if($comments->count() > 0)
                                       <div class="d-flex flex-column p-1 justify-content-between mx-auto w-100">
                                          <div class="w-100 row p-0 m-0 mx-auto">
                                             <span title="Supprimer les commentaires non approuvés" wire:click="deleteNotApprovedComments" style="font-size: 17px" class="btn-success col-5 border mx-1 px-2 border-white cursor-pointer text-white ">
                                                <span class="fa fa-trash cursor-pointer text-white"></span>
                                                <span class="">Vider</span>
                                             </span>
                                             <span title="Supprimer tous les commentaires" wire:click="deleteAllComments" style="font-size: 17px" class="btn-danger mx-1 border px-2 col-5 border-white cursor-pointer text-white ">
                                                <span class="fa fa-trash cursor-pointer text-white"></span>
                                                <span class="">Vider</span>
                                             </span>
                                          </div>
                                          <div class="w-100 m-0 mx-auto row p-0 mt-2">
                                             <span title="Faire quelques choses..." style="font-size: 17px" class="btn-danger mx-1 border col-10 px-4 border-white cursor-pointer text-white ">
                                                <span class="fa fa-desktop cursor-pointer text-white"></span>
                                                <span class="">Quelques ...</span>
                                             </span>
                                          </div>
                                       </div>
                                 @endif
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
