<?php
namespace App\Helpers\ZtwenManagers;

use App\Models\Image;


trait GaleryManager{

    /**
     * set a default profil photo for a model
     *
     * @return string
     */
    public function defaultProfil($model = 'user')
    {
        if($model == 'user'){
            return "/myassets/images/product_02.jpg";
        }
        elseif($model == 'product'){
            return "/myassets/images/product_03.jpg";
        }
        elseif($model == 'category'){
            return "/myassets/images/product_04.jpg";
        }
        return "/myassets/images/product_08.jpg";
    }
    

    public function __profil($folder = 'originals', $target = 'last')
    {
        $images = $this->images;
        if($images->toArray() !== []){
            if($folder !== 'originals'){
                $path = "/storage/" . $this->imagesFolder . "/formats_" . $folder;
                return $path . "/" . $this->images->reverse()->first()->name;
            }
            else{
                $path = "/storage/" . $this->imagesFolder . "/" . $folder;
                return $path . "/" . $this->images->reverse()->first()->name;
            }
        }
        return $this->defaultProfil();
    }

    public function currentPhoto()
    {
        $images = $this->images;
        if($images->toArray() !== []){
            return $this->current_photo;
        }
        return $this->defaultProfil();
    }

    public function galery($folder = 'originals')
    {
        if($this->images->count() < 1){
            $images = [];
            for ($i=0; $i < 3; $i++) { 
                $images[$i] = $this->defaultProfil('product');
            }
            return $images;
        }
        else{
            return $this->getImagesOfSize($folder);
        }
    }


    public function getImagesOfSize($folder = 'originals')
    {
        $images = $this->images;
        $galery = [];
        if($images->toArray() !== []){
            if($folder !== 'originals'){
                $path = "/storage/" . $this->imagesFolder . "/formats_" . $folder;
                foreach($images as $image){
                    $galery[] = $path . "/" . $image->name;
                }
            }
            else{
                $path = "/storage/" . $this->imagesFolder . "/" . $folder;
                foreach($images as $image){
                    $galery[] = $path . "/" . $image->name;
                }
            }
            return $galery;
        }
        return $this->galery($folder);
    }

    public function productGalery()
    {
        return [];
    }







}