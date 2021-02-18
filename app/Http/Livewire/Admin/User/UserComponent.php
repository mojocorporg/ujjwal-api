<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class UserComponent extends Component
{
    use WithPagination;
    public $module = 'Users';
    public $query = '', $per_page = 10;
    
    public function render()
    {
        return view('livewire.admin.user.user-component', [
            'users' => User::withCount(['reviews', 'referrals', 'business_user as calls_count' => function($query){
                $query->select(DB::raw('SUM(call_count)'));
            }, 
            'business_user as shares_count' => function($query){
                $query->select(DB::raw('SUM(share_count)'));
            }])
            ->where('name', 'like', '%'.$this->query.'%')
            ->latest()
            ->paginate($this->per_page),
        ])
        ->extends('layouts.app')
        ->section('content');
    }
}
