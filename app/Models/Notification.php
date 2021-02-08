<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model  implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table='notifications';

    const SECTION_APP_OPEN = 'home';


    protected $fillable=[
        'title',
        'body',
        'section',
        'section_id',
        'repeat_type',
        'filter_data',
        'days',
        'schedule_time',
        'schedule_date',
        'notification_data',
        'sent_at',
        'sent_count',
        'status',
    ];

    public function getImageAttribute()
    {
         $media=$this->getMedia('notifications')->last();
         if($media)
         return $media->getFullUrl();
         else
         return '';
        
    }
    
}
