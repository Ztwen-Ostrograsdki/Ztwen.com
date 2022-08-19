@php
   if($width){
      $col = 'col-xxl-' . $width . ' col-xl-' . $width . ' col-lg-' . $width . ' col-md- ' . $width . 'col-9' . ' mx-auto';
   }
@endphp

<div wire:ignore.self class="modal lug fade" id="{{$modalName}}" role="dialog" >
    <div class="modal-dialog modal-z-xlg {{$width ? $col : ''}}" role="document">
       <!-- Modal content-->
       <div class="modal-content z-bg-secondary-light-opac border" style="position: absolute; top:80px;">
            @if($hasHeader)
               <div class="modal-header">
                  <div class="d-flex justify-content-between w-100">
                     @if ($modalHeaderTitle !== '')
                        <h6 class="text-uppercase text-white-50 mr-2 mt-1">
                           {{$modalHeaderTitle}} 
                           <span class="{{$icon}} mx-1"></span>
                        </h6>
                     @endif
                     <div class="d-flex justify-content-end w-20">
                        <div class="w-25"></div>
                        <button type="button" class="close text-danger" data-dismiss="modal">&times;</button>
                     </div>
                  </div>
               </div>
            @endif
          <div class="modal-body m-0 p-0 bg-transparent">
             <div class="">
                 <div class="">
                     <div class="z-bg-secondary-light-opac row w-100 p-0 m-0">
                        @if ($modalBodyTitle !== '')
                        <div class="w-100 {{$header_color}} m-0 p-0 {{$hasHeader ? '' : 'border-bottom z-bg-secondary-light mb-2'}}">
                           <h6 class="text-center w-100 p-0 m-0 mt-3">
                              <h6 class="w-100 text-capitalize text-center">
                                 <span>{{$modalBodyTitle}} </span>
                                 <span class="{{$icon}} fa-1x mx-1"></span>
                              </h6>
                           </h6>
                       </div>
                        @endif
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