<?php
class Pages extends Controller{
    public function __construct(){
       
    }
    public function index(){
        if(isLoggedIn()){
            redirect("posts");
        }
        $data = [
            "title"=>"SharePosts"
        ];
        $this->view("pages/index",$data);
    }
    public function about(){
        $data = [
            "title"=>"About Us"
        ];
        
        $this->view("pages/about",$data);

    }
}