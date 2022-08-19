<div class="m-0 p-0 w-100">
    <div class="z-justify-relative-top-80 w-100" style="width: 90%;" >
       <div class="w-100 border m-0 p-0">
          <div class="m-0 p-0 w-100"> 
             <div class="row w-100 m-0">
                <div class="col-2 m-0 text-capitalize border border-dark bg-dark p-0 text-white" style="min-height: 650px;">
                   <div class="d-fex flex-column w-100 mb-3">
                        <div class="m-0" id="OpenEditPhotoProfilModal" title="Doucle cliquer pour changer la photo de profil">
                           <div class="d-flex w-100 justify-content-between cursor-pointer m-0 p-0">
                            @if($user)
                                <img src="{{$user->__profil('250')}}" alt="mon profil">
                            @endif
                           </div>
                        </div>
                        <hr class="m-0 p-0 bg-white w-100">
                        <div class="m-0 py-2 px-2 z-bg-secondary" wire:click="setActiveTag('editing', 'Edition de profil')">
                           <div class="d-flex w-100 justify-content-between cursor-pointer m-0 p-0">
                                <span class="bi-tools "></span>
                                <h6 class="w-100 ml-3 d-none d-lg-inline d-xl-inline">Editer profil</h6>
                                <span class="bi-pen-fill"></span>
                           </div>
                        </div>
                        <hr class="m-0 p-0 bg-white w-100">
                        <div class="m-0 py-2 px-2 @if($activeTagName == 'panier') z-bg-orange @endif">
                           <div class="d-flex w-100 justify-content-between cursor-pointer m-0 p-0" wire:click="setActiveTag('panier', 'Panier')">
                                <span class="bi-cart-check "></span>
                                <h6 class="w-100 ml-3 d-none d-lg-inline d-xl-inline">Panier</h6>
                                @if ($carts_counter < 10)
                                    <span class="">(0{{ $carts_counter }})</span>
                                @else
                                    <span class="">({{ $carts_counter }})</span>
                                @endif
                                <span class="@if($activeTagName == 'panier') bi-chevron-down @else bi-chevron-right @endif "></span>
                           </div>
                        </div>
                        <hr class="m-0 p-0 bg-white w-100">
                        <div class="m-0 py-2 px-2 @if($activeTagName == 'demandes') z-bg-orange @endif">
                           <div class="d-flex justify-content-between w-100 cursor-pointer m-0 p-0" wire:click="setActiveTag('demandes', 'Les demandes envoyées')">
                                <span class="bi-person-plus"></span>
                                <h6 class="w-100 ml-3 d-none d-lg-inline d-xl-inline">Demandes envoyées</h6>
                                @if (count($demandes) < 10)
                                    <span class="">(0{{ count($demandes) }})</span>
                                @else
                                    <span class="">({{ count($demandes) }})</span>
                                @endif
                                <span class="@if($activeTagName == 'demandes') bi-chevron-down @else bi-chevron-right @endif "></span>
                           </div>
                        </div>
                        <hr class="m-0 p-0 bg-white w-100">
                        <div class="m-0 py-2 px-2 @if($activeTagName == 'followers') z-bg-orange @endif">
                            <div class="d-flex justify-content-between w-100 cursor-pointer m-0 p-0" wire:click="setActiveTag('followers', 'Les amis qui me suivent')">
                                <span class="bi-people-fill"></span>
                                <h6 class="w-100 ml-3 d-none d-lg-inline d-xl-inline">Followers</h6>
                                @if (count($myFollowers) < 10)
                                    <span class="">(0{{ count($myFollowers) }})</span>
                                @else
                                    <span class="">({{ count($myFollowers) }})</span>
                                @endif
                                <span class="@if($activeTagName == 'followers') bi-chevron-down @else bi-chevron-right @endif "></span>
                            </div>
                        </div>
                        <hr class="m-0 p-0 bg-white w-100">
                        <div class="m-0 py-2 px-2 @if($activeTagName == 'friends') z-bg-orange @endif">
                            <div class="d-flex justify-content-between w-100 cursor-pointer m-0 p-0" wire:click="setActiveTag('friends', 'Vos Amis')">
                                <span class="bi-person-heart"></span>
                                <h6 class="w-100 d-none d-lg-inline d-xl-inline ml-3">Mes Amis</h6>
                                @if (count($myFriends) < 10)
                                    <span class="">(0{{ count($myFriends) }})</span>
                                @else
                                    <span class="">({{ count($myFriends) }})</span>
                                @endif
                                <span class="@if($activeTagName == 'friends') bi-chevron-down @else bi-chevron-right @endif "></span>
                            </div>
                        </div>
                        <hr class="m-0 p-0 bg-white w-100">
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
                            </div>
                         </div>
                        <hr class="m-0 p-0 bg-white w-100">
                   </div>
                </div>
                <div class="col-10 border-left border-white bg-dark pb-3" >
                   <div class="w-100 mx-auto mt-2 border">
                    <div class="mx-auto d-flex w-100 justify-between">
                        <div class="mx-auto w-100 m-0 p-0 row">
                            <div class="mx-auto w-100">
                                <h4 class="text-white-50 text-center pt-3 pb-1">
                                    <span class="bi-person-badge mx-2"></span>
                                    Profil
                                </h4>
                                <hr class="m-0 p-0 text-white w-100">
                                <div class="d-flex flex-column w-100">
                                    <h6 class="text-white-50 px-3 pt-2 pb-1">
                                        <span class="bi-pen-fill mx-2"></span>
                                        {{ $user->name }}
                                    </h5>
                                    <h6 class="text-white-50 px-3 pb-1">
                                        <span class="bi-shield-check mx-2"></span>
                                        {{ $user->role }}
                                    </h6>
                                    <h6 class="text-white-50 px-3 pb-1">
                                        <span class="bi-people mx-2"></span>
                                        {{ count($user->getMyFriends()) }}
                                    </h6>
                                </div>
                            </div>
                        </div>
                        @auth
                           <div class="text-white-50 cursor-pointer text-center border-left p-3" data-toggle="modal" data-target="#addFriendsModal" data-dismiss="modal">
                              <span class="text-center">
                                 <span class="fa fa-user-plus fa-2x mt-3"></span>
                                 <span class="">Suivre des amis</span>
                              </span>
                           </div>
                        @endauth
                     </div>
                     </div>
                     <div class="border mt-3 p-3">
                        <div class="mx-auto justify-center d-flex w-100">
                           <h5 class=" text-white w-100">
                               <span class="float-left text-uppercase">{{$activeTagTitle}}</span>
                               <a class="float-right text-white btn bg-orange border-white border" href="{{route('carts.validation', ['user_id' => auth()->user()->id])}}">
                                   <span class="">Valider panier</span>
                                   <strong class="bi-cart-check text-white "></strong>
                               </a>
                           </h5>
                        </div>
                        <hr class="w-100 bg-white text-white mt-2">
                        <div class="px-2" style="height: 360px; overflow: auto">
                        @if($activeTagName == 'demandes')
                            <div class="mx-auto justify-center d-flex w-100">
                                @if(count($demandes) > 0)
                                    <div class="w-100 mx-auto m-0 p-0">
                                        @foreach($demandes as $key => $req)
                                            <div class="m-0 my-2 p-0 mx-auto border z-bg-hover-secondary d-flex justify-content-between w-100">
                                                <div class="w-25 m-0 p-0 border-right">
                                                    <img src="{{$req['user']->__profil('250')}}" alt="le profil de {{$req['user']->name}}">
                                                </div>
                                                <div class="m-0 p-0 w-75 p-2">
                                                    <h6 class="text-white">
                                                        {{$req['user']->name}}
                                                    </h6>
                                                    <h6 class="text-white-50">
                                                        {{count($req['user']->getMyFriends())}}
                                                        <span class="bi-people"></span>
                                                        <span class="text-warning ml-2 float-right">
                                                            @if($req['user']->role == 'admin')
                                                                <span class="fa fa-user-secret mx-1"></span>
                                                                <small>Admin</small>
                                                            @endif
                                                        </span>
                                                    </h6>
                                                    <div class="mt-3">
                                                        <small title="Supprimer la demande" wire:click="cancelRequestFriend({{$req['user']->id}})" class="btn-danger border border-white text-white px-3 py-2 rounded cursor-pointer mr-2">
                                                            <small class="fa bi-person-x-fill cursor-pointer mt-1"></small>
                                                            <small class="cursor-pointer">Annuler</small>
                                                        </small>
                                                        <small class="btn-primary border border-white text-white px-3 py-2 rounded cursor-pointer ">
                                                            <small class="fa bi-messenger cursor-pointer mt-1"></small>
                                                            <small class="cursor-pointer">Message</small>
                                                        </small>
                                                    </div>
                                                    <small class="float-right ">
                                                        <small class="bi-clock mx-1"></small>
                                                        Demande envoyée {{$req['request']->getDateAgoFormated()}}
                                                    </small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
                                        <span class="fa fa-warning text-warning fa-4x"></span>
                                        <h6 class="text-warning fa fa-3x">Ouups aucune demandes enregistées !!!</h6>
                                    </div>
                                @endif
                            </div>
                        @endif
                        @if($activeTagName == 'followers')
                            <div class="mx-auto justify-center d-flex flex-column w-100">
                                @if(count($myFollowers) > 0)
                                    @foreach($myFollowers as $u)
                                        <div class="m-0 my-2 p-0 mx-auto border z-bg-hover-secondary d-flex justify-content-between w-100">
                                            <div class="w-25 m-0 p-0 border-right">
                                                <img src="{{$u->__profil('250')}}" alt="le profil de {{$u->name}}">
                                            </div>
                                        <div class="m-0 p-0 w-75 p-2">
                                            <h6 class="text-white">
                                                {{$u->name}}
                                            </h6>
                                            <h6 class="text-white-50">
                                                {{count($u->getMyFriends())}}
                                                <span class="bi-people"></span>
                                                <span class="text-warning ml-2 float-right">
                                                    @if($u->role == 'admin')
                                                        <span class="fa fa-user-secret mx-1"></span>
                                                        <small>Admin</small>
                                                    @endif
                                                </span>
                                            </h6>
                                            <div class="mt-3">
                                                <small wire:click="requestManager({{$u->id}}, 'accepted')" class="btn-success border border-white text-dark px-3 py-2 rounded cursor-pointer mr-2">
                                                    <small class="fa bi-person-check cursor-pointer mt-1"></small>
                                                    <small class="cursor-pointer">Accepter</small>
                                                </small>
                                                <small wire:click="requestManager({{$u->id}}, 'refused')" class="btn-info border border-white text-white px-3 py-2 rounded cursor-pointer mr-2">
                                                    <small class="fa bi-person-x-fill cursor-pointer mt-1"></small>
                                                    <small class="cursor-pointer">Refuser</small>
                                                </small>
                                                <small class="btn-danger border border-white text-white px-3 py-2 rounded cursor-pointer mr-2">
                                                    <small class="fa bi-tools cursor-pointer mt-1"></small>
                                                    <small class="cursor-pointer">Signaler</small>
                                                </small>
                                                <small wire:click="openSingleChat({{$u->id}})" class="btn-primary border border-white text-white px-3 py-2 rounded cursor-pointer ">
                                                    <small class="fa bi-messenger cursor-pointer mt-1"></small>
                                                    <small class="cursor-pointer">Message</small>
                                                </small>
                                            </div>
                                                <small class="float-right ">
                                                    <small class="bi-clock mx-1"></small>
                                                    Suivi {{auth()->user()->friendlySince($u->id)->getDateAgoFormated()}}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
                                        <span class="fa fa-warning text-warning fa-4x"></span>
                                        <h6 class="text-warning fa fa-2x">Ouups vous n'avez aucun amis qui vous suit !!!</h6>
                                    </div>
                                @endif
                            </div>
                        @endif
                        @if($activeTagName == 'friends')
                            <div class="mx-auto justify-center d-flex flex-column w-100">
                                @if(count($myFriends) > 0)
                                    @foreach($myFriends as $u)
                                        <div class="m-0 my-2 p-0 mx-auto border z-bg-hover-secondary d-flex justify-content-between w-100">
                                            <div class="w-25 m-0 p-0 border-right">
                                                <img class="h-100" src="{{$u->__profil('250')}}" alt="le profil de {{$u->name}}">
                                            </div>
                                        <div class="m-0 p-0 w-75 p-2">
                                            <h6 class="text-white">
                                                {{$u->name}}
                                            </h6>
                                            <h6 class="text-white-50">
                                                {{count($u->getMyFriends())}}
                                                <span class="bi-people"></span>
                                                <span class="text-warning ml-2 float-right">
                                                    @if($u->role == 'admin')
                                                        <span class="fa fa-user-secret mx-1"></span>
                                                        <small>Admin</small>
                                                    @endif
                                                </span>
                                            </h6>
                                            <div class="mt-3">
                                                <small wire:click="unfollowThis({{$u->id}})" class="btn-info border border-white text-white px-3 py-2 rounded cursor-pointer mr-2">
                                                    <small class="fa bi-person-x-fill cursor-pointer mt-1"></small>
                                                    <small class="cursor-pointer d-none d-lg-inline d-xl-inline">Ne plus suivre</small>
                                                </small>
                                                <small class="btn-danger border border-white text-white px-3 py-2 rounded cursor-pointer mr-2">
                                                    <small class="fa bi-tools cursor-pointer mt-1"></small>
                                                    <small class="cursor-pointer d-none d-lg-inline d-xl-inline">Signaler</small>
                                                </small>
                                                <small wire:click="openSingleChat({{$u->id}})" class="btn-primary border border-white text-white px-3 py-2 rounded cursor-pointer ">
                                                    <small class="fa bi-messenger cursor-pointer mt-1"></small>
                                                    <small class="cursor-pointer d-none d-lg-inline d-xl-inline">Message</small>
                                                </small>
                                            </div>
                                                <small class="float-right mt-2">
                                                    <small class="bi-clock mx-1 mt-2"></small>
                                                    Suivi {{auth()->user()->friendlySince($u->id)->getDateAgoFormated()}}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
                                        <span class="fa fa-warning text-warning fa-4x"></span>
                                        <h6 class="text-warning fa fa-2x">Ouups vous n'avez aucun amis qui vous suit !!!</h6>
                                    </div>
                                @endif
                            </div>
                        @endif
                        @if($activeTagName == 'panier')
                            <div class="mx-auto justify-center text-white d-flex w-100">
                            @if($carts_counter > 0)
                                <div class="w-100 mx-auto my-1">
                                    @livewire('cart')
                                </div>
                            @else
                                <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
                                    <span class="fa fa-warning text-warning fa-4x"></span>
                                    <h6 class="text-warning fa fa-3x">Ouups votre panier est vide !!!</h6>
                                    <a href="{{route('products')}}" class="btn btn-primary my-2 text-white ml-2">
                                        <span class="bi-cart"></span>
                                        <span>
                                            Ajouter des articles
                                        </span>
                                    </a>
                                </div>
                            @endif
                           </div>
                        @endif
                        @if($activeTagName == 'editing')
                           @include('livewire.components.user.user-profil-editor')
                        @endif
                        </div>
                     </div>
                </div>
             </div>
          </div>   
       </div>
    </div>
    
 </div>
