<div class="m-0 p-0">
    <div class="col-md-12 m-0 p-0">
        <div class="filters-content">
            <div class="row grid">
                @foreach($products as $product)
                    <div class="col-lg-{{$col}} col-md-{{$col}} all des ">
                        <div class="product-item @if(Auth::user() && Auth::user()->__alreadyIntoMyCart($product->id)) shadow @endif">
                            <a href="{{route('product.profil', ['slug' => $product->slug])}}">
                                <img class="z-img-h-250" src="{{$product->__profil()}}" alt="image de l'article {{$product->slug}}">
                            </a>
                                <div class="down-content mx-auto px-lg-1">
                                    <a><h4 class="h6 " title="{{$product->getName()}}">{{mb_substr($product->slug, 0, 15)}} ...</h4></a>
                                    <h6>{{$product->price}} FCFA
                                        @auth
                                            @if(Auth::user()->__alreadyIntoMyCart($product->id))
                                                <strong title="Vous suivez cet article: Vous l'avez ajouté à votre panier" class="text-success bi-cart-check-fill cursor-pointer"></strong>
                                            @endif
                                        @endauth
                                    </h6>
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
                                                    <strong class="mt-1"> {{$product->comments->count()}} </strong>
                                                    <strong class="fa fa-comments mt-1"></strong>
                                                </strong>
                                                <strong class="">
                                                    <strong class="mt-1"> {{$product->mySeens()}} </strong>
                                                    <strong class="fa fa-eye mt-1"></strong>
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row w-100 mx-auto">
                                        <div class="d-flex cursor-pointer justify-content-center col-lg-4 col-xl-4 col-12 mx-auto">
                                            <strong wire:click="likedThis({{ $product->id }})" title="Cliquez pour liker cet article" class="fa fa-heart z-scale text-danger fa-2x"></strong>
                                        </div>
                                        <div class=" d-flex cursor-pointer justify-content-center mt-lg-2 mt-xl-2 mt-3 col-lg-7 col-xl-7 col-12 mx-auto p-0">
                                            <div class="d-flex justify-content-around p-0 m-0 w-100">
                                                @auth
                                                    @if(Auth::user()->__alreadyIntoMyCart($product->id))
                                                        <a wire:click="deleteFromCart({{ $product->id }})" title="Mettre cet article dans mon panier" class="z-scale text-danger text-center w-100">
                                                            <i class="btn-danger py-1 pb-2 px-lg-1 px-xl-1 px-md-1 px-4 w-100 border border-warning"> 
                                                                <small class="w-75 mx-auto text-center d-inline-block">
                                                                    <small class="fa bi-minecart"></small>
                                                                    <small class="d-xl-inline">Retirer</small>
                                                                </small>
                                                            </i>
                                                        </a>
                                                    @else
                                                        <a title="Mettre cet article dans mon panier" wire:click="addToCart({{ $product->id }})" class="z-scale text-danger text-center w-100">
                                                            <i class="btn-success py-1 pb-2 px-lg-1 px-xl-1 px-md-1 px-4 w-100 border"> 
                                                                <small class="w-75 mx-auto text-center d-inline-block">
                                                                    <small class="fa bi-minecart"></small>
                                                                    <small class="d-xl-inline">Panier</small>
                                                                </small>
                                                            </i>
                                                        </a>
                                                    @endif
                                                @endauth
                                                @guest
                                                    <a title="Mettre cet article dans mon panier" wire:click="addToCart({{ $product->id }})" class="z-scale text-danger text-center w-100">
                                                        <i class="btn-success py-1 pb-2 px-lg-1 px-xl-1 px-md-1 px-4 w-100 border"> 
                                                            <small class="w-75 mx-auto text-center d-inline-block">
                                                                <small class="fa bi-minecart"></small>
                                                                <small class="d-xl-inline">Panier</small>
                                                            </small>
                                                        </i>
                                                    </a>  
                                                @endguest
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>