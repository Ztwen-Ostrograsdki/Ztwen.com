<div class="w-100 m-0 p-0" >
    @foreach ($comments as $key => $com)
    <div class="w-100 mx-auto p-0 border my-3 z-bg-hover-secondary rounded">
        <div class="row m-0 mx-auto p-0 w-100">
            <div class="col-xl-3 col-xxl-3 col-lg-3 col-md-3 d-none d-md-block d-xxl-block d-xl-block d-lg-block p-0 m-0 border-right">
                <img class="w-100 h-100" src="{{$com->product->__profil()}}" alt="image de l'article {{$com->product->slug}}">
            </div>
            <div class="col-12 col-xl-9 col-xxl-9 col-lg-9 col-md-9">
                <div class="w-100 m-0 p-0 py-1 d-flex justify-content-between">
                    <div class="m-0 p-0 py-1 d-flex justify-content-between">
                        <h6 class="text-center p-0 m-0">
                            <span class="d-flex">
                                Posté par : 
                                <img width="22" class="border rounded-circle ml-1" src="{{$com->user->__profil('110')}}" alt="Le profil du poster">
                                <span class="mx-2 text-uppercase">{{$com->user->name}}</span>
                                @if($com->user->role == 'admin')
                                    <span class="fa fa-user-secret mt-1 @isMaster($com->user) text-warning @else text-white-50 @endisMaster float-right"></span>
                                @endif
                            </span>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-start">
                        @isAdmin()
                            <small title="Bloquer l'untilisateur {{$com->user->name}} poster de ce commentaire" wire:click="blockAUser({{$com->user->id}})"  class="z-scale py-1 cursor-pointer btn-danger mr-2 py-0 px-2 border border-white">
                                <span class="fa bi-person-x-fill p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Bloquer</small>
                            </small>
                            <small  class="z-scale py-1 cursor-pointer btn-success mr-2 py-0 border border-white px-2">
                                <span class="fa bi-chat text-white p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Chat</small>
                            </small>
                            <small wire:click="editAProduct({{$com->product->id}})"  class="z-scale py-1 cursor-pointer btn-secondary mr-2 py-0 px-2 border border-white">
                                <span class="fa fa-edit p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Editer</small>
                            </small>
                            @if(!$com->approved)
                            <small id="approvedButton" wire:click="approvedAComment({{$com->id}})" title="Approuver ce commentaire poster par {{$com->user->name}}" class="z-scale py-1 cursor-pointer btn-white mr-2 py-0 px-2 border border-white">
                                <span class="fa bi-shield-check text-success p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Approuver</small>
                            </small>
                            @endif
                            <small wire:click="deleteAComment({{$com->id}})" title="Supprimer ce commentaire poster par {{$com->user->name}}" class="z-scale py-1 cursor-pointer btn-danger mr-2 py-0 px-2 border border-white">
                                <span class="fa text-white bi-trash2-fill  p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Suppr.</small>
                            </small>
                        @endisAdmin
                    </div>
                </div>
                <hr class="bg-white">
                <div class="w-100 mx-auto d-flex justify-content-between">
                    <span>
                        <span class="d-flex justify-content-between">
                            <strong class="text-bold">Article : </strong>
                            <a class="text-white d-inline-block pl-1" href="{{route('product.profil', ['slug' => $com->product->slug])}}">
                                <span class="text-capitalize text-info"> {{ $com->product->getName() }}</span>
                            </a>
                            @isAdmin()
                                <span class="fa fa-edit mt-1 ml-3 cursor-pointer" title="Editer cet article" wire:click="editAProduct({{$com->product->id}})"></span>
                            @endisAdmin
                        </span>
                    </span>
                </div>
                <hr class="bg-white">
                <div class="w-100 mx-auto d-flex flex-column">
                    <span class="d-flex justify-content-between">
                        <strong class="text-bold text-warning">Contenu du commentaire :</strong>
                    </span>
                    <span class="z-word-break-break">
                        {{$com->content}}
                    </span>
                </div>
                <hr class="bg-white">
                @auth
                    @isMaster()
                        <div class="d-flex w-100 m-0 justify-content-between">
                            <span>
                                <strong>Prix: </strong> <span>{{$com->product->price}}</span>
                            </span>
                            <span>
                                <strong>Total: </strong> <span>{{$com->product->total}}</span>
                            </span>
                            <span>
                                <strong>vendus: </strong> <span>{{$com->product->sells}}</span>
                            </span>
                            <span>
                                <strong>Reduction: </strong> <span>{{$com->product->reduction}}</span> <span>%</span>
                            </span>
                        </div>
                    @endisMaster
                @endauth
                <div class="d-flex justify-content-between m-0 w-100 text-danger">
                    <div class="d-flex justify-content-start m-0 text-danger w-auto">
                        <strong>
                            <strong class="mt-1"> {{$com->product->likes->count()}}</strong>
                            <strong class="fa fa-heart mt-1"></strong>
                        </strong>
                        <strong class="mx-1">
                            <strong class="mt-1"> {{$com->product->comments->count()}} </strong>
                            <strong class="fa fa-comments mt-1"></strong>
                        </strong>
                        <strong class="">
                            <strong class="mt-1"> {{$com->product->seen}} </strong>
                            <strong class="fa fa-eye mt-1"></strong>
                        </strong>
                        <span class="mx-1">
                            <strong class="text-white-50"> || Catégorie : </strong>
                            <a class="text-white d-inline-block pl-1" href="{{route('category.profil', ['slug' => $com->product->category->getSlug()])}}">
                                <span class="text-uppercase z-text-cyan"> {{ $com->product->category->name }}</span>
                            </a>
                            @isAdmin()
                                <span class="fa fa-edit text-white-50 mt-1 ml-1 cursor-pointer" title="Editer cette catégorie" wire:click="editACategory({{$com->product->category->id}})"></span>
                            @endisAdmin
                        </span>
                    </div>
                    <div class="d-flex justify-content-around m-0">
                        <span>
                            <small class="text-white-50 mt-2 mx-2">
                                <small class="text-warning">Posté {{ $com->getDateAgoFormated() }}</small>
                            </small>
                            @if($com->approved)
                                <span style="font-size: 12px" class="bi-check-all text-success"></span>
                            @endif
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endforeach
</div>
