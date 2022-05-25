<header class="yours @fixedHeaderForRoute() position-fixed @endfixedHeaderForRoute" style="z-index:2000;" >
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="{{route('home')}}"><h2>ZtweN <em>Oströgrasdki</em> <small class="text-lowercase text-muted"><sup>market</sup></small> </h2></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
              @isRoute('home')
                  <li class="nav-item active cursor-pointer">
                      <a class="nav-link" href="{{route('home')}}">Acceuil
                        <span class="sr-only">(current)</span>
                      </a>
                  </li> 
              @else
                  <li class="nav-item cursor-pointer">
                      <a class="nav-link" href="{{route('home')}}">Acceuil
                        <span class="sr-only">(current)</span>
                      </a>
                  </li> 
              @endisRoute
              @isRoute( 'products')
                  <li class="nav-item active cursor-pointer">
                      <a class="nav-link" href="{{route('products')}}">Articles
                        <span class="sr-only">(current)</span>
                      </a>
                  </li> 
              @else
                  <li class="nav-item cursor-pointer">
                      <a class="nav-link" href="{{route('products')}}">Articles
                        <span class="sr-only">(current)</span>
                      </a>
                  </li> 
              @endisRoute
              @isRoute( 'categories')
                  <li class="nav-item active cursor-pointer">
                      <a class="nav-link" href="{{route('products')}}">Catégories
                        <span class="sr-only">(current)</span>
                      </a>
                  </li> 
              @else
                  <li class="nav-item cursor-pointer">
                      <a class="nav-link" href="{{route('categories')}}">Catégories
                        <span class="sr-only">(current)</span>
                      </a>
                  </li> 
              @endisRoute
              @auth
                  @isAdmin(Auth::user())
                      @isRoute('admin')
                          <li class="nav-item active cursor-pointer">
                              <a class="nav-link" href="{{route('admin')}}">Admin<span class="d-lg-none d-md-none">istration</span>
                              <span class="sr-only">(current)</span>
                              </a>
                          </li> 
                      @else
                          <li class="nav-item cursor-pointer">
                              <a class="nav-link" href="{{route('admin')}}">Admin<span class="d-lg-none d-md-none">istration</span>
                              <span class="sr-only">(current)</span>
                              </a>
                          </li> 
                      @endisRoute
                  @endisAdmin
                <li class="nav-item cursor-pointer">
                    <div class=" sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48" class="text-bold text-dark">
                            <x-slot name="trigger">
                                <x-responsive-nav-link class="text-white-50 cursor-pointer z-color-hover-orange">
                                    <span class="fa fa-user text-success pt-3 pb-2"></span> {{  mb_substr(Auth::user()->name, 0, 7) }}
                                    @livewire('notifications-center')
                                </x-responsive-nav-link>
                            </x-slot>
                            <x-slot name="content" :class="'text-left'">
                                <!-- Authentication -->
                                @isNotRoute('user-profil')
                                <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold" href="{{route('user-profil', Auth::user()->id)}}">
                                    <span class="fa mr-3 d-flex">
                                        @if(Auth::user()->current_photo)
                                            <img width="30" class="border rounded-circle" src="/storage/profilPhotos/{{Auth::user()->currentPhoto()}}" alt="mon profil">
                                            <span class="mt-1 mx-2 fa">
                                                {{ __('Profil') }}
                                            </span>
                                        @else
                                            <img width="30" class="border rounded-circle" src="{{Auth::user()->currentPhoto()}}" alt="mon profil">
                                            <span class="mt-1 mx-2 fa">
                                                {{ __('Profil') }}
                                            </span>
                                        @endif
                                    </span>
                                    
                                </x-dropdown-link>
                                @endisNotRoute
                                <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold"  href="#">
                                    <span wire:click="openModalForMyNotifications">
                                        <span class="fa bi-envelope-open mr-3"></span> 
                                        <span>
                                            @livewire('my-notifications-counter')
                                        </span>
                                    </span>
                                </x-dropdown-link>
                                <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold"  href="{{ route('chat')}}">
                                    <span class="fa fa-wechat mr-3"></span>{{ __('Messenger') }}
                                </x-dropdown-link>
                                <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold"  href="{{route('user-profil', Auth::user()->id)}}">
                                    <span class="bi-minecart mr-3"></span>{{ __('Mon Panier') }} <span class="text-danger ml-1">{{$carts}}</span>
                                </x-dropdown-link>
                                @isAdmin()
                                    <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold" data-toggle="modal" data-target="#createProductModal" href="#" wire:click="createNewProduct">
                                        <span class="fa fa-cart-plus mr-3"></span>{{ __('Ajouter un article') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold" data-toggle="modal" data-target="#createCategoryModal" href="#">
                                        <span class="fa fa-plus mr-3"></span>{{ __('Une catégorie') }}
                                    </x-dropdown-link>
                                @endisAdmin
                                <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold" data-toggle="modal" data-dismiss="modal" data-target="#logoutModal" href="#">
                                    <span class="fa fa-upload  mr-3"></span>{{ __('Déconnexion') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </li>
            @endauth
            @guest
            <li class="nav-item cursor-pointer">
                <a class="nav-link registerModalOpen" data-toggle="modal" data-dismiss="modal" data-target="#registerModal">S'inscrire
                <span class="sr-only">(current)</span>
                </a>
            </li> 
            <li class="nav-item cursor-pointer">
                <a class="nav-link loginOpen" data-toggle="modal" data-dismiss="modal" data-target="#loginModal">Connexion
                    <span class="sr-only">(current)</span>
                </a>
            </li> 
            @endguest
            </ul>
        </div>
      </div>
    </nav>
  </header>