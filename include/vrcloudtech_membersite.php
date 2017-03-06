<?PHP

require_once("class.phpmailer.php");
class vrclouctechsite
{
   
    
    var $username;
    var $pwd;
    var $database;
    var $tablename;
    var $connection;
    var $rand_key;
    
    var $error_message;
	
	function vrcloudtechmembersite()
    {
        $this->sitename = 'vrcloudtech.com';
        $this->rand_key = '0iQx5oBk66oVZep';
    }
	
	 function GetSelfScript()
    {
        return htmlentities($_SERVER['PHP_SELF']);
    }  
	function UserEmail()
	
    {
        return isset($_SESSION['email_of_user'])?$_SESSION['email_of_user']:'';
    }
	 
    function GetErrorMessage()
    {
        if(empty($this->error_message))
        {
            return '';
        }
        $errormsg = nl2br(htmlentities($this->error_message));
        return $errormsg;
    } 
    
  function SafeDisplay($value_name)
    {
        if(empty($_POST[$value_name]))
        {
            return'';
        }
        return htmlentities($_POST[$value_name]);
    }
	
	function InitDB($host,$uname,$pwd,$database,$tablename)
    {
        $this->db_host  = $host;
        $this->username = $uname;
        $this->pwd  = $pwd;
        $this->database  = $database;
        $this->tablename = $tablename;
        
    }
	
	  function SetAdminEmail($email)
    {
        $this->admin_email = $email;
    }
    
    function SetWebsiteName($sitename)
    {
        $this->sitename = $sitename;
    }
    
    function SetRandomKey($key)
    {
        $this->rand_key = $key;
    }
    
    function HandleDBError($err)
    {
        $this->HandleError($err."\r\n mysqlerror:".mysql_error());
    }
    
	 function HandleError($err)
    {
        $this->error_message .= $err."\r\n";
    }
   function GetFromAddress(){

        $host = 'vrcloudtech.net';

        $from ="donotreply@$host";
		echo $from;
        return $from;
    } 


function SendUserConfirmationEmail(&$formvars)

    {
		echo"Inside send mail";
		
        $mailer = new PHPMailer();
		$mailer->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mailer->SMTPAuth = true; // authentication enabled
		$mailer->isSMTP();
		$mailer->CharSet = 'utf-8';
		$mailer->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mailer->Host = "smtp.gmail.com";
		$mailer->Port = 465; // or 587
		$mailer->IsHTML(true);
		$mailer->Username = "vinoth.rlingam@gmail.com";
		$mailer->Password = "Welc0me2";

        
        
        $mailer->AddAddress($formvars['email']);
        
        $mailer->Subject = "Your registration with ".'www.vrcloudtech.net';

        $mailer->From = $this->GetFromAddress();        
        
        $confirmcode = $formvars['confirmcode'];
		
        
        $confirm_url = $this->GetAbsoluteURLFolder().'/confirmreg.php?code='.$confirmcode;
		echo $confirm_url;
        
        $mailer->Body ="Hello ".$formvars['name']."\r\n\r\n".
        "Thanks for your registration with "."www.vrcloudtech.net"."\r\n".
        "Please click the link below to confirm your registration.\r\n".
        "$confirm_url\r\n".
        "\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        "www.vrcloudtech.net";
		if ($mailer->Send()){
			echo "mail failed";
		}
        return true;
    }
    function GetAbsoluteURLFolder()
    {
        $scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
        $scriptFolder .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
		
        return $scriptFolder;
    }
function RegisterUser(){
$formvars = array();

    {
        $formvars['name'] = $this->Sanitize($_POST['fullName']);		
        $formvars['email'] = $this->Sanitize($_POST['email']);
        $formvars['username'] = $this->Sanitize($_POST['userName']);
        $formvars['password'] = $this->Sanitize($_POST['password']);
		
		
    }
	$this->InsertIntoDB($formvars);
	$this->SendUserConfirmationEmail($formvars);
	return true;
	
}

function Sanitize($str,$remove_nl=true)
    {
        $str = $this->RemoveSlashes($str);

        if($remove_nl)
        {
            $injections = array('/(\n+)/i',
                '/(\r+)/i',
                '/(\t+)/i',
                '/(%0A+)/i',
                '/(%0D+)/i',
                '/(%08+)/i',
                '/(%09+)/i'
                );
            $str = preg_replace($injections,'',$str);
        }

        return $str;
    }
	
function RemoveSlashes($str)
    {
        if(get_magic_quotes_gpc())
        {
            $str = stripslashes($str);
        }
        return $str;
    }        
 function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }
    
    
