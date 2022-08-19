<div class="m-0 p-0 w-100" x-data="{ selector: false }">
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
                        <div class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
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
                           @if ($comments->total() > 9)
                              <span class="">{{$comments->total()}}</span>
                           @else
                              <span class="">0{{$comments->total()}}</span>
                           @endif
                           <span class="@if($adminTagName == 'comments') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 @if($adminTagName == 'admins') z-admin-active @endif px-2">
                        <div wire:click="setActiveTag('admins', 'Administrateurs')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="mr-2 bi-person-workspace"></span>
                           <span class="w-100 m-0 d-none d-xl-inline">Administrateurs</span>
                           @if ($admins->total() > 9)
                              <span class="">{{$admins->total()}}</span>
                           @else
                              <span class="">0{{$admins->total()}}</span>
                           @endif
                           <span class="@if($adminTagName == 'admins') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-2 @if($adminTagName == 'users') z-admin-active @endif">
                        <div wire:click="setActiveTag('users', 'Utilisateurs')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="mr-2 bi-people-fill"></span>
                           <span class="w-100 m-0 d-none d-xl-inline">Utilisateurs</span>
                           @if ($users->total() > 9)
                              <span class="">{{$users->total()}}</span>
                           @else
                              <span class="">0{{$users->total()}}</span>
                           @endif
                           <span class="@if($adminTagName == 'users') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-2 @if($adminTagName == 'unconfirmed') z-admin-active @endif">
                        <div wire:click="setActiveTag('unconfirmed', 'Email non confirmé')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="mr-2 bi-person-x-fill  "></span>
                           <span class="w-100 m-0 d-none d-xl-inline">Email non confirmé</span>
                           @if ($unconfirmed->total() > 9)
                              <span class="">{{$unconfirmed->total()}}</span>
                           @else
                              <span class="">0{{$unconfirmed->total()}}</span>
                           @endif
                           <span class="@if($adminTagName == 'unconfirmed') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-2 @if($adminTagName == 'categories') z-admin-active @endif">
                        <div wire:click="setActiveTag('categories', 'Catégories')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="mr-2 bi-list-check"></span>
                           <span class="w-100 m-0 d-none d-xl-inline">Catégories</span>
                           @if ($categories->total() > 9)
                              <span class="">{{$categories->total()}}</span>
                           @else
                              <span class="">0{{$categories->total()}}</span>
                           @endif
                           <span class="@if($adminTagName == 'categories') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 @if($adminTagName == 'products') z-admin-active @endif px-2">
                        <div wire:click="setActiveTag('products', 'Articles')" class="d-flex w-100 cursor-pointer m-0 p-0 justify-content-between">
                           <span class="mr-2 bi-cart-check"></span>
                           <span class="w-100 m-0  d-none d-xl-inline">Articles</span>
                           @if ($products->total() > 9)
                              <span class="">{{$products->total()}}</span>
                           @else
                              <span class="">0{{$products->total()}}</span>
                           @endif
                           <span class="@if($adminTagName == 'products') bi-chevron-down @else bi-chevron-right @endif "></span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-2">
                        @if(Auth::user()->hasAdminAdvancedKey())
                        <x-dropdown align="right"  width="80" class=" m-0 p-0 bg-secondary">
                            <x-slot name="trigger">
                                <x-responsive-nav-link class="text-white cursor-pointer m-0 p-0">
                                    <span class="bi-tools"></span>
                                    Gestion
                                </x-responsive-nav-link>
                            </x-slot>
                            <x-slot name="content" :class="'text-left p-0 m-0 text-dark'">
                                <x-dropdown-link title="Actions sur les articles" wire:click="advancedRequests('-App-Models-Product')" class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold" href="#">
                                       <span class="bi-cart-dash mr-1"></span>
                                       <span>Gérer les articles</span>
                                </x-dropdown-link>
                                <x-dropdown-link title="Actions sur les catégories" wire:click="advancedRequests('-App-Models-Category')" class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold" href="#">
                                    <span class="bi-tags mr-1"></span>
                                    <span>Gérer les Catégories</span>
                                </x-dropdown-link>
                                <x-dropdown-link title="Actions sur les utilisateurs" wire:click="advancedRequests('-App-Models-User')" class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold" href="#">
                                    <span class="bi-people mr-1"></span>
                                    <span>Gérer les Utilisateurs</span>
                                </x-dropdown-link>
                                <x-dropdown-link title="Actions sur les utilisateurs" wire:click="advancedRequests('-App-Models-User')" class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold" href="#">
                                    <span class="fa fa-user-secret mr-1"></span>
                                    <span>Gérer les admins</span>
                                </x-dropdown-link>
                                <x-dropdown-link title="Actions sur les commentaires" wire:click="advancedRequests('-App-Models-Comment')" class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold" href="#">
                                    <span class="fa fa-comment mr-1"></span>
                                    <span>Gérer les commentaires</span>
                                </x-dropdown-link>
                                <x-dropdown-link title="Actions sur les clées" wire:click="advancedRequests('-App-Models-UserAdminKey')" class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold" href="#">
                                    <span class="bi-key mr-1"></span>
                                    <span>Gérer toutes clées</span>
                                </x-dropdown-link>
                                <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold" href="#">
                                    <span class="bi-table mr-1"></span>
                                    <span>Gérer toutes les tables</span>
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                        @endif
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-2">
                        <div class="d-flex flex-column w-100 cursor-pointer m-0 p-0 justify-content-around">
                           @if(!Auth::user()->hasAdminAdvancedKey())
                            <span title="Enclancher une procédure avancée irreversible. Neccessite une clé de confirmation" wire:click="generateAdvancedRequestsKey" class="cursor-pointer py-1 border my-1 rounded px-2">
                                <span class="bi-tools"></span>
                                <span class="d-none d-xxl-inline d-xl-inline d-md-inline d-lg-inline ml-1">Req. avancées</span>
                           </span>
                           @endif
                           <span x-show="!selector" title="Activer la sélection multiple" class="cursor-pointer py-1 my-1 border rounded px-2" x-on:click="selector = true;">
                              <span class="bi-check-all"></span>
                              <span class="d-none d-xxl-inline d-xl-inline d-md-inline d-lg-inline ml-1">Selectionner</span>
                           </span>
                           <span x-show="selector" title="Annuler la sélection multiple" class="cursor-pointer py-1 my-1 border rounded px-2 bg-secondary-light-opac" x-on:click="selector = false;">
                              <span class="bi-check-all"></span>
                              <span class="d-none d-xxl-inline d-xl-inline d-md-inline d-lg-inline ml-1">Selectionner</span>
                           </span>
                           <span title="Regénérer une clé de session d'administration" wire:click="regenerateAdminKey" class="cursor-pointer py-1 my-1 border rounded px-2">
                              <span class="bi-key"></span>
                              <span class="d-none d-xxl-inline d-xl-inline d-md-inline d-lg-inline ml-1">Générer une clé</span>
                           </span>
                           <span title="Afficher la clé de session d'administration" wire:click="displayAdminSessionKey" class="cursor-pointer py-1 border rounded px-2">
                              <span class="bi-eye"></span>
                              <span class="d-none d-xxl-inline d-xl-inline d-md-inline d-lg-inline ml-1">Afficher la clé</span>
                           </span>
                           <span title="Détruire la clé de session d'administration" wire:click="destroyAdminSessionKey" class="cursor-pointer py-1 my-1 border rounded px-2">
                              <span class="bi-trash"></span>
                              <span class="d-none d-xxl-inline d-xl-inline d-md-inline d-lg-inline ml-1">Détruire la clé</span>
                           </span>
                           <span title="Acceder à mon profil" class="cursor-pointer border rounded mb-1 py-1">
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
                  <div x-show="!selector" x-transition class="w-100 mx-auto mt-2 border">
                    <div class="mx-auto d-flex w-100 justify-content-between">
                        <div class="col-6 bg-info">
                           <h6 class="text-center text-white text-uppercase mt-4">
                              {{$adminTagTitle}}
                           </h6>
                        </div>
                        <div class="col-3 p-0 text-white flex-column border-left d-flex justify-content-between">
                           <span wire:click="resetAdminTrashedData" class="py-2 px-2 cursor-pointer @if(!$adminTrashedData) bg-info @endif">
                              <span class="bi-minecart"></span>
                              <span>Actifs</span>
                           </span>
                           <hr class="bg-white p-0 m-0">
                           <span wire:click="setAdminTrashedData" class="py-2 px-2 cursor-pointer @if($adminTrashedData) bg-info @endif">
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
                        ])
               </div>
            </div>
         </div>   
      </div>
   </div>
   @livewire('user-cart-manager')
   @livewire('advanced-requests-modal')
</div>
