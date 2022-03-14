<div>
    <div class="page-heading products-heading header-text">
        <div class="container">
        <div class="row">
            <div class="col-md-12">
            <div class="text-content">
                <h4>nouvel arrivage</h4>
                <h2>Les articles à la une</h2>
            </div>
            </div>
        </div>
        </div>
    </div>
        <div class="products">
        <div class="container">
            <div class="row">
            <div class="col-md-12">
                <div class="filters">
                <ul>
                    <li class="active" data-filter="*">Tous les articles</li>
                    <li data-filter=".des">Les profits</li>
                    <li data-filter=".dev">Flash trocs</li>
                    <li data-filter=".gra">Les dernières minutes</li>
                </ul>
                </div>
            </div>
            <div class="col-md-12">
                <div class="filters-content">
                    <div class="row grid">
                        @foreach($products as $product)
                            <div class="col-lg-4 col-md-4 all des">
                                <div class="product-item">
                                    <a title="Cliquez pour charger l'article {{ $product->slug }}" wire:click="setTargetedProduct({{$product->id}})" class="cursor-pointer " data-dismiss="modal" data-target="#productProfilModal" data-toggle="modal">
                                        @if($product->images->count() > 0)
                                            <img class="z-img-h-250" src="/storage/articlesImages/{{$product->getProductDefaultImageInGalery()}}" alt="image de l'article {{$product->slug}}">
                                        @else
                                            <img class="z-img-h-250" src="{{$product->getRandomDefaultImage()}}" alt="image de l'article {{$product->slug}}">
                                        @endif
                                    </a>
                                        <div class="down-content mx-auto px-lg-1">
                                            <a ><h4>{{mb_substr($product->slug, 0, 15)}} ...</h4></a>
                                            <h6>{{$product->price}}</h6>
                                            <p class="px-1">
                                                {{$product->description}}
                                            </p>
                                            <div class="d-flex justify-content-betwween w-100 m-0 p-0 mx-auto">
                                                <ul class="col-lg-5 col-xl-5 d-xl-inline-block d-lg-inline-block d-none">
                                                    <li><i class="fa fa-star"></i></li>
                                                    <li><i class="fa fa-star"></i></li>
                                                    <li><i class="fa fa-star"></i></li>
                                                    <li><i class="fa fa-star"></i></li>
                                                    <li><i class="fa fa-star"></i></li>
                                                </ul>
                                                <div class="m-0 p-0 col-lg-7 col-xl-7 px-xl-2 pr-xl-2 px-lg-2 pr-lg-2 col-12">
                                                    <div class="m-0 p-0 d-flex justify-content-lg-end justify-content-xl-end justify-content-center w-100 text-danger">
                                                        <strong>
                                                            <strong class="mt-1"> {{$product->likes->count()}} </strong>
                                                            <strong class="fa fa-heart mt-1"></strong>
                                                        </strong>
                                                        <strong class="mx-3">
                                                            <strong class="mt-1"> {{$allProductsComments[$product->id]->count()}} </strong>
                                                            <strong class="fa fa-comments mt-1"></strong>
                                                        </strong>
                                                        <strong class="">
                                                            @if($targetedProduct && $targetedProductSeens && $targetedProduct->id == $product->id)
                                                                <strong class="mt-1"> {{$targetedProductSeens}} </strong>
                                                            @else
                                                                <strong class="mt-1"> {{$product->mySeens()}} </strong>
                                                            @endif
                                                            <strong class="fa fa-eye mt-1"></strong>
                                                        </strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row w-100 mx-auto">
                                                <div class="d-flex cursor-pointer justify-content-center col-lg-4 col-xl-4 col-12 mx-auto">
                                                    <strong wire:click="liked({{ $product->id }})" title="Cliquez pour liker cet article" class="fa fa-heart z-scale text-danger fa-2x"></strong>
                                                </div>
                                                <div class="d-flex cursor-pointer justify-content-center mt-lg-2 mt-xl-2 mt-3 col-lg-7 col-xl-7 col-12 mx-auto">
                                                    <a href="{{route('product-profil', ['id' => $product->id])}}" wire:click="liked({{ $product->id }})" class="ml-3 z-scale text-danger">
                                                        <small class="btn-primary p-2 px-lg-4 px-xl-4 px-md-2 px-4 border"> 
                                                            <small class="fa fa-chevron-down"></small>
                                                            <small>Voir plus</small>
                                                         </small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-12 ">
                <ul class="pages mb-3">
                    @if($minPage > 0)
                        <span>
                            <li wire:click="decreasePage()">
                            <a>
                                <i class="fa fa-angle-double-left"></i>
                            </a>
                            </li>
                        </span>
                    @endif
                    @foreach ($pages as $page)
                        @if($page + 1 <= $maxPage && $page + 1 > $minPage)
                            <li class="@if($active_page == $page) active @endif cursor-pointer" ><a wire:click="setActivePage({{$page}})" class="" >{{$page + 1}}</a></li>
                        @endif
                    @endforeach
                    @if($maxPage < count($pages))
                        <li wire:click="increasePage()"><a><i class="fa fa-angle-double-right"></i></a></li>
                    @endif
                </ul>
            </div>
            </div>
        </div>
    </div>
</div>