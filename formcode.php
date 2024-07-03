<?php
session_start();
include_once 'include/config.php';

if(isset($_POST['register']))
{
    $status = true;
    $insert = array();
    $data = array(); // Initialize the data array

    if(empty($_POST['name']))
    {
        $data['error'] = "FIELD IS REQUIRED";
        $status = false;
    }
    else
    {
        $name = $data['value'] = $_POST['name'];
    }
    $insert['name'] = $data;
    $data = array(); // Reset the data array
    unset($data);

    if(empty($_POST['mobile']))
    {
        $data['error'] = "FIELD IS REQUIRED";
        $status = false;
    }
    else
    {
        $mobile = $data['value'] = $_POST['mobile'];
    }
    $insert['mobile'] = $data;
    $data = array(); // Reset the data array
    unset($data);

    if(empty($_POST['email']))
    {
        $data['error'] = "FIELD IS REQUIRED";
        $status = false;
    }
    else
    {
        $email = $data['value'] = $_POST['email'];
    }
    $insert['email'] = $data;
    $data = array(); // Reset the data array
    unset($data);

    if(empty($_POST['password']))
    {
        $data['error'] = "FIELD IS REQUIRED";
        $status = false;
    }
    if($_POST['cpassword'] != $_POST['password'])
    {
        $data['confirm_error'] = "Password does not match";
        $status = false;
    }
    else
    {
        $password = md5($_POST['password']);
    }
    $insert['password'] = $data;
    unset($data);
    $_SESSION['insert'] = $insert;

    if($status == true)
    {
        $sql_user_insert = "INSERT INTO user (USER_NAME, USER_MOBILE, USER_EMAIL, USER_PASS) VALUES ('$name', '$mobile', '$email', '$password')";
        $x = mysqli_query($conn, $sql_user_insert);

        if($x == true)
        {
            header("Location: login.php");
            unset($_SESSION['insert']);
            exit();
        }
    }
    else
    {
        header("Location:register.php");
    }
}
?>
