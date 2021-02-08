<?php

namespace App\Http\Livewire\Admin\Business;

use Livewire\Component;
use App\Models\Business;
use App\Models\Tag;

class BusinessCreateComponent extends Component
{
    public $module = 'Business';
    public Business $business; 
    public $updateMode = false;
    public $contacts;
    public $tags_id;
    public $i = 1;

    protected $rules = [
        'business.company_name' => 'required|min:3',
        'business.owner_name' => 'required',
        'business.address' => 'required',
        'business.lat' => 'nullable',
        'business.long' => 'nullable',
        'business.pincode' => 'nullable',
        'business.city' => 'required',
        'business.state' => 'nullable',
        'business.description' => 'required',
        'business.status' => 'nullable',
        'contacts.*' => 'nullable',
        'tags_id' => 'nullable',
    ];

    public function mount($business = null)
    {
        if($business){
            $this->business = $business;
            $this->contacts = $this->business->phones()->pluck('phone_number')->toArray();
            $this->tags_id = $business->tags()->pluck('tags.id')->toArray();
            $this->updateMode = true;
        }else{
            $this->business=new Business();
            $this->business->status = 0;
            // $inputs = $this->i += 0;
            $this->contacts[0] = null;
        }
    }

    public function addRow()
    {
        $inputs = $this->i += 1;
        $this->contacts[$inputs] = null;
    }

    public function removeRow($i)
    {
        unset($this->contacts[$i]);
    }


    public function updateContact($value, $i)
    {
        $this->contacts[$i] = $value;
    }

    public function store()
    {
        $this->validate();

        $this->business->save();

        $contactArray = [];
        foreach($this->contacts as $key => $contact){
           array_push($contactArray, ['business_id' => $this->business->id, 'phone_number' => $contact]);
        }
        if($contactArray){
            $this->business->phones()->delete();
            $this->business->phones()->insert($contactArray);
        }

        $this->business->tags()->sync($this->tags_id);

        if($this->updateMode)
        session()->flash('success', 'Business successfully updated.');
        else
        session()->flash('success', 'Business successfully created.');
        $this->updateMode = false;
        return redirect(route('business'));

    }


    public function render()
    {
        return view('livewire.admin.business.business-create-component', [
            'tags' => Tag::where('status', 1)->get()
        ])
        ->extends('layouts.app')
        ->section('content');
    }
}
