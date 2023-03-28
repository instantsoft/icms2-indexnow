<?php

class onPingForumAfterAddThread extends cmsAction {

    public function run($thread) {

        $this->processPing(href_to_abs('forum', $thread['slug'] . '.html'));

        return $thread;
    }

}
