<?php

class formPingOptions extends cmsForm {

    public function init($options = []) {

        return [
            [
                'type'   => 'fieldset',
                'title'  => LANG_PING_KEYS,
                'childs' => [
                    new fieldString('ya_key', [
                        'title' => sprintf(LANG_PING_KEY, 'Yandex'),
                        'hint'  => LANG_PING_KEY_HINT,
                        'default' => string_random(),
                        'rules' => [
                            ['required'],
                            ['regexp', '#^[a-zA-Z0-9\-]+$#u'],
                            ['min_length', 8],
                            ['max_length', 128]
                        ]
                    ]),
                    new fieldString('bing_key', [
                        'title' => sprintf(LANG_PING_KEY, 'Bing'),
                        'hint'  => LANG_PING_KEY_HINT,
                        'default' => string_random(),
                        'rules' => [
                            ['required'],
                            ['regexp', '#^[a-zA-Z0-9\-]+$#u'],
                            ['min_length', 8],
                            ['max_length', 128]
                        ]
                    ])
                ]
            ],
            [
                'type' => 'html',
                'content' => $options ? sprintf(LANG_PING_KEY_PATHS,
                        href_to($options['ya_key'].'.txt'), href_to_abs($options['ya_key'].'.txt'),
                        href_to($options['bing_key'].'.txt'), href_to_abs($options['bing_key'].'.txt')) : ''
            ]
        ];
    }

}
