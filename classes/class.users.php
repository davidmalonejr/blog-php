<?php

class User{

    private $db;
    
    public function __construct($db){
        $this->db = $db; 
    }


    public function is_logged_in(){
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            return true;
        }        
    }

    public function create_hash($value)
    {
        return $hash = password_hash( $value, PASSWORD_DEFAULT );


    }

    private function verify_hash($password,$hash)
    {
        // crypt($hash,$hash) == crypt($password, $hash);
       
        return password_verify( $password, $hash );
    }

    private function get_user_hash($username){    

        try {

         

            $stmt = $this->db->prepare('SELECT password FROM techno_blog_users WHERE username = :username');
            $stmt->execute(array('username' => $username));
            
            $row = $stmt->fetch();
            return $row['password'];

        } catch(PDOException $e) {
            echo '<p class="error">'.$e->getMessage().'</p>';
        }
    }

    
    public function login($username,$password){    

        $dbHashed = $this->get_user_hash($username);

        // $userHashed =json_encode($this->create_hash('password123'));
        // echo $userHashed;
        
        if($this->verify_hash($password,$dbHashed) == 1){
            
            $_SESSION['loggedin'] = true;
            return true;
        }        
    }
    
        
    public function logout(){
        session_destroy();
    }
    
}

?>