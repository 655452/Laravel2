<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class OneTimePasswordSend extends Notification
{
    use Queueable;

    private $otp;

    /**
     * Create a new notification instance.
     *
     * @param $otp
     */
    public function __construct($otp)
    {
       
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $array = [];
        
        if (setting('twilio_disabled') == true &&
            !blank(setting('twilio_from')) &&
            !blank(setting('twilio_account_sid')) 
        ) {
            if (setting('otp_type_checking') == 'phone' || setting('otp_type_checking') == 'both') {
                array_push($array, TwilioChannel::class);
            }
        }

        if (setting('mail_disabled') == true &&
            !blank(setting('mail_host')) &&
            !blank(setting('mail_username')) &&
            !blank(setting('mail_password')) &&
            !blank(setting('mail_port')) &&
            !blank(setting('mail_from_name')) &&
            !blank(setting('mail_from_address'))
        ) {
            if (setting('otp_type_checking') == 'email' || setting('otp_type_checking') == 'both') {
                array_push($array, 'mail');
            }
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
            ->subject("One Time Password")
            ->greeting('Hello '.$notifiable->name.',')
            ->line("This is your otp ".$this->otp);
    }
    /**
     * @param $notifiable
     * @return \NotificationChannels\Twilio\TwilioMessage|TwilioSmsMessage
     */
    public function toTwilio($notifiable)
    {
       
        return (new TwilioSmsMessage())
            ->content("Welcome back $notifiable->name, This is your OTP ".$this->otp);
    }
}
