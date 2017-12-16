<?php
// src/AppBundle/Entity/RestApi.php
namespace AppBundle\Entity;

use AppBundle\Entity\DataInterface;
use AppBundle\Entity\AuthenticatorInterface;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Implements REST API's interface. Uses JSON format.
 */
class RestApi implements RestApiInterface {
    
    /**
     * @var DataInterface Data processing object
     */
    private $data;
    
    /**
     * @var AuthenticatorInterface The API authentication object
     */
    private $authenticator;
    
    const RET_CODES = [
            "200" => "HTTP/1.1 200 OK",
            "201" => "HTTP/1.1 201 Created",
            "204" => "HTTP/1.1 204 No Content",
            "400" => "HTTP/1.1 400 Bad Request",
            "403" => "HTTP/1.1 403 Forbidden",
            "404" => "HTTP/1.1 404 Not Found",
            "405" => "HTTP/1.1 405 Method Not Allowed",
            "500" => "HTTP/1.1 500 Internal Server Error",
            "503" => "HTTP/1.1 503 Service Unavailable"
        ];
    
    /**
     * Processes a request.
     * 
     * @param AppBundle\Entity\DataInterface $aData Data processing object
     * @param AppBundle\Entity\AuthenticatorInterface $aAuthenticator Authentication checker
     * @return string 
     */
    public function __construct(DataInterface $aData, AuthenticatorInterface $aAuthenticator) {
        $this->data = $aData;
        $this->authenticator = $aAuthenticator;
    }
    
    /**
     * Processes a request.
     * 
     * @return array Response with headers, response code, body 
     */
    public function process() {
        $request = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $request = explode('/', trim($request,'/'));
        $resource = array_shift($request);
        $resource = preg_replace('/[^a-z0-9\-\.]+/i','', $resource);
        
        // Work only with prices. If not return 404.
        if($resource != "prices") {
            return $this->buildJsonRequestContent("404", "Bad resource!");
        }
        
        // Validate the referrer
        if(!$this->authenticator->validate()) {
            return $this->buildJsonRequestContent("403", "Bad credentials!");
        }
        
        // Get request body
        $reqBody = json_decode(file_get_contents('php://input'), true);

        $method = $_SERVER["REQUEST_METHOD"];
        
        // Check request method and call appropriate method
        switch ($method) {
            case "GET":
                $quer = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);
                if(!$quer) {
                    return $this->buildJsonRequestContent("400", "Request query is empty!");
                }
                $quer = rawurldecode($quer);
                $querParams = array_filter(explode('&', $quer));
                if(empty($querParams)) {
                    return $this->buildJsonRequestContent("400", "Bad request query!");
                }
                foreach($querParams as $par) {
                    $parCur = array_filter(explode('=', $par));
                    if(empty($parCur)) {
                        return $this->buildJsonRequestContent("400", "Bad request query!");
                    }
                    $querParamsAssoc[$parCur[0]] = $parCur[1];
                }
                
                if(isset($querParamsAssoc["datefr"]) && isset($querParamsAssoc["dateto"])) {
                    $dateFrom = preg_replace('/[^0-9\-]/', "", $querParamsAssoc["datefr"]);
                    $dateTo   = preg_replace('/[^0-9\-]/', "", $querParamsAssoc["dateto"]);
                    // Get prices for types
                    if(isset($querParamsAssoc["types"])) {
                        $types = explode(",", $querParamsAssoc["types"]);
                        $cleanTypes = array_map(
                                function ($t) {
                                    return intval($t);
                                },
                                $types
                            );
                        return $this->buildJsonRequestContent(
                            "200", 
                            json_encode(
                                    $this->data->getAllPrices($dateFrom, $dateTo, $cleanTypes), 
                                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK
                                )
                        );
                    }
                    else {
                        // Get averaged prices only
                        return $this->buildJsonRequestContent(
                                "200", 
                                json_encode(
                                        $this->data->getAveragedPricesByDateInterval($dateFrom, $dateTo), 
                                        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK
                                    )
                            );
                    }
                }
                else {
                    return $this->buildJsonRequestContent("400", "No date interval!");
                }
            case 'PUT':
                // $sql = "update `$table` set $set where id=$key";
                break;
            case 'POST':
                if(empty($reqBody) || !is_array($reqBody)) {
                    return $this->buildJsonRequestContent("204", "No content received!");
                }
                foreach($reqBody as $reqBodyEl) {
                    if(!is_array($reqBodyEl)) {
                        return $this->buildJsonRequestContent("400", "Wrong data format 1!");
                    }
                    foreach($reqBodyEl as $k => $reqBodyElEl) {
                        if(!(is_array($reqBodyElEl) && isset($reqBodyElEl["date"]) && isset($reqBodyElEl["price"]) && isset($reqBodyElEl["type"]) && isset($reqBodyElEl["town"]))) {
                            return $this->buildJsonRequestContent("400", "Wrong data format 2!");
                        }
                        $reqBodyElEl["date"]  = preg_replace('/[^0-9\-]/', "", $reqBodyElEl["date"]);
                        $reqBodyElEl["price"] = preg_replace('/[^0-9]/', "", $reqBodyElEl["price"]);
                        $reqBodyElEl["type"]  = preg_replace('/[^0-9]/', "", $reqBodyElEl["type"]);
                        $reqBodyElEl["town"]  = preg_replace('/[^а-яА-Я\s]/u', "", $reqBodyElEl["town"]);
                    }
                }
                return $this->buildJsonRequestContent(
                            "201", 
                            json_encode(
                                    $this->data->setPrices($reqBody), 
                                    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK
                                )
                        );
                break;
            case 'DELETE':
                //$sql = "delete `$table` where id=$key";
                break;
        }
    }
    
    /*
     * Form JSON request content with code and body.
     * 
     * @param 
     */
    private function buildJsonRequestContent(int $code, $body) {
        $ret["headers"][] = "Content-type: application/json; charset=UTF-8";
        $ret["headers"][] = self::RET_CODES[$code];
        $ret["body"] = $body;
        return $ret;
    }
    
}
