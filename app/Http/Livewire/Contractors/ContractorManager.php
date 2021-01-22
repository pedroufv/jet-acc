<?php

namespace App\Http\Livewire\Contractors;

use App\Models\Contractor;
use Livewire\Component;
use Livewire\WithPagination;

class ContractorManager extends Component
{
    use WithPagination;

    public $name;

    public $company_name;

    public $identifier;

    protected $rules = [
        'name' => 'required|min:6',
        'company_name' => 'required',
        'identifier' => 'required',
    ];

    protected $messages = ['name.required' => 'Nome Obrigatorio'];

    public $managing;

    public $managingFor;

    public $confirmingDeletion;

    public $beingDeleted;

    public function getListProperty()
    {
        return Contractor::orderBy('id', 'desc')->paginate();
    }

    public function store()
    {
        Contractor::create($this->validate());

        $this->reset(['name', 'company_name', 'identifier']);

        $this->emit('created');
    }

    public function edit(Contractor $contractor)
    {
        $this->managing = true;

        $this->managingFor = $contractor;

        $this->name = $contractor->name;
        $this->company_name = $contractor->company_name;
        $this->identifier = $contractor->identifier;
    }

    public function cancel()
    {
        $this->reset(['name', 'company_name', 'identifier']);

        $this->managing = false;
    }

    public function update()
    {
        $this->managingFor->update($this->validate());

        $this->reset(['name', 'company_name', 'identifier']);

        $this->managing = false;
    }

    public function confirmDeletion(Contractor $contractor)
    {
        $this->confirmingDeletion = true;

        $this->beingDeleted = $contractor;
    }

    public function destroy()
    {
        $this->confirmingDeletion = false;

        $this->beingDeleted->delete();

        $this->managingFor = null;
    }

    public function render()
    {
        return view('contractors.contractor-manager');
    }
}
