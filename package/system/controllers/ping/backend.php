<?php

class backendPing extends cmsBackend {

    use \icms\controllers\admin\traits\queueActions;

    public $useDefaultOptionsAction = true;

    /**
     * Для трейта queueActions
     * @var array
     */
    public $queue = [
        'queues'           => ['ping'],
        'queue_name'       => LANG_PING_CONTROLLER,
        'use_queue_action' => true
    ];

    public function __construct(cmsRequest $request) {

        parent::__construct($request);

        array_unshift($this->backend_menu,
                [
                    'title'   => LANG_OPTIONS,
                    'url'     => href_to($this->root_url),
                    'options' => [
                        'icon' => 'cog'
                    ]
                ]
        );
    }

}
