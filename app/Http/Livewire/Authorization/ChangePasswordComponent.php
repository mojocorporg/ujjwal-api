<?php

namespace App\Http\Livewire\Authorization;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordComponent extends Component
{
    public User $user;
    public $old_password;
    public $new_password;
    public $confirm_password;


    protected $rules = [
        'old_password' => 'required',
        'new_password' => 'required|min:6',
        'confirm_password' => 'required_with:new_password|same:new_password|min:6',
    ];

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function update()
    {
        $user = Auth::user();

        $this->validate();

        if (!$user || !Hash::check($this->old_password, $user->password)) {
            session()->flash('error', 'Current password is not matched');
            return redirect()->route('change.password');
        }

        $user->password = Hash::make($this->new_password); // password
        $user->update();

        session()->flash('success', 'Successfully updated password');
        return redirect()->route('change.password');
    }


    public function render()
    {
        return view('livewire.authorization.change-password-component')
                ->extends('layouts.app')
                ->section('content');
    }

}
