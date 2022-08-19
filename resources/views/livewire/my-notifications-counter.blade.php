<div class="d-inline">
    <span>
        <span>
            @if(auth()->user()->myNotifications->count() == 0)
            Aucune notif. 
            @elseif(auth()->user()->myNotifications->count() == 1)
            Vous avez 01 
            @elseif(auth()->user()->myNotifications->count() > 1 && auth()->user()->myNotifications->count() < 10)
            Vous avez 0{{auth()->user()->myNotifications->count()}} 
            @elseif(auth()->user()->myNotifications->count() > 9)
            Vous avez {{auth()->user()->myNotifications->count()}} 
            @endif
        </span>
    </span>
</div>
