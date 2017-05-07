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
        $id = $data->id;
        $isOn = $data->isOn;
        $brightness = $data->brightness;
        $area = $data->area;
        
        $sql = query_Insert_NewLight;
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('ssss', $id, $isOn, $brightness, $area);
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
        $result =$stmt->execute();
        $stmt->close();

        if($result) {
            return true;
        } else {
            return false;
        }
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
            .' ON DUPLICATE KEY UPDATE IsOn=VALUES(IsOn),Brightness=VALUES(Brightness)';

        return $sqlUpdateStmt;
    }

    static function
    Prettify($msg) {
        echo '<br>' . $msg;
    }
}