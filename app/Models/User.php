<?php

namespace App\Models;

use App\Models\Bank;
use App\Models\Order;
use App\Models\Waiter;
use App\Models\Address;
use App\Models\Balance;
use App\Enums\BalanceType;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\UserDeposit;
use Spatie\MediaLibrary\HasMedia;
use App\Models\DeliveryBoyAccount;
use Spatie\Permission\Models\Role;
use App\Presenters\InvoicePresenter;
use App\Presenters\CustomerPresenter;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Shipu\Watchable\Traits\HasModelEvents;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject, HasMedia
{
    use Notifiable, InteractsWithMedia, HasModelEvents, HasRoles;
    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'username', 'password', 'phone', 'address', 'roles', 'device_token', 'status', 'applied','provider','provider_id','country_code', 'country_code_name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'status' => 'int',
        'applied'=>'int',
    ];

    protected $appends = ['myrole'];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class)->with('table','timeSlot');
    }

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function deliveryBoyAccount()
    {
        return $this->hasOne(DeliveryBoyAccount::class, 'user_id', 'id');
    }

    public function waiter()
    {
        return $this->hasOne(Waiter::class, 'user_id', 'id');
    }

    public function restaurant()
    {
        return $this->hasOne(Restaurant::class);
    }

    public function balance()
    {
        return $this->belongsTo(Balance::class);
    }

    public function getImageAttribute()
    {
        if (!empty($this->getFirstMediaUrl('user'))) {
            return asset($this->getFirstMediaUrl('user'));
        }
        return asset('themes/images/user-avatar.png');
    }

    public function deleteMedia($mediaName, $mediaId)
    {
        $media = Media::where([
            'collection_name' => $mediaName,
            'model_id' => $mediaId,
            'model_type' => User::class,
        ])->first();

        if ($media) {
            $media->delete();
        }
    }

    public function OnModelCreating()
    {
        $balance               = new Balance();
        $balance->name         = $this->username;
        $balance->type         = BalanceType::REGULAR;
        $balance->balance      = 0;
        $balance->creator_type = 1;
        $balance->creator_id   = 1;
        $balance->editor_type  = 1;
        $balance->editor_id    = 1;
        $balance->save();

        $this->balance_id = $balance->id;
    }

    public function OnModelCreated()
    {
        $deposit                 = new UserDeposit;
        $deposit->user_id        = $this->id;
        $deposit->deposit_amount = 0;
        $deposit->limit_amount   = 0;
        $deposit->save();
    }

    public function routeNotificationForTwilio()
    {
        return $this->phone;
    }

    /**
     * Route notifications for the FCM channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForFcm($notification)
    {
        return $this->device_token;
    }

    public function getMyroleAttribute()
    {
        return $this->roles->pluck('id', 'id')->first();
    }

    public function getrole()
    {
        return $this->hasOne(Role::class, 'id', 'myrole');
    }

    public function deposit()
    {
        return $this->hasOne(UserDeposit::class);
    }

    public function bank()
    {
        return $this->hasOne(Bank::class);
    }

    public function getMyStatusAttribute()
    {
        return trans('user_statuses.' . $this->status);
    }


    public function presentUpcomingInvoice()
    {
        if (!$invoice = $this->upcomingInvoice()) {
            return null;
        }

        return new InvoicePresenter($invoice->asStripeInvoice());
    }

    public function presentCustomer()
    {
        if (!$this->hasStripeId()) {
            return null;
        }

        return new CustomerPresenter($this->asStripeCustomer());
    }

    /**
     * Check if user's team limit reached.
     *
     * @return bool
     */
    public function productLimitReached()
    {
        return $this->shop->products->count() === $this->plan->product_limit;
    }

    public function usage()
    {
        return $this->shop->products->count;
    }

}
