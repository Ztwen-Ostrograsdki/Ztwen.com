<div>
    @auth
    <div wire:ignore.self class="modal fade lug" id="displayMyNotificationsModal" role="dialog" >
       <div class="modal-dialog modal-z-xlg" role="document">
          <!-- Modal content-->
          <div class="modal-content  border" style="position: absolute; top:100px; z-index: 2010;">
             <div class="modal-header">
                <div class="d-flex justify-content-between w-100">
                   <h4 class="text-uppercase mr-2 mt-1">
                       Vos notifications
                   </h4>
                   <div class="d-flex justify-content-end w-20">
                      <div class="w-15 mx-0 px-0">
                      </div>
                      <div class="w-25"></div>
                      <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                   </div>
                </div>
             </div>
             <div class="modal-body m-0 p-0">
                <div class="">
                    <div class="wrapper wrapper--w780 ">
                       <div class="card card-3 border row w-100 p-0 m-0 z-bg-hover-secondary">
                            <div class="card-body border p-0 col-12 col-lg-8 col-xl-8 p-3">
                               <h3 class="z-title text-white w-100 p-1 m-0 text-capitalize mb-2">
                                    <span class="">
                                        @if($total == 0)
                                        Vous n'avez recu aucune notification <span style="font-size: 22px" class="bi-envelope-open text-warning"></span>
                                        @elseif($total == 1)
                                        Vous avez recu une notification <span style="font-size: 22px" class="bi-envelope-check text-success"></span>
                                        @elseif($total > 1 && $total < 10)
                                        Vous avez recu 0{{$total}} notifications <span style="font-size: 22px" class="bi-envelope-check text-success"></span>
                                        @elseif($total > 9)
                                        Vous avez recu {{$total}} notifications <span style="font-size: 22px" class="bi-envelope-check text-success"></span>
                                        @endif
                                    </span>
                                    @if($total > 0)
                                        <span wire:click="deleteThis()" style="font-size: 18px" class="btn-danger border px-4 py-1 border-white cursor-pointer text-white float-right text-right">
                                            <span class="fa fa-trash cursor-pointer text-white"></span>
                                            <span class="">Vider</span>
                                        </span>
                                    @endif
                                </h3>
                                <hr class="bg-white p-0 m-0">
                                <hr class="bg-white p-0 m-0 my-1">
                                @if($myNotifications && $total > 0)
                                    <div class="d-flex flex-column w-100 mx-auto p-1">
                                        @foreach ($myNotifications as $notif)
                                            <h5 class="border-bottom d-flex flex-column">
                                                <span class="float-left p-2">
                                                    <span class="fa fa-check text-success"></span>
                                                    <span class="mx-1 z-word-break-break" style="">
                                                        {{$notif->content}}
                                                    </span>
                                                    <span wire:click="deleteThis({{$notif->id}})" class="float-right text-right cursor-pointer btn-primary border border-white px-4 py-1">
                                                        <span class="fa fa-close text-danger"></span>
                                                        <span>Lu</span>
                                                    </span>
                                                </span>
                                                <div class="d-flex justify-content-between text-white-50 w-100 p-1">
                                                    @if($notif->target)
                                                    <small class="mx-2">
                                                        Cible : <span class="text-warning">{{$notif->target}}</span>
                                                        @if($notif->target == "Articles")
                                                            => <span class="text-warning">{{\App\Models\Product::find($notif->target_id)->getName()}}</span>
                                                        @elseif($notif->target == "Commentaires")
                                                            @if($notif->comment)
                                                                 => <span class="text-warning">{{mb_substr($notif->comment->content, 0, 15)}}</span>
                                                            @else
                                                            => <span class="text-warning">Contenu déjà supprimé</span>
                                                            @endif
                                                        @elseif($notif->target == "Nouvel Article")
                                                            @if(\App\Models\Product::find($notif->target_id))
                                                            => <span class="text-warning">{{mb_substr(\App\Models\Product::find($notif->target_id)->getName(), 0, 15)}}</span>
                                                            @else
                                                            => <span class="text-warning">Contenu déjà supprimé</span>
                                                            @endif
                                                        @elseif($notif->target == "Nouvelle Catégorie" || $notif->target == "Catégorie Editée")
                                                            @if(\App\Models\Category::find($notif->target_id))
                                                            => <span class="text-warning">{{mb_substr(\App\Models\Category::find($notif->target_id)->name, 0, 15)}}</span>
                                                            @else
                                                            => <span class="text-warning">Contenu déjà supprimé</span>
                                                            @endif
                                                        @endif
                                                        @if($notif->target == "Articles" || $notif->target == "Commentaires")
                                                            @if($notif->comment)
                                                                <span class="text-muted"> @@@ Posté {{$notif->comment->getDateAgoFormated()}}</span>
                                                            @else
                                                                <span class="text-muted "> --@@@ Posté {{$notif->getDateAgoFormated()}}</span>
                                                            @endif
                                                        @elseif($notif->target == "Nouvel Article")
                                                            @if(\App\Models\Product::find($notif->target_id))
                                                                <span class="text-muted"> @@@ Posté {{\App\Models\Product::find($notif->target_id)->getDateAgoFormated()}}</span>
                                                            @else
                                                                <span class="text-warning">Article déjà retiré</span>
                                                            @endif
                                                        @elseif($notif->target == "Nouvelle Catégorie" || $notif->target == "Catégorie Editée")
                                                            @if(\App\Models\Category::find($notif->target_id))
                                                                <span class="text-muted"> @@@ Posté {{\App\Models\Category::find($notif->target_id)->getDateAgoFormated()}}</span>
                                                            @else
                                                                <span class="text-warning">Catégorie déjà retirée</span>
                                                            @endif
                                                        @endif
                                                    </small>
                                                    @endif
                                                    <small class="mx-2">
                                                        Expéd. : Admin <span class="fa fa-user-secret text-danger"></span>
                                                    </small>
                                                    <small>
                                                        Envoyé {{$notif->getDateAgoFormated()}}
                                                    </small>
                                                </div>
                                            </h5>
                                        @endforeach
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
    @endauth
</div>