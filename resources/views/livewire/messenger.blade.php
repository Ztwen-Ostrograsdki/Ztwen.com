<div>
    <div class="wrapper-chat w-100 m-0 p-0 px-2 border-secondary border z-bg-hover-secondary">
        <div class="container-chat">
            <div class="w-100 p-0 my-1 border z-bg-secondary-hover text-center">
                <h6 class="text-white py-2 text-center px-2 m-0">
                    <span class="bi-messenger"></span>
                    <span>Chat Box</span>
                </h6>
            </div>
            <div class="left">
                <div class="z-bg-hover-secondary m-0 p-0 border py-2">
                    <form class="d-flex justify-content-start w-100">
                        @csrf
                        <input style="width: calc(100% - 55px)" placeholder="Taper..." class="form-control z-bg-hover-secondary mx-1 border text-white-50" type="text" />
                        <span class="mt-2" style="width: 50px;">
                            <span class="bi-search cursor-pointer px-1 mx-1"></span>
                        </span>
                    </form> 
                </div>
                @if(count($users) > 0)
                <ul class="people m-0 p-0 bg-transparent px-1 py-2">
                    @foreach ($users as $k => $u)
                        <li wire:click="setReceiver({{$u->id}})" class="person @if($receiver && $receiver->id === $u->id) active-active @endif" data-chat="person{{$k + 1}}">
                            <i>
                                <img src="{{$profil_path1}}" alt="" />
                                <i style="" class="online bi-circle-fill text-success"></i>
                            </i>
                            <span class="name">{{$u->name}}</span>
                            <span class="time">{{auth()->user()->__getLastMessage($u->id) ? auth()->user()->__getLastMessage($u->id)->getDateAgoFormated(true) : ''}}</span>
                            <span id="preview_{{$u->id}}" class="preview">{{auth()->user()->__getLastMessage($u->id) ? (mb_strlen(auth()->user()->__getLastMessage($u->id)->message) < 30 ? auth()->user()->__getLastMessage($u->id)->message : mb_substr(auth()->user()->__getLastMessage($u->id)->message, 0, 30) . ' ...') : 'Aucun message'}}</span>
                            <span style="display: none;" id="UserTyping_{{$u->id}}" class="preview"> {{$u->name}} est entrain d'écrire...</span>
                        </li>
                    @endforeach
                </ul>
                @else
                <ul class="people m-0 p-0 bg-transparent px-1 py-2">
                    <li class="person">
                        <i>
                            <img src="{{$profil_path1}}" alt="" />
                            <i style="" class="online bi-circle-fill text-success"></i>
                        </i>
                        <span class="name">{{$u->name}}</span>
                        <span class="time">2:09 PM</span>
                        <span class="preview">Once</span>
                    </li>
                </ul>
                @endif
            </div>
            <div class="right border">
                <div class="top z-bg-hover-secondary">
                    <h6 class="text-center my-3">
                        <span class="text-white-50">
                            Ecris avec ... <span class="name text-white text-capitalize ml-2">{{$receiver ? $receiver->name : ''}}</span>
                        </span>
                    </h6>
                </div>
                <div class="chat @if(!$receiver) d-none @else active-chat @endif" data-chat="">
                    @if(count($allMessages) > 0)
                        @foreach ($allMessages as $key => $m )
                            <div class="conversation-start">
                                <span>Today, 5:38 PM</span>
                            </div>
                            @if($m->sender_id == $receiver->id)
                            <div class="bubble you mb-0 cursor-pointer">
                                <span> {{$m->message}}</span>
                            </div>
                            <small class="d-inline-block float-left w-100 text-left">
                                <small class="z-fs-9px">{{$m->getDateAgoFormated(true)}}</small>
                            </small>
                            @elseif($m->sender_id == auth()->user()->id)
                            <div class="bubble me mb-0 cursor-pointer">
                                <span> {{$m->message}}</span>
                            </div>
                            <small class="d-inline-block float-right w-100 text-right">
                                <small class="z-fs-9px">{{$m->getDateAgoFormated(true)}}</small>
                                <span class="@if($m->seen) bi-check-all text-success @else bi-check @endif"></span>
                            </small>
                            @else

                            @endif
                            
                        @endforeach
                    @else
                        <div class="chat active-chat" data-chat="">
                            <div class="bubble empty-left">
                                Hooops du vide ....
                            </div>
                            <div class="bubble empty-right">
                               ....Aller voyons écriver quelque chose...
                            </div>
                        </div>
                    @endif
                </div>

                <div class="chat @if($receiver) d-none @else active-chat @endif" data-chat="">
                    <div class="bubble empty-left">
                        Selctionner un utilisateur pour ....
                    </div>
                    <div class="bubble empty-right">
                       ....lancer la discussion...
                    </div>
                </div>
                <div class="write z-bg-secondary border border-secondary">
                    <form class="d-flex justify-content-start w-100 z-bg-secondary" wire:submit.prevent="send">

                        <span style="width: 50px;" class="bi-emoji-smile mt-2 cursor-pointer px-1"></span>
                        <input wire:model.debounce.500ms="texto" style="width: calc(100% - 140px)" class=" z-bg-hover-secondary mx-1" type="text" />
                        <span class="mt-2" style="width: 80px;">
                            <span class="bi-paperclip cursor-pointer px-1"></span>
                            <span  wire:click="send" class="bi-send cursor-pointer px-1 mx-1"></span>
                        </span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>