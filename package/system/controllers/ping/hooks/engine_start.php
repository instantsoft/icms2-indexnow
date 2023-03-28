<?php

class onPingEngineStart extends cmsAction {

    public function run() {

        $matches = [];

        $regexp = '#^([a-zA-Z0-9\-]+)\.txt$#u';

        if(preg_match($regexp, $this->cms_core->uri_action, $matches) ||
                preg_match($regexp, $this->cms_core->uri_controller, $matches)){

            $this->cms_core->uri_controller = 'ping';
            $this->cms_core->uri_action     = 'get_key';
            $this->cms_core->uri_params     = [$matches[1]];
        }

        return true;
    }

}
