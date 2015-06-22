<?php

class displayJson {
    
    private $json;
    private $start_level = 0;
    
    /**
     * @param array $json
     */
    public function __construct($json) {
        $this->json = $json;
    }

    /**
     * printValues()
     * display the key/value pairs as simple strings
     */
    function printValuesSimple($key, $value, $level, $keyOnly=FALSE) {
        $indent = str_repeat('-', $level);
        
        // only show key when the value is of type array
        if ($keyOnly) {
            $output = $indent . $key;
        }
        else {
            $output = $indent . $key . ' => ' . $value;
        }
        print $output . EOL;
    }
    
    function printValues($key, $value, $level, $keyStatus='') {
        $output = '';
        $start_output = '';
                
        // only show key when the value is of type array
                
        if ($keyStatus == 'keyOnly') {
            if($level == 0){
                $start_output = '<ul>' . EOL;
            }
            $output = '  <li>' . $key . '</li>' . EOL . '<ul>';
        }
        elseif($keyStatus == 'keyClose' && !is_array($value)){
            $output = '  <li>' . $key . ' => ' . $value . '</li>' . EOL . '</ul>';
            
        }
        elseif(!is_array($value)) {
            $output = '  <li>' . $key . ' => ' . $value . '</li>';
        }
        print $start_output . $output . EOL;
        // @todo need to add </ul> after last element is displayed
       
    }
        
        
    
    /**
     * displayJson
     * loop throught the JSON response and display
     *
     * @param array $response
     * This is an assocciative array from json_decode()
     * @param int $level
     * The hierarchical level of the array item
     */
    function display($json_stream = array(), $level=0) {
        $keyStatus = 'keyOnly';
        
        // send the whole response when first called
        if (empty($json_stream)) {
            $json_stream = $this->json; 
        }
        
        foreach ($json_stream as $key => $value) {
            if (is_array($value)) {
                $this->printValues($key, $value, $level, $keyStatus);
                $level++;
                $this->display($value, $level);
                $level--;
                $keyStatus = 'keyClose';
                $this->printValues($key, $value, $level, $keyStatus);
            }
            /*elseif($level == 0 && !is_array($value)){
                $keyStatus = 'keyClose';
                $this->printValues($key, $value, $level, $keyStatus);
            }*/
            else {
                $this->printValues($key, $value, $level);
            }
        }
        $keyStatus = 'keyClose';
        $this->printValues($key, $value, $level, $keyStatus);
        
    }
}

/******************************************/
// like index.php

error_reporting(E_ALL);

//define('EOL',"<br/>\n");
define('EOL',"\n");

// get json response
$json_response = '{ "extensions" : [ { "name" : "Souhail Afilal", "phoneNumbers" : [ "12032041786" ], "statusItems" : { "uid" : "830", "BLF_Monitored_Extensions" : "{}", "accountId" : "79274", "lastCallTime" : "1434858936098", "available" : "true", "callername" : "", "contactH" : "", "contactM" : "", "userId" : "572752", "StartTime" : "", "callStatus" : "Idle", "contactF" : "", "contactE" : "safilal@recoveryplanner.com", "contactD" : "830", "loginName" : "safilal" }, "extension" : "830", "duration" : -1, "status" : "", "onCallWith" : "" } ], "name" : "message", "type" : "event", "availability" : "AVAILABLE", "numAvailableExts" : 1, "numUnavailableExts" : 0, "servicedBy" : "10.20.5.103" }';
$return_array = TRUE;
$response = json_decode($json_response, $return_array);

// print_r($response);

// display json response
$displayer = new displayJson($response);
$displayer->display();