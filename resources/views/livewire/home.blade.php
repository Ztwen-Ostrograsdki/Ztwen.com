<!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="banner header-text">
        <div class="owl-banner owl-carousel">
          <div class="banner-item-01">
            <div class="text-content">
              <h4>
                <span class="fa fa-cart-shopping"></span>
                Des articles, des offres
              </h4>
              <h2>Nouvels arrivages</h2>
            </div>
          </div>
          <div class="banner-item-02">
            <div class="text-content">
                <h4>
                    <span class="fa fa-cart-plus"></span>
                    Des articles de grandes classes
                </h4>
              <h2>Choisir tes meilleurs articles</h2>
            </div>
          </div>
          <div class="banner-item-03">
            <div class="text-content">
              <h4>
                <span class="fa bi-clock"></span>
                Dernières minutes
              </h4>
              <h2>L'heure tourne</h2>
            </div>
          </div>
        </div>
      </div>
      <!-- Banner Ends Here -->
  
      <div class="latest-products">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="section-heading m-0 p-0 mb-2">
                <h2 class="m-0 p-0 my-1">Les articles récents</h2>
                <a href="{{route('products')}}">Voir tous les articles <i class="fa fa-angle-right"></i></a>
              </div>
              @if($allProducts->count() > 0)
                <div class="col-md-12">
                    <div class="filters-content m-0 p-0">
                        <div class="row grid m-0 p-0">
                            @foreach($products as $product)
                                <div class="col-lg-4 col-md-4 all des">
                                    <div class="product-item">
                                        <a wire:click="setTargetedProduct({{$product->id}})" title="Cliquez pour charger l'article {{ $product->slug }}" href="{{route('product-profil', ['id' => $product->id])}}">
                                            @if($product->images->count() > 0)
                                                <img class="z-img-h-250" src="/storage/articlesImages/{{$product->getProductDefaultImageInGalery()}}" alt="image de l'article {{$product->slug}}">
                                            @else
                                                <img class="z-img-h-250" src="{{$product->getRandomDefaultImage()}}" alt="image de l'article {{$product->slug}}">
                                            @endif
                                        </a>
                                            <div class="down-content mx-auto px-lg-1">
                                                <a ><h4>{{mb_substr($product->slug, 0, 15)}} ...</h4></a>
                                                <h6>{{$product->price}}
                                                    @auth
                                                        @if(Auth::user()->alreadyIntoCart($product->id))
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
                                                    <div class=" d-flex cursor-pointer justify-content-center mt-lg-2 mt-xl-2 mt-3 col-lg-7 col-xl-7 col-12 mx-auto p-0">
                                                        <div class="d-flex justify-content-around p-0 m-0 w-100">
                                                            <a style="width: 45%" href="{{route('product-profil', ['id' => $product->id])}}" class="z-scale text-danger text-center">
                                                                <i class="btn-primary py-1 pb-2 px-lg-1 px-xl-1 px-md-1 px-4 w-100 border"> 
                                                                    <small class="w-75 mx-auto text-center d-inline-block">
                                                                        <small class="fa fa-chevron-down"></small>
                                                                        <small class="d-xl-inline">Voir plus</small>
                                                                    </small>
                                                                </i>
                                                            </a>
                                                            @auth
                                                                @if(Auth::user()->alreadyIntoCart($product->id))
                                                                    <a wire:click="deleteFromCart({{ $product->id }})" title="Mettre cet article dans mon panier" style="width: 45%" class="z-scale text-danger text-center">
                                                                        <i class="btn-danger py-1 pb-2 px-lg-1 px-xl-1 px-md-1 px-4 w-100 border border-warning"> 
                                                                            <small class="w-75 mx-auto text-center d-inline-block">
                                                                                <small class="fa bi-minecart"></small>
                                                                                <small class="d-xl-inline">Retirer</small>
                                                                            </small>
                                                                        </i>
                                                                    </a>
                                                                @else
                                                                    <a title="Mettre cet article dans mon panier" style="width: 45%" wire:click="addToCart({{ $product->id }})" class="z-scale text-danger text-center">
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
                                                                <a title="Mettre cet article dans mon panier" style="width: 45%" wire:click="addToCart({{ $product->id }})" class="z-scale text-danger text-center">
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
                @else
                <div class="d-flex flex-column mx-auto text-center border border-danger p-3 my-2">
                    <span class="fa fa-warning text-danger fa-4x"></span>
                    <h4 class="text-danger fa fa-2x">Ouups aucun article n'a encore été posté !!!</h4>
                </div>
                @endif
            </div>
          </div>
        </div>
      </div>
      <div class="pb-0">
        {{-- THE LAST COMMENTS --}}
        @if($lastComments->count() > 0)
        <div class="container">
          <div class="row mb-0 p-0 mb-2">
            <div class="col-md-12">
                <div class="section-heading m-0 p-0 my-1">
                    <h3  class="m-0 p-0" >Les Derniers Commentaires <span class="fa fa-comment-o"></span></h3>
                </div>
            </div>
            <div class="col-12">
                <div>
                    @include('livewire.components.commentsCardsComponents', 
                    [
                    'comments' => $lastComments
                    ])
                </div>
            </div>
          </div>
        </div>
        @endif
        {{-- THE END OF LAST COMMENTS --}}
        <div class="container">
          <div class="row mb-0 p-0 py-2 mb-2">
            <div class="col-md-12">
              <div class="section-heading">
                A propos <h2  class="" >ZtweN <em>Oströgrasdki</em> <small class="text-lowercase text-muted"><sup>market</sup></small> </h2>
              </div>
            </div>
            <div class="col-md-6">
              <div class="left-content">
                <h4>Suivre le meilleur des articles</h4>
                <p><a rel="nofollow" href="#" target="_parent">Ce site</a> est l'un des meilleurs spécialisés dans la vente et l'achat d'article de tous genre et toute catégorie. <a href="">Contactez-moi</a> pour plus d'infos</p>
                <ul class="">
                  <li>
                    <strong class="fa fa-check"></strong>
                    <span>Plus de <strong>15 000</strong> articles plubliés par semaine</span>
                  </li>
                  <li>
                    <strong class="fa fa-check"></strong>
                    <span>Plus de <strong>2 millions</strong> d'abonnés </span>
                  </li>
                  <li>
                    <strong class="fa fa-check"></strong>
                    <span>plus de <strong>10 000</strong> articles vendus par semaines</span>
                  </li>
                  <li>
                    <strong class="fa fa-check"></strong>
                    <span>Activités <strong>7jrs/7 et 24H/24</strong></span>
                  </li>
                  <li>
                    <strong class="fa fa-check"></strong>
                    <span>Vos choix et vos préférences</span>
                  </li>
                </ul>
                <a href="{{route('about')}}" class="filled-button">Voir plus</a>
              </div>
            </div>
            <div class="col-md-6">
              <div class="right-image">
                <img src="myassets/images/feature-image.jpg" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="call-to-action m-0 p-0">
        <div class="container">
          <div class="row py-0 ">
            <div class="col-md-12 ">
              <div class="inner-content m-0 mb-2  border border-dark">
                <div class="d-flex justify-content-between bg-secondary border rounded px-2 py-2">
                  <div class="">
                    <h4 class="text-white" >ZtweN <em>Oströgrasdki</em> <small class="text-lowercase text-white-50"><sup>market</sup></small> </h4>
                    <h5 class="text-white">
                      La technologie du buziness!!!
                    </h5>
                  </div>
                  <div class="">
                    <div class="w-100 d-flex flex-column justify-content-center text-center">
                      <h5 class="w-100 py-2">L'auteur : <br>
                        <hr class="my-1 bg-white">
                        <strong>Kouassi Vincent HOUNDEKINDO</strong>
                      </h5>
                      <img class="text-center mx-auto border shadow" width="200" src="myassets/author/img-1.jpg" alt="l'auteur">
                    </div>
                  </div>
                  <div class="">
                    <a href="#" class="filled-button">S'abonner maintenant</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  