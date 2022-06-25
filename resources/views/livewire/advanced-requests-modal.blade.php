<div>
@if($classMapping)
<div wire:ignore.self class="modal fade lug" id="advancedrequestsModal" role="dialog" >
    <div class="modal-dialog modal-z-xlg" role="document">
        <div class="modal-content z-bg-secondary border" style="position: absolute; top:100px; z-index: 2010">
            <div class="modal-header">
                <div class="d-flex justify-content-between w-100">
                    <h6 class="text-uppercase mr-2 mt-1 text-white-50">
                        Procedures avancées irreversibles
                            @if (session()->has('alert'))
                                <span class="alert text-capitalize alert-{{session('type')}} ml-4">{{session('alert')}}</span>
                        @endif
                    </h6>
                    <div class="d-flex justify-content-end w-20">
                    <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            </div>
            <div class="modal-body m-0 p-0 z-bg-secondary">
                <div class="">
                    <div class="">
                        <div class="z-bg-secondary row w-100 p-0 m-0">
                            <div class=" p-0 col-12">
                                <h6 class="z-title text-white-50 text-center p-1 m-0 "> Procedure avancées sur la table des : 
                                    <br>
                                    <span class="bi-sd-card mx-1"></span>
                                    <span class="text-capitalize">
                                        {{ $classMapping }}
                                    </span>
                                    <span class="bi-sd-card mx-1"></span>
                                </h6>
                                <hr class="bg-secondary text-white p-0 w-75 mx-auto">
                                <form autocomplete="off" class="mt-3 pb-3 px-2 form-group bg-transparent" wire:submit.prevent="start">
                                    <div class="p-0 m-0 mt-0 mb-2 row w-100 px-2">
                                        <label class="z-text-cyan m-0 p-0 w-100 cursor-pointer" for="adv_code">La clé de confirmation</label>
                                        <input placeholder="Veuillez decrire brièvement cette catégorie..." class="text-white w-75 form-control bg-transparent border border-white px-2 @error('code') text-danger border-danger @enderror" wire:model.defer="code" type="text" name="adv_code" id="adv_code">
                                        @error('adv_code')
                                            <small class="py-1 z-text-orange">{{$message}}</small>
                                        @enderror
                                    </div>
                                    <div class="col-8 px-1 text-dark mx-auto my-1 d-flex justify-content-around">
                                        <span class="btn bg-success">
                                            <small class="bi-check-all"></small>
                                            <small class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Approuver</small>
                                        </span>
                                        <span class="btn bg-warning">
                                            <small class="bi-question"></small>
                                            <small class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Indesirable</small>
                                        </span>
                                        <span class="btn bg-orange">
                                            <small class="bi-trash"></small>
                                            <small class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Supprimer</small>
                                        </span>
                                        <span class="btn bg-primary">
                                            <small class="bi-messenger"></small>
                                            <small class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Message</small>
                                        </span>
                                    </div>
                                    <div class="m-0 p-0 w-50 text-center mx-auto pr-3 pb-2">
                                        <strong data-toggle="modal" data-dismiss="modal" class="text-warning" style="cursor: pointer">Annuler</strong>
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
@endif
</div>