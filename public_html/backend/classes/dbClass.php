<?php


class dbClass {
    
    private $dbHost = 'localhost';
    private $dbUser = 'root';
    private $dbPass = '';
    private $dbName = 'exertis-library';
    static  $mysqli;
    
    
    public function __construct(){
        self::$mysqli = new mysqli($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);        
    }    
    
    public static function query($query){
        return self::$mysqli->query($query);
    }
    
    public static function fetchAllUsers(){
        return self::$mysqli->query('SELECT * FROM admin')->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function fetchAllPasswords(){
        return self::$mysqli->query('SELECT * FROM passwords')->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function getPasswordsByAdminId($id){
        return self::$mysqli->query('SELECT * FROM passwords WHERE admin_id='.$id.'')->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function getUserById($id){
        return self::$mysqli->query('SELECT * FROM admin WHERE id='.$id.'')->fetch_assoc();
    }
    
    public static function getLastPasswordId(){
        return self::$mysqli->query('SELECT id FROM passwords ORDER BY id DESC LIMIT 1')->fetch_assoc();
    }
    
    public static function savePassword($name, $password){
        return self::$mysqli->query('INSERT INTO passwords (admin_id, name, password) VALUES ("'.$_COOKIE['userId'].'", "'.$name.'", "'.$password.'")');
    }
    
    public static function saveUser($username, $email, $password){
        return self::$mysqli->query('INSERT INTO admin (username, email, password) VALUES ("'.$username.'", "'.$email.'", "'.$password.'")');
    }
    
    public static function editPassword($id, $name, $password){
        return self::$mysqli->query('UPDATE passwords SET admin_id="'.$_COOKIE['userId'].'", name="'.$name.'", password="'.$password.'" WHERE id="'.$id.'"');
    }
    
    public static function editUser($id, $username, $email){
        return self::$mysqli->query('UPDATE admin SET username="'.$username.'", email="'.$email.'" WHERE id="'.$id.'"');
    }
    
    public static function editUserWithPwd($id, $username, $email, $password){
        return self::$mysqli->query('UPDATE admin SET username="'.$username.'", email="'.$email.'", password="'.$password.'" WHERE id="'.$id.'"');
    }
    
    public static function getPasswordFromPasswords($password){
        return self::$mysqli->query('SELECT id FROM passwords WHERE password="'.$password.'"')->fetch_assoc();
    }
    
    public static function getEmailFromUsers($email){
        return self::$mysqli->query('SELECT id FROM admin WHERE email="'.$email.'"')->fetch_assoc();
    }
    
    public static function getPasswordById($id){
        return self::$mysqli->query('SELECT * FROM passwords WHERE id="'.$id.'"')->fetch_assoc();
    }
    
    public static function getAccessableFiles($id){
        return self::$mysqli->query('SELECT * FROM files WHERE password_id="'.$id.'" ORDER BY id ASC')->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function deletePassword($id){
        $query = self::$mysqli->query('DELETE FROM files WHERE password_id="'.$id.'"');
        $query = self::$mysqli->query('DELETE FROM passwords WHERE id="'.$id.'"');
        
        return $query;
    }
    
    public static function deleteUser($id){
        $passwdId = self::$mysqli->query('SELECT id FROM passwords WHERE admin_id="'.$id.'"')->fetch_assoc()['id'];
        
        $query = self::$mysqli->query('DELETE FROM files WHERE password_id="'.$passwdId.'"');
        $query = self::$mysqli->query('DELETE FROM passwords WHERE admin_id="'.$id.'"');
        $query = self::$mysqli->query('DELETE FROM admin WHERE id="'.$id.'"');
        
        return $query;
    }
    
    
}

$db = new dbClass();