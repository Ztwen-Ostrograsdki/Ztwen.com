<div wire:ignore.self class="modal fade lug" id="logoutModal" role="dialog" >
<div class="modal-dialog" role="document">
    <!-- Modal content-->
    <div class="modal-content z-bg-secondary border" style="position: absolute; top:250px;">
        <div class="modal-header">
            <div class="d-flex justify-content-between w-100">
            <h6 class="text-uppercase mr-2 mt-1 text-white">
                Déconnexion 
                @if (session()->has('message'))
                    <span class="alert text-capitalize alert-{{session('type')}} ml-1">{{session('message')}}</span>
                @endif
            </h6>
            <div class="d-flex z-bg-secondary justify-content-end w-20">
                <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
            </div>
            </div>
        </div>
        <div class="modal-body m-0 p-0 border z-bg-secondary">
            <div class="">
                <div class="">
                    <div class=" row w-100 p-0 m-0">
                        <div class="bg-transparent p-0 py-2 col-12">
                            <h6 class="text-warning text-center p-1 m-0 py-1">Voulez-vous vraiment vous déconnecter?</h6>
                            @csrf
                            <form autocomplete="false" method="post" class="mt-2 form-group bg-transparent" wire:submit.prevent="logout">
                                <div class="p-0 m-0 mx-auto d-flex justify-content-center pb-1 pt-1">
                                    <button class="w-50 border border-white btn btn--pill bg-danger" type="submit">Se Déconnecter</button>
                                </div>
                            </form>
                            <form autocomplete="false" method="post" class="mt-3" wire:submit.prevent="cancel">
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
