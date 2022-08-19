<?php

namespace App\Observers;

use App\Models\image;

class ImageObserver
{
    /**
     * Handle the image "created" event.
     *
     * @param  \App\Models\image  $image
     * @return void
     */
    public function created(image $image)
    {
        
    }

    /**
     * Handle the image "updated" event.
     *
     * @param  \App\Models\image  $image
     * @return void
     */
    public function updated(image $image)
    {
        //
    }

    /**
     * Handle the image "deleted" event.
     *
     * @param  \App\Models\image  $image
     * @return void
     */
    public function deleted(image $image)
    {
        //
    }

    /**
     * Handle the image "restored" event.
     *
     * @param  \App\Models\image  $image
     * @return void
     */
    public function restored(image $image)
    {
        //
    }

    /**
     * Handle the image "force deleted" event.
     *
     * @param  \App\Models\image  $image
     * @return void
     */
    public function forceDeleted(image $image)
    {
        //
    }
}
