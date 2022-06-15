<header class="d-lg-block d-xxl-block d-xl-block d-none yours @fixedHeaderForRoute() position-fixed @endfixedHeaderForRoute" style="z-index:;" >
    <nav class="navbar navbar-expand-lg d-lg-block d-xxl-block d-xl-block d-none">
      <div class="container">
        <a class="navbar-brand" href="{{route('home')}}"><h2>ZtweN <em>Oströgrasdki</em> <small class="text-lowercase text-muted"><sup>market</sup></small> </h2></a>
        <button style="background-color: none !important" class="navbar-toggler border border-white bg-transparent" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <x-z-link :route="'home'" :active="request()->routeIs('home')">
                    {{ __('Accueil') }}
                </x-z-link>
                <x-z-link :route="'products'" :active="request()->routeIs('products')">
                    {{ __('Articles') }}
                </x-z-link>
                <x-z-link :route="'categories'" :active="request()->routeIs('categories')">
                    {{ __('Catégories') }}
                </x-z-link>
                @auth
                    @isAdmin(Auth::user())
                    <x-z-link :route="'admin'" :active="request()->routeIs('admin')">
                        {{ __('Admin') }}
                    </x-z-link>
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
                                @routeHas('user-profil')
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
                                @endrouteHas
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
                @routeHas('registration')
                    <li class="nav-item cursor-pointer">
                        <a class="nav-link registerModalOpen @isRoute('registration') active @endisRoute " data-toggle="modal" data-dismiss="modal" data-target="#registerModal">S'inscrire
                        <span class="sr-only">(current)</span>
                        </a>
                    </li> 
                @endrouteHas
                @routeHas('login')
                    <li class="nav-item cursor-pointer">
                        <a class="nav-link loginOpen @isRoute('login') active @endisRoute " data-toggle="modal" data-dismiss="modal" data-target="#loginModal">Connexion
                            <span class="sr-only">(current)</span>
                        </a>
                    </li> 
                @endrouteHas
            @endguest
            </ul>
        </div>
      </div>
    </nav>
  </header> 
  {{-- HEADER FOR SMALL SCREEN --}}
  <header class="d-block d-xl-none d-xxl-none">
    <main class="d-block d-xl-none d-xxl-none">
        <nav class="navbar navbar-dark">
            <div class="container-fluid">
              <a class="navbar-brand" href="{{Route::has('home') ? route('home') : url('/')}}"><h2>ZtweN <em>Oströgrasdki</em> <small class="text-lowercase text-muted"><sup class="text-white-50">market</sup></small> </h2></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarDark" aria-controls="offcanvasNavbarDark">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="offcanvas offcanvas-start text-white bg-dark" tabindex="-1" id="offcanvasNavbarDark" aria-labelledby="offcanvasNavbarDarkLabel">
                <div class="offcanvas-header">
                  <h5 class="offcanvas-title" id="offcanvasNavbarDarkLabel">
                    <span class="bi-house mr-2"></span> Menu
                  </h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                  <ul class="navbar-nav justify-content-end text-white flex-grow-1 pe-3">
                    <x-z-link :route="'home'" :active="request()->routeIs('home')">
                        <span class="bi-house mr-2"></span>
                        <span>{{ __('Accueil') }}</span>
                    </x-z-link>
                    <x-z-link :route="'products'" :active="request()->routeIs('products')">
                        <span class="bi-tools mr-2"></span>
                        <span>{{ __('Articles') }}</span>
                    </x-z-link>
                    <x-z-link :route="'categories'" :active="request()->routeIs('categories')">
                        <span class="bi-bookmarks mr-2"></span>
                        <span>{{ __('Catégories') }}</span>
                        <span class="bi-chevron-down float-end"></span>
                    </x-z-link>
                    @auth
                    <x-z-link :params="['id' => auth()->user()->id]" :route="'user-profil'" :active="request()->routeIs('user-profil')">
                        <span class="bi-person mr-2"></span>
                        <span>{{ __('Profil') }}</span>
                    </x-z-link>
                    @endauth
                    @guest
                    <x-z-link :route="'login'" :active="request()->routeIs('login')">
                        <span class="bi-person-check mr-2"></span>
                        <span>{{ __('Se connecter') }}</span>
                    </x-z-link>
                    <x-z-link :route="'registration'" :active="request()->routeIs('registration')">
                        <span class="bi-person-plus mr-2"></span>
                        <span>{{ __("S'inscrire") }}</span>
                    </x-z-link>
                    @endguest
                    
                  </ul>
                  <form class="d-flex mt-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                  </form>
                </div>
              </div>
            </div>
          </nav>
      </main>
  </header>