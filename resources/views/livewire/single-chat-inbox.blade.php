<div>
    <div wire:ignore.self class="modal fade lug" id="singleChatModal" role="dialog" >
       <div class="modal-dialog modal-z-xlg" role="document">
          <!-- Modal content-->
          <div class="modal-content modal-fullscreen border @if('errorTexto') border-danger @endif" style="z-index: 2010; top: 20px;">
             <div class="modal-header">
                <div class="d-flex justify-content-between w-100">
                   <h6 class="text-uppercase mr-2 mt-1 d-flex justify-content-between">
                       Messenger <span class="fa bi-messenger mx-2 mr-4"></span>
                        @if($receiver)
                            <span>
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
                        </span>
                        @endif
                        @if (session()->has('alert'))
                            <span class="alert text-capitalize alert-{{session('type')}} ml-4">{{session('alert')}}</span>
                        @endif
                   </h6>
                   <div class="d-flex justify-content-end w-20">
                      <div class="w-15 mx-0 px-0">
                      </div>
                      <div class="w-25"></div>
                      <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                   </div>
                </div>
             </div>
             @if($receiver)
             <div class="modal-body m-0 p-0">
                <div class="">
                    <div class="wrapper wrapper--w780 ">
                       <div class="card card-3 border row w-100 p-0 m-0 z-bg-hover-secondary">
                            <div class="card-body border p-0 col-12 p-0">
                                <div class="pb-3 mt-2" style="max-height: 480px; overflow: auto; margin-bottom: 100px;">
                                    <div class="w-100 p-0 m-0 px-3 mx-auto d-flex flex-column messages-box"> 
                                       @if($total > $limit)
                                        <h6 wire:loaded wire:target="allMessages" wire:click="showMoreMessages" class="mx-auto border cursor-pointer bg-transparent border-secondary px-3 py-2 rounded">
                                           <span class="bi-download"></span>
                                           Charger plus de messages
                                       </h6>
                                       @endif
                                        <h5 wire:loading wire:target="allMessages" class="mx-auto border cursor-pointer bg-transparent border-secondary px-3 py-2 rounded">
                                            ... Chargement en cours, veuillez patienter ...
                                        </h5>
                                        @foreach ($allMessages as $key => $m)
                                            <div class="@if($m->sender_id == Auth::user()->id) text-right @else text-left @endif">
                                                <h6 wire:key="{{$m->id}}" id="" class="chatMessageCard cursor-pointer shadow border rounded  @if($m->deleted_at) border d-inline-block border-muted w-auto @else w-auto @endif p-2 my-2 @if($m->sender_id == Auth::user()->id) float-right @else float-left  @endif">
                                                    <span class="d-flex w-100">
                                                        <span class="text-white-50 pb-1 d-flex border-bottom w-100 @if($m->sender_id == Auth::user()->id) float-right @if($m->deleted_at) border-muted @else border-warning @endif text-right justify-content-end @else border-primary text-left float-left justify-content-start @endif">
                                                            @if($m->sender_id == Auth::user()->id)
                                                                @if ($user->current_photo)
                                                                    <span class="d-flex">
                                                                        <img width="30" class="border rounded-circle" src="/storage/profilPhotos/{{$user->currentPhoto()}}" alt="mon profil">
                                                                        <span class="mx-2">{{Auth::user()->name}}</span>
                                                                    </span>
                                                                @else
                                                                    <span class="d-flex">
                                                                        <img width="30" class="border rounded-circle" src="{{$user->currentPhoto()}}" alt="mon profil">
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
                                                    </span>
                                                    <span message-id="message-{{$m->id}}" class="messages-content message-content-box cursor-pointer py-1">
                                                        @if($m->deleted_at)
                                                            <span class="text-muted">
                                                                @if($m->sender_id == Auth()->user()->id)
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
                                                            <span class="text-white z-word-break-break">
                                                                {{$m->message}}
                                                            </span>
                                                        @endif
                                                    </span>
                                                    <span class="messages-keyboard d-flex w-100 @if($m->sender_id == Auth::user()->id)  @if($m->deleted_at) bg-seconday @else bg-warning @endif float-right text-right justify-content-end @else text-left float-left @if($m->deleted_at) bg-primary @else bg-primary @endif justify-content-start @endif">
                                                        <small class="text-italic italic d-flex justify-content-between w-100 " style="font-size: 11px; padding: 1px">
                                                            <i class="text-dark  @if($m->deleted_at) text-dark @endif">
                                                                Envoyé {{$m->getDateAgoFormated()}}
                                                            </i>
                                                            @if($m->sender_id == Auth::user()->id)
                                                                @if($m->seen)
                                                                    <span class="px-1">
                                                                        <i class="fa bi-check-all text-dark"></i>
                                                                    </span>
                                                                @else 
                                                                <i class="fa fa-check text-dark px-1"></i>
                                                                @endif
                                                            @endif
                                                        </small>
                                                    </span>
                                                </h6>
                                            </div>
                                        @endforeach
                                        @if($defaultLimit < $limit)
                                        <h6 wire:click="showLessMessages" class="mx-auto border cursor-pointer bg-transparent border-secondary px-3 py-2 rounded">
                                            <span class="bi-cloud-download"></span>
                                            Charger moins de messages
                                        </h6>
                                       @endif
                                    </div>
                                </div>
                                <form style="position: fixed; bottom: -12px;" autocomplete="off" class="mt-3 pb-3 pt-5 px-0  rounded mx-0 shadow zw-98 mx-auto z-bg-secondary" wire:submit.prevent="send">
                                    <small style="display: none;" id="isTyping_{{$receiver->id}}" class="z-bg-secondary my-1">
                                        <strong class="text-warning bi-pen mx-2"></strong>
                                        <span class="text-warning">
                                            {{$receiver->name}} est entrain d'écrire...
                                        </span>
                                    </small>
                                    @csrf
                                    <div class="w-100 m-0 p-0 mx-auto d-flex px-2 justify-content-between">
                                        <input placeholder="Taper votre message..." style="font-family: cursive !important;" wire:model.debounce.700ms="texto" class="form-control chat-input ml-2 zw-83 border text-white bg-transparent @error('texto') border-danger @enderror" name="texto" id="texto" >
                                        <button id="" class="btn btn-primary d-flex justify-content-between w-auto">
                                            <span class="d-none d-lg-inline d-md-inline d-xl-inline">Envoyer</span>
                                            <span class="fa fa-send mt-2"></span>
                                        </button>
                                    </div>
                                    @error('texto') 
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
             @endif
          </div>
       </div>
    </div>
    </div>