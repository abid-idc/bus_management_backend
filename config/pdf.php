<?php

return [
    'mode'                       => '',
    'format'                     => 'A4',
    'default_font_size'          => '12',
    'default_font'               => 'sans-serif',
    'margin_left'                => 10,
    'margin_right'               => 10,
    'margin_top'                 => 10,
    'margin_bottom'              => 10,
    'margin_header'              => 0,
    'margin_footer'              => 0,
    'orientation'                => 'P',
    'title'                      => 'Rapport',
    'author'                     => '',
    'watermark'                  => '',
    'show_watermark'             => false,
    'show_watermark_image'       => false,
    'watermark_font'             => 'sans-serif',
    'display_mode'               => 'fullpage',
    'watermark_text_alpha'       => 0.1,
    'watermark_image_path'       => '',
    'watermark_image_alpha'      => 0.2,
    'watermark_image_size'       => 'D',
    'watermark_image_position'   => 'P',
    'custom_font_dir'  => base_path('resources/fonts/'), // don't forget the trailing slash!
    'custom_font_data' => [
        'montserrat' => [ // must be lowercase and snake_case
            'R'  => 'Montserrat.ttf',    // regular font
            'B'  => 'Montserrat_Bold.ttf',       // optional: bold font
            'I'  => 'Montserrat_Italic.ttf',     // optional: italic font
            'BI' => 'Montserrat_Bold_Italic.ttf' // optional: bold-italic font
        ],
        'candara' => [ // must be lowercase and snake_case
            'R'  => 'Candara.ttf',    // regular font
            'B'  => 'Candara_Bold.ttf',       // optional: bold font
            'I'  => 'Candara_Italic.ttf',     // optional: italic font
            'BI' => 'Candara_Bold_Italic.ttf' // optional: bold-italic font
        ],
        'ubuntu' => [ // must be lowercase and snake_case
            'R'  => 'Ubuntu.ttf',    // regular font
            'B'  => 'Ubuntu_Bold.ttf',       // optional: bold font
            'I'  => 'Ubuntu_Italic.ttf',     // optional: italic font
            'BI' => 'Ubuntu_Bold_Italic.ttf' // optional: bold-italic font
        ],
        // ...add as many as you want.
    ],
    'auto_language_detection'    => false,
    'temp_dir'                   => storage_path('app'),
    'pdfa'                       => false,
    'pdfaauto'                   => false,
    'use_active_forms'           => false,
];