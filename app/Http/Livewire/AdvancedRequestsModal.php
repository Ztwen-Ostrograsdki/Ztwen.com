<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Product;
use Livewire\Component;
use App\Rules\PasswordChecked;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class AdvancedRequestsModal extends Component
{
    public $classMapping;
    public $init_process = false;
    public $hideConfirmButton = false;
    public $authentify = false;
    public $action = 'cancel';
    public $modelTable;
    public $records = 0;
    public $trashedRecords = 0;
    public $hasNotTrashedColumn = false;
    public $code;
    public $user;
    public $truth_key;
    public $counter;
    public $process = 100;
    public $fakerQuantity = 1;

    protected $rules = [
        'code' => 'required|string',
    ];

    protected $listeners = ['startAdvancedRequests'];

    public function render()
    {
        return view('livewire.advanced-requests-modal');
    }


    public function startAdvancedRequests($classMapping)
    {
        $this->reset(
                'records', 'trashedRecords', 
                'hasNotTrashedColumn', 'hideConfirmButton',
                'init_process', 'classMapping', 'modelTable', 'action',
                'user', 'code', 'truth_key', 'authentify'
        );
        $this->resetErrorBag();

        $this->setUserAndKey();
        $class = str_replace('-', '\\', $classMapping);
        $model = new $class;
        $this->classMapping = $model;
        $this->modelTable = get_class($model);

        if($this->tableHasColumn('deleted_at')){
            $this->records = $this->classMapping::withTrashed('deleted_at')->get()->count();
            $this->trashedRecords = $this->classMapping::onlyTrashed()->get()->count();
        }
        else{
            $this->records = $this->classMapping::all()->count();
            $this->trashedRecords = 0;
            $this->hasNotTrashedColumn = true;
        }
        
        $this->dispatchBrowserEvent('modal-startAdvancedRequests');
    }


    /**
     * Determine if a model table has a specific column
     *
     * @param string $classMapping
     * @param string $columName
     * @return bool
     */
    public function tableHasColumn($columName)
    {
        $model = $this->classMapping;
        return $model->getConnection()
                        ->getSchemaBuilder()
                        ->hasColumn($model->getTable(), $columName);
    }



    public function setRequestActionTo($action)
    {
        if(in_array($action, ['toTrashed', 'truncate', 'fromTrashed', 'generateFaker'])){
            $this->init_process = true;
            $this->action = $action;
        }
    }

    public function setUserAndKey()
    {
        $this->user = User::find(auth()->user()->id);
        if($this->user->hasAdminAdvancedKey()){
            $this->truth_key = $this->user->userAdminKey->key;
        }
        else{
            $this->user->__generateAdvancedRequestKey();
            $this->truth_key = $this->user->userAdminKey->key;
        }
    }



    public function confirm()
    {
        $this->validate();
        $this->validate(['code' => new PasswordChecked($this->truth_key)]);
        if($this->keyIsExpires()){
            $this->dispatchBrowserEvent('ToastDoNotClose', ['type' => 'error', 'title' => 'Confirmation échouée', 'message' => "Cette clé a déjà expiré. Veuillez renseigner la nouvelle clé."]);
            $this->addError('code', "Cette clé n'est plus valable. Taper la nouvelle clé!");
            $this->user->__regenerateAdminSession();
            $this->user->__generateAdvancedRequestKey();
        }
        else{
            $this->authentify = true;
        }

    }


    public function maker()
    {
        call_user_func(array(__CLASS__, $this->action));
    }


    public function keyIsExpires()
    {
        $now = Carbon::now();
        $e = $this->user->userAdminKey->updated_at;
        $times = $now->diffInMinutes($e);
        if($times > 600){
            return true;
        }
        return false;
    }


    public function toTrashed()
    {
        $data = $this->classMapping::all();
        if(count($data) > 0){
            foreach ($data as $d){
                $d->deleteThisModel(false);
            }
        }

        $this->emit('reloadAdminComponent');
    }

    public function fromTrashed($data = null)
    {
        $data = $this->classMapping::onlyTrashed()->get();
        foreach ($data as $d){
            $d->restoreThisModel();
        }
        $this->emit('reloadAdminComponent');
    }

    public function generateFaker()
    {
        $fakerQuantity = (int)$this->fakerQuantity;
        $this->classMapping::factory($fakerQuantity)->create();
        $this->emit('reloadAdminComponent');
    }

    public function truncate($data = null)
    {
        $classMapping = $this->classMapping;
        Schema::disableForeignKeyConstraints();
        $classMapping::truncate();
        Schema::enableForeignKeyConstraints();
        $this->emit('reloadAdminComponent');
    }


}
