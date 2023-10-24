<?php
// Initialize variables
require_once "config.php";
$email = "";
$ans = "";
$userans = "";
session_start();
$showForm = true;
$showResetForm = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submitEmail"])) {
        // User submitted the email form
        $email = $_POST["email"];

        // Perform necessary validation and checks here (e.g., check if the email exists in your database)

        // Assuming you have a database connection
    

    
        // SQL query to check if the email exists in the database
        $sql = "SELECT * FROM users WHERE mail = '$email'";
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            // Email exists in the database, generate a reset password token and send instructions
            // You can include the reset password form or display a success message here
            $showForm = false;
            $showResetForm = true;
            $userData = $result->fetch_assoc();
           
$ans=$userData["answer"];
$_SESSION["answer"] = $ans;

            // Generate and save the reset password token (You need to implement this part)

            // You can include the reset password form or display a success message here
        } else {
            // Email does not exist in the database, show an error message
            $errorMessage = "Email not found. Please check your email address.";
        }

      
    } elseif (isset($_POST["submitReset"])) {
        // User submitted the reset password form
        // Process the form and reset the password (You need to implement this part)
        // You can also redirect to a confirmation page
        // After processing, you can set $showResetForm to false to hide the reset form
    
        $userans = $_POST["resetPassword"];
      
        $ans = $_SESSION["answer"];
        echo $ans;
        echo $userans;
        if ($userans == $ans){
            header("location: forgot.php");
            session_destroy();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Please Fill the Answer to Reset Password</h2>

                <?php if ($showForm) { ?>
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter your email" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submitEmail">Reset Password</button>
                    </form>
                <?php } elseif ($showResetForm) { ?>
                    <!-- Reset Password Form -->
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="resetPassword"><?php echo htmlspecialchars($userData["selectquestion"]); ?></label>
                            <input type="text" class="form-control" id="resetPassword" name="resetPassword" placeholder="Enter your Answer" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submitReset">Submit</button>
                    </form>
                <?php } ?>

                <!-- Display error message if applicable -->
                <?php if (!empty($errorMessage)) { ?>
                    <div class="alert alert-danger mt-3">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>