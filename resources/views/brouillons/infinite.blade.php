<!-- /resources/views/livewire/infinite-post-listing.blade.php -->

<div class="container p-4 mx-auto">
    <h1 class="font-semibold text-2xl font-bold text-gray-800">Infinite Load Posts</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-4">
        @foreach($posts as $post)
            <a href="#" class="block p-4 bg-white rounded shadow-sm hover:shadow overflow-hidden" :key="$post['id']">
                <h2 class="truncate font-semibold text-lg text-gray-800">
                    {{ $post['title'] }}
                </h2>

                <p class="mt-2 text-gray-800">
                    {{ $post['body'] }}
                </p>
            </a>
        @endforeach
    </div>

    @if($hasMorePages)
        <div
            x-data="{
                init () {
                    let observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                @this.call('loadPosts')
                            }
                        })
                    }, {
                        root: null
                    });
                    observer.observe(this.$el);
                }
            }"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mt-4"
        >
            @foreach(range(1, 4) as $x)
                @include('partials.skeleton')
            @endforeach
        </div>
    @endif
</div>




{{-- SKELETON  partials.skeleton --}}


<div class="mt-4 p-4 w-full mx-auto bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-800 shadow-sm rounded-md">
    <div class="animate-pulse flex space-x-4">
        <div class="flex-1 space-y-4 py-1">
            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-3/4"></div>
            <div class="space-y-2">
                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded"></div>
                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-5/6"></div>
                <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-5/6"></div>
            </div>
        </div>
    </div>
</div>