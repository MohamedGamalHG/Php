<?php
require_once './person_class.php';


$errorMsg = '';

$pass = '';
$object=new Person_class();
 
if (isset($_POST['myButton'])) {

         $username=strip_tags(stripslashes($_POST['username']));
          $object->SetUsername($username);
        
         $pass=strip_tags(stripslashes($_POST['pass']));
         $object->SetPassword($pass);

	// error handling conditional checks go here
        if (empty($pass)&&empty($email)) {
            $errorMsg = 'Please fill data field';
        }
	elseif (empty ($username) ) {

		$errorMsg = 'Please fill email field';

	}
       elseif (empty($pass)) {
            $errorMsg = 'Please fill password field';
        }
//        elseif (empty($iris_image)) {
//            $errorMsg = 'Please upload  iris image';
//        }
//
        else {
           

           $return=$object->logIn();
           if($return){
                echo $return;
                header("location: welcome.php");
                exit();
           }
           else{
                 $errorMsg = "Incorrect login data, please try again";
           }


    } // Close else after error checks

        

} //Close if (isset ($_POST['uname'])){

?>
<html >
<head>

<title>Web Intersect &bull; Log In</title>
<style type="text/css">
<!--
body {
	margin-top: 0px;
}
-->
</style></head>
<body>

<table width="400" align="center" cellpadding="6" style="background-color:#FFF; border:#666 1px solid;">
    <form action="login_1_1.php" method="post" enctype="multipart/form-data" name="signinform" id="signinform" >
    <tr>
      <td width="23%"><font size="+2">Log In</font></td>
      <td width="77%"><font color="#FF0000"><?php print "$errorMsg"; ?></font></td>
    </tr>
    <tr>
      <td><strong>Email:</strong></td>
      <td><input name="username" type="text" id="email" style="width:60%;" /></td>
    </tr>
    <tr>
      <td><strong>Password:</strong></td>
      <td><input name="pass" type="password" id="pass" maxlength="24" style="width:60%;"/></td>
    </tr>
  
    <tr>
      <td>&nbsp;</td>
      <td><input name="myButton" type="submit" id="myButton" value="Sign In" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
   

  </form>
</table>
<br />
<br />
<br />
</body>
</html>