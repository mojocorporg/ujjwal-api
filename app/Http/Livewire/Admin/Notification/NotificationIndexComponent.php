<?php

namespace App\Http\Livewire\Admin\Notification;

use Livewire\Component;
use App\Models\Notification;
use Livewire\WithPagination;

class NotificationIndexComponent extends Component
{
    use WithPagination;

    public $module = 'Notification';
    public Notification $notification; 
    public $query = '', $per_page = 10, $show_form= false, $updateMode = false;


    public function render()
    {
        return view('livewire.admin.notification.notification-index-component', [
            'notifications' => Notification::where('title', 'like', '%'.$this->query.'%')->latest('updated_at')->paginate($this->per_page)
        ])
        ->extends('layouts.app')->section('content');
    }

    public function destroy($id)
    {
        if ($id) {
            $notification = Notification::find($id);
            $notification->delete();
            session()->flash('error', 'Notification successfully deleted.');
        }
    } 
}
