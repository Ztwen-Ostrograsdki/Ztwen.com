<div class="" style="height: 565px; overflow: auto">
    @if ($tag == 'users')
        @include('livewire.components.admin.theUsers', 
        [
        'users' => $users
        ])
    @elseif ($tag == 'unconfirmed')
        @include('livewire.components.admin.unconfirmed', 
            [
            'unconfirmed' => $unconfirmed
            ])
    @elseif ($tag == 'admins')
        @include('livewire.components.admin.theAdmins', 
            [
            'admins' => $admins
            ])
    @elseif ($tag == "categories")
    @include('livewire.components.admin.theCategories', 
    [
       'categories' => $categories
    ])
    @elseif ($tag == "products")
    @include('livewire.components.admin.theProducts', 
    [
       'products' => $products
    ])
    @elseif ($tag == "comments")
    @include('livewire.comments-lister', 
        [
            'comments' => $comments
        ]
    )
    @endif
</div>