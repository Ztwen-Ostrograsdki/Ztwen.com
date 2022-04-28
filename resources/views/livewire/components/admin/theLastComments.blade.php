@if($comments->count() > 0)
    <div class="mt-2">
        @include('livewire.components.commentsCardsComponents', 
        [
        'comments' => $comments
        ])
    </div>
@else
    <div class="d-flex flex-column mx-auto text-center p-3 mt-4">
        <span class="fa fa-warning text-warning fa-4x"></span>
        <h4 class="text-warning fa fa-3x">Ouups aucun article encore enregisté !!!</h4>
    </div>
@endif