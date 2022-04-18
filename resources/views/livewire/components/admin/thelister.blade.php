<div>
    @if ($tag == 'users')
        @if($users->count() > 0)
        <div class="w-100 m-0 p-0 mt-3">
        <table class="w-100 m-0 p-0 table-striped table-bordered z-table text-white">
            <thead class="text-white text-center">
                <th class="py-2 text-center">#ID</th>
                <th class="">Nom</th>
                <th>Email</th>
                <th>Inscrit depuis</th>
                <th>Action</th>
                <th>Status</th> 
            </thead>
            <tbody>
                @foreach($users as $u)
                    <tr>
                        <td class="py-2">{{$u->id}}</td>
                        <td class="text-capitalize">
                            @if($u->current_photo)
                                    <span class="d-flex">
                                    <img width="30" class="border rounded-circle" src="/storage/profilPhotos/{{$u->currentPhoto()}}" alt="mon profil">
                                    <span class="mx-2">{{$u->name}}</span>
                                    @if($u->role == 'admin')
                                        <span class="fa fa-user-secret mt-1 text-white-50 float-right"></span>
                                    @endif
                                    </span>
                            @else
                                <span class="d-flex">
                                    <img width="30" class="border rounded-circle" src="{{$u->currentPhoto()}}" alt="mon profil">
                                    <span class="mx-2">{{$u->name}}</span>
                                    @if($u->role == 'admin')
                                    <span class="fa fa-user-secret text-white-50 mt-1 float-right"></span>
                                    @endif
                                </span>
                            @endif
                        </td>
                        <td>{{$u->email}}</td>
                        <td>{{$u->created_at}}</td>
                        <td class="text-center w-auto p-0">
                            @isNotMaster($u)
                                <span class="row mx-auto w-100 border m-0 p-0">
                                    <span class="text-danger  danger-hover  col-4 p-2 px-3 cursor-pointer border border-danger fa fa-trash"></span>
                                    <span class="text-warning warning-hover col-4 p-2 px-3 cursor-pointer border border-warning fa fa-key"></span>
                                    @isNotAdmin($u)
                                    <form method="POST" class="col-4 p-0 m-0" wire:submit.prevent="updateUserRole({{$u->id}}, 'admin')">
                                        <button class="text-success success-hover m-0 w-100 p-2 px-3 cursor-pointer border border-success fa fa-user-secret"  type="submit"></button>
                                    </form>
                                    @else
                                    <form method="POST" class="col-4 p-0 m-0" wire:submit.prevent="updateUserRole({{$u->id}}, 'user')">
                                        <button class="text-danger danger-hover m-0 w-100 p-2 px-3 cursor-pointer border border-success fa fa-user-secret"  type="submit"></button>
                                    </form>
                                    @endisNotAdmin
                                </span>
                            @else
                            <strong class="text-success">Administrateur principal</strong>
                            @endisNotMaster
                        </td>
                        <td>{{$u->role}}</td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>                                                     
        </div>
        @else
        <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
            <span class="fa fa-warning text-warning fa-4x"></span>
            <h4 class="text-warning fa fa-3x">Ouups aucune données enregistées !!!</h4>
        </div>
        @endif
    @elseif ($tag == 'admins')
        @if($admins->count() > 0)
        <div class="w-100 m-0 p-0 mt-3">
        <table class="w-100 m-0 p-0 table-striped table-bordered z-table text-white">
            <thead class="text-white text-center">
                <th class="py-2 text-center">#ID</th>
                <th class="">Nom</th>
                <th>Email</th>
                <th>Inscrit depuis</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach($admins as $u)
                    <tr>
                        <td class="py-2">{{$u->id}}</td>
                        <td class="text-capitalize">
                            @if($u->current_photo)
                                    <span class="d-flex">
                                    <img width="30" class="border rounded-circle" src="/storage/profilPhotos/{{$u->currentPhoto()}}" alt="mon profil">
                                    <span class="mx-2">{{$u->name}}</span>
                                    @if($u->role == 'admin')
                                        <span class="fa fa-user-secret mt-1 text-white-50 float-right"></span>
                                    @endif
                                    </span>
                            @else
                                <span class="d-flex">
                                    <img width="30" class="border rounded-circle" src="{{$u->currentPhoto()}}" alt="mon profil">
                                    <span class="mx-2">{{$u->name}}</span>
                                    @if($u->role == 'admin')
                                    <span class="fa fa-user-secret text-white-50 mt-1 float-right"></span>
                                    @endif
                                </span>
                            @endif
                        </td>
                        <td>{{$u->email}}</td>
                        <td>{{$u->created_at}}</td>
                        <td class="text-center w-auto p-0">
                            @isNotMaster($u)
                                <span class="row mx-auto w-100 border m-0 p-0">
                                    <span class="text-danger  danger-hover  col-4 p-2 px-3 cursor-pointer border border-danger fa fa-trash"></span>
                                    <span class="text-warning warning-hover col-4 p-2 px-3 cursor-pointer border border-warning fa fa-key"></span>
                                    @isNotAdmin($u)
                                    <form method="POST" class="col-4 p-0 m-0" wire:submit.prevent="updateUserRole({{$u->id}}, 'admin')">
                                        <button class="text-success success-hover m-0 w-100 p-2 px-3 cursor-pointer border border-success fa fa-user-secret"  type="submit"></button>
                                    </form>
                                    @else
                                    <form method="POST" class="col-4 p-0 m-0" wire:submit.prevent="updateUserRole({{$u->id}}, 'user')">
                                        <button class="text-danger danger-hover m-0 w-100 p-2 px-3 cursor-pointer border border-success fa fa-user-secret"  type="submit"></button>
                                    </form>
                                    @endisNotAdmin
                                </span>
                            @else
                            <strong class="text-success">Administrateur principal</strong>
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
            <h4 class="text-warning fa fa-3x">Ouups aucune données enregistées !!!</h4>
        </div>
        @endif
    @elseif ($tag == "categories")
    @if($categories->count() > 0)
    <div class="w-100 m-0 p-0 mt-3">
    <table class="w-100 m-0 p-0 table-striped table-bordered z-table text-white">
        <thead class="text-white text-center">
            <th class="py-2 text-center">#ID</th>
            <th class="">Catégorie</th>
            <th>Description</th>
            <th>Articles</th>
            <th>Vendus</th>
            <th>Action</th>
        </thead>
        <tbody>
            @foreach($categories as $c)
                <tr>
                    <td class="py-2">{{$c->id}}</td>
                    <td class="p-0">
                        <a class="text-white w-100 h-100 d-inline-block py-2 pl-1" href="{{route('category', ['id' => $c->id])}}">
                            {{$c->name}}
                        </a>
                    </td>
                    <td class="p-0">
                        <a class="text-white w-100 h-100 d-inline-block py-2 pl-1" href="{{route('category', ['id' => $c->id])}}">
                            {{ mb_substr($c->description, 0, 27) }} ...
                        </a>
                    </td>
                    <td class="text-center">{{ $c->products->count() }}</td>
                    <td class="text-center">{{ $c->products->count() }}</td>
                    <td class="text-center w-auto p-0">
                        <span class="row mx-auto w-100 border m-0 p-0">
                            <span class="text-danger  danger-hover  col-4 p-2 px-3 cursor-pointer border border-danger fa fa-trash"></span>
                            <span class="text-info  danger-hover  col-4 p-2 px-3 cursor-pointer border border-danger fa fa-trash"></span>
                            <span class="text-warning warning-hover col-4 p-2 px-3 cursor-pointer border border-warning fa fa-key"></span>
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>                                                     
    </div>
    @else
    <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
        <span class="fa fa-warning text-warning fa-4x"></span>
        <h4 class="text-warning fa fa-3x">Ouups aucune données enregistées !!!</h4>
    </div>
    @endif
    @endif
</div>