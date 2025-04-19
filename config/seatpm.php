<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Discord Webhook URL
    |--------------------------------------------------------------------------
    |
    | This webhook will be used to send notifications for project, task,
    | and comment lifecycle events. You can override this at runtime if
    | needed. Leave blank to disable Discord integration.
    |
    */

    'webhook_url' => env('SEATPM_DISCORD_WEBHOOK', ''),

    /*
    |--------------------------------------------------------------------------
    | Enable Global Notifications
    |--------------------------------------------------------------------------
    |
    | If set to true, all activity for any project will be posted to the
    | Discord webhook. If false, only scoped notifications (by visibility)
    | will be triggered.
    |
    */

    'notify_globally' => true,

    /*
    |--------------------------------------------------------------------------
    | Default Gantt Display Range (Days)
    |--------------------------------------------------------------------------
    |
    | This determines the default time window shown on the Gantt chart
    | when viewing a project timeline. You can adjust this globally.
    |
    */

    'gantt_default_days' => 30,

    /*
    |--------------------------------------------------------------------------
    | Plugin Branding Options
    |--------------------------------------------------------------------------
    |
    | You may adjust some visual branding options here for the plugin UI.
    |
    */

    'brand' => [
        'name' => 'SeAT-PM',
        'accent_color' => '#3a9aeb',
    ],
];
