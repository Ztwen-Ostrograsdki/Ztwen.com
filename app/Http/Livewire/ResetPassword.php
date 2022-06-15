<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Rules\EqualsTo;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Component
{

    public $showPassword = false;
    public $password;
    public $delay;
    public $pageOff = false;
    public $password_confirmation;
    public $user;
    public $token;
    public $user_id;
    public $key;
    public $expires;
    public $code;
    public $hash;
    public $from_email = false;
    public $s;
    protected $rules = [
        'password_confirmation' => 'required|string|between:4,40',
        'password' => 'required|string|confirmed|between:4,40',
    ];


    public function mount($id, $token, $key, $hash, $s, $email)
    {
        if(!request()->hasValidSignature()){
            return abort(401);
        }
        if($id){
            $this->expires = Carbon::parse((int)request()->expires);
            $user = User::where('id', $id)->whereNull('email_verified_token')->whereNull('token')->whereNotNull('email_verified_at')->first();
            if($user){
                $this->user_id = $id;
                $this->user = $user;
                $this->token = $token;
                $this->key = $key;
                $this->hash = $hash;
                if($s !== 'no' && $email == 'yes'){
                    $this->from_email = true;
                    $this->s = $s;
                    $this->code = $this->skey;
                }
            }
            else{
                return abort(403);
            }
        }
       
    }


    
    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function toogleShowPassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function render()
    {
        return view('livewire.reset-password');
    }


    public function resetThePassword()
    {
        if(!request()->hasValidSignature()){
            return abort(419, "Session expirée, veuillez relancer le processus");
        }
        if($this->from_email){
            if($this->skey == $this->user->reset_password_token){
                $this->validate([
                'password_confirmation' => 'bail|required|string|between:4,40',
                'password' => 'bail|required|string|confirmed|between:4,40',
                ]);
            }
            else{
                return abort(404);
            }
        }
        else{
            $this->validate();
            $this->validate(['code' => 'bail|required|string']);
            $this->validate(['code' => new EqualsTo($this->user->reset_password_token)]);
        }
        if(Hash::check($this->password, $this->user->password)){
            $this->addError('password', "Vous ne pouvez pas utiliser ce mot de passe");
            $this->addError('password_confirmation', "Vous ne pouvez pas utiliser ce mot de passe");
        }
        else{
            $this->user->forceFill([
                'password' => Hash::make($this->password),
            ])->save();
            if($this->from_email){
                $this->user->sendEmailForPasswordHaveBeenResetNotification(true);
            }
            else{
                $this->user->sendEmailForPasswordHaveBeenResetNotification(false);
            }
            $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success', 'message' => "La mise à jour de votre mot de passe s'est bien déroulée!"]);
            return redirect()->route('login');
        }
        $this->dispatchBrowserEvent('FireAlertDoNotClose', ['type' => 'success', 'message' => "La mise à jour s'est bien déroulée",  'title' => 'succès']);
    }

    public function cancelResetPassword()
    {
        $user = User::where('id', $this->user_id)->whereNull('email_verified_token')->whereNull('token')->whereNotNull('email_verified_at')->first();
        if($user){
            if($user->reset_password_token){
                $user->forceFill([
                    'reset_password_token' => null,
                ])->save();
            }
        }
        return redirect()->route('login');
    }



    public function getDelay()
    {
        if($this->pageOff){
            $sec = 0;
            $min = 0;
            $this->pageOff = true;
            $this->delay =  " 00 min 00'";
            return false;
        }
        $now = Carbon::now();
        $e = $this->expires;
        $all = $now->diffInSeconds($e);
        if($all == 0){
            $sec = 0;
            $min = 0;
            $this->pageOff = true;
            $this->delay =  " 00 min 00 '";
        }
        else{
            $toMins = $all / 60;
            if($toMins > 1){
                $min = floor($toMins);
                $sec = floor(($toMins - $min)*60);
                $this->pageOff = false;
                $this->delay =  $min . " min " . $sec . " '";
            }
            else{
                $min = '00';
                $sec = $all;
                $this->pageOff = false;
                $this->delay =  $min . " min " . $sec . " '";
            }
        }
        
    }



}
