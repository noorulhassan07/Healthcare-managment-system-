<?php
session_start();
include_once 'include/header.php';

// Database connection
$db_name = "hms";
$db_user = "root";
$db_pass = "";
$db_host = "127.0.0.1";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $message = $_POST['massage']; // Note: the form field name has a typo ('massage' instead of 'message')

    // Validate form data (basic validation)
    if (!empty($name) && !empty($mobile) && !empty($email) && !empty($message)) {
        // Insert data into the contact table
        $sql = "INSERT INTO contact (contact_name, contact_number, contact_email, contact_message) VALUES ('$name', '$mobile', '$email', '$message')";

        if (mysqli_query($conn, $sql)) {
            echo "Message sent successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "All fields are required.";
    }
}

mysqli_close($conn);
?>

<div class="container bg-transparent">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 py-3 bg-white from-wrapper">
            <div class="container shadow-lg">
                <h3>Contact Us</h3>
                <hr>
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="massage">Message</label>
                        <textarea id="massage" name="massage" rows="5" cols="10" class="form-control"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 col-sm-4 pb-3">
                            <input type="submit" value="Send" name="send" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>  
</div>
<?php include_once 'include/footer.php'; ?>
