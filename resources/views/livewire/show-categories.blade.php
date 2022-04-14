<div class="m-0 p-0 w-100">
    <div class="z-justify-relative-top-80 w-100" style="width: 90%;">
        <div class="w-100 border m-0 p-0">
            <div class="m-0 p-0 w-100 z-banner text-center" style="font-family: Haettenschweiler, 'Arial Narrow Bold', sans-serif; word-spacing: 5px; letter-spacing: 2px;">
                <h2 class="text-uppercase pt-3">nouvel arrivage</h2>
                <h1 class="text-capitalize">Les catégories à la une</h1>                           
            </div>
            <div class=" d-flex zw-95 mx-auto justify-content-center mt-1">
                <div class="d-flex justify-content-between w-100" >
                    <div class="w-25 bg-secondary border border-primary" style="max-height: 400px; overflow: auto">
                        <h4 class="w-100 py-2 bg-secondary text-center text-white">Les catégories</h4>   
                        <div class="w-100 d-flex flex-column">
                            @foreach ($categories as $cat)
                                <h4 wire:click="changeCategory({{$cat->id}})" class="cursor-pointer z-hover-secondary py-2 border border-bottom px-2">
                                    <span>{{$cat->name}} </span> <span class="text-right float-right">({{$cat->products->count()}})</span>
                                </h4>
                            @endforeach
                        </div>
                    </div>
                    <div class="w-75 p-2">
                        @if($category)
                            <h4 class="cursor-pointer z-secondary text-center text-white py-2 border border-bottom px-2">
                                <span>{{$category->name}} </span> <span class="">({{$category->products->count()}})</span>
                            </h4>

                            <div class="w-100 mx-auto">
                                @foreach ($products as $p)
                                    <div class="w-100 d-flex justify-content-between">
                                        <div>
                                            {{$p->slug}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <h4 class="cursor-pointer z-secondary text-center text-white py-2 border border-bottom px-2">
                                <span> Selectionnez une catégorie </span>
                            </h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>