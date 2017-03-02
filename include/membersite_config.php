<?PHP
require_once("include/vrcloudtech_membersite.php");

$vrcloudtechmembersite = new vrclouctechsite();

//Provide your site name here
$vrcloudtechmembersite->SetWebsiteName('user11.com');

//Provide the email address where you want to get notifications
$vrcloudtechmembersite->SetAdminEmail('user11@user11.com');

//Provide your database login details here:
//hostname, user name, password, database name and table name
//note that the script will create the table (for example, fgusers in this case)
//by itself on submitting register.php for the first time
$vrcloudtechmembersite->InitDB(/*hostname*/'localhost',
                      /*username*/'root',
                      /*password*/'',
                      /*database name*/'vrcloudtech',
                      /*table name*/'registeruser');

//For better security. Get a random string from this link: http://tinyurl.com/randstr
// and put it here
$vrcloudtechmembersite->SetRandomKey('qSRcVS6DrTzrPvr');

?>