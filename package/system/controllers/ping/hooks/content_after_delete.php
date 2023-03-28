<?php

class onPingContentAfterDelete extends cmsAction {

    public function run($data) {

        $ctype = $data['ctype'];
        $item  = $data['item'];

        if (empty($ctype['options']['is_ping'])) {
            return $data;
        }

        $this->processPing(href_to_abs($ctype['name'], $item['slug'] . '.html'));

        return $data;
    }

}
