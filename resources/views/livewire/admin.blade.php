<div class="m-0 p-0 w-100">
   <div class="z-justify-relative-top-80 w-100" style="width: 90%;">
      <div class="w-100 border m-0 p-0">
         <div class="m-0 p-0 w-100">
            <div class="row w-100 m-0">
               <div id="adminLeftDashboard" class="col-2 m-0 text-capitalize border border-dark bg-dark p-0  @if($adminTrashedData) text-danger @else text-white @endif" style="min-height: 650px;">
                  <div class="d-fex flex-column w-100 mb-3">
                     <div class="m-0 py-2 px-2">
                        <div class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="bi-search mr-2"></span>
                           <h5 class="w-100 m-0 p-0 d-none d-xl-inline">
                              <input wire:model="search" name="search" class="form-control py-1 bg-transparent text-white border border-secondary" placeholder="Rechercher dans {{$adminTagTitle}}" type="text">
                           </h5>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 text-white bg-white">
                     <div class="m-0 py-2 @if($adminTagName == 'notifications') z-admin-active @endif px-2">
                        <div wire:click="setActiveTag('notifications', 'Notifications')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="bi-envelope-fill mr-2"></span>
                           <span class="w-100 m-0 d-none d-xl-inline">Notifications</span>
                           <span class="">255</span>
                           <span class="@if($adminTagName == 'notifications') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 @if($adminTagName == 'comments') z-admin-active @endif  px-2">
                        <div wire:click="setActiveTag('comments', 'Commentaires')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="mr-2 bi-chat-fill "></span>
                           <span class="w-100 m-0 d-none d-xl-inline">Commentaires</span>
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
                           <span class="w-100 m-0 d-none d-xl-inline">Administrateurs</span>
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
                           <span class="w-100 m-0 d-none d-xl-inline">Utilisateurs</span>
                           @if ($users->count() > 9)
                              <span class="">{{$users->count()}}</span>
                           @else
                              <span class="">0{{$users->count()}}</span>
                           @endif
                           <span class="@if($adminTagName == 'users') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-2 @if($adminTagName == 'unconfirmed') z-admin-active @endif">
                        <div wire:click="setActiveTag('unconfirmed', 'Email non confirmé')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="mr-2 bi-person-x-fill  "></span>
                           <span class="w-100 m-0 d-none d-xl-inline">Email non confirmé</span>
                           @if ($unconfirmed->count() > 9)
                              <span class="">{{$unconfirmed->count()}}</span>
                           @else
                              <span class="">0{{$unconfirmed->count()}}</span>
                           @endif
                           <span class="@if($adminTagName == 'unconfirmed') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-2 @if($adminTagName == 'categories') z-admin-active @endif">
                        <div wire:click="setActiveTag('categories', 'Catégories')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="mr-2 bi-list-check"></span>
                           <span class="w-100 m-0 d-none d-xl-inline">Catégories</span>
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
                           <span class="w-100 m-0  d-none d-xl-inline">Articles</span>
                           @if ($products->count() > 9)
                              <span class="">{{$products->count()}}</span>
                           @else
                              <span class="">0{{$products->count()}}</span>
                           @endif
                           <span class="@if($adminTagName == 'products') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-2">
                        <div class="d-flex flex-column w-100 cursor-pointer m-0 p-0 justify-content-around">
                           <span title="Détruire la clé de session d'administration" wire:click="destroyAdminSessionKey" class="cursor-pointer py-1 border rounded px-2">
                                 <span class="bi-trash"></span>
                                 <span class="d-none d-xxl-inline d-xl-inline d-md-inline d-lg-inline ml-1">Détruire la clé</span>
                           </span>
                           <span title="Regénérer une clé de session d'administration" wire:click="regenerateAdminKey" class="cursor-pointer py-1 my-1 border rounded px-2">
                                 <span class="bi-key"></span>
                                 <span class="d-none d-xxl-inline d-xl-inline d-md-inline d-lg-inline ml-1">Générer une clé</span>
                           </span>
                           <span title="Afficher la clé de session d'administration" wire:click="displayAdminSessionKey" class="cursor-pointer py-1 border rounded px-2">
                              <span class="bi-eye"></span>
                              <span class="d-none d-xxl-inline d-xl-inline d-md-inline d-lg-inline ml-1">Afficher la clé</span>
                           </span>
                           <span title="Acceder à mon profil" class="cursor-pointer border rounded my-1 py-1">
                              <a class=" w-100 text-white py-2 px-2" href="{{route('user-profil', ['id' => auth()->user()->id])}}">
                                 <span class="bi-person "></span>
                                 <span class="d-none d-xxl-inline d-xl-inline d-md-inline d-lg-inline ml-1">Mon profil</span>
                              </a>
                           </span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                  </div>
               </div>
               <div id="adminRightDashboard" class="col-10 border-left border-white bg-dark pb-5">
                  <span id="adminsToggler" class="adminsToggler position-relative d-flex">
                     <strong class="bi-chevron-right  d-none text-white" id="adminHider"></strong>
                     <strong class="bi-chevron-left text-white" id="adminShower"></strong>
                  </span>
                  <div class="w-100 mx-auto mt-2 border">
                    <div class="mx-auto d-flex w-100 justify-content-between">
                        <div class="col-6 bg-info">
                           <h6 class="text-center text-white text-uppercase mt-4">
                              {{$adminTagTitle}}
                           </h6>
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
                  @if($showSearch)
                  <div class="m-0 p-0 mx-auto w-100 d-flex justify-content-between">
                     <div class="input-group my-3 w-75">
                        <input type="text" wire:model="search" class="form-control bg-transparent border border-white text-white" placeholder="Taper un mot ou groupe de mots clé à rechercher dans {{$adminTagTitle}}" aria-label="Chercher" aria-describedby="basic-addon2">
                        <div class=" cursor-pointer bg-primary">
                            <span class="input-group-text bg-primary text-white" >
                                <span class="fa fa-search mx-2"></span>
                                <span>Rechercher</span>
                            </span>
                        </div>
                     </div>
                     <span wire:click="toogleSearchBanner" class="bi-x-octagon cursor-pointer p-2 float-end text-white"></span>
                  </div>
                  @else
                  <div class="py-2 mx-1">
                     <span wire:click="toogleSearchBanner" class="bi-search cursor-pointer p-2 float-start text-white"></span>
                  </div>
                  @endif
                  @include('livewire.components.admin.thelister', 
                        [
                           'tag' => $adminTagName, 
                           'users' => $users,
                           'unconfirmed' => $unconfirmed,
                           'categories' => $categories
                        ])
               </div>
            </div>
         </div>   
      </div>
   </div>
   
</div>
