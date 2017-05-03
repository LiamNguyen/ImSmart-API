<?php
    include_once dirname(__FILE__) . '/Constants.php';

/* *
 * SELECT STATEMENTS
 * */
    define(
        'query_Select_AllLights', 
        'SELECT *
         FROM ' . DB_NAME . '.tbl_light'
    );

    define(
        'query_Select_AllAirConditioners', 
        'SELECT * 
         FROM ' . DB_NAME . '.tbl_airconditioner' 
    );

    define(
        'query_Insert_NewLight',
        'INSERT INTO ' . DB_NAME . '.tbl_light
        (IsOn, Brightness, Area)
        VALUES (?, ?, ?)'
    );

    define(
        'query_Update_AirConditioner',
        'UPDATE ' . DB_NAME . '.tbl_airconditioner ac
        SET ac.IsOn = ?, ac.FanSpeed = ?, ac.Swing = ?, ac.Mode = ?, ac.Temperature = ?, ac.IsTimerOn = ?, ac.OffTime = ?, ac.Area = ?
        WHERE ac.Id = ?'
    )

?>  