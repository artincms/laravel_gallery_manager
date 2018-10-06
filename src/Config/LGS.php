<?php

return [

    /* Important Settings */
    'backend_lgs_middlewares'   => explode(',', env('LGS_BACKEND_MIDDLEWARES', 'web')),
    'frontend_lgs_middlewares'  => explode(',', env('LGS_FRONTEND_MIDDLEWARES', 'web')),
    // you can change default route from sms-admin to anything you want
    'backend_lgs_route_prefix'  => env('LGS_BACKEND_ROUTE_PERFIX', 'LGS'),
    'frontend_lgs_route_prefix' => env('LGS_FRONTEND_ROUTE_PERFIX', 'LGS'),
    // ======================================================================
    //allow user to upload private file in filemanager
    'user_model'                => env('LGS_USER_MODEL', 'App\User'),
    'guest_can_vote'            => env('LGS_GUEST_CAN_VOTE', false),
    'show_bread_crumb'          => env('LGS_SHOW_BREAD_CRUMB', false),
    'multi_lang'                => env('LGS_MULTI_LANG', 'lGS_SampleLang'),
    'header_back_color'         => env('LGS_HEADER_BACK_COLOR', '#00394d'),
    'header_font_color'         => env('LGS_FONT_COLOR', '#ffffff'),

];