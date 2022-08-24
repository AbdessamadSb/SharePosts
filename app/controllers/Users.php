<?php
class Users extends Controller{
    public function __construct()   {
        $this->userModel = $this->model("User");
        
    }
    //Check for Post
    public function register(){
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            // Process Form
            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST,FILTER_UNSAFE_RAW);
            // init data
            $data = [
                'name'=>trim($_POST['name']),
                'email'=>trim($_POST['email']),
                'password'=>trim($_POST['password']),
                'confirm_pass'=>trim($_POST['confirm_pass']),
                'name_err'=>'',
                'email_err'=>'',
                'password_err'=>'',
                'confirm_pass_err'=>''
            ]; 
            // Validate email
            if(empty($data['email'])){
                $data['email_err'] = "Please enter email";
            }else{
                // check email if exist 
                if($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = "Email is already taken";
                }
            }
            // Validate name
            if(empty($data['name'])){
                $data['name_err'] = "Please enter name";
            }
            // Validate password
            if(empty($data['password'])){
                $data['password_err'] = "Please enter password";
            } elseif(strlen($data['password'])<6){
                $data['password_err'] = "Password must be at least 6 characters";
            }
            // Valdiate confirm password
            if(empty($data['confirm_pass'])){
                $data['confirm_pass_err'] = "Please confirm password";
            } else {
                if($data['password']!= $data['confirm_pass']){
                    $data['confirm_pass_err'] = "Passwords do not match";
                }
            }
            // Make sure errors are empty
            if(empty($data['email_err'])&& empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_pass_err'])){
                // Validate 
               
                //hash password 
                $data["password"] = password_hash($data["password"],PASSWORD_DEFAULT);
                // register user
                if($this->userModel->register($data)){
                    flash("register_success","You are registered and you can log in");
                    redirect("users/login");
                }else{
                    die("Something went wrong");
                }

            }else {
                // Load view whit errors
                $this->view("users/register",$data);
            }
        }else{
            // Init Data
            $data = [
                'name'=>'',
                'email'=>'',
                'password'=>'',
                'confirm_pass'=>'',
                'name_err'=>'',
                'email_err'=>'',
                'password_err'=>'',
                'confirm_pass_err'=>''
            ];
            // Load the view
            $this->view('users/register',$data);
        }
    }
    public function login(){
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            // Process Form 
            // Sanitize post data
            $_POST = filter_input_array(INPUT_POST,FILTER_UNSAFE_RAW);
            // init data
            $data = [
                
                'email'=>trim($_POST['email']),
                'password'=>trim($_POST['password']),
                'email_err'=>'',
                'password_err'=>'',
            ]; 
            // Validate email
            if(empty($data['email'])){
                $data['email_err'] = "Please enter email";
            }
            // Validate password
            if(empty($data['password'])){
                $data['password_err'] = "Please enter password";
            } elseif(strlen($data['password'])<6){
                $data['password_err'] = "Password must be at least 6 characters";
            }
            // check for user/mail  
            if($this->userModel->findUserByEmail($data["email"])){
                // User Found 
            }else{
                // User not found
                $data["email_err"] = "No User Found";
            }
            // Make sure errors are empty
            if(empty($data['email_err']) && empty($data['password_err'])){
                // Validate 
                // check and set logged in user
                $loggedInUser = $this->userModel->login($data["email"],$data["password"]);
                if($loggedInUser){
                    //Create Session
                    $this->createUserSession($loggedInUser);
                }else{
                    $data["password_err"] = "Password incorrect";
                    $this->view("users/login",$data);
                }

            }else {
                // Load view whit errors
                $this->view("users/login",$data);
            }

            
        }else{
            // Init Data
            $data = [
                'email'=>'',
                'password'=>'',
                'email_err'=>'',
                'password_err'=>'',
            ];
            // Load the view
            $this->view('users/login',$data);
        }
    }
    public function createUserSession($user){
        $_SESSION["user_id"] = $user->id;
        $_SESSION["user_email"] = $user->email;
        $_SESSION["user_name"] = $user->name;
        redirect("posts");
    }
    public function logout(){
        session_unset();
        session_destroy();
        redirect("users/login");
    }
    
}