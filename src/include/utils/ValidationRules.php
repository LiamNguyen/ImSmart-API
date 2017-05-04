<?php

class ValidationRules {
/* *
* Type: Helper method
* Responsibility: Check required fields when creating new lights
* */
    function verifyRequiredFieldsForCreatingNewLight($data) {
        $result = array();
        
        if (!is_int($data->isOn) || !is_int($data->brightness) || empty($data->area)) {
            $result['status'] = 0;
            $result['message'] = required_fields_missing_message;
            $result['errorCode'] = required_fields_missing_code;
            return array('isValid' => false, 'response' => $result);
        }
        
        return array('isValid' => true);
    }
    

}

?>