<header class="yours @fixedHeaderForRoute() position-fixed @endfixedHeaderForRoute" style="z-index:200;" >
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
                        <x-dropdown align="right" width="48" class="text-bold">
                            <x-slot name="trigger">
                                <x-responsive-nav-link class="text-secondary cursor-pointer">
                                    <span class="fa fa-user text-success"></span> {{  mb_substr(Auth::user()->name, 0, 7) }}
                                </x-responsive-nav-link>
                            </x-slot>
                            <x-slot name="content" :class="'text-left'">
                                <!-- Authentication -->
                                @isNotRoute('user-profil')
                                <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 border-bottom text-bold" href="{{route('user-profil', Auth::user()->id)}}">
                                    <span class="fa mr-3 d-flex">
                                        @if(Auth::user()->current_photo)
                                            <img width="30" class="border rounded-circle" src="/storage/profilPhotos/{{Auth::user()->currentPhoto()}}" alt="mon profil">
                                            <span class="mt-1 ml-2">Profil</span>
                                        @else
                                        <img width="30" class="border rounded-circle" src="{{Auth::user()->currentPhoto()}}" alt="mon profil">
                                            <span>Profil</span>
                                        @endif
                                    </span>
                                    
                                </x-dropdown-link>
                                @endisNotRoute
                                <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 border-bottom text-bold"  href="{{ route('chat')}}">
                                    <span class="fa fa-wechat mr-3"></span>{{ __('Messenger') }}
                                </x-dropdown-link>
                                <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 border-bottom text-bold"  href="{{route('user-profil', Auth::user()->id)}}">
                                    <span class="bi-minecart mr-3"></span>{{ __('Mon Panier') }} <span class="text-danger ml-1">{{$carts}}</span>
                                </x-dropdown-link>
                                <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 border-bottom text-bold" data-toggle="modal" data-dismiss="modal" data-target="#logoutModal" href="#">
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