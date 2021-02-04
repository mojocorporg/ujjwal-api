<?php

namespace App\Http\Livewire\Admin\Business;

use Livewire\Component;
use App\Models\Business;
use Livewire\WithPagination;

class BusinessIndexComponent extends Component
{
    use WithPagination;

    public $module = 'Business';
    public Business $business; 
    public $query = '', $per_page = 10, $show_form= false, $updateMode = false;

    public function toggleForm()
    {
        $this->show_form=!$this->show_form;
        if($this->show_form){
            $this->business=new Business();
            $this->business->status = 0;
        }
    }

    protected $rules = [
        'business.name' => 'required|min:3',
        'business.status' => 'nullable',
    ];

    public function store()
    {
        $this->validate();

        $this->business->save();
    
        $this->show_form=false;
        if($this->updateMode)
        session()->flash('success', 'Business successfully updated.');
        else
        session()->flash('success', 'Business successfully created.');
        $this->updateMode = false;
    }

    public function edit(Business $business)
    {
        $this->show_form=true;
        $this->updateMode = true;
        $this->business=$business;
    }


    public function render()
    {
        return view('livewire.admin.business.business-index-component', [
            'businesses' => Business::where('company_name', 'like', '%'.$this->query.'%')->latest()->paginate($this->per_page),
        ])
        ->extends('layouts.app')
        ->section('content');
    }

    public function destroy($id)
    {
        if ($id) {
            $business = Business::find($id);
            $business->delete();
            session()->flash('error', 'Business successfully deleted.');
        }
    }
}
