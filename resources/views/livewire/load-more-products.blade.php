<div x-data="{
    checkScroll() {
            var isLoadedOnce = false;
            window.onscroll = function(ev) {
                //document.body.scrollHeight worked for me insted of document.body.offsetHeight
                if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight - 1000) {
                    if( !isLoadedOnce) {
                        @this.call('loadMore')
                        isLoadedOnce = true;
                    }
                }
            };
        }
    }"

    x-init="checkScroll"
>
    <div class="w-100 mx-auto d-flex justify-center my-2">
        <span class="py-2 cursor-pointer px-3 text-white zw-35 text-center d-inline-block z-bg-secondary-light-opac border border-white rounded" wire:click="loadMore">Charger plus d'articles...</span>
    </div>
    <div wire:loading.delay>
        <div id="preloader-white">
            <div class="jumper">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
</div>
