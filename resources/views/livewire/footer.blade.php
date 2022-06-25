<div>
    <footer class="footer-32892 pb-0">
        <div class="site-section">
          <div class="container">
            <div class="row px-2">
                <hr class="z-bg-orange my-1 w-100">
                <div class="col-12 my-0 p-0">
                    <div>
                        <h6 class="z-color-orange">
                            <span class="fa fa-user fa-1x mr-3"></span>
                            <strong>Auteur</strong>
                        </h6>
                    </div>
                    <hr class="z-bg-orange my-1 w-100">
                    <div class="my-0 p-0">
                        <div class="d-flex justify-content-between my-0 p-0" style="height: 200px">
                            <div class="h-100 m-0 p-0" style="">
                                <a href="#"><img src="{{$authorImages[0]}}" alt="Image" class="h-100 img-fluid border"></a>
                            </div>
                            <div class="text-left p-2 zw-70" style="height: 100px;">
                                <h6 class="z-color-orange">
                                    Kouassi Vincent HOUNDEKINDO
                                </h6>
                                <h6>
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum praesentium aut, doloribus ullam rem at mollitia similique iusto amet ipsam laudantium perferendis distinctio, placeat quasi exercitationem ipsa optio quibusdam saepe.
                                </h6>
                                <div class="mt-lg-5 mt-xxl-5 mt-xl-5 mt-3 col-lg-5 col-md-7 col-xl-5 col-10 m-0 p-0 d-flex justify-content-between z-color-orange">
                                    <span class="bi-facebook"></span>
                                    <span class="bi-messenger"></span>
                                    <span class="bi-whatsapp"></span>
                                    <span class="bi-youtube"></span>
                                    <span class="bi-twitter"></span>
                                    <span class="bi-linkedin"></span>
                                    <span class="bi-google"></span>
                                    <span class="bi-github"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="z-bg-orange my-1 w-100">
                <div class="col-md pr-md-5 mb-4 mb-md-0">
                    <h5>Apropos de nous</h5>
                    <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam itaque unde facere repellendus, odio et iste voluptatum aspernatur ratione mollitia tempora eligendi maxime est, blanditiis accusamus. Incidunt, aut, quis!</p>
                    <ul class="list-unstyled quick-info mb-4">
                    <li><a href="#" class="d-flex align-items-center"><span class="icon mr-3 icon-phone z-color-orange"></span> (+229) 61 100 804 </a></li>
                    <li><a href="#" class="d-flex align-items-center"><span class="icon mr-3 icon-envelope z-color-orange"></span> houndekz@gmail.com</a></li>
                    </ul>
                    <form autocomplete="off"  wire:submit.prevent="subscribeToNewLetter" class="subscribe">
                        <input type="text" wire:model.defer="email" class="form-control border  @error('email') border-danger @enderror " placeholder="Taper votre adresse mail">
                        <input type="submit" class="btn btn-submit z-bg-orange w-auto" value="OK">
                        @error('email')
                            <small class="text-danger float-left text-left ml-3 my-1">{{$message}}</small>
                        @enderror
                    </form>
                    
                </div>
              <div class="col-md mb-4 mb-md-0">
                <h5>Dernier Tweets</h5>
                <ul class="list-unstyled tweets">
                  <li class="d-flex">
                    <div class="mr-4"><span class="icon icon-twitter"></span></div>
                    <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere unde omnis veniam porro excepturi.</div>
                  </li>
                  <li class="d-flex">
                    <div class="mr-4"><span class="icon icon-twitter"></span></div>
                    <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere unde omnis veniam porro excepturi.</div>
                  </li>
                  <li class="d-flex">
                    <div class="mr-4"><span class="icon icon-twitter"></span></div>
                    <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere unde omnis veniam porro excepturi.</div>
                  </li>
                </ul>
              </div>
  
              <div class="col-md-3 mb-4 mb-md-0">
                <h5>Les plus actrayants</h5>
                <div class="row gallery">
                  <div class="col-4">
                    <a href="#"><img src="{{$footerImages[0]}}" alt="Image" class="img-fluid border"></a>
                    <a href="#"><img src="{{$footerImages[1]}}" alt="Image" class="img-fluid border "></a>
                  </div>
                  <div class="col-4">
                    <a href="#"><img src="{{$footerImages[2]}}" alt="Image" class="img-fluid border "></a>
                    <a href="#"><img src="{{$footerImages[3]}}" alt="Image" class="img-fluid border"></a>
                  </div>
                  <div class="col-4">
                    <a href="#"><img src="{{$footerImages[4]}}" alt="Image" class="img-fluid border "></a>
                    <a href="#"><img src="{{$footerImages[5]}}" alt="Image" class="img-fluid border"></a>
                  </div>
                  <div class="col-12">
                    <a href="#"><img src="{{$footerImages[6]}}" alt="Image" class="img-fluid border "></a>
                    <a href="#"><img src="{{$footerImages[8]}}" alt="Image" class="img-fluid border"></a>
                  </div>
                </div>
              </div>
              
              <div class="col-12 z-color-orange">
                <div class="py-2 footer-menu-wrap border-top z-border-orange d-md-flex align-items-center">
                    <ul class="list-unstyled footer-menu mr-auto py-0">
                        @routeHas('home')
                            @isNotRoute('home')
                                <li><a href="{{route('home')}}">Acceuil</a></li>
                            @endisNotRoute
                        @endrouteHas
                        <li><a href="#">A propos</a></li>
                        <li><a href="#">Nos services</a></li>
                        @auth
                            @routeHas('user-profil')
                                @isNotRoute('user-profil')
                                    <li><a href="{{route('user-profil', ['id' => auth()->user()->id])}}">Profil</a></li>
                                @endisNotRoute
                            @endrouteHas
                        @endauth    
                        <li><a href="#">Contacts</a></li>
                        @auth
                            <li><a data-toggle="modal" data-dismiss="modal" data-target="#logoutModal" href="#">Logout</a></li>
                        @endauth    
                        @guest
                            @routeHas('login')
                                @isNotRoute('login')
                                    <li><a href="{{route('login')}}">Se connecter</a></li>
                                @endisNotRoute
                            @endrouteHas
                            @routeHas('registration')
                                @isNotRoute('registration')
                                    <li><a href="{{route('registration')}}">S'inscrire</a></li>
                                @endisNotRoute
                            @endrouteHas
                        @endguest    
                    </ul>
                    @routeHas('home')
                        <div class="site-logo-wrap ml-auto">
                            <a href="{{route('home')}}" class="site-logo">
                            ZtweN
                            </a>
                        </div>
                    @endrouteHas
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-100 d-block pb-5 border-top border-secondary">
            <h6 class="z-color-orange pt-4 pb-1" style="font-family: cursive">
                <strong class="z-color-orange">Copyright &copy; {{date('Y')}} 
                    <a class="z-color-orange mx-3" href="#" target="_blank">ZtweN Oströgrasdki@webDev</a>
                </strong>
            </h6>
        </div>
      </footer>
</div>