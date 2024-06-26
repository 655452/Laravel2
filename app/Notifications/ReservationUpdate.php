<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Kutia\Larafirebase\Messages\FirebaseMessage;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class ReservationUpdate extends Notification implements ShouldQueue
{
    use Queueable;

    private $reservation;
    protected $fcmTokens;

    /**
     * Create a new notification instance.
     *
     * @param $reservation
     */
    public function __construct($reservation,$fcmTokens)
    {
        $this->reservation = $reservation;
        $this->fcmTokens = $fcmTokens;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $array = ['database', 'firebase'];

        if (setting('twilio_disabled') != true &&
            !blank(setting('twilio_from')) &&
            !blank(setting('twilio_account_sid')) &&
            !blank(setting('twilio_account_sid'))
        ) {
            array_push($array, TwilioChannel::class);
        }

        if (setting('mail_disabled') != true &&
            !blank(setting('mail_host')) &&
            !blank(setting('mail_username')) &&
            !blank(setting('mail_password')) &&
            !blank(setting('mail_port')) &&
            !blank(setting('mail_from_name')) &&
            !blank(setting('mail_from_address'))
        ) {
            array_push($array, 'mail');
        }

        return $array;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Your reservation #".$this->reservation->id." has been created at ".setting('site_name'))
            ->greeting('Hello '.$notifiable->name.',')
            ->line("This is to confirm that your reservation ".$this->reservation->id.", created on ".$this->reservation->created_at)
            ->line('Thank you for making reservation on '.setting('site_name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    /**
     * @param $notifiable
     * @return \NotificationChannels\Twilio\TwilioMessage|TwilioSmsMessage
     */
    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage())
            ->content("Your reservation #".$this->reservation->id." has been created at ".$this->reservation->restaurant->name);
    }


    public function toFirebase($notifiable)
    {
        $title = 'Hello '.$notifiable->name;
        $body  = "Your reservation #".$this->reservation->id." has been updated to ".trans('reservation_status.' . $this->reservation->status).' '.$this->reservation->restaurant->name;
        $icon  = public_path('images/fav.png');
        $image = $this->reservation->restaurant->image;

        return (new FirebaseMessage)
            ->withTitle($title)
            ->withBody($body)
            ->withIcon($icon)
            ->withImage($image)
            ->withClickAction('FLUTTER_NOTIFICATION_CLICK')
            ->withPriority('high')->asMessage($this->fcmTokens);
    }

}
