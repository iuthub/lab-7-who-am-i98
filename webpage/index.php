<?php
session_start();

include 'connection.php';

$posts_sql = "SELECT * FROM `posts`";
$posts = $con->query($posts_sql);

if (isset($_GET['logout']) && $_GET['logout'] == '1') {
    session_destroy();
    header('Location: index.php');
}

if (isset($_POST['title']) && isset($_POST['body']) && isset($_POST['userId'])) {
    $title = $con->real_escape_string($_POST['title']);
    $body = $con->real_escape_string($_POST['body']);
    $userId = $_POST['userId'];
    $sql = "INSERT INTO `posts`(`title`,`body`,`userId`) VALUES ('$title','$body',$userId)";
    if ($con->query($sql) === true) {
        header('Location: index.php');
    } else {
        echo "Error: $con->error";
    }
}

if (isset($_POST['username']) && isset($_POST['pwd'])) {
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];
    if ($_POST['remember'] == "on") {
        setcookie("username", $username, time() + 60 * 60 * 24 * 365);
    } else {
        setcookie("username", $username, time() - 1);
    }
    $sql = "SELECT id FROM `users` WHERE username='$username' and password='$pwd'";
    $res = $con->query($sql);

    if ($res->num_rows > 0) {
		$_SESSION["user"] = $res;
        header('Location: index.php');
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>My Personal Page</title>
		<link href="style.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		<?php include 'header.php';?>
		<!-- Show this part if user is not signed in yet -->
		<?php if (!isset($_SESSION["user"])) {?>
			<div class="twocols">
				<form action="index.php" method="post" class="twocols_col">
					<ul class="form">
						<li>
							<label for="username">Username</label>
							<input type="text" name="username" id="username" value="<?=isset($_COOKIE['username']) ? $_COOKIE['username'] : ""?>" />
						</li>
						<li>
							<label for="pwd">Password</label>
							<input type="password" name="pwd" id="pwd" />
						</li>
						<li>
							<label for="remember">Remember Me</label>
							<input type="checkbox" name="remember" id="remember" checked />
						</li>
						<li>
							<input type="submit" value="Submit" /> &nbsp; Not registered? <a href="register.php">Register</a>
						</li>
					</ul>
				</form>
				<div class="twocols_col">
					<h2>About Us</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur libero nostrum consequatur dolor. Nesciunt eos dolorem enim accusantium libero impedit ipsa perspiciatis vel dolore reiciendis ratione quam, non sequi sit! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio nobis vero ullam quae. Repellendus dolores quis tenetur enim distinctio, optio vero, cupiditate commodi eligendi similique laboriosam maxime corporis quasi labore!</p>
				</div>
			</div>
		<?php }?>

		<?php if (isset($_SESSION["user"])) {
    echo "<div class=\"logout_panel\"><a href=\"register.php\">My Profile</a>&nbsp;|&nbsp;<a href=\"index.php?logout=1\">Log Out</a></div>";
}
?>

		<?php if (isset($_SESSION["user"])) {?>
		<h2>New Post <?=$_SESSION["user"]->fetch_assoc()['id']?></h2>
		<form action="index.php" method="post">
			<ul class="form">
				<li>
					<label for="title">Title</label>
					<input type="text" name="title" id="title" />
				</li>
				<li>
					<label for="body">Body</label>
					<textarea name="body" id="body" cols="30" rows="10"></textarea>
				</li>
				<li>
					<input type="hidden" name="userId" value="<?=isset($_SESSION['user']) ? $_SESSION['user']->fetch_assoc()['id'] : null?>">
					<input type="submit" value="Post" />
				</li>
			</ul>
		</form>
		<?php }?>
		<div class="onecol">
		<?php foreach ($posts->fetch_all() as $post) {?>
			<div class="card">
				<h2><?=$post[1]?></h2>
				<h5>Author, Sep 2, 2017</h5>
				<p><?=$post[2]?></p>
			</div>
		<?php }?>
		</div>
	</body>
</html>