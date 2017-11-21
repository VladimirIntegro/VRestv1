<?php
// src/AppBundle/Entity/RestApi.php
namespace AppBundle\Entity;

use AppBundle\Entity\DataInterface;

/**
 * Copyright 2017 Vladimir Zhitkov. All rights reserved.
 * @author Vladimir Zhitkov
 * 
 * Implements REST API's interface. Uses JSON format.
 */
class RestApi implements RestApiInterface {
    
    /**
     * @var string Request method. GET, POST, PUT, DELETE allowed
     */
    //private $requestMethod;
    
    /**
     * @var string SERVER path info
     */
    //private $pathInfo;
    
    /**
     * @var string Request body
     */
    //private $requestBody;
    
    /**
     * @var BaseData Data processing object
     */
    private $data;
    
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
     * @param string $aRequestMethod GET, POST, PUT, DELETE
     * @param string $aPathInfo Server path info string
     * @param AppBundle\Entity\DataInterface $aData Data processing object
     * @return string 
     */
    //public function __construct(string $aRequestMethod, string $aPathInfo, DataInterface $aData) {
    public function __construct(DataInterface $aData) {
        //$this->requestMethod = $aRequestMethod;
        //$this->pathInfo = $aPathInfo;
        //$this->requestBody = json_decode(file_get_contents('php://input'),true);
        $this->data = $aData;
    }
    
    /**
     * Processes a request.
     * 
     * @return array Response with headers, response code, body 
     */
    public function process() {
        //$urlPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        //$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
        $request = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        //$request = explode('/', $request);
        //$request = array_shift($request);
        $request = trim($request,'/');
        $request = explode('/', $request);
        $resource = array_shift($request);
        $resource = preg_replace('/[^a-z0-9\-\.]+/i','', $resource);
        
        // Work only with prices. If not return 404.
        if($resource != "prices") {
            $ret["headers"][] = "Content-type: application/json; charset=UTF-8";
            $ret["headers"][] = self::RET_CODES["404"];
            $ret["body"] = "";
            return $ret;
        }
        
        //$resourceType = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
        //$resourceKey = array_shift($request)+0;
        $method = $_SERVER["REQUEST_METHOD"];
        //$query = $_SERVER["QUERY_STRING"];
        //$urlPathParams = explode('/', $urlPath);
        //$resource = array_shift($urlPathParams);
        
        // Check request method and call appropriate method
        switch ($method) {
            case "GET":
                //$query = $_SERVER["QUERY_STRING"];
                //$query = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);
                $ret["headers"][] = "Content-type: application/json; charset=UTF-8";
                if(isset($_GET["datefr"]) && isset($_GET["dateto"])) {
                    $dateFrom = intval($_GET["datefr"]);
                    $dateTo = intval($_GET["dateto"]);
                    $ret["headers"][] = self::RET_CODES["200"];
                    $ret["body"] = json_encode($this->data->getByDateInterval($dateFrom, $dateTo));
                    //$ret["body"] = "request=".print_r($request, true);
                }
                else {
                    $ret["headers"][] = self::RET_CODES["400"];
                    $ret["body"] = "";
                }
                return $ret;
            //case 'PUT':
            //  $sql = "update `$table` set $set where id=$key"; break;
            //case 'POST':
            //  $sql = "insert into `$table` set $set"; break;
            //case 'DELETE':
            //  $sql = "delete `$table` where id=$key"; break;
        }
        
        /*// get the HTTP method, path and body of the request
        //$method = $_SERVER['REQUEST_METHOD'];
        $request = explode('/', trim($this->pathInfo,'/'));
        //$input = json_decode(file_get_contents('php://input'),true);

        // connect to the mysql database
        //$link = mysqli_connect('localhost', 'user', 'pass', 'dbname');
        //mysqli_set_charset($link,'utf8');

        // retrieve the table and key from the path
        $table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
        $key = array_shift($request)+0;

        // escape the columns and values from the input object
        $columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($this->requestBody));
        //$values = array_map(function ($value) use ($link) {
        //    if ($value===null) return null;
        //    return mysqli_real_escape_string($link,(string)$value);
        //},array_values($this->requestBody));
        $values = array_map(function ($value) {
            if($value===null) return null;
            return (string)$value;
        },array_values($this->requestBody));

        // build the SET part of the SQL command
        $set = '';
        for ($i=0;$i<count($columns);$i++) {
            $set.=($i>0?',':'').'`'.$columns[$i].'`=';
            $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
        }

        // create SQL based on HTTP method
        switch ($this->requestMethod) {
          case 'GET':
            //$sql = "select * from `$table`".($key?" WHERE id=$key":''); break;
              $result = $this->data->get();
          //case 'PUT':
          //  $sql = "update `$table` set $set where id=$key"; break;
          //case 'POST':
          //  $sql = "insert into `$table` set $set"; break;
          //case 'DELETE':
          //  $sql = "delete `$table` where id=$key"; break;
        }

        // excecute SQL statement
        //$result = mysqli_query($link,$sql);

        // die if action failed
        if(!$result) {
          //http_response_code(404);
          //die(mysqli_error());
            //return self::RET_CODES["404"];
        }

        // print results, insert id or affected row count
        if ($this->requestMethod == 'GET') {
            //if (!$key) echo '[';
            //for ($i=0;$i<mysqli_num_rows($result);$i++) {
            //  echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
            //}
            //if (!$key) echo ']';
            //$ret["headers"][] = "Access-Control-Allow-Origin: *";
            $ret["headers"][] = "Content-Type: application/json; charset=UTF-8";
            $ret["response"] = $result;
            return $ret;
        //echo json_encode($this->contacts);
        }// elseif ($this->requestMethod == 'POST') {
        //  echo mysqli_insert_id($link);
        //} else {
        //  echo mysqli_affected_rows($link);
        //}

        // close mysql connection
        //mysqli_close($link);*/
    }
    
}
