<div class="m-0 p-0 w-100">
    <div class="z-justify-relative-top-80 w-100" style="width: 90%;">
       <div class="w-100 border m-0 p-0">
          <div class="m-0 p-0 w-100">
             <div class="row w-100 m-0">
                <div class="col-3 m-0 text-capitalize border border-dark bg-dark p-0 text-white" style="min-height: 650px;">
                   <div class="d-fex flex-column w-100 mb-3">
                        <div class="m-0 py-2 px-4 @if($activeTagName == 'demandes') bg-info @endif">
                           <div class="d-flex w-100 cursor-pointer m-0 p-0" wire:click="setActiveTag('demandes', 'Les demandes')">
                              <span class="fa fa-2x fa-inbox"></span>
                              <h5 class="w-100 m-0 mt-1 ml-3">Mes demandes d'ajout</h5>
                              <span class="badge badge-danger badge-pill pt-2" wire:poll>{{count($demandes)}}</span>
                           </div>
                        </div>
                        <hr class="m-0 p-0 bg-white w-100">
                        <div class="m-0 py-2 px-4 @if($activeTagName == 'followers') bg-info @endif"">
                           <div class="d-flex w-100 cursor-pointer m-0 p-0" wire:click="setActiveTag('followers', 'Les amis qui me suivent')">
                              <span class="fa fa-2x fa-users"></span>
                              <h5 class="w-100 m-0 mt-1 ml-3">Mes followers</h5>
                              <span class="fa fa-2x">255</span>
                           </div>
                        </div>
                        <hr class="m-0 p-0 bg-white w-100">
                   </div>
                </div>
                <div class="col-9 border-left border-white bg-dark pb-3">
                   <div class="w-100 mx-auto mt-2 border">
                    <div class="mx-auto d-flex w-100 justify-between">
                        <div class="mx-auto w-100 m-0 p-0 row">
                            <div id="OpenEditPhotoProfilModal" class="col-4 m-0 p-0 border-right" title="Doucle cliquer pour changer la photo de profil"  >
                                @if($user->current_photo)
                                    <img src="/storage/profilPhotos/{{$user->currentPhoto()}}" alt="mon profil">
                                @else
                                 <img src="{{$user->currentPhoto()}}" alt="mon profil">
                                  @endif
                            </div>
                            <div>
                                <div class="d-flex flex-column w-100">
                                    <h4 class="text-white-50 px-3 pt-3 pb-1">{{ $user->name }}</h4>
                                    <small class="text-warning float-right text-right d-inline-block"> <span class="fa fa-user-secret"></span> {{ $user->role }}</small>
                                </div>

                                <hr class="bg-white ">
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
                           <h4 class="text-capitalize text-white">{{$activeTagTitle}}</h4>
                        </div>
                        <hr class="w-100 bg-white mt-2">
                        @if($activeTagName == 'demandes')
                           <div class="mx-auto justify-center d-flex w-100">
                              @if(count($demandes) > 0)
                                 @foreach($demandes as $key => $req)
                                    <table class="table text-white table-striped mt-2 w-100 mx-auto border">
                                       <thead>
                                          <th>#No</th>
                                          <th>Nom</th>
                                          <th>Date</th>
                                          <th>Actions</th>
                                       </thead>
                                       <tbody>
                                          <tr>
                                             <td class="py-2">{{$key + 1}}</td>
                                             <td class="py-2">{{$req['user']->name}}</td>
                                             <td class="py-2">{{$req['request']->created_at}}</td>
                                             <td class="py-2 d-flex justify-content-between">
                                                <span wire:click="requestManager({{$req['user']->id}}, 'accepted')" class="text-success d-flex w-50">
                                                   <span class="fa fa-check cursor-pointer mt-1"></span>
                                                   <span class="text-success cursor-pointer">Accepter</span>
                                                </span>
                                                <span wire:click="requestManager({{$req['user']->id}}, 'refused')" class="text-danger d-flex w-50">
                                                   <span class="fa fa-close cursor-pointer mt-1"></span>
                                                   <span class="cursor-pointer">Accepter</span>
                                                </span>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 @endforeach
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
                                    <div class="m-0 py-2 px-4 d-flex justify-between cursor-pointer w-100">
                                       <div class="d-flex justify-content-start w-75 m-0 p-0">
                                          <div class="">
                                             @if($u->current_photo)
                                                   <a class="d-flex text-white">
                                                   <img width="30" class="border rounded-circle" src="/storage/profilPhotos/{{$u->currentPhoto()}}" alt="mon profil">
                                                   <span class="mx-2">{{$u->name}}</span>
                                                   @if($u->role == 'admin')
                                                      <span class="fa fa-user-secret mt-1 text-white-50 float-right"></span>
                                                   @endif
                                                   </a>
                                             @else
                                                   <a class="d-flex text-white">
                                                      <img width="30" class="border rounded-circle" src="{{$u->currentPhoto()}}" alt="mon profil">
                                                      <span class="mx-2">{{$u->name}}</span>
                                                      @if($u->role == 'admin')
                                                      <span class="fa fa-user-secret text-white-50 mt-1 float-right"></span>
                                                      @endif
                                                   </a>
                                             @endif
                                          </div>
                                          <span>
                                             @isOnline($u)
                                             <span class="text-success mx-1">Connecté</span><span class="fa fa-circle text-success"></span>
                                             @endisNotOnline
                                             @if(count(Auth::user()->getUnreadMessagesOf($u->id)) > 0)
                                             <span class="">
                                                   (
                                                      <span class="text-danger i"> {{ count(Auth::user()->getUnreadMessagesOf($u->id)) }} </span>
                                                      <small> non lus </small>
                                                   )
                                             </span>
                                             @endif
                                          <span/>
                                       </div>
                                       @if(!Auth::user()->iFollowingButNotYet($u) && !Auth::user()->iFollowThis($u))
                                       <div wire:click="followThisUser({{$u->id}})" class="d-flex justify-between w-25">
                                          <span class="btn-primary px-4 border cursor-pointer">
                                             <span class="fa fa-user-plus"></span>
                                             <span>suivre</span>
                                          </span>
                                       </div>
                                       @elseif(Auth::user()->iFollowingButNotYet($u))
                                       <div class="d-flex justify-between w-25">
                                          <span class="btn-info px-4 border py-y cursor-pointer">
                                             <span class="fa fa-send"></span>
                                             <span class="text-white-50">En attente...</span>
                                          </span>
                                       </div>
                                       <div wire:click="cancelRequestFriend({{$u->id}})" class="d-flex justify-between w-25">
                                          <span class="btn-danger px-4 border py-y cursor-pointer">
                                             <span class="fa fa-close"></span>
                                             <span class="text-white-50">Annuler...</span>
                                          </span>
                                       </div>
                                       @else
                                          <div class="d-flex justify-between w-25">
                                             <span class="btn-primary px-4 border cursor-pointer">
                                                <span class="fa fa-wechat"></span>
                                                <span>Chater</span>
                                             </span>
                                          </div>
                                          <div wire:click="cancelRequestFriend({{$u->id}})" class="d-flex justify-between w-25">
                                             <span class="btn-danger px-4 border py-y cursor-pointer">
                                                <span class="fa fa-close"></span>
                                                <span class="text-white-50">Retirer...</span>
                                             </span>
                                          </div>
                                       @endif
                                 </div>
                                 <hr class="m-0 p-0 w-100 bg-white">
                                 @endforeach
                              @else
                                 <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
                                    <span class="fa fa-warning text-warning fa-4x"></span>
                                    <h4 class="text-warning fa fa-2x">Ouups vous n'avez aucun amis qui vous suit !!!</h4>
                                 </div>
                              @endif
                           </div>
                        @endif
                     </div>
                </div>
             </div>
          </div>   
       </div>
    </div>
    
 </div>
