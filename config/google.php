<?php

return [
    'application_name' => env('GOOGLE_APPLICATION_NAME', 'Laravel Google Sheets'),

    'client_id' => env('GOOGLE_CLIENT_ID', ''),
    'client_secret' => env('GOOGLE_CLIENT_SECRET', ''),
    'redirect_uri' => env('GOOGLE_REDIRECT', ''),

    'scopes' => [
        \Google\Service\Sheets::SPREADSHEETS,
    ],

    'access_type' => 'offline',
    'approval_prompt' => 'auto',
    'prompt' => 'consent',

    'developer_key' => env('GOOGLE_DEVELOPER_KEY', ''),

    'service' => [
        'enable' => true,
        'file' => env('GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION')
        ? base_path(env('GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION'))
        : storage_path('credentials.json'),
    ],

    'post_spreadsheet_id' => env('GOOGLE_SHEETS_ID'),
    'post_sheet_name' => env('GOOGLE_SHEET_NAME', 'Sheet1'),
];
