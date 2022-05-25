<div class="m-0 p-0 w-100">
    <div class="z-justify-relative-top-80 w-100" style="width: 90%;" >
       <div class="w-100 border m-0 p-0">
          <div class="m-0 p-0 w-100"> 
             <div class="row w-100 m-0">
                <div class="col-2 m-0 text-capitalize border border-dark bg-dark p-0 text-white" style="min-height: 650px;">
                   <div class="d-fex flex-column w-100 mb-3">
                        <div class="m-0" id="OpenEditPhotoProfilModal" title="Doucle cliquer pour changer la photo de profil">
                           <div class="d-flex w-100 justify-content-between cursor-pointer m-0 p-0">
                            @if($user && $user->current_photo)
                                <img src="/storage/profilPhotos/{{$user->currentPhoto()}}" alt="mon profil">
                            @elseif($user && !$user->current_photo)
                                <img src="{{$user->currentPhoto()}}" alt="mon profil">
                            @endif
                           </div>
                        </div>
                        <hr class="m-0 p-0 bg-white w-100">
                        <div class="m-0 py-2 px-2 z-bg-secondary" wire:click="setActiveTag('editing', 'Edition de profil')">
                           <div class="d-flex w-100 justify-content-between cursor-pointer m-0 p-0">
                                <span class="bi-tools "></span>
                                <h5 class="w-100 m-0 ml-3 d-none d-lg-inline d-xl-inline">Editer profil</h5>
                                <span class="bi-pen-fill"></span>
                           </div>
                        </div>
                        <hr class="m-0 p-0 bg-white w-100">
                        <div class="m-0 py-2 px-2 @if($activeTagName == 'panier') bg-info @endif">
                           <div class="d-flex w-100 justify-content-between cursor-pointer m-0 p-0" wire:click="setActiveTag('panier', 'Panier')">
                                <span class="bi-cart-check "></span>
                                <h5 class="w-100 m-0 ml-3 d-none d-lg-inline d-xl-inline">Panier</h5>
                                @if (count($carts) < 10)
                                    <span class="">(0{{ count($carts) }})</span>
                                @else
                                    <span class="">({{ count($carts) }})</span>
                                @endif
                                <span class="@if($activeTagName == 'panier') bi-chevron-down @else bi-chevron-right @endif "></span>
                           </div>
                        </div>
                        <hr class="m-0 p-0 bg-white w-100">
                        <div class="m-0 py-2 px-2 @if($activeTagName == 'demandes') bg-info @endif">
                           <div class="d-flex justify-content-between w-100 cursor-pointer m-0 p-0" wire:click="setActiveTag('demandes', 'Les demandes envoyées')">
                                <span class="bi-person-plus"></span>
                                <h5 class="w-100 m-0 ml-3 d-none d-lg-inline d-xl-inline">Demandes envoyées</h5>
                                @if (count($demandes) < 10)
                                    <span class="">(0{{ count($demandes) }})</span>
                                @else
                                    <span class="">({{ count($demandes) }})</span>
                                @endif
                                <span class="@if($activeTagName == 'demandes') bi-chevron-down @else bi-chevron-right @endif "></span>
                           </div>
                        </div>
                        <hr class="m-0 p-0 bg-white w-100">
                        <div class="m-0 py-2 px-2 @if($activeTagName == 'followers') bg-info @endif"">
                            <div class="d-flex justify-content-between w-100 cursor-pointer m-0 p-0" wire:click="setActiveTag('followers', 'Les amis qui me suivent')">
                                <span class="bi-people-fill"></span>
                                <h5 class="w-100 m-0 ml-3 d-none d-lg-inline d-xl-inline">Followers</h5>
                                @if (count($myFollowers) < 10)
                                    <span class="">(0{{ count($myFollowers) }})</span>
                                @else
                                    <span class="">({{ count($myFollowers) }})</span>
                                @endif
                                <span class="@if($activeTagName == 'followers') bi-chevron-down @else bi-chevron-right @endif "></span>
                            </div>
                        </div>
                        <hr class="m-0 p-0 bg-white w-100">
                        <div class="m-0 py-2 px-2 @if($activeTagName == 'friends') bg-info @endif">
                            <div class="d-flex justify-content-between w-100 cursor-pointer m-0 p-0" wire:click="setActiveTag('friends', 'Vos Amis')">
                                <span class="bi-person-heart"></span>
                                <h5 class="w-100 m-0 d-none d-lg-inline d-xl-inline ml-3">Mes Amis</h5>
                                @if (count($myFriends) < 10)
                                    <span class="">(0{{ count($myFriends) }})</span>
                                @else
                                    <span class="">({{ count($myFriends) }})</span>
                                @endif
                                <span class="@if($activeTagName == 'friends') bi-chevron-down @else bi-chevron-right @endif "></span>
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
                                <hr class="m-0 p-0 bg-white w-100">
                                <div class="d-flex flex-column w-100">
                                    <h5 class="text-white-50 px-3 pt-2 pb-1">
                                        <span class="bi-pen-fill mx-2"></span>
                                        {{ $user->name }}
                                    </h5>
                                    <h5 class="text-white-50 px-3 pb-1">
                                        <span class="bi-shield-check mx-2"></span>
                                        {{ $user->role }}
                                    </h5>
                                    <h5 class="text-white-50 px-3 pb-1">
                                        <span class="bi-people mx-2"></span>
                                        {{ count($user->getMyFriends()) }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                        @auth
                           <div class="text-white-50 cursor-pointer border-left p-3" data-toggle="modal" data-target="#addFriendsModal" data-dismiss="modal">
                              <span class="">
                                 <span class="fa fa-user-plus fa-2x mt-3"></span>
                                 <span class="">Suivre des amis</span>
                              </span>
                           </div>
                        @endauth
                     </div>
                     </div>
                     <div class="border mt-3 p-3">
                        <div class="mx-auto justify-center d-flex w-75">
                           <h4 class="text-uppercase text-white">{{$activeTagTitle}}</h4>
                        </div>
                        <hr class="w-100 bg-white mt-2">
                        <div class="px-2" style="height: 360px; overflow: auto">
                        @if($activeTagName == 'demandes')
                            <div class="mx-auto justify-center d-flex w-100">
                                @if(count($demandes) > 0)
                                    <div class="w-100 mx-auto m-0 p-0">
                                        @foreach($demandes as $key => $req)
                                            <div class="m-0 my-2 p-0 mx-auto border z-bg-hover-secondary d-flex justify-content-between w-100">
                                                <div class="w-25 m-0 p-0 border-right">
                                                    @if($req['user']->current_photo)
                                                        <img src="/storage/profilPhotos/{{$req['user']->currentPhoto()}}" alt="le profil de {{$req['user']->name}}">
                                                    @else
                                                    <img src="{{$req['user']->currentPhoto()}}" alt="le profil de {{$req['user']->name}}">
                                                    @endif
                                                </div>
                                                <div class="m-0 p-0 w-75 p-2">
                                                    <h4 class="text-white">
                                                        {{$req['user']->name}}
                                                    </h4>
                                                    <h5 class="text-white-50">
                                                        {{count($req['user']->getMyFriends())}}
                                                        <span class="bi-people"></span>
                                                        <span class="text-warning ml-2 float-right">
                                                            @if($req['user']->role == 'admin')
                                                                <span class="fa fa-user-secret mx-1"></span>
                                                                <small>Admin</small>
                                                            @endif
                                                        </span>
                                                    </h5>
                                                    <div class="mt-3">
                                                        <small wire:click="requestManager({{$req['user']->id}}, 'accepted')" class="text-success d-none w-50">
                                                            <small class="fa fa-check cursor-pointer mt-1"></small>
                                                            <small class="text-success cursor-pointer">Accepter</small>
                                                        </small>
                                                        <small wire:click="cancelRequestFriend({{$req['user']->id}})" class="btn-danger border border-white text-white px-3 py-2 rounded cursor-pointer mr-2">
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
                                        <h4 class="text-warning fa fa-3x">Ouups aucune demandes enregistées !!!</h4>
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
                                                @if($u->current_photo)
                                                    <img src="/storage/profilPhotos/{{$u->currentPhoto()}}" alt="le profil de {{$u->name}}">
                                                @else
                                                <img src="{{$u->currentPhoto()}}" alt="le profil de {{$u->name}}">
                                                @endif
                                            </div>
                                        <div class="m-0 p-0 w-75 p-2">
                                            <h4 class="text-white">
                                                {{$u->name}}
                                            </h4>
                                            <h5 class="text-white-50">
                                                {{count($u->getMyFriends())}}
                                                <span class="bi-people"></span>
                                                <span class="text-warning ml-2 float-right">
                                                    @if($u->role == 'admin')
                                                        <span class="fa fa-user-secret mx-1"></span>
                                                        <small>Admin</small>
                                                    @endif
                                                </span>
                                            </h5>
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
                                        <h4 class="text-warning fa fa-2x">Ouups vous n'avez aucun amis qui vous suit !!!</h4>
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
                                                @if($u->current_photo)
                                                    <img src="/storage/profilPhotos/{{$u->currentPhoto()}}" alt="le profil de {{$u->name}}">
                                                @else
                                                <img src="{{$u->currentPhoto()}}" alt="le profil de {{$u->name}}">
                                                @endif
                                            </div>
                                        <div class="m-0 p-0 w-75 p-2">
                                            <h4 class="text-white">
                                                {{$u->name}}
                                            </h4>
                                            <h5 class="text-white-50">
                                                {{count($u->getMyFriends())}}
                                                <span class="bi-people"></span>
                                                <span class="text-warning ml-2 float-right">
                                                    @if($u->role == 'admin')
                                                        <span class="fa fa-user-secret mx-1"></span>
                                                        <small>Admin</small>
                                                    @endif
                                                </span>
                                            </h5>
                                            <div class="mt-3">
                                                <small wire:click="unfollowThis({{$u->id}})" class="btn-info border border-white text-white px-3 py-2 rounded cursor-pointer mr-2">
                                                    <small class="fa bi-person-x-fill cursor-pointer mt-1"></small>
                                                    <small class="cursor-pointer">Ne plus suivre</small>
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
                                        <h4 class="text-warning fa fa-2x">Ouups vous n'avez aucun amis qui vous suit !!!</h4>
                                    </div>
                                @endif
                            </div>
                        @endif
                        @if($activeTagName == 'panier')
                            <div class="mx-auto justify-center text-white d-flex w-100">
                            @if(count($carts) > 0)
                                <div class="w-100 mx-auto my-1">
                                    @livewire('cart')
                                </div>
                            @else
                                <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
                                    <span class="fa fa-warning text-warning fa-4x"></span>
                                    <h4 class="text-warning fa fa-3x">Ouups votre panier est vide !!!</h4>
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
                            <div class="mx-auto justify-center text-white d-flex w-100">
                                <div class="d-flex mx-100 text-center p-3 mt-4 w-100">
                                    <div class="w-100">
                                        <div class="w-100">
                                            @if($edit_name)
                                                <form wire:submit.prevent="renamed" autocomplete="off" class="my-1 d-flex p-2 cursor-pointer w-100 shadow">
                                                    <div class="d-flex justify-between zw-80">
                                                        <div class="w-100">
                                                            <label class="z-text-cyan float-left text-left" for="my_name">Veuillez saisir votre nouveau nom</label>
                                                            <input type="text" placeholder="Saisissez votre nouveau nom..." style="font-family: cursive !important;" wire:model="name" class="form-control py-3 border zw-95 text-white bg-transparent @error('name') border-danger text-danger @enderror" name="my_name" id="my_name" >
                                                            @error('name')
                                                                <span class="text-danger mx-2 mt-1 float-left text-left">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="d-inline-block float-right text-right zw-20">
                                                        <span wire:click="editMyName" title="Fermer la fenêtre d'édition" class="fa fa-close cursor-pointer text-danger p-2 border border-danger"></span>
                                                    </div>
                                                </form>
                                            @else
                                                <h5 class="my-1 d-flex p-2 cursor-pointer p-2">
                                                    <span class="text-bold text-white-50 mt-2">Nom : </span>
                                                    <span class="mx-2 mt-2">{{$user->name}}</span>
                                                    <span class="bi-pen mx-2 ml-5 p-2 float-end" wire:click="editMyName"></span>
                                                </h5>
                                                <hr class="bg-secondary">
                                            @endif
                                        </div>
                                        <div class="w-100">
                                            @if($edit_email)
                                                @if(!$confirm_email_field)
                                                <form wire:submit.prevent="changeEmail" autocomplete="off" class="my-1 d-flex p-2 cursor-pointer w-100 shadow">
                                                    <div class="d-flex justify-between zw-80">
                                                        <div class="w-100">
                                                            <label class="z-text-cyan float-left text-left" for="my_email">Veuillez saisir votre nouvelle adresse email</label>
                                                            <input type="text" placeholder="Saisissez votre nouvelle adresse mail..." style="font-family: cursive !important;" wire:model="email" class="form-control py-3 border zw-95 text-white bg-transparent @error('email') border-danger text-danger @enderror" name="my_email" id="my_email" >
                                                            @error('email')
                                                                <span class="text-danger mx-2 mt-1 float-left text-left">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="d-inline-block float-right text-right zw-20">
                                                        <span wire:click="editMyEmail" title="Fermer la fenêtre d'édition" class="fa fa-close cursor-pointer text-danger p-2 border border-danger"></span>
                                                    </div>
                                                </form>
                                                @else
                                                <form wire:submit.prevent="confirmedEmail" autocomplete="off" class="my-1 d-flex p-2 cursor-pointer w-100 shadow">
                                                    <div class="d-flex justify-between zw-80">
                                                        <div class="w-100">
                                                            <label class="z-text-cyan float-left text-left" for="code">Veuillez saisir le code qui vous a été envoyé sur {{$email}}</label>
                                                            <div class="d-flex justify-content-between w-100">
                                                                <input type="text" placeholder="Saisissez le code qui vous a été envoyé..." style="font-family: cursive !important;" wire:model="code" class="form-control py-3 border w-75 text-white bg-transparent @error('code') border-danger text-danger @enderror" name="code" id="code" >
                                                                <span class="btn-primary w-auto px-2 py-2 border border-white">Je n'ai pas reçu de courriel</span>
                                                            </div>
                                                            @error('code')
                                                                <span class="text-danger mx-2 mt-1 float-left text-left">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="d-inline-block float-right text-right zw-20">
                                                        <span wire:click="editMyEmail" title="Annuler l'édition de l'adresse mail" class="fa fa-close cursor-pointer text-danger p-2 border border-danger"></span>
                                                    </div>
                                                </form>
                                                @endif
                                            @else
                                                <h5 class="my-1 d-flex p-2 cursor-pointer p-2">
                                                    <span class="text-bold text-white-50 mt-2">Adresse mail : </span>
                                                    <span class="mx-2 mt-2">{{$user->email}}</span>
                                                    <span class="bi-pen mx-2 ml-5 p-2 float-end" wire:click="editMyEmail"></span>
                                                </h5>
                                                <hr class="bg-secondary">
                                            @endif
                                        </div>

                                        <div class="w-100">
                                            @if($edit_password)
                                                @if($psw_step_1)
                                                <form wire:submit.prevent="verifiedOldPassword" autocomplete="off" class="my-1 d-flex p-2 cursor-pointer w-100 shadow">
                                                    <div class="d-flex justify-between zw-90">
                                                        <div class="w-100">
                                                            <label class="z-text-cyan float-left text-left" for="old_pwd">Veuillez saisir votre ancien mot de passe</label>
                                                            <div class="d-flex w-100 justify-center">
                                                                <div class="row w-100">
                                                                    @if($show_old_pwd)
                                                                        <input type="text" placeholder="Taper l'ancien mot de passe ..." style="font-family: cursive !important;" wire:model="old_pwd" class="col-12 col-lg-7 col-xl-7 mr-lg-2 mr-xl-2 form-control py-3 border zw-60 text-white bg-transparent @error('old_pwd') border-danger text-danger @enderror" name="old_pwd" id="old_pwd" >
                                                                    @else
                                                                        <input type="password" placeholder="Taper l'ancien mot de passe ..." style="font-family: cursive !important;" wire:model="old_pwd" class="col-12 col-lg-7 col-xl-7 mr-lg-2 mr-xl-2 form-control py-3 border zw-60 text-white bg-transparent @error('old_pwd') border-danger text-danger @enderror" name="old_pwd" id="old_pwd" >
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            @error('old_pwd')
                                                                <span class="text-danger mx-2 mt-1 d-block mt-1 mb-2 float-left text-left">{{$message}}</span>
                                                            @enderror
                                                            <div class="w-100 mt-3">
                                                                <button wire:click="verifiedOldPassword" type="button" class="btn-primary mt-2 rounded text-center w-75 px-4 py-2 border border-white">Confirmer</button>
                                                                <strong class="text-center text-warning d-block mt-2 cursor-pointer">
                                                                    Mot de passe oublié ?
                                                                </strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-inline-block float-right text-right zw-10">
                                                        <span wire:click="cancelPasswordEdit" title="Fermer la fenêtre d'édition" class="fa fa-close cursor-pointer text-danger p-2 border border-danger"></span>
                                                    </div>
                                                </form>
                                                @elseif($psw_step_2)
                                                <form wire:submit.prevent="changePassword" autocomplete="off" class="my-1 d-flex p-2 cursor-pointer w-100 shadow">
                                                    <div class="d-flex justify-between zw-85">
                                                        <div class="w-100">
                                                            <div class="w-100">
                                                                <label class="z-text-cyan float-left text-left" for="my_password">Veuillez saisir votre nouveau mot de passe</label>
                                                                <div class="d-flex justify-content-between w-100">
                                                                    <input type="@if($show_new_pwd) text @else password @endif" placeholder="Saisissez votre nouveau mot de passe ..." style="font-family: cursive !important;" wire:model="new_password" class="form-control py-3 border zw-65 text-white bg-transparent @error('new_password') border-danger text-danger @enderror" name="new_password" id="new_password" >
                                                                </div>
                                                                @error('new_password')
                                                                    <span class="text-danger mx-2 mt-1 mb-2 d-block w-100 float-left text-left">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="w-100 mt-2">
                                                                <label class="z-text-cyan d-block w-100 float-left text-left" for="pwd_confirmation">Confirmer votre mot de passe</label>
                                                                <div class="d-flex justify-content-between w-100">
                                                                    <input type="@if($show_new_pwd) text @else password @endif" placeholder="Confirmer votre mot de passe..." style="font-family: cursive !important;" wire:model="new_password_confirmation" class="form-control py-3 border zw-65 text-white bg-transparent @error('new_password_confirmation') border-danger text-danger @enderror" name="new_password_confirmation" id="pwd_confirmation" >
                                                                    <span class="d-flex justify-content-between zw-30">
                                                                        <span class="d-flex justify-between">
                                                                            <label class="z-text-cyan" for="show_new_password">Afficher mot de passe</label>
                                                                            <input class="form-check-input" wire:model="show_new_pwd" type="checkbox">
                                                                        </span>
                                                                        <button wire:click="changePassword" type="button" class="btn-primary w-auto px-4 py-2 border border-white">Confirmer</button>
                                                                    </span>
                                                                </div>
                                                                @error('new_password_confirmation')
                                                                    <span class="text-danger mx-2 mt-1 float-left text-left">{{$message}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-inline-block float-right text-right zw-20">
                                                        <span wire:click="cancelPasswordEdit" title="Annuler l'édition du mot de passe" class="fa fa-close cursor-pointer text-danger p-2 border border-danger"></span>
                                                    </div>
                                                </form>
                                                @endif
                                            @else
                                                <h5 class="my-1 d-flex p-2 cursor-pointer p-2">
                                                    <span class="text-bold text-white-50 mt-2">Sécurité : </span>
                                                    <span class="mx-2 mt-2">Changer mon mot de passe</span>
                                                    <span class="bi-pen mx-2 ml-5 p-2 float-end" wire:click="editMyPassword"></span>
                                                </h5>
                                                <hr class="bg-secondary">
                                            @endif
                                        </div>
                                    </div>
                                </div>
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
