<div>
    <div wire:ignore.self class="modal fade lug" id="processModal" role="dialog" >
        <div class="modal-dialog modal-z-xlg" role="document">
            <div class="modal-content z-bg-secondary border" style="position: absolute; top:100px; z-index: 2010">
                <div class="modal-header">
                    <div class="d-flex justify-content-between w-100">
                        <h6 class="text-uppercase mr-2 mt-1 text-white-50 justify-content-between">
                            <span>
                                Procedure en cours ...
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
                <div class="modal-body m-0 p-0 z-bg-secondary">
                    <div class="">
                        <div class="">
                            <div class="z-bg-secondary row w-100 p-0 m-0">
                                <div class=" p-0 col-12">
                                    <h6 class="z-title text-white-50 text-center p-1 m-0 "> Procedure avancées sur la table des : 
                                        <br>
                                        <span class="bi-sd-card mx-1"></span>
                                        <span class="text-capitalize">
                                            2222
                                        </span>
                                        <span class="bi-sd-card mx-1"></span>
                                    </h6>
                                    <hr class="bg-secondary text-white p-0 w-75 mx-auto">
                                    
                                    @if (session()->has('rest') && session()->has('counter'))
                                        <div class="mx-auto w-75 my-5 border border-white p-2 rounded bg-success">
                                            <h6 class="text-center w-100 text-white py-2">
                                                <strong class="text-center fs-4">
                                                    {{ floor((session('rest') / session('counter'))) * 100 }} % restant
                                                </strong>
                                            </h6>
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
</div>