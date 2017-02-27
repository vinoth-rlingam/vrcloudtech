<?PHP
$hi="hi";
echo $hi;
if(isset($_POST['Submit'])){
	
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
$formvars = array();

    {
        $formvars['name'] = Sanitize($_POST['fullName']);
		echo $formvars['name'];
        $formvars['email'] = Sanitize($_POST['email']);
        $formvars['username'] = Sanitize($_POST['userName']);
        $formvars['password'] = Sanitize($_POST['password']);
		
    }
	InsertIntoDB($formvars);
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

function InsertIntoDB(&$formvars)
    {
		$db_host="";
		$username="";
		$pwd="";
		$database="";
		
		
        $db_host  = '127.0.0.1';
        $username = 'root';
        $pwd  = '';
        $database  = 'vrcloudtech';
        $tablename = 'registeruser';
		$connection = mysqli_connect($db_host,$username,$pwd,$database);
       if(mysqli_errno($connection)){
	   echo "error db";}else
    
		$insert_query = 'insert into '.$tablename.'(
                name,
                email,
                username,
                password
                )
                values
                (
                "' . SanitizeForSQL($formvars['name']) . '",
                "' . SanitizeForSQL($formvars['email']) . '",
                "' . SanitizeForSQL($formvars['username']) . '",
                "' . md5($formvars['password']) . '"
                )';   
				$insert = $connection->query($insert_query);
				echo $insert_query;
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