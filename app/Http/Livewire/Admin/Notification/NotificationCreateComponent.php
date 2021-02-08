<?php

namespace App\Http\Livewire\Admin\Notification;

use Illuminate\Notifications\Notification;
use Livewire\Component;

class NotificationCreateComponent extends Component
{
    public $module = 'Notification';
    public Notification $notification; 
    public $updateMode = false;


    protected $rules = [
        'notification.title' => 'required|min:3',
        'notification.body' => 'required|min:3',
        'notification.section' => 'required',
        'notification.section_id' => 'nullable',
        'notification.link' => 'sometimes',
        'notification.repeat_type' => 'nullable',
        'notification.filter_data' => 'nullable',
        'notification.days' => 'nullable',
        'notification.schedule_time' => 'nullable',
        'notification.schedule_date' => 'nullable',
        'notification.notification_data' => 'sometimes',
        'notification.sent_at' => 'sometimes',
        'notification.sent_count' => 'sometimes',
        'notification.status' => 'sometimes',
        'icon' => 'nullable|file|mimes:jpeg,jpg,png|max:1024',
    ];

    
    public function render()
    {
        return view('livewire.admin.notification.notification-create-component');
    }
}
