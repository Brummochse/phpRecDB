<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
    <head>
        <title>Login Page</title>
        <style type="text/css">
            <!--
            body {font-family: Helvetica, Tahoma, Arial, sans-serif; font-size: 12px; text-align: center; font-weight: normal;}
            h1 {font-family: Helvetica, Tahoma, Arial, sans-serif; font-size: 28px; text-align: center; font-weight: bold;}
            td {font-family: Helvetica, Tahoma, Arial, sans-serif; font-size: 14px; font-weight: normal;}
            -->
        </style>
         <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
    </head>
    <body bgcolor="#e9e9e9">
        <center>
            <h1>phpRecDB</h1>
            <h2>administration area</h2>

            <form action="admin/index.php" method="POST">
                <input type="hidden" name="action" value="login" />
                <table align="center" cellpadding="2" cellspacing="0">
                    <tr><td align="right">Username:</td><td><input type="text" name="userName" /></td></tr>
                    <tr><td align="right">Password:</td><td><input type="password" name="userPass"  /></td></tr>

                    <tr><td></td><td><input type="submit" value="Login"  /></td></tr>
                </table>
            </form>

        </center>
    </body>
</html>