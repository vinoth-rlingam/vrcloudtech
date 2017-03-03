<?PHP
require_once("include/membersite_config.php");

if(!$vrcloudtechmembersite->CheckLogin())
{
    $vrcloudtechmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($vrcloudtechmembersite->ChangePassword())
   {
        $vrcloudtechmembersite->RedirectToURL("index.php");
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Change password</title>
      <link rel="STYLESHEET" type="text/css" href="css/fg_membersite.css" />      
      <link rel="STYLESHEET" type="text/css" href="css/pwdwidget.css" />
      <script src="scripts/pwdwidget.js" type="text/javascript"></script>       
</head>
<body>

<!-- Form Code Start -->
<div id='vrcloudtechmembersite'>
<form id='changepwd' action='<?php echo $vrcloudtechmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>Change Password</legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>

<div class='short_explanation'>* required fields</div>

<div><span class='error'><?php echo $vrcloudtechmembersite->GetErrorMessage(); ?></span></div>
<div class='container'>
    <label for='oldpwd' >Old Password*:</label><br/>
    <div class='pwdwidgetdiv' id='oldpwddiv' ></div><br/>
    
    <input type='password' name='oldpwd' id='oldpwd' maxlength="50" />
    
    <span id='changepwd_oldpwd_errorloc' class='error'></span>
</div>

<div class='container'>
    <label for='newpwd' >New Password*:</label><br/>
    <div class='pwdwidgetdiv' id='newpwddiv' ></div>
   
    <input type='password' name='newpwd' id='newpwd' maxlength="50" /><br/>
    
    <span id='changepwd_newpwd_errorloc' class='error'></span>
</div>

<br/><br/><br/>
<div class='container'>
    <input type='submit' name='Submit' value='Submit' />
</div>

</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->

<script type='text/javascript'>
// <![CDATA[
    var pwdwidget = new PasswordWidget('oldpwddiv','oldpwd');
    pwdwidget.enableGenerate = false;
    pwdwidget.enableShowStrength=false;
    pwdwidget.enableShowStrengthStr =false;
    pwdwidget.MakePWDWidget();
    
    var pwdwidget = new PasswordWidget('newpwddiv','newpwd');
    pwdwidget.MakePWDWidget();
    
  /*  
    var frmvalidator  = new Validator("changepwd");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("oldpwd","req","Please provide your old password");
    
    frmvalidator.addValidation("newpwd","req","Please provide your new password");*/

// ]]>
</script>

<p>
<a href='login-home.php'>Home</a>
</p>

</div>
<!--
Form Code End (see html-form-guide.com for more info.)
-->

</body>
</html>