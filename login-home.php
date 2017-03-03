<?PHP
require_once("include/membersite_config.php");

if(!$vrcloudtechmembersite->CheckLogin())
{
    $vrcloudtechmembersite->RedirectToURL("register.php");
    exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Home page</title>
     
	  <style>
div.container {
    width: 100%;   
	background-color: #c6e2ff;
}

header{
    padding: 1em;
    color: white;
    background-color: #191970;
    clear: left;
    text-align: center;
}

nav {
    float: left;
    max-width: 160px;
    margin: 0;
    padding: 1em;
}
span.changepasswordSpace {
    padding-left: 100px;
}

span.controlledSpace {
    padding-left: 900px;
}

</style>
</head>
<body>
<div class="container" id='vrcloudtech_content'style="height: 100%;">
<header>
<div align="right" >
   <h4 align ="right">Hi <?= $vrcloudtechmembersite->UserFullName(); ?></h4>
   <a href='logout.php'>Logout</a></div>
   <a href='change-pwd.php'>Change password</a>
   <span class="changepasswordSpace"/>
   <a href='access-controlled.php'>A sample 'members-only' page</a>
   <span class="controlledSpace"/>
   
   
</header>



</div>
</body>
</html>
