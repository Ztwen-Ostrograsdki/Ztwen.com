<x-z-modal-generator :icon="''" :modalName="'displayMyNotificationsModal'" :modalHeaderTitle="'Vos notifications'" :modalBodyTitle="''">
    <div class="w-75 my-2 border rounded border-orange p-2 mx-auto">
        <h6 class="z-title text-white w-100 m-0 text-capitalize mb-2">
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
                <span title="Supprimer toutes les notifications" wire:click="deleteThis()" style="font-size: 18px" class="bg-orange rounded border px-4 py-2 border-white cursor-pointer text-white float-right text-right">
                    <span class="fa fa-trash cursor-pointer text-white"></span>
                    <span class="d-none d-xxl-inline d-xl-inline">Vider</span>
                </span>
            @endif
        </h6>
    </div>
    @if($myNotifications && $total > 0)
    <hr class="text-white px-0 mx-0">
    <div class="d-flex flex-column w-100 mx-auto p-1 px-2">
        @foreach ($myNotifications as $notif)
            @if($notif->target !== "Admin-Advanced-Key")
            <h6 class="border rounded my-1 d-flex flex-column">
                <span class="float-left p-2">
                    <span class="fa fa-check text-success"></span>
                    <span class="mx-1 z-word-break-break text-white-50" style="">
                        {{$notif->content}}
                    </span>
                    <span title="Supprimer cette notification" wire:click="deleteThis({{$notif->id}})" class="float-right text-right cursor-pointer bg-orange rounded border border-white px-2 py-1">
                        <span class="fa fa-close"></span>
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
                            => <small class="text-warning">Contenu déjà supprimé</small>
                            @endif
                        @elseif($notif->target == "Nouvel Article")
                            @if(\App\Models\Product::find($notif->target_id))
                            => <small class="text-warning">{{mb_substr(\App\Models\Product::find($notif->target_id)->getName(), 0, 15)}}</small>
                            @else
                            => <small class="text-warning">Contenu déjà supprimé</small>
                            @endif
                        @elseif($notif->target == "Nouvelle Catégorie" || $notif->target == "Catégorie Editée")
                            @if(\App\Models\Category::find($notif->target_id))
                            => <small class="text-warning">{{mb_substr(\App\Models\Category::find($notif->target_id)->name, 0, 15)}}</small>
                            @else
                            => <small class="text-warning">Contenu déjà supprimé</small>
                            @endif
                        @endif
                        @if($notif->target == "Articles" || $notif->target == "Commentaires")
                            @if($notif->comment)
                                <small class="text-white-50"> @@@ Posté {{$notif->comment->getDateAgoFormated()}}</small>
                            @else
                                <small class="text-white-50 "> --@@@ Posté {{$notif->getDateAgoFormated()}}</small>
                            @endif
                        @elseif($notif->target == "Nouvel Article")
                            @if(\App\Models\Product::find($notif->target_id))
                                <small class="text-white-50"> @@@ Posté {{\App\Models\Product::find($notif->target_id)->getDateAgoFormated()}}</small>
                            @else
                                <small class="text-warning">Article déjà retiré</small>
                            @endif
                        @elseif($notif->target == "Nouvelle Catégorie" || $notif->target == "Catégorie Editée")
                            @if(\App\Models\Category::find($notif->target_id))
                                <small class="text-white-50"> @@@ Posté {{\App\Models\Category::find($notif->target_id)->getDateAgoFormated()}}</small>
                            @else
                                <small class="text-warning">Catégorie déjà retirée</small>
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
            </h6>
            @endif
        @endforeach
    </div>
@endif
</x-z-modal-generator>
    