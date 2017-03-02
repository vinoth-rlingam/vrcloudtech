<?PHP
require_once("./include/membersite_config.php");
if(isset($_POST['Submit'])){
	
	if($vrcloudtechmembersite->RegisterUser()){
		$vrcloudtechmembersite->RedirectToURL("thank-you.html");
	};
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
    <input type="text" name="fullName" class="form-control" id="fullName" value='<?php echo $vrcloudtechmembersite->SafeDisplay('fullName') ?>' placeholder="FullName">
  </div>
  
   <div class="form-group">
    <label for="fullname">Email</label>
    <input type="email" name="email" class="form-control" id="email" value='<?php echo $vrcloudtechmembersite->SafeDisplay('email') ?>' placeholder="email">
  </div>
   <div class="form-group">
    <label for="fullname">UserName</label>
    <input type="text" name="userName" class="form-control" id="userName" value='<?php echo $vrcloudtechmembersite->SafeDisplay('userName') ?>' placeholder="userName">
  </div>
   <div class="form-group">
    <label for="fullname">Password</label>
    <input type="password" name="password" class="form-control" id="password" value='<?php echo $vrcloudtechmembersite->SafeDisplay('password') ?>' placeholder="password">
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