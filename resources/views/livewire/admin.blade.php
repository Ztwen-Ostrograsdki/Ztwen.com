<div class="m-0 p-0 w-100">
   <div class="z-justify-relative-top-80 w-100" style="width: 90%;">
      <div class="w-100 border m-0 p-0">
         <div class="m-0 p-0 w-100">
            <div class="row w-100 m-0">
               <div class="col-3 m-0 text-capitalize border border-dark bg-dark p-0 text-white" style="min-height: 650px;">
                  <div class="d-fex flex-column w-100 mb-3">
                     <div class="m-0 py-2 px-4">
                        <div class="d-flex w-100 cursor-pointer m-0 p-0">
                           <span class="fa fa-2x fa-inbox"></span>
                           <h4 class="w-100 m-0 mt-2 ml-3">Notifications</h4>
                           <span class="fa fa-2x">255</span>
                        </div>
                     </div>
                     <div class="m-0 py-2 @if(Route::currentRouteName() == 'admin') z-admin-active @endif px-4">
                        <div class="d-flex w-100 cursor-pointer m-0 p-0">
                           <span class="fa fa-user-secret fa-2x"></span>
                           <h4 class="w-100 m-0 mt-2 ml-3">Les administrateurs</h4>
                           <span class="fa fa-2x">255</span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-4 @if(Route::currentRouteName() == 'products') z-admin-active @endif">
                        <div class="d-flex w-100 cursor-pointer m-0 p-0">
                           <span class="fa fa-user fa-2x"></span>
                           <h4 class="w-100 m-0 mt-2 ml-3">Les utilisateurs</h4>
                           <span class="fa fa-2x">255</span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-4 @if(Route::currentRouteName() == 'products') z-admin-active @endif">
                        <div class="d-flex w-100 cursor-pointer m-0 p-0">
                           <span class="fa fa-shopping-cart fa-2x"></span>
                           <h4 class="w-100 m-0 mt-2 ml-3">Les produits</h4>
                           <span class="fa fa-2x">255</span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     <div class="m-0 py-2 px-4">
                        <div class="d-flex w-100 cursor-pointer m-0 p-0">
                           <span class="fa fa-desktop fa-2x"></span>
                           <h4 class="w-100 m-0 mt-2 ml-3">Les articles</h4>
                           <span class="fa fa-2x">255</span>
                        </div>
                     </div>
                     <hr class="m-0 p-0 w-100 bg-white">
                     
                  </div>
               </div>
               <div class="col-9 border-left border-white bg-dark pb-3">
                  <div class="w-100 mx-auto mt-2 border">
                    <div class="mx-auto d-flex w-100 justify-between">
                        <div></div>
                        @isAdmin(Auth::user())
                           <div class="text-white-50 cursor-pointer border-left p-3" data-toggle="modal" data-target="#registerModal" data-dismiss="modal">
                              <span class="">
                                 <span class="fa fa-user-plus fa-2x"></span>
                                 <span class="">Ajouter un utilisateur</span>
                              </span>
                           </div>
                        @endisAdmin
                    </div>
                  </div>
                  @if($users->count() > 0)
                  <div class="w-100 m-0 p-0 mt-3">
                    <table class="w-100 m-0 p-0 table-striped table-bordered z-table text-white">
                        <thead class="text-white text-center">
                            <th class="py-2 text-center">#ID</th>
                            <th class="">Nom</th>
                            <th>Email</th>
                            <th>Inscrit depuis</th>
                            <th>Action</th>
                            <th>Status</th> 
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                                <tr>
                                    <td class="py-2">{{$u->id}}</td>
                                    <td class="text-capitalize">
                                       @if($u->current_photo)
                                             <span class="d-flex">
                                                <img width="30" class="border rounded-circle" src="/storage/profilPhotos/{{$u->currentPhoto()}}" alt="mon profil">
                                                <span class="mx-2">{{$u->name}}</span>
                                                @if($u->role == 'admin')
                                                   <span class="fa fa-user-secret mt-1 text-white-50 float-right"></span>
                                                @endif
                                             </span>
                                       @else
                                          <span class="d-flex">
                                             <img width="30" class="border rounded-circle" src="{{$u->currentPhoto()}}" alt="mon profil">
                                             <span class="mx-2">{{$u->name}}</span>
                                             @if($u->role == 'admin')
                                                <span class="fa fa-user-secret text-white-50 mt-1 float-right"></span>
                                             @endif
                                          </span>
                                       @endif
                                    </td>
                                    <td>{{$u->email}}</td>
                                    <td>{{$u->created_at}}</td>
                                    <td class="text-center w-auto p-0">
                                       @isNotMaster($u)
                                          <span class="row mx-auto w-100 border m-0 p-0">
                                             <span class="text-danger  danger-hover  col-4 p-2 px-3 cursor-pointer border border-danger fa fa-trash"></span>
                                             <span class="text-warning warning-hover col-4 p-2 px-3 cursor-pointer border border-warning fa fa-key"></span>
                                             @isNotAdmin($u)
                                                <form method="POST" class="col-4 p-0 m-0" wire:submit.prevent="updateUserRole({{$u->id}}, 'admin')">
                                                   <button class="text-success success-hover m-0 w-100 p-2 px-3 cursor-pointer border border-success fa fa-user-secret"  type="submit"></button>
                                                </form>
                                             @else
                                                <form method="POST" class="col-4 p-0 m-0" wire:submit.prevent="updateUserRole({{$u->id}}, 'user')">
                                                   <button class="text-danger danger-hover m-0 w-100 p-2 px-3 cursor-pointer border border-success fa fa-user-secret"  type="submit"></button>
                                                </form>
                                             @endisNotAdmin
                                          </span>
                                       @else
                                       <strong class="text-success">Administrateur principal</strong>
                                       @endisNotMaster
                                    </td>
                                    <td>{{$u->role}}</td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>                                                     
                  </div>
                  @else
                  <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
                     <span class="fa fa-warning text-warning fa-4x"></span>
                     <h4 class="text-warning fa fa-3x">Ouups aucune données enregistées !!!</h4>
                  </div>
                  @endif
               </div>
            </div>
         </div>   
      </div>
   </div>
   
</div>
