<?php

class ValidationRules {
/* *
* Type: Helper method
* Responsibility: Check required fields when creating new lights
* */
    function verifyRequiredFieldsForCreatingNewLight($data) {
        $result = array();
        $isValid = false;
        
        if (empty($data->isOn) || empty($data->brightness) || empty($data->area)) {
            $result['status'] = 0;
            $result['message'] = required_fields_missing_message;
            $result['errorCode'] = required_fields_missing_code;
            return array('isValid' => false, 'response' => $result)
        }
        
        return array('isValid' => true);
    }
}

?>