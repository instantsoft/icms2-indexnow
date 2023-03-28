<?php

class onPingQueuePing extends cmsAction {

    public $disallow_event_db_register = true;

    public function run($attempt, $page_url) {

        $this->sendPing($page_url);

        return true;
    }

}
