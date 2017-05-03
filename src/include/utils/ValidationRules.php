<?php

class ValidationRules {
/* *
* Type: Helper method
* Responsibility: Check required fields when creating new lights
* */
    function verifyRequiredFieldsForCreatingNewLight($data) {
        $result = array();
        
        if (empty($data->isOn) || empty($data->brightness) || empty($data->area)) {
            $result['status'] = '0';
            $result['message'] = required_fields_missing_message;
            $result['errorCode'] = required_fields_missing_code;
            return array('isValid' => false, 'response' => $result);
        }
        
        return array('isValid' => true);
    }

    function verifyRequiredFieldsForUpdatingAirConditioner($data) {
        $result = array();
        
        if (empty($data->isOn) || empty($data->fanSpeed) || empty($data->swing) || empty($data->mode) || 
            empty($data->temperature) || empty($data->isTimerOn) || empty($data->offTime) || empty($data->area)) {
            $result['status'] = '0';
            $result['message'] = required_fields_missing_message;
            $result['errorCode'] = required_fields_missing_code;
            return array('isValid' => false, 'response' => $result);
        }
        
        return array('isValid' => true);
    }
    

}

?>