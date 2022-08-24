<?php
// App core Class
// Creates URL & loads core Controller
// URL FORMAT  -/controller/method/params
class Core {
    protected $currController = "Pages";
    protected $currMethod = "index";
    protected $params = [];
    public function __construct(){
        //print_r($this->getUrl());
        $url = $this->getUrl();
        if(empty($url)){
            $url[0] = $this->currController;
        }
        // look in controllers for first value  
        if(file_exists('../app/controllers/'.ucwords($url[0]).".php")){
            // If exists, set it as controller
            $this-> currController = ucwords($url[0]);
            // unset 0 index
            unset($url[0]);
        }
        // Require the controller
        require_once "../app/controllers/". $this->currController . ".php";
        // Instantiate controller class
        $this->currController = new $this->currController;
        //check for second part of url
        if (isset($url[1])){
            //Check to see if method exists in controller
            if (method_exists($this->currController,$url[1])){
                $this->currMethod = $url[1];
                unset($url[1]);
                
            }

        }
        // Get params
        $this->params = $url ? array_values($url) : [];
        // call a callback whit array of params
        call_user_func_array([$this->currController,$this->currMethod],$this->params);
    }
    public function getUrl(){
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'],"/");
            $url =filter_var($url,FILTER_SANITIZE_URL);
            $url = explode("/",$url);
            return $url;
        }
    }
}