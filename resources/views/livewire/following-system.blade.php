<x-z-modal-generator :icon="'fa fa-2x bi-person-plus'" :modalName="'addFriendsModal'" :modalHeaderTitle="'Ajout des amis '" :modalBodyTitle=" 'Ajout des amis '">
    @if(Auth::user() && $users->count() > 0)
        <div class="w-100 m-0 p-0 mt-3 px-2">
            <table class="w-100 m-0 p-2 table-striped table-bordered z-table text-white">
                <tbody>
                    @foreach($users as $u)
                        @if(!Auth::user()->isMyFriend($u) && !Auth::user()->iFollowingButNotYet($u))
                        <tr class="px-2">
                            <td class="py-2 px-2 text-capitalize">
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
                            <td wire:click="followThisUser({{$u->id}})" class="text-success  z-scale text-center w-auto p-0 cursor-pointer">
                                <span class="d-flex justify-content-around mx-auto w-100 m-0 p-0">
                                <span  class="p-2 px-3 fa fa-user-plus "></span>
                            </td>
                        </tr>
                    @endif
                    @endforeach
                </tbody>
                </tbody>
            </table>                                                     
        </div>
        @else
        <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
            <span class="fa fa-warning text-warning fa-4x"></span>
            <h4 class="text-warning fa fa-3x">Ouups aucun utilisateur disponible !!!</h4>
        </div>
        @endif
    <x-z-modal-dismisser>Annuler</x-z-modal-dismisser>
</x-z-modal-generator>