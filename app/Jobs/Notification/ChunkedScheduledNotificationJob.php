<?php

namespace App\Jobs\Notification;

use App\Models\User;
use App\Models\Business;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use LaravelFCM\Message\PayloadDataBuilder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Jobs\Notification\CommonBulkNotificationJob;
use App\Jobs\Notification\SendSingleNotificationJob;

class ChunkedScheduledNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chunkUsersData;
    protected $notification_data;
    /** 
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($chunkUsersData, $notification_data)
    {
        $this->chunkUsersData = $chunkUsersData;
        $this->notification_data = $notification_data;
    }

    public function sendNotification ($users_data,$n) {
        $temp = [
            'notification_id' => $n->id,
            'success' => 0,
            'failed' => 0,
            'delete_token_count' => 0,
            'error_token_count' => 0,
            'modify_token_count' => 0,
            'retry_token_count' => 0,
        ];
        $delay = 0;
        foreach ($users_data as $index => $user){

            $title = preg_replace("/\B::name::\B/", $user->name, $n->title);
            $body = preg_replace("/\B::name::\B/", $user->name, $n->body);

            $dataBuilder = new PayloadDataBuilder();

            $notification_data = $this->notification_data;
            $image= null;
            $img = $this->notification_data->getMedia('notification')->last();
            if($img){
                $image = $img ? $img->getFullUrl() : null;            
            }

            $section_type=Notification::SECTION_APP_OPEN;
            $section_id=null;
            $route= null;            
            if($notification_data->section){
                $section_type=$notification_data->section;
                $section_id=$notification_data->section_id;

                if($section_type == 'user_profile' && $section_id){
                    $user = User::find($section_id);
                    $image = $user->profile_image;
                }

                if($section_type == 'business' && $section_id){
                    $business = Business::find($section_id);
                    $image = $business ? $business->image : null;
                }

            }
            $dataBuilder->addData([
                'title' => $title,
                'body' => $body,
                'image' => $image,
                'url' => $route,
                'section' => $section_type,
                'id' => $section_id
            ]);
            
            // if($index % 200 == 0){
            //     $delay = $delay + 60;
            // }
            $payload = $dataBuilder->build();
            if($user->notification_token) {
                 SendSingleNotificationJob::dispatch($user, $payload)->onConnection('default')->onQueue('notify')->delay($delay);
            }

        }

        // Update datetime after send notification...
        $n->sent_at = date('Y-m-d h:i:s');
        $n->sent_count = ++$n->sent_count;
        $n->update();
        return true;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    
        $title = $this->notification_data->title;
        $body = $this->notification_data->body;
        $title = preg_match("/\B::name::\B/",$this->notification_data->title,$title);
        $body = preg_match("/\B::name::\B/",$this->notification_data->body,$body);
        if($title || $body){
            $this->sendNotification($this->chunkUsersData,$this->notification_data);
        }else{
            $this->sendBulkNotification($this->chunkUsersData,$this->notification_data);
        }  
    }

    public function sendBulkNotification(){
            $dataBuilder = new PayloadDataBuilder();
            $notification_data = $this->notification_data;
            $image= null;
            $img = $this->notification_data->getMedia('notification')->last();
            if($img){
                $image = $img ? $img->getFullUrl() : null;            
            }

            $section_type=Notification::SECTION_APP_OPEN;
            $section_id=null;
            $route= null;            
            if($notification_data->section){
                $section_type=$notification_data->section;
                $section_id=$notification_data->section_id;

                if($section_type == 'user_profile' && $section_id){
                    $user = User::find($section_id);
                    $image = $user->profile_image;
                }

                if($section_type == 'business' && $section_id){
                    $business = Business::find($section_id);
                    $image = $business ? $business->image : null;
                }

            }
            $dataBuilder->addData([
                'title' => $this->notification_data->title,
                'body' => $this->notification_data->body,
                'image' => $image,
                'url' => $route,
                'section' => $section_type,
                'id' => $section_id
            ]);
            
            $payload = $dataBuilder->build();

            $all_tokens = $this->chunkUsersData->pluck('notification_token');
            \Log::info($all_tokens);
            \Log::info(json_encode($payload));

            foreach($all_tokens->chunk(1000) as $key =>  $tokens){
                CommonBulkNotificationJob::dispatch($tokens->toArray(),$payload)->onConnection('default')->onQueue('notify')->delay(now()->addSeconds($key * 5));
            }
    }
}
