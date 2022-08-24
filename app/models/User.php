<?php 
class User{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }
    // Register User
    public function register($data){
        $this->db->query("INSERT INTO users(name,email,password)VALUES(:name,:email,:password)"); 
        //Bind Values
        $this->db->bind(":name",$data["name"]);
        $this->db->bind(":email",$data["email"]);
        $this->db->bind(":password",$data["password"]);
        //Execute
        if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
    // Login User
    public function login($email,$password){
        $this->db->query("SELECT * FROM users WHERE email=:email");
        $this->db->bind(":email",$email);
        $this->db->execute();
        $row = $this->db->single();
        $hashedPass = $row->password;
        if(password_verify($password,$hashedPass)){
            return $row;
        }else{
            return false;
        }
        

    }

    //find user by email
    public function findUserByEmail($email){
        $this->db->query("SELECT * From users WHERE email=:email");
        //Bind value
        $this->db->bind(":email",$email);
        //Execute
        $this->db->execute();
        $row = $this->db->single();
        //check row 
        if($this->db->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }
    //Get user by id
    public function getUserById($id){
        $this->db->query("SELECT * From users WHERE id=:id");
        //Bind value
        $this->db->bind(":id",$id);
        //Execute
        $this->db->execute();
        $row = $this->db->single();
        return $row;
    }
}