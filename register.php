<?PHP
require_once("include/class.phpmailer.php");
if(isset($_POST['Submit'])){
	
	RegisterUser();
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
        $formvars['name'] = Sanitize($_POST['fullName']);
		
        $formvars['email'] = Sanitize($_POST['email']);
        $formvars['username'] = Sanitize($_POST['userName']);
        $formvars['password'] = Sanitize($_POST['password']);
		
		
    }
	InsertIntoDB($formvars);
	SendUserConfirmationEmail($formvars);
	return true;
	
}

function Sanitize($str,$remove_nl=true)
    {
        $str = RemoveSlashes($str);

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
		$db_host="";
		$username="";
		$pwd="";
		$database="";
		
		$confirmcode = MakeConfirmationMd5($formvars['email']);
		
		$formvars['confirmcode'] = $confirmcode;
		
        $db_host  = 'vrcloudtech.cntcf3hj2a6p.ap-south-1.rds.amazonaws.com:3306';
        $username = 'vrcloudtech';
        $pwd  = 'vrcloudtech';
        $database  = 'vrcloudtech';
        $tablename = 'registeruser';
		$connection = mysqli_connect($db_host,$username,$pwd,$database);
       if(mysqli_errno($connection)){
	   echo "error db";}else
    
		$insert_query = 'insert into '.$tablename.'(
                name,
                email,
                username,
                password,
				confirmcode
                )
                values
                (
                "' . SanitizeForSQL($formvars['name']) . '",
                "' . SanitizeForSQL($formvars['email']) . '",
                "' . SanitizeForSQL($formvars['username']) . '",
                "' . md5($formvars['password']) . '",
				"' . $formvars['confirmcode'] . '"
                )';   
			
				$insert = $connection->query($insert_query);
				
				
				
	}
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <title>Contact us</title>
      
</head>
<body>

<!-- Form Code Start -->
<form name ="vrcmembervalidation"onsubmit="return validateForm()" method="post">
<fieldset>


<legend>Register</legend>
<!--<input type='hidden' name='submitted' id='submitted' value='1'/>-->
    <div fieldset class="form-group">
    <label for="fullname">FullName</label>
    <input type="text" name="fullName" class="form-control" id="fullName" placeholder="FullName">
  </div>
  
   <div class="form-group">
    <label for="fullname">Email</label>
    <input type="email" name="email" class="form-control" id="email" placeholder="email">
  </div>
   <div class="form-group">
    <label for="fullname">UserName</label>
    <input type="text" name="userName" class="form-control" id="userName" placeholder="userName">
  </div>
   <div class="form-group">
    <label for="fullname">Password</label>
    <input type="password" name="password" class="form-control" id="password" placeholder="password">
  </div>
<div class='container'>
    <input type='submit' name='Submit' value='Submit' />
</div>

</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->

<script type='text/javascript'>
function validateForm() {
    var x = document.forms["vrcmembervalidation"]["userName"].value;
    if (x == "") {
        alert("Name must be filled out");
        return false;
    }
}
</script>

<!--
Form Code End (see html-form-guide.com for more info.)
-->

</body>
</html>