@if($comments->count() > 0)
<div class="w-100 m-0 p-0">
    @foreach ($comments as $key => $com)
        
    <div class="w-100 mx-auto p-0 border mb-2 z-bg-hover-secondary">
        <div class="row m-0 mx-auto p-0 w-100">
            <div class="col-3 p-0 m-0 border-right">
                @if($com->product->images->count() > 0)
                    <img height="auto" class="w-100 h-100" src="/storage/articlesImages/{{$com->product->getProductDefaultImageInGalery()}}" alt="image de l'article {{$com->product->slug}}">
                @else
                    <img class="w-100 h-100" src="{{$com->product->getRandomDefaultImage()}}" alt="image de l'article {{$com->product->slug}}">
                @endif
            </div>
            <div class="col-9">
                <div class="w-100 m-0 p-0 py-1 d-flex justify-content-between">
                    <h4 class="text-center text-uppercase py-1 w-33">
                        @if($com->user->current_photo)
                        <span class="d-flex">
                            <img width="45" class="border rounded-circle" src="/storage/profilPhotos/{{$com->user->currentPhoto()}}" alt="Le profil du poster">
                            <span class="mx-2">{{$com->user->name}}</span>
                            @if($com->user->role == 'admin')
                                <span class="fa fa-user-secret mt-1 @isMaster($com->user) text-warning @else text-white-50 @endisMaster float-right"></span>
                            @endif
                        </span>
                    @else
                        <span class="d-flex">
                            <img width="45" class="border rounded-circle" src="{{$com->user->currentPhoto()}}" alt="mon profil">
                            <span class="mx-2">{{$com->user->name}}</span>
                            @if($com->user->role == 'admin')
                            <span class="fa fa-user-secret @isMaster($com->user) text-warning @else text-white-50 @endisMaster mt-1 float-right"></span>
                            @endif
                        </span>
                    @endif
                    </h4>
                    <div class="d-flex justify-content-start">
                        @isAdmin()
                        <span wire:click="blockAUser({{$com->user->id}})"  class="z-scale py-1 cursor-pointer btn-danger mr-2 py-0 px-2 border border-white">
                            <span class="fa bi-person-x-fill p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Bloquer</small>
                        </span>
                        <span  class="z-scale py-1 cursor-pointer btn-success mr-2 py-0 border border-white px-2">
                            <span class="fa bi-chat text-white p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Chat</small>
                        </span>
                        <span wire:click="editAProduct({{$com->product->id}})"  class="z-scale py-1 cursor-pointer btn-secondary mr-2 py-0 px-2 border border-white">
                            <span class="fa fa-edit p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Editer</small>
                        </span>
                        <span class="z-scale py-1 cursor-pointer btn-white mr-2 py-0 px-2 border border-white">
                            <span class="fa bi-shield-check text-success p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Approuver</small>
                        </span>
                        <span class="z-scale py-1 cursor-pointer btn-danger mr-2 py-0 px-2 border border-white">
                            <span class="fa text-white fa-lock-o p-0 m-0"></span> <small class="d-none d-lg-inline d-xlg-inline d-md-inline">Refuser</small>
                        </span>
                        @endisAdmin
                    </div>
                </div>
                <hr class="bg-white">
                <div class="w-100 mx-auto d-flex justify-content-between">
                    <span>
                        <span class="d-flex justify-content-between">
                            <strong class="text-bold">Article : </strong>
                            <a class="text-white d-inline-block pl-1" href="{{route('product-profil', ['id' => $com->product->id])}}">
                                <span class="text-capitalize text-info"> {{ $com->product->getName() }}</span>
                            </a>
                            @isAdmin()
                                <span class="fa fa-edit mt-1 ml-3 cursor-pointer" title="Editer cet article" wire:click="editAProduct({{$com->product->id}})"></span>
                            @endisAdmin
                        </span>
                    </span>
                    <span>
                        <span class="d-flex justify-content-between">
                            <strong class="text-bold">Catégorie : </strong>
                            <a class="text-white d-inline-block pl-1" href="{{route('category', ['id' => $com->product->category->id])}}">
                                <span class="text-secondary text-uppercase text-success"> {{ $com->product->category->name }}</span>
                            </a>
                            @isAdmin()
                                <span class="fa fa-edit mt-1 ml-3 cursor-pointer" title="Editer cette catégorie" wire:click="editACategory({{$com->product->category->id}})"></span>
                            @endisAdmin
                        </span>
                    </span>
                </div>
                <hr class="bg-white">
                <div class="w-100 mx-auto d-flex flex-column">
                    <span class="d-flex justify-content-between">
                        <strong class="text-bold text-warning">Contenu du commentaire :</strong>
                        <small class="text-warning">Commentaire posté {{ $com->getDateAgoFormated() }}</small>
                    </span>
                    <span>
                        {{$com->content}}
                    </span>
                </div>
                <hr class="bg-white">
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
                <div class="d-flex justify-content-between m-0 w-100 text-danger">
                    <div class="d-flex justify-content-end m-0 text-danger">
                        <strong>
                            <strong class="mt-1"> {{$com->product->likes->count()}}</strong>
                            <strong class="fa fa-heart mt-1"></strong>
                        </strong>
                        <strong class="mx-3">
                            <strong class="mt-1"> {{$com->product->comments->count()}} </strong>
                            <strong class="fa fa-comments mt-1"></strong>
                        </strong>
                        <strong class="">
                            <strong class="mt-1"> {{$com->product->seen}} </strong>
                            <strong class="fa fa-eye mt-1"></strong>
                        </strong>
                    </div>
                    <div class="d-flex justify-content-end m-0">
                        <small class="text-white-50 mt-2">
                            Article éditée {{ $com->product->getDateAgoFormated() }}
                        </small>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endforeach
</div>
@endif