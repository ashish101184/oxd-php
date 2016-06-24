<?php
/**
 * Created Vlad Karapetyan
 */

abstract class Client_OXD_RP{

    private $command_types = array( 'get_authorization_url','update_site_registration', 'get_tokens_by_code','get_user_info', 'register_site','get_logout_uri' );
    protected $data = array();
    protected $command;
    protected $params = array();
    protected $response_json;
    protected $response_object;
    protected $response_status;
    protected $response_data = array();
    protected static $socket = null;
    protected  $base_url;
    protected  $oxd_host_ip;
    protected  $oxd_host_port;
    /**
     * abstract Client_oxd constructor.
     */
    public function __construct($base_url='./', $oxd_host_ip= '127.0.0.1', $oxd_host_port=8099)
    {
        $this->oxd_host_ip = $oxd_host_ip;
        $this->oxd_host_port = $oxd_host_port;
        $this->base_url = $base_url;

        if (filter_var($oxd_host_ip, FILTER_VALIDATE_IP) === false) {
            $this->error_message($oxd_host_ip." is not a valid IP address");
        }

        if(is_int($oxd_host_port) && $oxd_host_port>=0 && $oxd_host_port<=65535){

        }else{
            $this->error_message($oxd_host_port."is not a valid port for socket. Port must be integer and between from 0 to 65535.");
        }
        $this->setCommand();
        $exist = false;
        for ($i = 0; $i < count($this->command_types); $i++) {

            if ($this->command_types[$i] == $this->getCommand()) {
                $exist = true;
                break;
            }
        }
        if (!$exist) {
            $this->log('Command: ' . $this->getCommand() . ' is not exist!','Exiting process.');
            $this->error_message('Command: ' . $this->getCommand() . ' is not exist!');
        }
    }

    /**
     * request to oxd socket
     **/
    public function oxd_socket_request($data,$char_count = 8192){
        if (!self::$socket = stream_socket_client( $this->oxd_host_ip . ':' . $this->oxd_host_port, $errno, $errstr, STREAM_CLIENT_PERSISTENT)) {
            $this->log("Client: socket::socket_connect is not connected, error: ",$errstr);
            die($errno);
        }else{
            $this->log("Client: socket::socket_connect", "socket connected");
        }
        $this->log("Client: oxd_socket_request", fwrite(self::$socket, $data));
        fwrite(self::$socket, $data);
        $result = fread(self::$socket, $char_count);
        if($result){
            $this->log("Client: oxd_socket_response", $result);
        }else{
            $this->log("Client: oxd_socket_response", 'Error socket reading process.');
        }
        if(fclose(self::$socket)){
            $this->log("Client: oxd_socket_connection", "disconnected.");
        }
        return $result;
    }
    /**
     * showing errors and exit.
     **/
    public function error_message($error)
    {
        die($error);
    }
    /**
     * saving process in log file.
     **/
    public function log($process, $message){
        $OldFile  = $this->base_url.'logs/oxd-php-server-'.date("Y-m-d") .'.log';
        $person = "\n".date('l jS \of F Y h:i:s A')."\n".$process.$message."\n";
        file_put_contents($OldFile, $person, FILE_APPEND | LOCK_EX);
    }
    /**
     * send function sends the command to the oxD server.
     *
     * Args:
     * command (dict) - Dict representation of the JSON command string
     **/
    public function request()
    {
        $this->setParams();

        $jsondata = json_encode($this->getData(), JSON_UNESCAPED_SLASHES);

        if(!$this->is_JSON($jsondata)){
            $this->log("Sending parameters must be JSON.",'Exiting process.');
            $this->error_message('Sending parameters must be JSON.');
        }
        $lenght = strlen($jsondata);
        if($lenght<=0){
            $this->log("Length must be more than zero.",'Exiting process.');
            $this->error_message("Length must be more than zero.");
        }else{
            $lenght = $lenght <= 999 ? "0" . $lenght : $lenght;
        }

        $this->response_json = $this->oxd_socket_request(utf8_encode($lenght . $jsondata));

        $this->response_json = str_replace(substr($this->response_json, 0, 4), "", $this->response_json);
        if ($this->response_json) {
            $object = json_decode($this->response_json);
            if ($object->status == 'error') {
                $this->error_message($object->data->error . ' : ' . $object->data->error_description);
            } elseif ($object->status == 'ok') {
                $this->response_object = json_decode($this->response_json);
            }
        } else {
            $this->log("Response is empty...",'Exiting process.');
            $this->error_message('Response is empty...');
        }
    }

    /**
     * @return mixed
     */
    public function getResponseStatus()
    {
        return $this->response_status;
    }

    /**
     * @param mixed $response_status
     */
    public function setResponseStatus()
    {
        $this->response_status = $this->getResponseObject()->status;
    }

    /**
     * @return mixed
     */
    public function getResponseData()
    {
        if (!$this->getResponseObject()) {
            $this->response_data = 'Data is empty';
            $this->error_message($this->response_data);
        } else {
            $this->response_data = $this->getResponseObject()->data;
        }
        return $this->response_data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $this->data = array('command' => $this->getCommand(), 'params' => $this->getParams());
        return $this->data;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param string $command
     */
    abstract function setCommand();

    /**
     * getResult function geting result from oxD server.
     * Return: response_object - The JSON response parsing to object
     **/
    public function getResponseObject()
    {
        return $this->response_object;
    }

    /**
     * function getting result from oxD server.
     * return: response_json - The JSON response from the oxD Server
     **/
    public function getResponseJSON()
    {
        return $this->response_json;
    }

    /**
     * @param array $params
     */
    abstract function setParams();

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * checking format string.
     * @param  string  $string
     * @return bool
     **/
    public function is_JSON($string){
        return is_string($string) && is_object(json_decode($string)) ? true : false;
    }

}