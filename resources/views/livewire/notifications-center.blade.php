<div class="d-inline m-0 p-0">
    @auth
        @if(auth()->user()->myNotifications->count() > 0)
        <span wire:poll>
            <span class="fa bi-envelope" style="font-size: 20px"></span>
            <small class=" bg-white border border-warning px-1 text-danger" style="border-radius: 100%; position: relative; left:-10px; top: -11px">{{$user->myNotifications->count()}}</small>
        </span>
        @endif
    @endauth
</div>
