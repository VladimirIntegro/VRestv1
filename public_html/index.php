<?php
// Input file
namespace AppBundle;

use AppBundle\Entity\PdoStorage;
use AppBundle\Entity\PricesData;
use AppBundle\Entity\RestApi;
use AppBundle\Entity\Logger;
use AppBundle\Entity\AuthenticatorBasic;
use AppBundle\Config\CoreConfig;

// Autoload all files
require_once '..'.DIRECTORY_SEPARATOR.'src'.DIRECTORY_SEPARATOR.'autoload.php';

try {
    $auth = new AuthenticatorBasic(CoreConfig::AUTH_PARAMS);
    
    // DB config from included config.php
    $storage = new PdoStorage(CoreConfig::DB);
    $storage->init();

    $data = new PricesData($storage);

    $restApi = new RestApi($data, $auth);
    $result = $restApi->process();
    if($result) {
        foreach($result["headers"] as $curHeader) {
            header($curHeader);
        }
        echo $result["body"];
    }

} catch(Exception $e) {
    $logger = new Logger();
    $logger->log($e);
    header('HTTP/1.1 500 Internal Server Error');
}
