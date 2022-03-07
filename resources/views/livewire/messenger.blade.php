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
                     <hr class="m-0 p-0 w-100 bg-white">
                     
                  </div>
               </div>
               <div class="col-9 border-left border-white bg-dark pb-3">
                  <div class="w-100 mx-auto mt-2 border">
                    <div class="mx-auto d-flex w-100 justify-between">
                        <div class="text-uppercase text-center text-white w-75">
                            <h3 class="z-title text-white text-center p-1 mt-2 m-0 w-100">
                                <span class="fa fa-wechat"></span>
                                Messenger BOX
                            </h3>
                        </div>
                        <div class="text-white-50 cursor-pointer border-left p-3" data-toggle="modal" data-target="#addFriendsModal" data-dismiss="modal">
                            <span class="">
                                <span class="fa fa-user-plus fa-2x"></span>
                                <span class="">Suivre un amis</span>
                            </span>
                        </div>
                    </div>
                  </div>
                  @if($users->count() > 0)
                  <div class="w-100 m-0 p-0 mt-3">
                    <table class="w-100 m-0 p-0 table-striped table-bordered z-table text-white">
                        <tbody>
                              @foreach($users as $u)
                                 <tr>
                                    <td class="py-2 text-capitalize">
                                       @if($u->current_photo)
                                             <a href="{{ route('chat', ['id' => $u->id])}}"class="d-flex text-white" wire:click="chatReceiver({{$u->id}})">
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
                                       @if ($u->id !== 1)
                                          <span class="row mx-auto w-100 border m-0 p-0">
                                             <span class="text-success  success-hover  col-6 p-2 px-3 cursor-pointer border border-success fa fa-user-plus "></span>
                                             <span class="text-warning warning-hover col-6 p-2 px-3 cursor-pointer border border-warning fa fa-key"></span>
                                          </span>
                                       @else
                                       <strong class="text-success">Administrateur principal</strong>
                                       @endif
                                    </td>
                                </tr>
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
