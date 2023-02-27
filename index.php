<?php
$username = "admin";
$password = "password";
$nonsense = "supercalifragilisticexpialidocious";

if (isset($_COOKIE['PrivatePageLogin'])) {
   if ($_COOKIE['PrivatePageLogin'] == md5($password.$nonsense)) {
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Generate Tweets for the Campaign</title>
  <script src="ChatGPT.js?v=61"></script>
  <meta content="text/html; charset=utf-8" http-equiv=Content-Type>
  <link rel="stylesheet" href="styles.css?v=5">
</head>
<body>
  <div id="idContainer">
    <div id="header">
      <h1 id="headerTitle">Twitter Campaign Tool</h1>
      <form action="signout.php" method="post">
        <button type="submit" id="btnSignOut">Sign Out</button>
      </form>
    </div>
    <textarea id="txtOutput" rows="10" placeholder="Output" readonly="readonly"></textarea>

    <div>
      <button type="button" onclick="Send()" id="btnSend">Generate Tweet</button>
      <button type="button" onclick="Copy()" id="btnCopy">Copy to Clipboard</button>
    </div>
    <div id="loaderItem" class="loader hide"></div>

    <label for="hashtagTxt">Hashtag</label>
    <input type="text" id="hashtagTxt" name="hashtagTxt" value="#Chitral">

    <label for="txtMsg">Context</label>
    <textarea id="txtMsg" name="txtMsg" rows="30" wrap="soft">Twitter is a microblogging network. Recently, it was bought by Elon Musk. Since the, he wanted to improve the freedom of speech on Twitter and wanted to improve the engagement and relevancy of the promoted tweets.</textarea>

    <div id="idText"></div>
  </div>
</body>
</html>




<?php
      exit;
   } else {
      echo "Bad Cookie.";
      exit;
   }
}
else {
?>

<html>
  <head>
      <link rel="stylesheet" href="loginstyle.css?v=1">
  </head>
  <body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=login" method="post">
  <table>
    <tr>
      <td><label for="user">Username</label></td>
      <td><input type="text" name="user" id="user" /></td>
    </tr>
    <tr>
      <td><label for="keypass">Password</label></td>
      <td><input type="password" name="keypass" id="keypass" /></td>
    </tr>
  </table>
  <input type="submit" id="submit" value="Login" />
</form>
  </body>
</html>
 
<?php   
}

if (isset($_GET['p']) && $_GET['p'] == "login") {
   if ($_POST['user'] != $username) {
      echo "Sorry, that username does not match.";
      exit;
   } else if ($_POST['keypass'] != $password) {
      echo "Sorry, that password does not match.";
      exit;
   } else if ($_POST['user'] == $username && $_POST['keypass'] == $password) {
      setcookie('PrivatePageLogin', md5($_POST['keypass'].$nonsense), time() + 3600);
      header("Location: $_SERVER[PHP_SELF]");
   } else {
      echo "Sorry, you could not be logged in at this time.";
   }
}
?>