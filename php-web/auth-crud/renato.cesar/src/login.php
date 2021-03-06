<?php
    require_once("utils/config.php");
    require_once("utils/auth.php");
    require_once("models/users.php");

    session_start();
    if ($_SESSION['auth']){
        session_write_close();
        header('location: index.php');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;
        
        if($username && $password) {
            $user = UserModel::get_user_by_username($username);
            if($user->compare_passwords($password)) {
                $_SESSION['auth'] = true;
                $_SESSION['user'] = $user->username;
                session_write_close();
                header('location: index.php');
            }
        }
    }


?>

<?php include('templates/header.php') ?>
<?php include('templates/navegation.php') ?>

<div class="content">
    <form class="form-signin" method="POST">
        <h1 class="h3 mb-3 font-weight-normal">Please Login</h1>
        <label for="usernameInput" class="sr-only">Username</label>
        <input type="text" name="username" id="usernameInput" class="form-control" placeholder="Username" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required="">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
</div>

<?php include('templates/footer.php') ?>