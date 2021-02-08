<?php

namespace App\Http\Livewire\Admin\Rule;

use App\Models\Rule;
use Livewire\Component;

class RulesComponent extends Component
{
    public $module = 'Rules';
    public Rule $rule; 
    public $updateMode = false;

    protected $rules = [
        'rule.without_login' => 'required',
        'rule.with_login' => 'required',
        'rule.on_referral' => 'required',
    ];

    public function mount()
    {
        $this->rule = Rule::first();
    }

    public function store()
    {
        $this->validate();

        $this->rule->save();

        session()->flash('success', 'Rules successfully updated.');

        return redirect(route('rules.update'));

    }

    public function render()
    {
        return view('livewire.admin.rule.rules-component')
        ->extends('layouts.app')
        ->section('content');;
    }
}
