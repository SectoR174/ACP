<?
include "./includes/config.php";
include "./includes/functions.php";
mysql_connect("$mysql_host","$mysql_login","$mysql_password");
mysql_select_db("$mysql_db_realmd");
echo'
		<form method="post" action="login.php">
			<table>
			<tr>
				<td>Логин</td>
				<td><input type="text" name="login"></td>
			</tr>
			<tr>
				<td>Пароль:</td>
				<td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Войти"></td>
			</tr>
			</table>
		</form>
';
include ("./include/core.php");
session_start();

$ulogin = trim(mysql_escape_string($_POST['login']));
$upass = trim(mysql_escape_string($_POST['pass']));

if($cAcc->CheckAccountExist($ulogin)) {
                $uarray = $cAcc->GetAccIdPassMail($ulogin);
                $pass = strtolower($uarray['sha_pass_hash']);
                $sph =  sha1(strtoupper("$ulogin") .":". strtoupper("$upass"));
                if($sph==$pass) {
                                $_SESSION["loginmode"]=1;
                                $_SESSION["realmid"]=1;
                                $_SESSION["uid"]=$uarray['id'];
                                $_SESSION["accname"]=$ulogin;
                                header("Location: index.php");
                } else {
                                sleep(2);
                                header("Location: login.php?login=false");
                }
} else {
                sleep(2);
                header("Location: login.php?login=false");
}
?> 