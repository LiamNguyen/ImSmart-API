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

?>  