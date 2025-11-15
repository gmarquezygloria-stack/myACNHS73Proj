<?php
    // Include the database connection file
    //include 'db_connect.php';
    $servername = "localhost";
    $username = "root"; // Replace with your MySQL username
    $password = "";     // Replace with your MySQL password
    $dbname = "profiledb"; // Replace with your database name


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //date_default_timezone_set('Asia/Manila');
    //$contactno = "";
    //$globalVariable = null;
    
    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect and saitize form data
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $lastname = ucwords($lastname);
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $firstname = ucwords($firstname);
        $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
        $middlename = ucwords($middlename);
        $maidename = mysqli_real_escape_string($conn, $_POST['maidename']);     
        $maidename = ucwords($maidename);
        $homeadd = mysqli_real_escape_string($conn, $_POST['homeadd']);
        $homeadd = ucwords($homeadd);
        $contactno = mysqli_real_escape_string($conn, $_POST['tel']);

        $original_date = mysqli_real_escape_string($conn, $_POST['dob']);
        $unix_timestamp = strtotime($original_date);
        $new_date = date("Y-m-d", $unix_timestamp);
        $birthday = $new_date;
        
        $emailadd = mysqli_real_escape_string($conn, $_POST['emailadd']);
        
        $reg_date = date('Y-m-d H:i:s');

        $fullname = $lastname . ", " . $firstname . " " . $middlename . " " . $maidename; 

        // Prepare and execute the SQL INSERT query
       $sql = "INSERT INTO members (lastname, firstname, middlename,maidename,homeadd,contactno,emailadd,birthday,reg_date,fullname) VALUES ('$lastname', '$firstname', '$middlename', '$maidename', '$homeadd', '$contactno','$emailadd', '$birthday', '$reg_date', '$fullname')";

        if ($conn->query($sql) === TRUE) {    
            $message = "New record created successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Fetch all existing data from the users table
    $sql_select = "SELECT id, lastname, firstname FROM members";
    $result = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Table Form</title>
    <link rel="stylesheet" href="profile.css">
    <style>

    </style>
</head>

<body>
    <div class="container">
        <h3>🤍 Member's Profile 🤍</h3>
    
        <?php 
            if (!empty($message)): 
        ?>
        <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
        <?php 
            echo $message; 
        ?>
    </div>
    <?php 
        endif; 
    ?>
    
    <div class="form-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="name">Lastname :</label>
                <input type="text" name="lastname" id="lastname" class="lastname" placeholder="Lastname" utocapitalize="sentences" required>
                <input type="text" name="firstname" id="firstname" class="firstname" placeholder="Firstname" autocapitalize="sentences" required>
                <input type="text" name="middlename" id="middlename" class="middlename" placeholder="Middlename" autocapitalize="sentences" required>
                <input type="text" name="maidename" id="maidename" class="maidename" placeholder="Maidename(Optional)" autocapitalize="sentences">
            </div>
            <div class="form-group">
                <label for="name">Home Address :</label>
                <input type="text" name="homeadd" id="homeadd" class="homeadd" placeholder="Home Address" required> 
            </div>
            <div class="form-group">
                <label for="email">e-mail :</label>
                <input type="email" name="emailadd" id="emailadd" placeholder="email Add" required>
            </div>
            <div class="form-group">
                <label for="name">Telephone/Cellular Phone :</label>
                <input type="text" name="tel" id="tel" class="tel" required>
            </div>
            <div class="form-group">
                <label for="dob">Date of Birth :</label>
                <input type="date" name="dob" id="dob" class="dob" required>
            </div>
            
            <button type="submit">Save Profile</button>
        </form>
    </div>    
    
</body>
</html>

<?php
    // Close the database connection
    $conn->close();
?>

