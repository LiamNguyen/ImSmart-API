<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
// require __DIR__ . '/../src/routes.php';

require_once __DIR__ . '/../src/include/DbOperation.php';

require_once __DIR__ . '/../src/include/Locale.php';

require_once __DIR__ . '/../src/include/utils/ValidationRules.php';

require __DIR__ . '/../lib/Prs/RequestInterface.php';

require __DIR__ . '/../lib/Prs/ResponseInterface.php';

require __DIR__ . '/../lib/Prs/ServerRequestInterface.php';

$app->get('/test/running', function () {
    return 'running';
});

/* *
 * URL: http://210.211.109.180/drmuller/api/light
 * Parameters: none
 * Authorization: none
 * Method: GET
 * */
$app->get('/lights', function ($request, $response) {
    $db = new DbOperation();
    $result = $db->getAllLights();
    $lights = array();
    $temp = array();

    while($row = $result->fetch_object()) {
        $temp = $row;
        array_push($lights, $temp);
    }

    return responseBuilder(200, $response, $lights);
});

/* *
 * URL: http://210.211.109.180/drmuller/api/airconditioner
 * Parameters: none
 * Authorization: none
 * Method: GET
 * */
$app->get('/airconditioners', function ($request, $response) {
    $db = new DbOperation();
    $result = $db->getAllAirConditioners();
    $airconditioners = array();
    $temp = array();

    while($row = $result->fetch_object()) {
        $temp = $row;
        array_push($airconditioners, $temp);
    }

    return responseBuilder(200, $response, $airconditioners);
});

/* *
 * Type: Helper method
 * Responsibility: Build response with contentType and httpStatusCode
 * */

function responseBuilder($status_code, $response, $responseObj) {
    return $response->withStatus($status_code)
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode($responseObj));
}

// Run app
$app->run();
