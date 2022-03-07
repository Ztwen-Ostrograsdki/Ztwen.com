<div wire:ignore.self class="modal fade lug" id="logoutModal" role="dialog" >
    <div class="modal-dialog" role="document">
       <!-- Modal content-->
       <div class="modal-content" style="position: absolute; top:150px;">
          <div class="modal-header">
             <div class="d-flex justify-content-between w-100">
                <h4 class="text-uppercase mr-2 mt-1">
                    Déconnexion 
                    @if (session()->has('message'))
                        <span class="alert text-capitalize alert-{{session('type')}} ml-1">{{session('message')}}</span>
                    @endif
                </h4>
                <div class="d-flex justify-content-end w-20">
                   <div class="w-15 mx-0 px-0">
                      <ul class="d-flex mx-0 px-0 mt-1 justify-content-between w-100">
                         <li class=" mx-1"><a href="#"><img src="images/flag-up-1.png" width="100" alt="" /> </a></li>
                         <li><a href="#"><img src="images/flag-up-2.png" width="100" alt="" /></a></li>
                      </ul>
                   </div>
                   <div class="w-25"></div>
                   <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                </div>
             </div>
          </div>
          <div class="modal-body m-0 p-0 border border-warning">
             <div class="page-wrapper bg-gra-01 font-poppins">
                 <div class="wrapper wrapper--w780 ">
                     <div class="card card-3 border border-danger row w-100 p-0 m-0">
                         <div class="card-body border p-0 border-success py-2 col-12 col-lg-6 col-xl-6">
                            <h4 class="text-warning text-center p-1 m-0 py-3">Voulez-vous vraiment vous déconnecter?</h4>
                            <hr class="m-0 p-0 bg-white">
                            <hr class="m-0 p-0 bg-warning">
                            <hr class="m-0 p-0 bg-info">
                                @csrf
                                <form autocomplete="false" method="post" class="mt-3" wire:submit.prevent="logout()">
                                    <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
                                        <button class="w-50 border border-white btn btn--pill bg-danger" type="submit">Se Déconnecter</button>
                                    </div>
			                    </form>
                                <form autocomplete="false" method="post" class="mt-3" wire:submit.prevent="cancel()">
                                    <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
                                        <button class="w-50 border border-white btn btn--pill bg-success" type="submit">Annuler la déconnexion</button>
                                    </div>
			                    </form>
                         </div>
                     </div>
                 </div>
             </div>
          </div>
       </div>
    </div>
 </div>
