<?php



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of person_class
 *
 * @author Wael
 */
session_start();
include_once './DbConnection.php';
class person_class {

    private $fName;
    private $lName;
    private $username;
    private $gender;
    private $password;
    private $birthdate;
    private $address;
    public  $Db;



    public function SetId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }
    public function SetFname($fname) {
        $this->fName = $fname;
    }

    public function getFname() {
        return $this->fName;
    }

    public function SetLname($lname) {
        $this->lName = $lname;
    }

    public function getLname() {
        return $this->lName;
    }

    public function SetUsername($username) {
        $this->username= $username;
    }

    public function getUsername() {
        return $this->username;
    }

    public function SetGender($gender) {
        $this->gender = $gender;
    }

    public function getGender() {
        return $this->gender;
    }

    public function SetPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function SetBirthdate($date) {
        $this->birthdate = $date;
    }

    public function getBirthdate() {
        return $this->birthdate;
    }

    public function SetAddress($date) {
        $this->address = $date;
    }

    public function getAddress() {
        return $this->address;
    }



    public function logIn() {
        $DB = DbConnection::getInstance();
        $this->username=$DB->clean($this->username);
         $this->password=$DB->clean($this->password);
        $query = "SELECT * FROM student WHERE username='$this->username' AND password='$this->password'";

        $result = $DB->database_query($query);
                  
        $login_check = $DB->database_num_rows($result);


        //Check whether the query was successful or not
        if ($login_check > 0) {

            //Login Successful
            session_regenerate_id();
            $member = $DB->database_all_assoc($result);
            $_SESSION['SESS_MEMBER_ID'] = $member[0]['id'];
            $_SESSION['SESS_FIRST_NAME'] = $member[0]['fname'];
            $_SESSION['SESS_LAST_NAME'] = $member[0]['lname'];
          

            session_write_close();

            return true;
        } else {
            return False;
        }

    }

}
?>

