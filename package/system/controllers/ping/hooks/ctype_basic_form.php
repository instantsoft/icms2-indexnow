<?php

class onPingCtypeBasicForm extends cmsAction {

    public function run($form) {

        $fieldset = $form->addFieldsetAfter('tags', LANG_PING_CONTROLLER, 'ping', ['is_collapsed' => true]);

        $form->addField($fieldset, new fieldCheckbox('options:is_ping', [
            'title' => LANG_PING_ENABLE
        ]));

        return $form;
    }

}
