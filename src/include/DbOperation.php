<?php

require_once dirname(__FILE__) . '/DbQueries.php';

require dirname(__FILE__) . '/MailSender/templates/Template_NotifyBooking.php';
require dirname(__FILE__) . '/MailSender/NotifyBookingMailConfig.php';

require dirname(__FILE__) . '/../.././lib/Firebase/src/BeforeValidException.php';
require dirname(__FILE__) . '/../.././lib/Firebase/src/ExpiredException.php';
require dirname(__FILE__) . '/../.././lib/Firebase/src/SignatureInvalidException.php';
require dirname(__FILE__) . '/../.././lib/Firebase/src/JWT.php';
use Firebase\JWT\JWT;

class DbOperation
{
    private $con;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->con = $db->connect();
    }

    //Method to get all the time
    public function getAllLights() {
        $sql = query_Select_AllLights;
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $lights = $stmt->get_result();
        $stmt->close();

        return $lights;        
    }

    //Method to get eco time
    public function getAllAirConditioners() {
        $sql = query_Select_AllAirConditioners;
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $conditioners = $stmt->get_result();
        $stmt->close();

        return $conditioners;
    }
             
    //Method to insert new light
    public function insertNewLight($data) {
        $isOn = $data->isOn;
        $brightness = $data->brightness;
        $area = $data->area;
        
        $sql = query_Insert_NewLight;
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('sss', $isOn, $brightness, $area);
        $result = $stmt->execute();
        $stmt->close();
            
        if ($result == 1) {
            return true;
        }
        else {
            return false;
        }
    }

    public function updateLights($data) {
        $sql = $this->formStringForLightsUpdate($data);
        $stmt = $this->con->prepare($sql);
        $result = $stmt->execute();
        $stmt->close();

        if($result) {
            return true;
        } else {
            return false;
        }
    }

    public function updateAirConditioners($data) {
        $sql = $this->formStringForAirConditionersUpdate($data);
        $stmt = $this->con->prepare($sql);
        $result = $stmt->execute();
        $stmt->close();
            
        if ($result == 1) {
            return true;
        }
        else {
            return false;
        }
    }

    private function formStringForAirConditionersUpdate($data) {
        $sqlUpdateStmt  = '';
        $index          = 0;

        $sqlUpdateStmt  = $sqlUpdateStmt
            .'INSERT INTO beta_imsmartdb.tbl_airconditioner (Id, IsOn, FanSpeed, Swing, Mode, Temperature, IsTimerOn, OffTime) VALUES ';

        foreach ($data as $value) {
            $ac = (object) $value;

            $sqlUpdateStmt = $sqlUpdateStmt
                . '('
                . ($index + 1)
                . ', '
                . ($ac->isOn == '' ? 0 : 1)
                . ', \"'
                . ($ac->fanSpeed)
                . '"\, \"'
                . ($ac->swing)
                . '"\, \"'
                . ($ac->mode)
                . '"\, '
                . ($ac->temperature)
                . ', '
                . ($ac->isTimerOn)
                . ', \"'
                . ($light->offTime)
                . '"\)';

            $index++;

            if ($index == count($data)) {
                break;
            }
            $sqlUpdateStmt = $sqlUpdateStmt . ', ';
        }

        $sqlUpdateStmt  = $sqlUpdateStmt
            .' ON DUPLICATE KEY UPDATE IsOn=VALUES(IsOn), FanSpeed=VALUES(FanSpeed), Swing=VALUES(Swing), Mode=VALUES(Mode), Temperature=VALUES(Temperature), 
            IsTimerOn=VALUES(IsTimerOn), OffTime=VALUES(OffTime)';

        return $sqlUpdateStmt;
    }

    private function formStringForLightsUpdate($data) {
        $sqlUpdateStmt  = '';
        $index          = 0;

        $sqlUpdateStmt  = $sqlUpdateStmt
            .'INSERT INTO beta_imsmartdb.tbl_light (id,IsOn, Brightness) VALUES ';

        foreach ($data as $value) {
            $light = (object) $value;

            $sqlUpdateStmt = $sqlUpdateStmt
                . '('
                . ($index + 1)
                . ', '
                . ($light->isOn == '' ? 0 : 1)
                . ', '
                . $light->brightness
                . ')';

            $index++;

            if ($index == count($data)) {
                break;
            }
            $sqlUpdateStmt = $sqlUpdateStmt . ', ';
        }

        $sqlUpdateStmt  = $sqlUpdateStmt
            .' ON DUPLICATE KEY UPDATE IsOn=VALUES(IsOn), Brightness=VALUES(Brightness)';

        return $sqlUpdateStmt;
    }

    static function
    Prettify($msg) {
        echo '<br>' . $msg;
    }
}