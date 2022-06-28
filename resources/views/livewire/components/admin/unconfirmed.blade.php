@if($unconfirmed->count() > 0)
<div>
<div class="w-100 m-0 p-0">
    @foreach ($unconfirmed as $key => $u_user)
    <div class="w-100 mx-auto p-0 border my-3 z-bg-hover-secondary rounded shadow">
        <div class="row m-0 mx-auto p-0 w-100">
            <div class="col-12">
                <div class="w-100 m-0 p-0 py-1 d-flex justify-content-between">
                    <h6 class="text-center py-1 w-33">
                        <span class="d-flex">
                            <span class="bi-person mr-2"> : </span>
                            <span class="mx-2 text-uppercase">{{$u_user->name}}</span>
                            @if($u_user->role == 'admin')
                            <span class="fa fa-user-secret @isMaster($u_user) text-warning @else text-white-50 @endisMaster mt-1 float-right"></span>
                            @endif
                        </span>
                    </h6>
                    <div class="d-flex justify-content-start">
                        @isMaster()
                        @if(!$u_user->hasVerifiedEmail())
                            <span title="Confirmer le compte de l'untilisateur {{$u_user->name}}" wire:click="verifiedThisUserMail({{$u_user->id}})"  class="z-scale py-1 cursor-pointer btn-success mr-2 py-0 px-2 border border-white">
                                <span class="fa bi-person-check p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Confirmer</small>
                            </span>
                        @endif
                        <span title="Supprimer l'untilisateur {{$u_user->name}}" wire:click="deleteAUser({{$u_user->id}})"  class="z-scale py-1 cursor-pointer btn-danger mr-2 py-0 px-2 border border-white">
                            <span class="fa bi-person-x-fill p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Suppr.</small>
                        </span>
                        <span title="Bloquer l'untilisateur {{$u_user->name}}" wire:click="blockAUser({{$u_user->id}})"  class="z-scale py-1 cursor-pointer btn-info z-bg-orange mr-2 py-0 px-2 border border-white">
                            <span class="fa bi-lock p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Bloquer</small>
                        </span>
                        <span  class="z-scale py-1 cursor-pointer btn-primary mr-2 py-0 border border-white px-2">
                            <span class="fa bi-mailbox text-white p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Mail</small>
                        </span>
                        @endisMaster
                    </div>
                </div>
                <hr class="bg-white">
                <div class="w-100 mx-auto d-flex flex-column">
                    <span class="d-flex justify-content-between">
                        <strong class="text-bold text-warning">Sa clé personnelle :</strong>
                        <small class="text-warning">Inscrit {{ $u_user->getDateAgoFormated() }}</small>
                    </span>
                    @if($show_token && $u_u_key == $key)
                    <span wire:click="toogle_u_u({{$key}})" class="z-word-break-break cursor-pointer">
                        {{$u_user->token}}
                    </span>
                    @else
                    <span wire:click="toogle_u_u({{$key}})" class="z-word-break-break cursor-pointer">
                        {{bcrypt($u_user->token)}}
                    </span>
                    @endif
                </div>
                <hr class="bg-white">
                <div class="d-flex w-100 m-0 justify-content-start py-2">
                    <span class="bi-voicemail mr-2 "> : </span>
                    <span>{{$u_user->email}}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
</div>
@endif