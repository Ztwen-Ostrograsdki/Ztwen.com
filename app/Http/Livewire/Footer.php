<?php

namespace App\Http\Livewire;

use App\Mail\SendEmailToSubscribedVisitors;
use App\Models\SubscribedVisitor;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;


class Footer extends Component
{
    public $chemin = "/myassets/footer/";
    public $author = "/myassets/author/img-1.jpg";

    public $email;
    public $localLang;
    public $footerImages = [];
    public $authorImages = [];

    protected $rules = [
        'email' => 'bail|required|email',
    ];

    public function mount()
    {
        $images = [];
        $authorImages = [];
        $authorImages[] = $this->author;
        
        if(session()->has('localLang')){
            $this->localLang = session('localLang');
            app()->setLocale($this->localLang);
        }
        else{
            $this->localLang = app()->getLocale();
        }
        for ($i = 1; $i <= 20; $i++) { 
            $images[] = $this->chemin . 'footer-' . $i . '.jpg';
            shuffle($images);
        }
        $this->footerImages = $images;
        $this->authorImages = $authorImages;

    }
    public function render()
    {
        return view('livewire.footer');
    }

    public function changeLocalLang()
    {
        session()->put('localLang', $this->localLang);
        app()->setLocale($this->localLang);
    }

    public function subscribeToNewLetter()
    {
        $v = $this->validate(['email' => 'bail|required|email']);
        if($v){
            $ip = request()->ip();
            $create = SubscribedVisitor::create([
                'email' => $this->email,
                'ip_address' => $ip,
            ]);
            if($create){
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success', 'message' => "Vous venez de vous abonner à la news letter avec succès!",  'title' => 'News Letter']);
                Mail::to($this->email)->send(new SendEmailToSubscribedVisitors($create));
                $this->reset('email');
            }
            else{
                $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'error', 'message' => "Une erreure est survenue",  'title' => 'News Letter']);
            }
        }
    }
}
