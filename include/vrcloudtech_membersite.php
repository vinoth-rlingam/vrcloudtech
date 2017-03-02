<?PHP


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
		$mailer->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
		$mailer->Host = "ssl://54.243.97.84";
		$mailer->Port = 25; // or 587
		$mailer->IsHTML(true);
		$mailer->Username = "AKIAJN3ANGOQT4W3NT3A";
		$mailer->Password = "Aj7qf62z65H90nU3nrBmVGsk0SxI3WksMzarJ8byg+Sd";

        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($formvars['email'],$formvars['name']);
        
        $mailer->Subject = "Your registration with ".'www.vrcloudtech.net';

        $mailer->From = GetFromAddress();        
        
        $confirmcode = $formvars['confirmcode'];
		
        
        $confirm_url = GetAbsoluteURLFolder().'/confirmreg.php?code='.$confirmcode;
		echo $confirm_url;
        
        $mailer->Body ="Hello ".$formvars['name']."\r\n\r\n".
        "Thanks for your registration with "."www.vrcloudtech.net"."\r\n".
        "Please click the link below to confirm your registration.\r\n".
        "$confirm_url\r\n".
        "\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        "www.vrcloudtech.net";
		if (!$mailer->Send()){
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
	//SendUserConfirmationEmail($formvars);
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
	
	function CheckLoginInDB($username,$password)
    {
		echo "inside login db";
       $this->connection = mysqli_connect($this->db_host,$this->username,$this->pwd,$this->database);      
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
	   
    
}
?>