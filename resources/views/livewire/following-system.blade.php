@auth
<div wire:ignore.self class="modal fade lug" id="addFriendsModal" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
       <!-- Modal content-->
       <div class="modal-content" style="position: absolute; height: 600px; z-index:5000; overflow:scroll">
          <div class="modal-header">
             <div class="d-flex justify-content-between w-100">
                <h4 class="text-uppercase mr-2 mt-1">
                    Ajout des amis 
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
                            <h4 class="text-warning text-center p-1 m-0 py-3">Selectionnez vos amis</h4>
                            <hr class="m-0 p-0 bg-white">
                            <hr class="m-0 p-0 bg-warning">
                            <hr class="m-0 p-0 bg-info">
                            @if($users->count() > 0)
                            <div class="w-100 m-0 p-0 mt-3" wire:poll="getUsers">
                              <table class="w-100 m-0 p-0 table-striped table-bordered z-table text-white">
                                  <tbody>
                                        @foreach($users as $u)
                                            @if(!Auth::user()->iFollowingButNotYet($u) && !Auth::user()->iFollowThis($u))
                                            <tr>
                                                <td class="py-2 text-capitalize">
                                                    @if($u->current_photo)
                                                        <a href="{{ route('chat', ['id' => $u->id])}}"class="d-flex text-white">
                                                            <img width="30" class="border rounded-circle" src="/storage/profilPhotos/{{$u->currentPhoto()}}" alt="mon profil">
                                                            <span class="mx-2">{{$u->name}}</span>
                                                            @if($u->role == 'admin')
                                                                <span class="fa fa-user-secret mt-1 text-white-50 float-right"></span>
                                                            @endif
                                                        </a>
                                                    @else
                                                        <a href="{{ route('chat', ['id' => $u->id])}}" class="d-flex text-white">
                                                        <img width="30" class="border rounded-circle" src="{{$u->currentPhoto()}}" alt="mon profil">
                                                        <span class="mx-2">{{$u->name}}</span>
                                                        @if($u->role == 'admin')
                                                            <span class="fa fa-user-secret text-white-50 mt-1 float-right"></span>
                                                        @endif
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="text-center w-auto p-0">
                                                    <span class="row mx-auto w-100 border m-0 p-0">
                                                    <span wire:click="followThisUser({{$u->id}})" class="text-success  success-hover @isNotAdmin($u) col-6 @else col-12  @endisNotAdmin p-2 px-3 cursor-pointer border border-success fa fa-user-plus "></span>
                                                @isNotAdmin($u)
                                                    <span class="text-warning warning-hover col-6 p-2 px-3 cursor-pointer border border-warning fa fa-key"></span>
                                                @endisNotAdmin
                                                    </span>
                                                </td>
                                            </tr>
                                        @endif
                                      @endforeach
                                  </tbody>
                              </table>                                                     
                            </div>
                            @else
                            <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
                               <span class="fa fa-warning text-warning fa-4x"></span>
                               <h4 class="text-warning fa fa-3x">Ouups aucun utilisateur disponible !!!</h4>
                            </div>
                            @endif
                         </div>
                     </div>
                 </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 @endauth
