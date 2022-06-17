<div>
    <div class="d-flex justify-content-center w-100 py-1 mx-1 mx-auto" wire:poll.visible.59000ms="updateCommentsData">
        <div class="w-100 d-flex flex-column">
            @foreach ($comments as $key => $com)
            <div class="@if(Auth::user() && $com->user_id == Auth::user()->id) text-right @else text-left @endif">
                <h6 wire:key="{{$com->id}}" id="" class="chatMessageCard cursor-pointer shadow border rounded   @if($com->deleted_at) border-muted @endif p-2 w-auto my-2 @if(Auth::user() && $com->user_id == Auth::user()->id) float-right mr-2 @else float-left  @endif">
                    <span class="d-flex w-100">
                        <span class="text-dark pb-1 d-flex border-bottom w-100 @if(Auth::user() && $com->user_id == Auth::user()->id) float-right @if($com->deleted_at) border-muted @else border-warning @endif text-right justify-content-end @else border-primary text-left float-left justify-content-start @endif">
                            @if(Auth::user() && $com->user_id == Auth::user()->id)
                                @if ($com->user->current_photo)
                                    <span class="d-flex">
                                        <img width="30" class="border rounded-circle" src="/storage/profilPhotos/{{$com->user->currentPhoto()}}" alt="mon profil">
                                        <span class="mx-2">{{Auth::user()->name}}</span>
                                    </span>
                                @else
                                    <span class="d-flex">
                                        <img width="30" class="border rounded-circle" src="{{$com->user->currentPhoto()}}" alt="mon profil">
                                        <span class="mx-2">{{Auth::user()->name}}</span>
                                    </span>
                                @endif
                            @else
                                @if ($com->user->current_photo)
                                <span class="d-flex">
                                    <img width="30" class="border rounded-circle" src="/storage/profilPhotos/{{$com->user->currentPhoto()}}" alt="mon profil">
                                    <span class="mx-2">{{$com->user->name}}</span>
                                </span>
                                @else
                                    <span class="d-flex">
                                        <img width="30" class="border rounded-circle" src="{{$com->user->currentPhoto()}}" alt="mon profil">
                                        <span class="mx-2">{{$com->user->name}}</span>
                                    </span>
                                @endif
                            @endif
                        </span>
                    </span>
                    <span style="font-size: 12px" message-id="message-{{$com->id}}" class="messages-content message-content-box cursor-pointer py-1">
                        <span class="my-2">
                            {{$com->content}}
                        </span>
                    </span>
                    <span class="messages-keyboard d-flex mt-2 w-100 @if(Auth::user() && $com->user_id == Auth::user()->id)   bg-warning float-right text-right justify-content-end @else text-left float-left bg-primary justify-content-start @endif">
                        <small class="text-italic italic d-flex justify-content-between w-100 " style="font-size: 9px; padding: 1px">
                            <span style="font-size: 10px">
                                Posté {{$com->getDateAgoFormated()}}
                            </span>
                            @if($com->approved)
                                <span class="px-1 py-0">
                                    <i style="font-size: 14px" class="bi-check-all text-success px-1 py-0"></i>
                                </span>
                            @endif
                        </small>
                    </span>
                    
                </h6>
            </div>
            @endforeach
        </div>
    </div>
</div>
