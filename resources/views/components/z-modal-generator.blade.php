<div wire:ignore.self class="modal lug fade" id="{{$modalName}}" role="dialog" >
    <div class="modal-dialog modal-z-xlg" role="document">
       <!-- Modal content-->
       <div class="modal-content z-bg-secondary border" style="position: absolute; top:80px;">
          <div class="modal-header">
             <div class="d-flex justify-content-between w-100">
                <h6 class="text-uppercase text-white-50 mr-2 mt-1">
                    {{$modalHeaderTitle}} 
                    @if (session()->has('message'))
                        <span class="text-capitalize text-{{session('type')}} bg-tranparent ml-4">{{session('message')}}</span>
                    @endif
                </h6>
                <div class="d-flex justify-content-end w-20">
                   <div class="w-25"></div>
                   <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                </div>
             </div>
          </div>
          <div class="modal-body m-0 p-0 bg-transparent">
             <div class="">
                 <div class="">
                     <div class="z-bg-secondary row w-100 p-0 m-0">
                        <div class="w-100 {{$header_color}} m-0 p-0">
                            <h6 class="text-center w-100 p-0 m-0 mt-3">
                                <span class="{{$icon}}"></span>
                                <h5 class="w-100 text-capitalize text-center">{{$modalBodyTitle}} </h5>
                            </h6>
                        </div>
                         <div class="p-0 col-12">
                            {{$slot}}
                         </div>
                     </div>
                 </div>
             </div>
          </div>
       </div>
    </div>
 </div>