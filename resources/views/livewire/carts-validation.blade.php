<div class="w-100 mx-auto row" style="position: relative; top: 100px; margin-bottom: 100px !important">
    @auth
    <div class="col-11 mx-auto col-xxl-8 col-xl-8 col-md-10">
        <div class="d-flex">
            <h5>Panier de  {{auth()->user()->name}}</h5> 
        </div>
        <div class="z-bg-secondary-light-opac border border-white rounded col-12 shadow p-2">
            <h6 class="border-bottom w-75 mb-1 border-white text-white">Contenu</h6>
            <p class="w-100 m-0 bg-transparent text-white-50">
                
            </p>
            <div class="mx-auto col-12 p-2">
                <table class="w-100 m-0 p-0 table-striped table-bordered z-table text-white">
                    <thead class="text-white text-center">
                        <th class="py-2 text-center">#N°</th>
                        <th class="">Article</th>
                        <th>PU (FCFA)</th>
                        <th>Quantité</th>
                        <th>Montant (FCFA)</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @foreach ($carts as $k => $product)
                        <tr class="">
                            <td class="py-2 text-center">{{ $k + 1 }}</td>
                            <td class="text-capitalize pl-2 ">{{$product->getName()}}</td>
                            <td class="text-capitalize pl-2">{{$product->price}}</td>
                            <td class="text-capitalize w-auto">
                                <input wire:model="quantities.{{$product->id}}" class="form-control w-100 text-center d-inline text-white z-bg-secondary-dark" placeholder="Saisir la quantité" type="number" min="1">
                            </td>
                            <td class="text-capitalize pl-2">{{$product->price * (int)$quantities[$product->id]}}</td>
                            <td wire:click="retrieve({{$product->id}})" class="text-center cursor-pointer" title="Retirer cet article du panier">
                                <span class="bi-trash text-orange"></span>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="py-2 text-center" colspan="3">Total</td>
                            <td class="py-2 text-center" >{{array_sum($quantities)}}</td>
                            <td class="py-2 text-center" colspan="2">{{ $this->amount }} FCFA</td>
                        </tr>
                    </tbody>
                </table>
                <div class="mx-auto d-flex justify-center mt-2 col-8">
                    <span class="px-2 text-center py-2 w-75 cursor-pointer bg-orange text-white border border-white rounded">
                        <strong class="bi-cart-check"></strong>
                        <span class="mx-2">Valider mon panier</span>
                        <strong class="bi-arrow-right"></strong>
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endauth
</div>
