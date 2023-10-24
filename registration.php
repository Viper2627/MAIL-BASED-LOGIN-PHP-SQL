<?php
require_once "config.php";
$mail = $password = $confirm_password =$answer= $selectedQuestion="";
$mail_err = $password_err = $confirm_password_err = $answererr = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty(trim($_POST["mail"]))){
        $mail_err="Please Enter the Mail Address";
    }
    if (empty(trim($_POST["answer"]))){
        $answererr="Please Select Any Qyestion & Give Answer";
    }
    if (empty(trim($_POST["mail"]))){
        $mail_err="Please Enter the Mail Address";
    } elseif(!filter_var(trim($_POST["mail"]), FILTER_VALIDATE_EMAIL)){
        $mail_err="Invalid Email Address";
    } else{
        $sqli  = "SELECT id FROM users WHERE mail = ?";

        if ($stmt = mysqli_prepare($link,$sqli)){
            mysqli_stmt_bind_param($stmt,"s",$param_mail);
            $param_mail = trim($_POST["mail"]);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt)==1){
                    $mail_err="EMAIL ID ALREADY EXIST";
                }else{
                    $mail=trim($_POST["mail"]);
                }
            }else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }

 
    }
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    } 
    $selectedQuestion = $_POST["question"];
    $answer = $_POST["answer"];
    
    if(empty($mail_err) && empty($password_err) && empty($confirm_password_err) && empty($answererr)){
        
        // Prepare an insert statement
        echo $selectedQuestion;
        $sql = "INSERT INTO users (mail, password,selectquestion,answer) VALUES (?, ?,?,?)";
        echo $selectedQuestion;
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            echo $selectedQuestion;
            mysqli_stmt_bind_param($stmt, "ssss", $param_mail, $param_password,$param_question,$param_answer);
            
            // Set parameters
            $param_mail = $mail;
            
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_answer = $answer;
            $param_question = $selectedQuestion;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email ID</label>
                <input type="text" name="mail" class="form-control <?php echo (!empty($mail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mail; ?>">
                <span class="invalid-feedback"><?php echo $mail_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label for="question">Select a Question</label>
                <select class="form-control" id="question" name="question">
                    <option value="Which is the first school you went to?">Which is the first school you went to?</option>
                    <option value="What was your first pets name?">What was your first pets name?</option>
                    <option value="What is your home nickname?">What is your home nickname?</option>
                </select>
            </div>

            <div class="form-group">
                <label for="answer">Your Answer</label>
                <input type="text" class="form-control" id="answer" name="answer" placeholder="Enter your answer">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
          
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

   
</body>
</html>