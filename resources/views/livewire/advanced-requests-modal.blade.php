<div>
@if($classMapping)
<div wire:ignore.self class="modal fade lug" id="advancedrequestsModal" role="dialog" >
    <div class="modal-dialog modal-z-xlg" role="document">
        <div class="modal-content z-bg-secondary border" style="position: absolute; top:100px; z-index: 2010">
            <div class="modal-header">
                <div class="d-flex justify-content-between w-100">
                    <h6 class="text-uppercase mr-2 mt-1 text-white-50 justify-content-between">
                        <span>
                            Procedures avancées irreversibles
                            @if (session()->has('alert'))
                                <span class="alert text-capitalize alert-{{session('type')}} ml-4">{{session('alert')}}</span>
                            @endif
                        </span>
                    </h6>
                    <div class="d-flex justify-content-end w-20">
                    <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            </div>
            <div class="modal-body m-0 p-0 z-bg-secondary" x-data="{ showBtn: true }">
                <div class="">
                    <div class="">
                        <div class="z-bg-secondary row w-100 p-0 m-0">
                            <div class=" p-0 col-12">
                                <h6 class="z-title text-white-50 text-center p-1 m-0 "> Procedure avancées sur la table des : 
                                    <br>
                                    <span class="bi-sd-card mx-1"></span>
                                    <span class="text-capitalize">
                                        {{ $modelTable }}
                                    </span>
                                    <span class="bi-sd-card mx-1"></span>
                                </h6>
                                <hr class="bg-secondary text-white p-0 w-75 mx-auto">
                                @if (!$authentify)
                                    @if ($init_process)
                                    <div class="mx-auto w-75 my-2 border border-info p-2 rounded">
                                        <h6 class="text-center w-100 text-orange">
                                            @if($action == 'toTrashed')
                                                <span class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Veuillez entrer le code pour confirmer l'envoie dans la corbeille</span>
                                            @elseif($action == 'fromTrashed')
                                                <span class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Veuillez entrer le code pour confirmer la restauration des données supprimées</span>
                                            @elseif($action == 'truncate')
                                                <span class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Veuillez entrer le code pour confirmer la suppression définitive</span>
                                            @elseif($action == 'generateFaker')
                                                <span class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Veuillez entrer le code pour générer de fausses données</span>
                                            @else
                                                <span class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">L'action choisie est inconnue</span>
                                            @endif
                                        </h6>
                                    </div>
                                    @else
                                    <div class="mx-auto w-75 my-2 border-orange p-2 rounded">
                                        <h6 class="text-center w-100 text-white">
                                            @if($hasNotTrashedColumn)
                                                Cette table comporte <strong class="text-orange">{{ $records }}</strong> enregistrements. Cette table de model n'est pas <strong class="text-info">{{ 'SOFTDELETE' }}</strong> C'est-à-dire que la corbeille n'est pas active pour cette table.
                                            @else
                                                Cette table comporte <strong class="text-orange">{{ $records }}</strong> enregistrements dont <strong class="text-info">{{ $trashedRecords }}</strong> enregistrements dans la corbeille.
                                            @endif
                                        </h6>
                                    </div>
                                    @endif
                                @endif
                                @if(!$authentify)
                                    <form autocomplete="off" class="mt-3 pb-3 px-2 form-group bg-transparent" wire:submit.prevent="confirm">
                                        @if($init_process)
                                            <div class="p-0 m-0 mt-0 mb-2 row w-100 px-2">
                                                <label class="z-text-cyan m-0 p-0 w-100 cursor-pointer" for="code">La clé de confirmation</label>
                                                <input placeholder="Veuillez renseigner la clé ..." class="text-white w-100 form-control bg-transparent border border-white px-2" wire:model.defer="code" type="text" name="code" id="code">
                                                @error('code')
                                                    <small class="py-1 z-text-orange">{{$message}}</small>
                                                @enderror
                                            </div>
                                            <div class="col-8 px-1 text-dark mx-auto my-1 d-flex justify-content-center">
                                                <button class="btn border border-white w-75 bg-primary cursor-pointer" x-on:click="showBtn = true">
                                                    <small class="bi-check-all"></small>
                                                    <small class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Confirmer la clé</small>
                                                </button>
                                            </div>
                                        @else
                                        <div class="col-8 px-1 text-dark mx-auto my-1 d-flex justify-content-around">
                                            <span wire:click="setRequestActionTo('generateFaker')" class="btn bg-success cursor-pointer">
                                                <small class="bi-upload"></small>
                                                <small class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Faker</small>
                                            </span>
                                            @if(!$hasNotTrashedColumn)
                                                @if ($records > 0)
                                                <span wire:click="setRequestActionTo('toTrashed')" class="btn bg-warning mx-2">
                                                    <small class="bi-question"></small>
                                                    <small class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Vers la corbeille</small>
                                                </span>
                                                @endif
                                                @if ($trashedRecords > 0)
                                                <span wire:click="setRequestActionTo('fromTrashed')" class="btn bg-info mx-2">
                                                    <small class="bi-reply-all"></small>
                                                    <small class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Restaurer la corbeille</small>
                                                </span>
                                                @endif
                                            @endif
                                            <span wire:click="setRequestActionTo('truncate')" class="btn bg-orange">
                                                <small class="bi-trash"></small>
                                                <small class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Suppr. définivement</small>
                                            </span>
                                        </div>
                                        @endif
                                        <div class="m-0 p-0 w-50 text-center mx-auto pr-3 pb-2 mt-2">
                                            <strong data-toggle="modal" data-dismiss="modal" class="text-warning" style="cursor: pointer">Annuler</strong>
                                        </div>
                                    </form>
                                @else
                                    <div class="mx-auto d-flex justify-content-center">
                                        <div x-show.important="showBtn" class="col-8 px-1 mx-auto text-white my-1 my-3">
                                            @if ($action == 'generateFaker')
                                                <span class="mx-auto d-flex justify-content-center my-2">
                                                    <span class="d-inline-block w-100">
                                                        <input placeholder="Veuillez renseigner le nombre de données à générer..." class="text-white w-100 mx-auto form-control bg-transparent border border-white px-2" wire:model="fakerQuantity" type="text" name="fakerQuantity" id="fakerQuantity">
                                                        @if ($fakerQuantity > 0)
                                                            <span class="mt-1 text-warning ml-2">
                                                                {{$fakerQuantity > 9 ? $fakerQuantity : '0' . $fakerQuantity }} donnée{{$fakerQuantity > 1 ? 's' : ''}} de cette table seront générées..
                                                            </span>
                                                        @else
                                                            <span class="mt-1 text-warning ml-2">
                                                                Veuillez renseiller un nombre supérieur à zéro (0)
                                                            </span>
                                                        @endif
                                                    </span>                                                    
                                                </span>
                                            @endif
                                            <strong class="btn border border-white py-2 text-white mx-auto w-75 bg-success d-flex justify-content-center cursor-pointer" 
                                            x-on:click="
                                                @this.call('maker');
                                                showBtn = false;
                                            ">
                                                <strong class="bi-check-all"></strong>
                                                <strong class="d-none d-xxl-inline d-xl-inline d-lg-inline mx-1">Confirmer le processus</strong>
                                            </strong>
                                        </div>
                                        <div x-show.important="!showBtn" class="col-8 px-1 text-white mx-auto my-1 mx-auto my-3">
                                            <strong wire:loading class="w-100 mx-auto">
                                                <span class="d-flex justify-content-center text-warning btn border border-white shadow mx-auto py-2 w-75 bg-secondary cursor-pointer">
                                                    <strong class="bi-clock-history mx-2"></strong>
                                                    <strong>
                                                        <strong class="text-center text-lowercase">
                                                            Veuillez patienter ...
                                                        </strong>
                                                    </strong>
                                                </span>
                                            </strong>
                                            <strong wire:loading.remove data-toggle="modal" data-dismiss="modal">
                                                <span class="d-flex justify-content-center btn border border-white shadow mx-auto py-2 text-white w-75 bg-success cursor-pointer">
                                                    <strong class="bi-check-all mx-2 text-white"></strong>
                                                    <div class="d-inline-block">
                                                        <strong class="text-center text-lowercase text-white">
                                                            Terminée !
                                                            <span class="ml-1">C'est fait!</span>
                                                        </strong>
                                                    </div>
                                                </span>
                                            </strong>
                                        </div>
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
@endif
</div>