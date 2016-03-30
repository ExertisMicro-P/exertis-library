<?php

class Security {
    
    
    public function hashPwd($str){
        
        $str = md5($str);
        $str = hash('sha1', $str);
        $str = hash('sha512', $str);
        
        return $str;
        
    }
    
    public function makeSafe($str){
        
        $str = strip_tags($str);
        $str = htmlentities($str);
        $str = stripslashes($str);
        
        return $str;
        
    }
    
    public function generatePassword(){
        
        $chars = $this->makeSafe("qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890!£$%&*()");
        $pwd = [];
        $charsLength = strlen($chars) - 1;
        
        for($i=5; $i<15; $i++){
            $random = rand(0, $charsLength);
            $pwd[] = $chars[$random];
        }
        
        return implode($pwd);
        
    }
    
    public function getIpAddress(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        
        return $ip;
    }
    
    public function loginUser($username, $password){
        
        $auth = dbClass::query('SELECT * FROM admin WHERE username="'.$username.'" AND password="'.$password.'"')->fetch_assoc();
        
        if($auth){
            
            dbClass::query('UPDATE admin SET last_login=now(), login_ip="'.$this->getIpAddress().'" WHERE id='.$auth['id'].'');
            
            return $auth;
        } else {
            return false;
        }
        
    }
    
    public function loginFrontUser($password){
        
        return dbClass::query('SELECT * FROM passwords WHERE password="'.$password.'"')->fetch_assoc();
                
    }
    
    
}

$security = new Security();