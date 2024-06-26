<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable / Disable auto save
    |--------------------------------------------------------------------------
    |
    | Auto-save every time the application shuts down
    |
     */
    'auto_save'              => false,

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | Options for caching. Set whether to enable cache, its key, time to live
    | in seconds and whether to auto clear after save.
    |
     */
    'cache'                  => [
        'enabled'    => false,
        'key'        => 'setting',
        'ttl'        => 36000000000,
        'auto_clear' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Setting driver
    |--------------------------------------------------------------------------
    |
    | Select where to store the settings.
    |
    | Supported: "database", "json", "memory"
    |
     */
    'driver'                 => 'database',

    /*
    |--------------------------------------------------------------------------
    | Database driver
    |--------------------------------------------------------------------------
    |
    | Options for database driver. Enter which connection to use, null means
    | the default connection. Set the table and column names.
    |
     */
    'database'               => [
        'connection' => null,
        'table'      => 'settings',
        'key'        => 'key',
        'value'      => 'value',
    ],

    /*
    |--------------------------------------------------------------------------
    | JSON driver
    |--------------------------------------------------------------------------
    |
    | Options for json driver. Enter the full path to the .json file.
    |
     */
    'json'                   => [
        'path' => storage_path() . '/settings.json',
    ],

    /*
    |--------------------------------------------------------------------------
    | Override application config values
    |--------------------------------------------------------------------------
    |
    | If defined, settings package will override these config values.
    |
    | Sample:
    |   "app.locale" => "settings.locale",
    |
     */
    'override'               => [
        "app.name"                                => "app_name",
        "app.env"                                 => "app_env",
        "mail.driver"                             => "mail_driver",
        "mail.host"                               => "mail_host",
        "mail.port"                               => "mail_port",
        "mail.username"                           => "mail_username",
        "mail.password"                           => "mail_password",
        "mail.from.name"                          => "mail_from_name",
        "mail.from.address"                       => "mail_from_address",
        "twilio-notification-channel.auth_token"  => "twilio_auth_token",
        "twilio-notification-channel.account_sid" => "twilio_account_sid",
        "twilio-notification-channel.from"        => "twilio_from",
        "services.fcm.key"                        => "fcm_secret_key",
        "services.stripe.key"                     => "stripe_key",
        "services.stripe.secret"                  => "stripe_secret",
        "services.razorpay.key"                   => "razorpay_key",
        "services.razorpay.secret"                => "razorpay_secret",
        "services.setting.timezone"               => "timezone",
    ],

    /*
    |--------------------------------------------------------------------------
    | Required Extra Columns
    |--------------------------------------------------------------------------
    |
    | The list of columns required to be set up
    |
    | Sample:
    |   "user_id",
    |   "tenant_id",
    |
     */
    'required_extra_columns' => [

    ],
];
