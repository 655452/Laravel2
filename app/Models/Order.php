<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Shipu\Watchable\Traits\HasModelEvents;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model implements HasMedia
{
    use HasModelEvents, InteractsWithMedia;

    protected $table    = 'orders';
    protected $fillable = [
        'restaurant_id',
        'user_id',
        'total',
        'sub_total',
        'delivery_charge',
        'status',
        'payment_status',
        'paid_amount',
        'address',
        'payment_method',
        'mobile',
        'lat',
        'long',
        'misc',
        'invoice_id',
        'order_type'
    ];
    protected $casts = [
        'status' => 'int',
        'order_type' => 'int',
        'payment_status' => 'int',
        'product_received' => 'int',
        'payment_method' => 'int',
        'user_id' => 'int',
        'restaurant_id' => 'int',
        'delivery_boy_id' => 'int',
    ];

    public function items()
    {
        return $this->hasMany(OrderLineItem::class)->with('menuItem','variation')->with('restaurant');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->with('media','roles');
    }

    public function delivery()
    {
        return $this->belongsTo(User::class, 'delivery_boy_id', 'id')->with('media','roles');
    }

    public function discount()
    {
        return $this->hasOne(Discount::class,'order_id','id');
    }

    public function getOrderCodeAttribute()
    {
        return json_decode($this->misc)->order_code ?? 'ORD-000000';
    }

    public function getRemarksAttribute()
    {
        return json_decode($this->misc)->remarks;
    }

    private function onModelCreated()
    {
        $invoice_id = Str::uuid();

        $invoice               = new Invoice;
        $invoice->id           = $invoice_id;
        $invoice->meta         = ['order_id' => $this->id, 'amount' => $this->total, 'user_id' => $this->user_id];
        $invoice->creator_type = User::class;
        $invoice->editor_type  = User::class;
        $invoice->creator_id   = 1;
        $invoice->editor_id    = 1;
        $invoice->save();

        $this->invoice_id = $invoice_id;
        $this->save();
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id')->with('media');
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Invoice::class);
    }
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    public function getGetOrderStatusAttribute()
    {
        return __('order_status.' . $this->status);
    }
    public function getGetOrderTypeAttribute()
    {

        return __('orders_type.' . $this->order_type);
    }

    public function getGetPaymentStatusAttribute()
    {
        return __('payment_status.' . $this->payment_status);
    }

    public function getGetPaymentMethodAttribute()
    {
        return __('payment_method.' . $this->payment_method);
    }

    public function getImageAttribute()
    {
        if (!empty($this->getFirstMediaUrl('orders'))) {
            return asset($this->getFirstMediaUrl('orders'));
        }
        return asset('assets/img/default/order.png');
    }

    public function getAttachmentAttribute()
    {
        return $this->getFirstMediaUrl('orders');
    }

    public function getAttachmentInfoAttribute()
    {
        return $this->getFirstMedia('orders');
    }

    public function scopeOrderowner($query)
    {
        $roleID = auth()->user()->myrole ?? 0;
        if ($roleID != UserRole::ADMIN) {
            if ($roleID == UserRole::RESTAURANTOWNER) {
                $restaurant_id = auth()->user()->restaurant->id ?? 0;
                $query->where('restaurant_id', $restaurant_id);
            } else if ($roleID == UserRole::DELIVERYBOY) {
                $query->where('delivery_boy_id', auth()->id());
            } else {
                $query->where('user_id', auth()->id());
            }
        }
    }
}
