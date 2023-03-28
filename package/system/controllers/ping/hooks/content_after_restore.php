<?php

class onPingContentAfterRestore extends cmsAction {

    public function run($data) {

        list($ctype_name, $item) = $data;

        $ctype = cmsCore::getModel('content')->getContentTypeByName($ctype_name);

        if (empty($ctype['options']['is_ping'])) {
            return $data;
        }

        $this->processPing(href_to_abs($ctype['name'], $item['slug'] . '.html'));

        return $data;
    }

}
