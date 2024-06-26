<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Shipu\Watchable\Traits\WatchableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PushNotification extends BaseModel implements HasMedia
{
    use WatchableTrait, InteractsWithMedia;
    protected $table       = 'push_notifications';
    protected $auditColumn = true;

    public function getImageAttribute()
    {
        if (!empty($this->getFirstMediaUrl('pushNotifications'))) {
            return asset($this->getFirstMediaUrl('pushNotifications'));
        }
        return asset('assets/img/default/notification.png');
    }
}
