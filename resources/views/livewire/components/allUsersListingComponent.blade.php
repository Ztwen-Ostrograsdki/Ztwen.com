<div>
    @if($data->count() > 0)
    <div class="w-100 m-0 p-0 mt-3">
    <table class="w-100 m-0 p-0 table-striped table-bordered z-table text-white">
        <thead class="text-white text-center">
            <th class="py-2 text-center">#ID</th>
            <th class="">Nom</th>
            <th class="d-none d-lg-table-cell d-xl-table-cell">Email</th>
            <th>Inscrit depuis</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($data as $k => $u)
                <tr class="@isMaster($u) text-warning @endisMaster">
                    <td class=" text-center">{{$k + 1}}</td>
                    <td class="text-capitalize pl-2">
                        @if($u->current_photo)
                            <span class="d-flex">
                            <img width="30" class="border rounded-circle" src="/storage/profilPhotos/{{$u->currentPhoto()}}" alt="mon profil">
                            <span class="mx-2 d-none d-lg-inline d-xl-inline">
                                {{$u->name}}
                            </span>
                            <span class="d-inline d-lg-none d-xl-none">
                                {{mb_substr($u->name, 0, 9)}}...
                            </span>
                            @if($u->role == 'admin')
                                <span class="fa fa-user-secret mt-1 @isMaster($u) text-warning @else text-white-50 @endisMaster float-right"></span>
                            @endif
                            </span>
                        @else
                            <span class="d-flex">
                                <img width="30" class="border rounded-circle" src="{{$u->currentPhoto()}}" alt="mon profil">
                                <span class="mx-2">{{$u->name}}</span>
                                @if($u->role == 'admin')
                                <span class="fa fa-user-secret @isMaster($u) text-warning @else text-white-50 @endisMaster mt-1 float-right"></span>
                                @endif
                                @if(auth()->user()->id !== $u->id)
                                <span title="Lancer un chat avec {{$u->name}} pas message" class="float-right mx-2">
                                    <span wire:click="openSingleChat({{$u->id}})" class="float-right cursor-pointer">
                                        <span class="fa bi-messenger cursor-pointer text-success"></span>
                                    </span>
                                </span>
                                @endif
                            </span>
                        @endif
                    </td>
                    <td title="Cette addresse mail @if($u->hasVerifiedEmail()) a d??ja ??t?? confirm?? @else n'a pas encore ??t?? confirm?? @endif" class="text-center @if($u->hasVerifiedEmail()) text-success @else text-danger @endif d-none d-lg-table-cell d-xl-table-cell">
                        {{$u->email}}
                    </td>
                    <td class="text-center">
                        {{ str_ireplace("Il y a ", '', $u->getDateAgoFormated(true)) }}
                    </td>
                    <td class="text-center w-auto p-0">
                        @isNotMaster($u)
                            <span class="row w-100 m-0 p-0">
                                @if ($u->deleted_at)
                                    <span title="Supprimer d??finivement {{$u->name}} de la base de donn??e" wire:click="forceDeleteAUser({{$u->id}})" class="text-danger col-4 m-0 p-0 cursor-pointer">
                                        <span class="text-danger cursor-pointer fa fa-trash py-2 px-2"></span>
                                    </span>
                                    <span title="Restaurer {{$u->name}}" wire:click="restoreAUser({{$u->id}})" class="text-success col-4 m-0 p-0 cursor-pointer border-right border-left">
                                        <span class="fa fa-reply py-2 px-2"></span>
                                    </span>
                                    <span title="D??bloquer {{$u->name}}" wire:click="unblockAUser({{$u->id}})" class="text-success col-4 m-0 p-0 cursor-pointer">
                                        <span class="fa fa-unlock py-2 px-2"></span>
                                    </span>
                                @else
                                    <span title="Supprimer d??finivement {{$u->name}} de la base de donn??e" wire:click="forceDeleteAUser({{$u->id}})" class="text-danger col-3 m-0 p-0 cursor-pointer">
                                        <span class="text-danger cursor-pointer fa fa-trash py-2 px-2"></span>
                                    </span>
                                    <span title="Envoyer {{$u->name}} dans la corbeile" wire:click="deleteAUser({{$u->id}})" class="text-warning border-right border-left col-3 m-0 p-0 cursor-pointer">
                                        <span class="cursor-pointer fa fa-trash py-2 px-2"></span>
                                    </span>
                                    <span title="Bloquer {{$u->name}}" wire:click="blockAUser({{$u->id}})" class="text-info col-3 m-0 p-0 cursor-pointer border-right">
                                        <span class="fa fa-lock py-2 px-2"></span>
                                    </span>
                                    @isNotAdmin($u)
                                        <span title="Definir en tant que administrateur" class="col-3 m-0 p-0 m-0" wire:click="updateUserRole({{$u->id}}, 'admin')">
                                            <span class="text-success m-0 cursor-pointer fa fa-user-secret py-2 px-2"></span>
                                        </span>
                                    @else
                                        <span title="Restreindre l'abilit?? ?? un simple utilisateur" class="col-3 m-0 p-0 " wire:click="updateUserRole({{$u->id}}, 'user')">
                                            <span class="text-danger m-0 cursor-pointer fa fa-user-secret py-2 px-2"></span>
                                        </span>
                                    @endisNotAdmin
                                @endif
                            </span>
                        @else
                        <strong class="text-success">Master</strong>
                        @endisNotMaster
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>                                                     
    </div>
    @else
    <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
        <span class="fa fa-warning text-warning fa-4x"></span>
        <h4 class="text-warning fa fa-3x">Ouups aucune donn??es enregist??es !!!</h4>
    </div>
    @endif
</div>