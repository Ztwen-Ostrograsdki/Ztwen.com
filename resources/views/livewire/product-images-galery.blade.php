<div>
    <div class="container-fluid">
        <div class="offcanvas offcanvas-end text-white bg-dark" tabindex="-1" id="offcanvasLoadProductImages" aria-labelledby="offcanvasLoadProductImagesLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasLoadProductImagesLabel">
                <span class="bi-tag mr-2"></span> 
                @if ($product)
                <span>
                    {{$product->getName()}}
                </span>
                @endif
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            
            <form class="d-flex mt-3" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
    </div>
</div>