<?php

namespace App\Jobs\Notification;

use App\Models\User;
use LaravelFCM\Facades\FCM;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendSingleNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user,object $data)
    {
        $this->user=$user;
        $this->data=$data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (isset($this->user->notification_token) && $this->user->notification_token != null) {
            try{
                $downstreamResponse = FCM::sendTo($this->user->notification_token, null, null, $this->data);
            }catch(\Exception $e){
                \Log::info('Exception From FCM Single Notification'. json_encode((string)$e));
            }catch(\Error $e){
                \Log::info('Error From FCM Single Notification'. json_encode((string)$e));
            }
        } else {
            return [];
        }
    }
}
