<?php

class onPingPublishDelayedContent extends cmsAction {

    public function run($is_pub_ctype_items) {

        $links = [];

        foreach ($is_pub_ctype_items as $ctype_name => $item) {

            $ctype = $this->model_content->getContentTypeByName($ctype_name);

            if (empty($ctype['options']['is_ping'])) {
                continue;
            }

            $links[] = href_to_abs($ctype['name'], $item['slug'] . '.html');
        }

        $this->processPing($links);

        return $is_pub_ctype_items;
    }

}