function SanitizeForSQL($str)
    {
        if( function_exists( "mysql_real_escape_string" ) )
        {
              $ret_str = mysql_real_escape_string( $str );
        }
        else
        {
              $ret_str = addslashes( $str );
        }
        return $ret_str;
    }
	
	function MakeConfirmationMd5($email)
    {   
	
	$rand_key = '0iQx5oBk66oVZep';
        $randno1 = rand();
        $randno2 = rand();
        return md5($email.$rand_key.$randno1.''.$randno2);
    }


	 function InsertIntoDB(&$formvars)
    {
    
		$this->connection = mysqli_connect($this->db_host,$this->username,$this->pwd,$this->database);
		
		
        $confirmcode = $this->MakeConfirmationMd5($formvars['email']);
        
        $formvars['confirmcode'] = $confirmcode;
        
        $insert_query = 'insert into '.$this->tablename.'(
                name,
                email,
                username,
                password,
                confirmcode
                )
                values
                (
                "' . $this->SanitizeForSQL($formvars['name']) . '",
                "' . $this->SanitizeForSQL($formvars['email']) . '",
                "' . $this->SanitizeForSQL($formvars['username']) . '",
                "' . md5($formvars['password']) . '",
                "' . $confirmcode . '"
                )';      
				echo $insert_query;
				$insert = $this->connection->query($insert_query);
           
        return true;
    }
	
//User login from idenx page

function Login()
    {
      echo "inside login";
        $username = trim($_POST['username']);
		echo $username;
        $password = trim($_POST['login-pass']);
        
        if(!isset($_SESSION)){ session_start(); }
        if(!$this->CheckLoginInDB($username,$password))
        {
            return false;
        }
        
        $_SESSION[$this->GetLoginSessionVar()] = $username;
        
        return true;
    }

  function GetLoginSessionVar()
    {
        $retvar = md5($this->rand_key);
        $retvar = 'usr_'.substr($retvar,0,10);
        return $retvar;
    }
