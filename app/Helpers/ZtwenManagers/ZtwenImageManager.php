<?php
namespace App\Helpers\ZtwenManagers;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Database\Eloquent\Model;

class ZtwenImageManager {

    public $model;
    public $image;
    public $extension;
    public $pathName;
    public $name;
    public $formats = [100, 110, 250, 500, 1200];

    public function __construct(Model $model, $image)
    {
        $this->model = $model;
        $this->image = $image;
        $this->extension = $this->image->extension();
        $this->setImageName($this->extension);
    }

    public function storer($folder)
    {
        $file = $this->image->storeAs($folder . '/originals', $this->getImageName());
        foreach($this->formats as $format){
            $path = storage_path() . "/app/". $folder . "/formats_" . $format;
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }
            $manager = new ImageManager(['driver' => 'gd']);
            $manager->make($this->image)->fit($format, $format)->save($path ."/" . $this->getImageName());

        }
        if($file){
            $this->setPathName($this->getImageName());
            $this->insertIntoDataBase($this->getImageName());
        }
        return $this;

    }


    public function insertIntoDataBase($fileName = null)
    {   
        $db = DB::transaction(function($e) use($fileName) {
            $image = Image::create(['name' => $fileName]);
            if($image){
                $this->adapterToAttachToImage($image);
            }
        });

        return !$db ? true : false;
    }


    public function adapterToAttachToImage(Image $image)
    {
        $class = get_class($this->model);
        if($class == "App\Models\User"){
            return $image->user()->attach($this->model->id);
        }
        elseif($class == "App\Models\Product"){
            return $image->product()->attach($this->model->id);
        }
        elseif($class == "App\Models\Category"){
            return $image->category()->attach($this->model->id);
        }
        else{
            return false;
        }
        
    }


    public function setPathName($path)
    {
        $this->pathName = $path;
        return $this;
    }

    public function getPathName()
    {
        return $this->pathName;
    }

    public function setImageName($extension)
    {
        $name = getdate()['year'].''.getdate()['mon'].''.getdate()['mday'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(20) . '.' . $extension;
        $this->name = $name;
        return $this;
    }

    public function getImageName()
    {
        return $this->name;
    }







}