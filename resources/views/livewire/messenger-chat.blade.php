<div class="m-0 p-0 w-100">
    <div class="z-justify-relative-top-80 w-100" style="width: 90%;">
       <div class="w-100 border m-0 p-0">
          <div class="m-0 p-0 w-100">
             <div class="row w-100 m-0 bg-dark pb-3">
                <div class="col-3 m-0 text-capitalize border border-dark bg-dark p-0 text-white" style="max-height: 650px; overflow: auto;">
                   <div class="d-fex flex-column w-100 mb-3">
                        <div class="m-0 py-2 px-4 bg-secondary">
                            <div class="d-flex w-100 cursor-pointer m-0 p-0" wire:poll="getConnectedUsers">
                                <span class="fa fa-user-secret fa-2x"></span>
                                <h5 class="w-100 m-0 mt-2 ml-3">
                                    <span class="">{{ $allUsers }} </span>
                                    Utilisateurs
                                    <span class="float-right">
                                        (
                                            <span class="">{{ $connectedUsers }} </span>
                                            <span class="fa fa-circle text-success"></span>
                                        )
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <hr class="m-0 p-0 w-100 bg-white">
                        @foreach($users as $u)
                            @if(auth()->user()->isMyFriend($u->id) || auth()->user()->id == 1 || auth()->user()->role == 'admin')
                                <div class="m-0 py-2 px-4 cursor-pointer secondary-hover-no-transform @if(isset($receiver) && $receiver->id == $u->id) bg-info @endif " wire:click="setReceiver({{$u->id}})">
                                    <div class="d-flex justify-content-between w-100 m-0 p-0">
                                        <div>
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
                                            <span class="fa fa-circle text-success"></span>
                                            @endisNotOnline
                                            @if(count(Auth::user()->getUnreadMessagesOf($u->id)) > 0)
                                            <span class="">
                                                (
                                                    <span class="text-danger i"> {{ count(Auth::user()->getUnreadMessagesOf($u->id)) }} </span>
                                                    <small> non lus </small>
                                                )
                                            </span>
                                            @endif
                                        </>
                                    </div>
                                </div>
                                <hr class="m-0 p-0 w-100 bg-white">
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-9 border-left border-white bg-dark" style="height: 565px; overflow: auto;">
                   <div class="w-100 mx-auto mt-2 border">
                     <div class="mx-auto d-flex w-100" wire:poll>
                        <div class="text-uppercase text-center text-white @if(isset($receiver)) bg-dark @else bg-info @endif d-flex" style="width: 93%;">
                            @if(isset($receiver))
                                @isMyFriend($receiver)
                                    @if ($receiver->current_photo)
                                        <span class="d-flex border-right">
                                            <img width="100" src="/storage/profilPhotos/{{$receiver->currentPhoto()}}" alt="mon profil">
                                        </span>
                                    @else
                                        <span class="d-flex border-right">
                                            <img width="100" src="{{Auth::user()->defaultProfil() }}" alt="mon profil">
                                        </span>
                                    @endif
                                @endisMyFriend
                            @endif
                            <h4 class="z-title text-white text-center p-1  mt-3 m-0 w-100">
                                @if(isset($receiver))
                                    <span class="fa fa-wechat text-success"></span>
                                    <span class="text-success">{{$receiver->name}} </span>
                                @else
                                    <span class="fa fa-wechat text-white"></span>
                                    Veuillez choisir correspondant
                                @endif
                            </h4>
                        </div>
                        @isMaster()
                            <div class="text-white-50 cursor-pointer border-left p-3" data-toggle="modal" data-target="#registerModal" data-dismiss="modal">
                                <span class="">
                                    <span class="fa fa-user-plus fa-2x"></span>
                                </span>
                            </div>
                        @else
                            <div title="Suivre des amis" class="text-white-50 cursor-pointer border-left p-3" data-toggle="modal" data-target="#addFriendsModal" data-dismiss="modal">
                                <span class="">
                                    <span class="fa fa-user-plus fa-2x"></span>
                                </span>
                            </div>
                        @endisMaster
                     </div>
                    </div>
                    @if(isset($receiver))
                        @isMyFriend($receiver)
                            @if($allMessages)
                                <div class="w-100 m-0 p-0 p-2 border my-1" wire:poll="refreshMessages"> {{-- --}}
                                    <div class="m-0 p-0 w-100 border p-3 text-white" >
                                        <div class="w-100 p-0 m-0 mx-auto d-flex flex-column messages-box"> 
                                            @foreach ($allMessages as $key => $texto)
                                                <div class="@if($texto->sender_id == Auth::user()->id) text-right @else text-left @endif">
                                                    <h4 wire:key="{{$texto->id}}" wire:click="toggleAction({{$key}}, {{$texto->id}})" id="" class="chatMessageCard cursor-pointer shadow w-auto  @if($texto->deleted_at) border border-muted @endif p-2 my-2 @if($texto->sender_id == Auth::user()->id) float-right @else float-left  @endif">
                                                        <span class="d-flex w-100">
                                                            @if($actionIsActive && $activeMSGK == $key)
                                                                @if($texto->sender_id == Auth::user()->id)
                                                                    <span style="width: 10%" class="chatAction d-flex border-bottom float-right @if($texto->deleted_at) border-muted @else border-warning @endif text-right">
                                                                        <span wire:click="targetedMessage({{$texto->id}})" data-target="#DeleteMessageModal" data-toggle="modal" data-dismiss="modal" class="fa z-scale fa-trash text-danger cursor-pointer px-2"></span>
                                                                        <span class="fa z-scale fa-reply  text-success cursor-pointer px-2"></span>
                                                                    </span>
                                                                @endif
                                                            @endif
                                                            <span class="text-white-50 pb-1 d-flex border-bottom w-100 @if($texto->sender_id == Auth::user()->id) float-right @if($texto->deleted_at) border-muted @else border-warning @endif text-right justify-content-end @else border-primary text-left float-left justify-content-start @endif">
                                                                @if($texto->sender_id == Auth::user()->id)
                                                                    @if ($sender->current_photo)
                                                                        <span class="d-flex">
                                                                            <img width="30" class="border rounded-circle" src="/storage/profilPhotos/{{$sender->currentPhoto()}}" alt="mon profil">
                                                                            <span class="mx-2">{{Auth::user()->name}}</span>
                                                                        </span>
                                                                    @else
                                                                        <span class="d-flex">
                                                                            <img width="30" class="border rounded-circle" src="{{$sender->currentPhoto()}}" alt="mon profil">
                                                                            <span class="mx-2">{{Auth::user()->name}}</span>
                                                                        </span>
                                                                    @endif
                                                                @else
                                                                    @if ($receiver->current_photo)
                                                                    <span class="d-flex">
                                                                        <img width="30" class="border rounded-circle" src="/storage/profilPhotos/{{$receiver->currentPhoto()}}" alt="mon profil">
                                                                        <span class="mx-2">{{$receiver->name}}</span>
                                                                    </span>
                                                                    @else
                                                                        <span class="d-flex">
                                                                            <img width="30" class="border rounded-circle" src="{{$receiver->currentPhoto()}}" alt="mon profil">
                                                                            <span class="mx-2">{{$receiver->name}}</span>
                                                                        </span>
                                                                    @endif
                                                                @endif
                                                            </span>
                                                            @if($actionIsActive && $activeMSGK == $key && $texto->sender_id == Auth()->user()->id)
                                                                @if($texto->sender_id !== $sender->id)
                                                                    <span style="width: 10%" class="chatAction d-flex border-bottom   @if($texto->deleted_at) border-seconday @else border-primary @endif text-left float-left">
                                                                        <span wire:click="targetedMessage({{$texto->id}})" data-target="#DeleteMessageModal" data-toggle="modal" data-dismiss="modal" class="fa z-scale fa-trash text-danger cursor-pointer px-2"></span>
                                                                        <span class="fa z-scale fa-reply  text-success cursor-pointer px-2"></span>
                                                                    </span>
                                                                @endif
                                                            @endif
                                                        </span>
                                                        <span message-id="message-{{$texto->id}}" class="messages-content message-content-box cursor-pointer py-1">
                                                            @if($texto->deleted_at)
                                                                <span class="text-muted">
                                                                    @if($texto->sender_id == Auth()->user()->id)
                                                                        <span>
                                                                            Vous avez supprimé ce message
                                                                        </span>
                                                                    @else
                                                                        <span>
                                                                            Ce message a été supprimé
                                                                        </span>
                                                                    @endif
                                                                </span>
                                                            @else
                                                                <span class="z-word-break-break">
                                                                    {{$texto->message}}
                                                                </span>
                                                            @endif
                                                        </span>
                                                        <span class="messages-keyboard d-flex w-100 @if($texto->sender_id == Auth::user()->id)  @if($texto->deleted_at) bg-seconday @else bg-warning @endif float-right text-right justify-content-end @else text-left float-left   @if($texto->deleted_at) bg-primary @else bg-primary @endif justify-content-start @endif">
                                                            <small class="text-italic italic d-flex justify-content-between w-100 " style="font-size: 11px; padding: 1px">
                                                                <i class="  @if($texto->deleted_at) text-muted @endif">
                                                                    Envoyé le {{$texto->created_at}}
                                                                </i>
                                                                @if($texto->sender_id == Auth::user()->id)
                                                                    @if($texto->seen)
                                                                        <i class="fa fa-check-double px-1"></i>
                                                                        <span class="px-1">
                                                                            <i class="fa fa-check text-success"></i>
                                                                            <i class="fa fa-check text-success"></i>
                                                                        </span>
                                                                    @else 
                                                                    <i class="fa fa-check px-1"></i>
                                                                    @endif
                                                                @endif
                                                            </small>
                                                        </span>
                                                        
                                                    </h4>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($receiver))
                                    <div id="messages-container" class="w-100 p-0 mt-3 border @if($errorTexto) border-danger text-danger @else border-warning @endif messages-keyboard" style="bottom: 60px">
                                        @if($errorTexto)
                                            <div id="errorBagTexto" class="w-100 p-0 m-0 text-center text-danger border-bottom border-danger">
                                                <h5 class="py-1 text-bold">Le message est incorrect</h5>
                                            </div>
                                        @endif
                                        
                                        <form id="chat-form" class="form w-100 mx-auto" wire:submit.prevent="sendMessage()" >
                                            @csrf
                                            <div class="w-100 m-0 p-0 mx-auto row">
                                                <textarea style="font-family: cursive !important;" wire:model.defer="newMessage" class=" form-textarea bg-secondary col-9" name="newMessage" id="newMessage" cols="10" style="" ></textarea>
                                                <button id="sendBtnForChat" class="btn btn-primary @if($errorTexto) btn-info text-danger @else text-white @endif  p-2 col-3">
                                                    Envoyer
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endisMyFriend
                    @endif
                </div>
            </div>
            {{-- modal --}}
            <div wire:ignore.self class="modal fade lug" id="DeleteMessageModal" role="dialog" >
                <div class="modal-dialog" role="document">
                   <!-- Modal content-->
                   <div class="modal-content" style="position: absolute; top:150px;">
                      <div class="modal-header">
                         <div class="d-flex justify-content-between w-100">
                            <h4 class="text-uppercase mr-2 mt-1">
                                Suppression de message
                            </h4>
                            <div class="d-flex justify-content-end w-20">
                               <div class="w-15 mx-0 px-0">
                                  <ul class="d-flex mx-0 px-0 mt-1 justify-content-between w-100">
                                     <li class=" mx-1"><a href="#"><img src="images/flag-up-1.png" width="100" alt="" /> </a></li>
                                     <li><a href="#"><img src="images/flag-up-2.png" width="100" alt="" /></a></li>
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
                                     <div class="card-body border p-0 border-success py-2 col-12 col-lg-6 col-xl-6">
                                        <h4 class="text-warning text-center p-1 m-0 py-3">Voulez-vous vraiment supprimer ce message @if($deletedMessage) définivement @endif ?</h4>
                                        <hr class="m-0 p-0 bg-white">
                                        <hr class="m-0 p-0 bg-warning">
                                        <hr class="m-0 p-0 bg-info">
                                            @csrf
                                            <form autocomplete="false" method="post" class="mt-3" wire:submit.prevent="deleteMessage({{$targetedMessage}})">
                                                <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
                                                    <button class="w-50 border border-white btn btn--pill bg-danger" type="submit">Supprimer</button>
                                                </div>
                                            </form>
                                            <form autocomplete="false" method="post" class="mt-3" wire:submit.prevent="cancel()">
                                                <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
                                                    <button class="w-50 border border-white btn btn--pill bg-success" type="submit">Annuler la suppression</button>
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
            
            {{-- en modal --}}



          </div>   
       </div>
    </div>
 </div>


 