function CheckLogin()
    {
         if(!isset($_SESSION)){ session_start(); }

         $sessionvar = $this->GetLoginSessionVar();
         
         if(empty($_SESSION[$sessionvar]))
         {
            return false;
         }
         return true;
    }
	
	    function DBLogin()
    {

        $this->connection = mysqli_connect($this->db_host,$this->username,$this->pwd,$this->database);

        if(!$this->connection)
        {   
            $this->HandleDBError("Database Login failed! Please make sure that the DB login credentials provided are correct");
            return false;
        }
       
        return true;
    } 
	
	function CheckLoginInDB($username,$password)
    {
		echo "inside login db";
		if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }   
       //$this->connection = mysqli_connect($this->db_host,$this->username,$this->pwd,$this->database);      
        $username = $this->SanitizeForSQL($username);
        $pwdmd5 = md5($password);
        $qry = "Select name, email from $this->tablename where username='$username' and password='$pwdmd5'";
		
		echo $qry;
       //$result = $this->connection->query($qry);
		$result= mysqli_query($this->connection,$qry);
        
        
        if(!$result || mysqli_num_rows($result) <= 0)
        {
            echo "Error logging in. The username or password does not match";
            return false;
        }
        
       $row = mysqli_fetch_assoc($result);
     $_SESSION['name_of_user']  = $row['name'];
        $_SESSION['email_of_user'] = $row['email'];

        
        
       
        
        return true;
    }
    
    function UserFullName()
    {
        return isset($_SESSION['name_of_user'])?$_SESSION['name_of_user']:'';
    }	
	   
   // Change Password

 function ChangePassword()
    {
        if(!$this->CheckLogin())
        {
            $this->HandleError("Not logged in!");
            return false;
        }
        
        if(empty($_POST['oldpwd']))
        {
            $this->HandleError("Old password is empty!");
            return false;
        }
        if(empty($_POST['newpwd']))
        {
            $this->HandleError("New password is empty!");
            return false;
        }
        
        $user_rec = array();
        if(!$this->GetUserFromEmail($this->UserEmail(),$user_rec))
        {
            return false;
        }
        
        $pwd = trim($_POST['oldpwd']);
		
        
        if($user_rec['password'] != md5($pwd))
        {
            $this->HandleError("The old password does not match!");
            return false;
        }
        $newpwd = trim($_POST['newpwd']);
        
        if(!$this->ChangePasswordInDB($user_rec, $newpwd))
        {
            return false;
        }
        return true;
    }
	
	 function GetUserFromEmail($email,&$user_rec)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }   
        $email = $this->SanitizeForSQL($email);
		
		$qry ="Select * from $this->tablename where email='$email'";
        
        $result = mysqli_query($this->connection,$qry);  

        if(!$result || mysqli_num_rows($result) <= 0)
        {
            $this->HandleError("There is no user with email: $email");
            return false;
        }
        $user_rec = mysqli_fetch_assoc($result);

        echo $user_rec['username'];
        return true;
    }
	
	 function ChangePasswordInDB($user_rec, $newpwd)
    {
        $newpwd = $this->SanitizeForSQL($newpwd);
        
        $qry = "Update $this->tablename Set `password`='".md5($newpwd)."' Where  username='".$user_rec['username']."'";
        
        if(!mysqli_query($this->connection,$qry))
        {
            $this->HandleDBError("Error updating the password \nquery:$qry");
            return false;
        }     
        return true;
    }
	
	//Password reset
	
	function ResetPassword()
    {
        if(empty($_GET['email']))
        {
            $this->HandleError("Email is empty!");
            return false;
        }
        if(empty($_GET['code']))
        {
            $this->HandleError("reset code is empty!");
            return false;
        }
        $email = trim($_GET['email']);
        $code = trim($_GET['code']);
        
        if($this->GetResetPasswordCode($email) != $code)
        {
            $this->HandleError("Bad reset code!");
            return false;
        }
        
        $user_rec = array();
        if(!$this->GetUserFromEmail($email,$user_rec))
        {
            return false;
        }
        
        $new_password = $this->ResetUserPasswordInDB($user_rec);
        if(false === $new_password || empty($new_password))
        {
            $this->HandleError("Error updating new password");
            return false;
        }
        
        if(false == $this->SendNewPassword($user_rec,$new_password))
        {
            $this->HandleError("Error sending new password");
            return false;
        }
        return true;
    }
	
	function SendNewPassword($user_rec, $new_password)
    {
        $email = $user_rec['email'];
        
        $mailer = new PHPMailer();
        
       $mailer->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mailer->SMTPAuth = true; // authentication enabled
		$mailer->isSMTP();
		$mailer->CharSet = 'utf-8';
		$mailer->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mailer->Host = "smtp.gmail.com";
		$mailer->Port = 465; // or 587
		$mailer->IsHTML(true);
		$mailer->Username = "vinoth.rlingam@gmail.com";
		$mailer->Password = "Welc0me2";
        
        $mailer->AddAddress($email,$user_rec['name']);
        
        $mailer->Subject = "Your new password for ".$this->sitename;

        $mailer->From = $this->GetFromAddress();
        
        $mailer->Body ="Hello ".$user_rec['name']."\r\n\r\n".
        "Your password is reset successfully. ".
        "Here is your updated login:\r\n".
        "username:".$user_rec['username']."\r\n".
        "password:$new_password\r\n".
        "\r\n".
        "Login here: ".$this->GetAbsoluteURLFolder()."/login.php\r\n".
        "\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        $this->sitename;
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }    
	
	 function EmailResetPasswordLink()
    {
        if(empty($_POST['email']))
        {
            $this->HandleError("Email is empty!");
            return false;
        }
        $user_rec = array();
        if(false === $this->GetUserFromEmail($_POST['email'], $user_rec))
        {
            return false;
        }
        if(false === $this->SendResetPasswordLink($user_rec))
        {
            return false;
        }
        return true;
    }
	
	 function GetResetPasswordCode($email)
    {
       return substr(md5($email.$this->sitename.$this->rand_key),0,10);
    }
	
	function SendResetPasswordLink($user_rec)
    {
        $email = $user_rec['email'];
        
        $mailer = new PHPMailer();
		$mailer->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mailer->SMTPAuth = true; // authentication enabled
		$mailer->isSMTP();
		$mailer->CharSet = 'utf-8';
		$mailer->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mailer->Host = "smtp.gmail.com";
		$mailer->Port = 465; // or 587
		$mailer->IsHTML(true);
		$mailer->Username = "vinoth.rlingam@gmail.com";
		$mailer->Password = "Welc0me2";
        
   
        
        $mailer->AddAddress($email,$user_rec['name']);
        
        $mailer->Subject = "Your reset password request at ".$this->sitename;

        $mailer->From = $this->GetFromAddress();
        
        $link = $this->GetAbsoluteURLFolder().
                '/resetpwd.php?email='.
                urlencode($email).'&code='.
                urlencode($this->GetResetPasswordCode($email));

        $mailer->Body ="Hello ".$user_rec['name']."\r\n\r\n".
        "There was a request to reset your password at ".$this->sitename."\r\n".
        "Please click the link below to complete the request: \r\n".$link."\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        $this->sitename;
        
        if(!$mailer->Send())
			
        {echo "mail not sent";
            return false;
        }
        return true;
    }
	
	 function ConfirmUser()
    {
        if(empty($_GET['code'])||strlen($_GET['code'])<=10)
        {
            $this->HandleError("Please provide the confirm code");
            return false;
        }
        $user_rec = array();
        if(!$this->UpdateDBRecForConfirmation($user_rec))
        {
            return false;
        }
        
        $this->SendUserWelcomeEmail($user_rec);
        
        
        
        return true;
    }  

 function UpdateDBRecForConfirmation(&$user_rec)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }   
        $confirmcode = $this->SanitizeForSQL($_GET['code']);
        
        $result = mysqli_query($this->connection,"Select name, email from $this->tablename where confirmcode='$confirmcode'");   
        if(!$result || mysqli_num_rows($result) <= 0)
        {
            $this->HandleError("Wrong confirm code.");
            return false;
        }
        $row = mysqli_fetch_assoc($result);
        $user_rec['name'] = $row['name'];
        $user_rec['email']= $row['email'];
        
        $qry = "Update $this->tablename Set confirmcode='y' Where  confirmcode='$confirmcode'";
        
        if(!mysqli_query($this->connection, $qry))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$qry");
            return false;
        }      
        return true;
    }	
	
	function SendUserWelcomeEmail(&$user_rec)
    {
        $mailer = new PHPMailer();
		$mailer->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mailer->SMTPAuth = true; // authentication enabled
		$mailer->isSMTP();
		$mailer->CharSet = 'utf-8';
		$mailer->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$mailer->Host = "smtp.gmail.com";
		$mailer->Port = 465; // or 587
		$mailer->IsHTML(true);
		$mailer->Username = "vinoth.rlingam@gmail.com";
		$mailer->Password = "Welc0me2";
                
        $mailer->AddAddress($user_rec['email'],$user_rec['name']);
        
        $mailer->Subject = "Welcome to ".$this->sitename;

        $mailer->From = $this->GetFromAddress();        
        
        $mailer->Body ="Hello ".$user_rec['name']."\r\n\r\n".
        "Welcome! Your registration  with ".$this->sitename." is completed.\r\n".
        "\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        $this->sitename;

        if(!$mailer->Send())
        {
            $this->HandleError("Failed sending user welcome email.");
            return false;
        }
        return true;
    }
	
	
	
	function ResetUserPasswordInDB($user_rec)
    {
        $new_password = substr(md5(uniqid()),0,10);
        
        if(false == $this->ChangePasswordInDB($user_rec,$new_password))
        {
            return false;
        }
        return $new_password;
    }
    
    
    
       
}
?>