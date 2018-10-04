<?php

return [

    /* Important Settings */
    'backend_lgs_middlewares'   => explode(',', env('BACKEND_LGS_MIDDLEWARES', 'web')),
    'frontend_lgs_middlewares'  => explode(',', env('FRONTEND_LGS_MIDDLEWARES', 'web')),
    // you can change default route from sms-admin to anything you want
    'backend_lgs_route_prefix'  => env('BACKEND_LGS_ROUTE_PERFIX', 'LGS'),
    'frontend_lgs_route_prefix' => env('FRONTEND_LGS_ROUTE_PERFIX', 'LGS'),
    // ======================================================================
    //allow user to upload private file in filemanager
    'user_model'                => env('LGS_USER_MODEL', 'App\User'),
    'guest_can_vote'            => env('LGS_GUEST_CAN_VOTE', false),
    'show_bread_crumb'          => env('LGS_SHOW_BREAD_CRUMB', false),
    'multi_lang'                => env('LGS_MULTI_LANG', 'lGS_SampleLang'),
    'header_back_color'         => env('LGS_HEADER_BACK_COLOR', '#00394d'),
    'header_font_color'         => env('LGS_FONT_COLOR', '#ffffff'),

];