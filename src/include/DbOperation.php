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

    static function
    Prettify($msg) {
        echo '<br>' . $msg;
    }
}