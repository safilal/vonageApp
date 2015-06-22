<?php
namespace vonage;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class displayResponse {
    
    private $response;
    private $start_level = 0;
    
    /**
     * @param array $response
     */
    public function __construct($response) {
        $this->response = $this->convertResponse($response);
        print_r($this->response);
    }
    
    private function convertResponse($response) {
        $return_array = TRUE;
        $response = json_decode($response, $return_array);  
        return $response;
    }    
    
    function printValues($key, $value, $level, $keyStatus='') {
        $output = '';
        $start_output = '';

        // only show key when  $value is of type array
        if ($keyStatus == 'keyOnly') {
            if($level == 0){
                // the very first element needs an opening ul tag
                $start_output = '<ul>' . EOL;
            }
            elseif($level > 1) {
                // at end of array items but not the end of the whole array
                // but remember its value is an array so open an <ul>
                $start_output = '</ul>' . EOL . '<ul>' . EOL;
            }
            // display only the key, we'll get the array values recursively
            $output = '  <li>' . $key . '</li>' . EOL . '<ul>';
        }
        elseif($keyStatus == 'keyClose' && !is_array($value)){
            // all elements of an array have been displayed, close it
            $output = '</ul>';
        }
        elseif(!is_array($value)) {
            // just a simple key value pair, display as usual
            $output = '  <li>' . $key . ' => ' . $value . '</li>';
        }

        print $start_output . $output . EOL;
    }
    
    /**
     * displayJson
     * loop throught the JSON response and display
     *
     * @param array $response
     * This is an assocciative array from response_decode()
     * @param int $level
     * The hierarchical level of the array item
     */
    function display($response_stream = array(), $level=0) {
        $keyStatus = 'keyOnly';
        
        // send the whole response when first called
        if (empty($response_stream)) {
            $response_stream = $this->response; 
        }
        
        foreach ($response_stream as $key => $value) {
            if (is_array($value)) {
                $this->printValues($key, $value, $level, $keyStatus);
                $level++;
                // continue to create nested <ul> tags
                $this->display($value, $level);
                // done with nested <ul> tags
            }
            else {
                $this->printValues($key, $value, $level);
            }
        }
        // we are at the end of an array
        $keyStatus = 'keyClose';
        $this->printValues($key, $value, $level, $keyStatus);
        
    }
}
