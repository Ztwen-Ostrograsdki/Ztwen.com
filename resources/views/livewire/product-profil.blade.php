<div wire:ignore.self class="m-0 p-0  @isNotRoute('product-profil') modal fade @endisNotRoute" id="productProfilModal" role="dialog" tabindex="-1" aria-labelledby="productProfilModalTitle" >
    <div class="modal-dialog modal-z-xlg m-0 mx-auto" role="document">
       <!-- Modal content-->
        <div class="modal-content" style="position: absolute; top:100px; z-index: 1000">
            <div class="modal-header">
                <div class="d-flex justify-content-between w-100">
                    @if(isset($product))
                        <h5 class="text-capitalize  mr-2 mt-1 modal-title" id="productProfilModalTitle">
                            Profil de l'article <span class="text-warning">{{ $product->getName() ?? 'En cours...'}}</span>
                        </h5>
                    @else
                        <span class="ml-3 text-warning text-capitalize text-italic" >Chargement en cours, veuillez patienter...</span>
                    @endif
                    <div class="d-flex justify-content-end w-20">
                        <div class="w-15 mx-0 px-0">
                                <ul class="d-flex mx-0 px-0 mt-1 justify-content-between w-100">
                                <li class=" mx-1"><a href="#"><img src="/images/flag-up-1.png" width="100" alt="" /> </a></li>
                                <li><a href="#"><img src="/images/flag-up-2.png" width="100" alt="" /></a></li>
                                </ul>
                        </div>
                        <div class="w-25"></div>
                    </div>
                </div>
            </div>
            @if(isset($product))
            <div class="modal-body m-0 p-0 border border-warning" @isRoute('product-profil') @endisRoute>
                <div class="page-wrapper bg-gra-01 font-poppins">
                    <div class="wrapper wrapper--w780 ">
                        <div class="card card-3 border border-danger w-100 p-0 m-0">
                            <div class="m-0 p-0 w-100 row">
                                @if($updating !== true)
                                    <div class="text-white bg-white col-md-12 col-lg-5 col-xl-5 col-12 border m-0 p-0">
                                        @if($product->images->count() > 0 && $galery !== [])
                                        <div id="productProfilImagesCarouselTrue" class="carousel slide m-0" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                @foreach ($galery as $key => $image)
                                                    <li data-target="#productProfilImagesCarouselTrue" data-slide-to="{{$key}}" class="@if($key == 0)active @endif"></li>
                                                @endforeach
                                            </ol>
                                            <div class="carousel-inner">
                                                @foreach ($galery as $key => $image)
                                                    <div class="carousel-item @if($key == 0)active @endif">
                                                        <img class="d-block w-100" src="/storage/articlesImages/{{$image->name}}" alt="slide-{{$key}}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <a class="carousel-control-prev" href="#productProfilImagesCarouselTrue" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#productProfilImagesCarouselTrue" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                        @elseif($product->images->count() < 1 || $galery == [])
                                        <div id="productProfilImagesCarouselFalse" class="carousel slide m-0" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                @foreach ($galery as $key => $image)
                                                    <li data-target="#productProfilImagesCarouselFalse" data-slide-to="{{$key}}" class="@if($key == 0)active @endif"></li>
                                                @endforeach
                                            </ol>
                                            <div class="carousel-inner">
                                                @foreach ($galery as $key => $image)
                                                    <div class="carousel-item @if($key == 0)active @endif">
                                                        <img class="d-block w-100" src="{{$image}}" alt="slide-{{$key}}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <a class="carousel-control-prev" href="#productProfilImagesCarouselFalse" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#productProfilImagesCarouselFalse" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                        @else
                                        <div id="productProfilImagesCarouselFalse" class="carousel slide m-0" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                    <li data-target="#productProfilImagesCarouselFalse" data-slide-to="{{$key}}" class="@if($key == 0)active @endif"></li>
                                            </ol>
                                            <div class="carousel-inner">
                                                    <div class="carousel-item @if($key == 0)active @endif">
                                                        <img class="d-block w-100" src="{{$image}}" alt="slide-{{$key}}">
                                                    </div>
                                            </div>
                                            <a class="carousel-control-prev" href="#productProfilImagesCarouselFalse" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#productProfilImagesCarouselFalse" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                        @endif
                                        <div class="m-0 w-100 border border-dark">
                                            <div class="w-100 p-0 m-0 p-2">
                                                <div class="d-flex justify-content-betwween w-100 m-0 p-0 mx-auto">
                                                    <div class="d-flex flex-column justify-center col-3 text-danger">
                                                    <div class="mx-auto w-100 d-flex justify-content-center">
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                            <span class="fa fa-star"></span>
                                                    </div>
                                                        <div class="mx-auto w-100 d-flex justify-content-center">
                                                            <span wire:click="liked" title="Cliquez pour liker cet article" class="cursor-pointer fa fa-heart z-scale text-danger fa-2x"></span>
                                                        </div>
                                                    </div>
                                                    <div class="m-0 p-0 col-9" >
                                                        <div class="m-0 p-0 d-flex justify-content-end w-100 text-danger">
                                                            <strong>
                                                                <strong class="mt-1"> {{$product->likes->count()}}</strong>
                                                                <strong class="fa fa-heart mt-1"></strong>
                                                            </strong>
                                                            <strong class="mx-3">
                                                                <strong class="mt-1"> {{$product->comments->count()}} </strong>
                                                                <strong class="fa fa-comments mt-1"></strong>
                                                            </strong>
                                                            <strong class="">
                                                                <strong class="mt-1"> {{$product->seen}} </strong>
                                                                <strong class="fa fa-eye mt-1"></strong>
                                                            </strong>
                                                        </div>
                                                        <div class="w-100 d-flex justify-content-end pt-1">
                                                            @if(isset($product))
                                                                <small class="text-secondary">Posté {{ $product->dateAgoToString }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-12 text-center col-lg-5 col-xl-5 col-12 border m-0 p-0 bg-secondary">
                                        <h5 class="text-center text-uppercase p-2 w-75 fa-2x">
                                            <span class="fa fa-download m-1"></span>Mise à jour en cours...
                                        </h5>                                    
                                    </div>
                                @endif
                                <div class="border-bottom border-dark bg-white w-100 d-block d-lg-none d-xl-none">
                                    <span class="w-100 p-2"></span>
                                </div>
                                <div class="bg-secondary text-dark col-md-12 col-lg-7 col-xl-7 col-12 m-0 p-0">
                                    <table class="w-100 p-0 m-0" style="height: 70px;">
                                        <div class="w-100 m-0 p-2">
                                            <h4 class="text-center p-2 text-uppercase">{{ $product->getName() }}</h4>
                                            <hr class="m-0 p-0 bg-white">
                                        </div>
                                        <div class="w-100 m-0 p-0">
                                            <div class="container w-75 m-0 mx-auto">
                                                <div class="row text-center text-capitalize">
                                                    <div class="col-6 d-flex flex-column">
                                                        <h5>
                                                            <strong>Prix :</strong>  <span>{{ $product->price }} FCFA</span>
                                                        </h5>
                                                        <h5>
                                                            <strong>Total :</strong>  <span> {{$product->total}} </span>
                                                        </h5>
                                                    </div>
                                                    <div class="col-6 d-flex flex-column">
                                                        <h5>
                                                            <strong>Total Vendu :</strong>  <span> {{$product->sells}} </span>
                                                        </h5>
                                                        <h5>
                                                            <strong>Réduction :</strong>  <span>{{rand(1, 30)}} %</span>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="m-0 p-0 bg-white mx-2 mt-1">
                                            <div class="container w-100 m-0" style="max-height: 350px; overflow: auto">
                                                <p>
                                                    {{$product->description}}
                                                </p>
                                            </div>
                                        </div>
                                        <td class="w-100 m-0 p-0 align-bottom">
                                            <div class="container col-11 d-flex justify-content-end pb-2">
                                                <span class="z-scale py-1 cursor-pointer btn-primary py-0 px-3 border border-white">
                                                    <span class="bi-download p-0 m-0"></span> <small>Acheter</small>
                                                </span>
                                                <span class="z-scale py-1 cursor-pointer btn-primary mx-2 px-3 border border-white">
                                                    <span class="bi-minecart "></span> <small>Panier</small>
                                                </span>
                                                <span wire:click="updategalery" class="z-scale cursor-pointer py-1 btn-primary px-3 border border-white">
                                                    <span class="bi-image"></span> <small>Ajouter une image</small>
                                                </span>
                                            </div>
                                        </td>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @else
                @include('components.mycomponents.product-profil-loader')
            @endif
        </div>
    </div>
 </div>