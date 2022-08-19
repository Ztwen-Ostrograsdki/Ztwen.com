<div>
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
                    <div class="col-12 mx-auto m-0 px-1">
                        <div class="filters-content m-0 p-0">
                            <h6 class="m-0 my-2 py-2 px-1 d-flex justify-content-between border rounded z-bg-hover-secondary border-white mx-auto" >
                                <span>
                                    Les articles récents <span class="bi-cart mx-1"></span>
                                </span>
                                <a class="text-orange" href="{{route('products')}}">Voir tous <i class="bi-cart-plus mx-1"></i></a>
                            </h6>
                            <div class="m-0 p-0">
                                @livewire('show-products', [
                                    'scroll'    => false,
                                    'onHome'    => true
                                ])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="p-0 m-0">
        {{-- THE LAST COMMENTS --}}
        @if($lastComments > 0)
        <div class="container">
            <div class="row mb-0 p-0 mb-2">
                <div class="col-12 mx-auto m-0 px-1">
                    <div class="m-0 p-0 my-1">
                        <h6 class="m-0 py-2 px-1 border rounded z-bg-hover-secondary border-white w-100" >Les Derniers Commentaires <span class="fa fa-comment-o"></span></h6>
                    </div>
                    <div>
                        @livewire('comments-lister', 
                        [
                            'target' => 'last',
                            'limit' => 3
                        ]
                        )
                    </div>
                </div>
            </div>
        </div>
        @endif
        {{-- THE END OF LAST COMMENTS --}}
        <h6 class="text-dark w-100 text-center">
            <strong>@@@@</strong>
        </h6>

        <div class="container">
            <div class="col-12 mx-auto m-0 px-1">
                <div class="m-0 p-0 my-1">
                    <h6 class="m-0 py-2 px-1 border rounded z-bg-hover-secondary border-white w-100" >
                        Nos activités et nos stats <span class="bi-activity mx-1"></span>
                    </h6>
                </div>
                <div class="row mb-0 mt-2 p-0 py-2">
                    <div class="col-md-6">
                        <div class="left-content">
                            <h6><strong class="text-orange cursor-pointer">ZtweN.com</strong> est l'un des meilleurs spécialisés dans la vente et l'achat d'articles de tout genre et toute catégorie. 
                                <strong class="text-primary cursor-pointer">Envoyez-moi</strong> un mail pour plus d'infos
                            </h6>
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
                            @guest
                                <a href="{{route('registration')}}" class="border border-dark bg-orange btn text-dark w-100">
                                    <strong>S'abonner maintenant à ZtweN.com  <span class="bi-person-workspace "></span> </strong>
                                </a>
                            @endguest
                            @auth
                            <a href="{{route('registration')}}" class="border border-dark bg-orange btn text-dark w-100">
                                <strong>S'abonner maintenant à ZtweN.com  <span class="bi-person-workspace "></span> </strong>
                            </a> 
                            @endauth
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="right-image">
                            <img src="myassets/stats/stats-0.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>