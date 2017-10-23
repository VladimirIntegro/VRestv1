<?php
// Input file
namespace AppBundle;

use AppBundle\Entity\PdoStorage;
use AppBundle\Entity\PricesData;
use AppBundle\Entity\RestApi;
use AppBundle\Entity\Logger;
use AppBundle\Config\CoreConfig;

// Autoload all classes
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'autoload.php';

try {
    // TODO: Add checking for right IP address of referer and token.
    // The functions should be placed in RestApi
    
    // DB config from included config.php
    $storage = new PdoStorage(CoreConfig::DB);
    $storage->init();

    $data = new PricesData($storage);

    $restApi = new RestApi($data);
    $result = $restApi->process();
    if($result) {
        foreach($result["headers"] as $curHeader) {
            header($curHeader);
        }
        echo $result["body"];
    }

} catch(Exception $e) {
    Logger::log($e);
    header('HTTP/1.1 500 Internal Server Error');
}
