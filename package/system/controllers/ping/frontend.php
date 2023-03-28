<?php

class ping extends cmsFrontend {

    protected $useOptions = true;

    /**
     * Поддерживаемые ПС
     *
     * @var array
     */
    private $searchengines = [
        'ya_key'   => 'https://yandex.com/',
        'bing_key' => 'https://www.bing.com/'
    ];

    /**
     * Экшен для TXT файлов
     *
     * @param string $key ключ
     */
    public function actionGetKey($key) {

        foreach ($this->searchengines as $key_name => $url) {

            if ($this->options[$key_name] === $key) {

                header('Content-Disposition: inline; filename="'.$key.'.txt"');
                header('Content-type: text/plain');

                die($key);
            }
        }

        return cmsCore::error404();
    }

    /**
     * Ставит URL в очередь
     *
     * @param string $page_url URL страницы для отправки
     */
    public function processPing($page_url) {

        cmsQueue::pushOn('ping', [
            'controller' => $this->name,
            'hook'       => 'queue_ping',
            'params'     => [
                $page_url
            ]
        ]);

    }

    /**
     * Выполняет запросы из очереди, см. хук onPingQueuePing
     *
     * @param string $page_url URL страницы для отправки
     */
    public function sendPing($page_url) {

        $model = new cmsModel();

        // Администраторы сайта
        $admin_ids = $model->filterEqual('is_admin', 1)->
                selectOnly('id')->
                get('{users}', function($item, $model){
                    return $item['id'];
                }, false);

        foreach ($this->searchengines as $key_name => $url) {

            $httpcode = $this->processSearchenginePing($key_name, $page_url);

            if($httpcode != '200'){

                // Отправляем уведомления
                $this->controller_messages->addRecipients($admin_ids)->sendNoticePM([
                    'content' => sprintf(LANG_PING_NOTICE, $url, $httpcode, $page_url)
                ]);

                $this->controller_messages->clearRecipients();
            }
        }
    }

    /**
     * Непосредственно собирает и выполняет запрос
     *
     * @param string $key_name Ключ опции
     * @param string $page_url URL страницы для отправки
     * @return string
     */
    private function processSearchenginePing($key_name, $page_url) {

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);

        if(is_array($page_url)){

            $request = [
                'host'        => $this->cms_config->host,
                'key'         => $this->options[$key_name],
                'keyLocation' => href_to_abs($this->options[$key_name] . '.txt'),
                'urlList'     => $page_url
            ];

            curl_setopt($curl, CURLOPT_URL, $this->searchengines[$key_name].'indexnow');
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json; charset=utf-8']);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));

        } else {

            $request = [
                'url' => $page_url,
                'key' => $this->options[$key_name]
            ];

            curl_setopt($curl, CURLOPT_URL, $this->searchengines[$key_name].'indexnow?' . http_build_query($request));
        }

        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_exec($curl);

        $httpcode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

        curl_close($curl);

        return $httpcode;
    }

}
