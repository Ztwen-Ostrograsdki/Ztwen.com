<div>
    @if ($tag == 'users')
        @include('livewire.components.admin.theUsers', 
        [
        'users' => $users
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
    @include('livewire.components.admin.theLastComments', 
    [
       'comments' => $comments
    ])
    @endif
</div>