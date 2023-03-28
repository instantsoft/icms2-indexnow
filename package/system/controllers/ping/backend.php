<?php

class backendPing extends cmsBackend {

    public $useDefaultOptionsAction = true;

    public $queue = [
        'queues'           => ['ping'],
        'queue_name'       => LANG_PING_CONTROLLER,
        'use_queue_action' => true
    ];

    public function __construct(cmsRequest $request) {

        parent::__construct($request);

        array_unshift($this->backend_menu,
            [
                'title' => LANG_OPTIONS,
                'url'   => href_to($this->root_url, 'options'),
                'options' => [
                    'icon' => 'cog'
                ]
            ]
        );

    }

    public function actionIndex() {
        $this->redirectToAction('options');
    }

}
