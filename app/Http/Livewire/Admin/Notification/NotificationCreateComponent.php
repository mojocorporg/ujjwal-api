<?php

namespace App\Http\Livewire\Admin\Notification;

use Livewire\Component;
use App\Models\Notification;
use Livewire\WithFileUploads;
use App\Jobs\Notification\ScheduledNotificationProcessJob;

class NotificationCreateComponent extends Component
{

    use WithFileUploads;

    public $module = 'Notification';
    public Notification $notification; 
    public $updateMode = false;
    public $selectedItem;
    public $selected_days = [];
    public $icon;   
    public $show_form=false;


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


    public function mount($notification = null)
    {
        if($notification){
            $this->notification = $notification;
            $this->selected_days = $notification->days ? json_decode($notification->days) : [];
            $this->updateMode = true;
        }else{
            $this->notification=new Notification();
            $this->notification->status = 0;
        }
    }

    public $repeat_types = [
            ['key' => 'now', 'value' => 'Now'],
            ['key' => 'once', 'value' => 'Once'],
            ['key' => 'every_day', 'value' => 'Every Day'],
            ['key' => 'custom_day', 'value' => 'Custom Days'],
    ];

    public $days = [
            ['key' => 'sunday', 'value' => 'Sunday'],
            ['key' => 'monday', 'value' => 'Monday'],
            ['key' => 'tuesday', 'value' => 'Tuesday'],
            ['key' => 'wednesday', 'value' => 'Wednesday'],
            ['key' => 'thursday', 'value' => 'Thursday'],
            ['key' => 'friday', 'value' => 'Friday'],
            ['key' => 'saturday', 'value' => 'Saturday'],
    ];

    public $sections = [
    ['key' => 'home', 'value' => 'Home'],
    ['key' => 'my_list', 'value' => 'My List'],
    ['key' => 'business', 'value' => 'Business'],
    ['key' => 'user_profile', 'value' => 'User Profile'],
    ];

    public function getTime($time)
    {
        return $this->notification->schedule_time = $time;
    }

    public function store()
    {
        $this->validate();
        
        $this->notification->sent_count = 0;
        $this->notification->status = $this->notification->status ? 1 : 0;
        if($this->selected_days)
        $this->notification->days = $this->selected_days;
        else
        $this->notification->days = null;        

        $this->notification->schedule_date = isset($this->notification->schedule_date) ? date('Y-m-d', strtotime($this->notification->schedule_date)) : null;
        $this->notification->schedule_time = isset($this->notification->schedule_time) ? date('H:i', strtotime($this->notification->schedule_time)) : null;
        $notification = $this->notification->save();
        if($this->icon){
            $this->notification
            ->addMedia($this->icon->getRealPath())
            ->usingName($this->icon->getClientOriginalName())
            ->toMediaCollection('notifications');
        }

        if($this->notification->repeat_type == 'now'){
            ScheduledNotificationProcessJob::dispatch([], $this->notification)->onQueue('notify');
        }

        $this->show_form=false;
        $this->icon=null;
        if($this->updateMode)
        session()->flash('success', 'Notification successfully updated.');
        else
        session()->flash('success', 'Notification successfully created.');
        $this->updateMode = false;

        return redirect(route('notification.index'));

    }


    
    public function render()
    {
        return view('livewire.admin.notification.notification-create-component')
        ->extends('layouts.app')
        ->section('content');
    }
}
