<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["Register"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $event = $_POST['event'];
    $college = $_POST['college'];
    $number = $_POST['number'];

    // Connect to the database (assuming the database credentials are defined)
    $conn = mysqli_connect("localhost", "root", "", "library");
    $query = "INSERT INTO Event(name, email, event, college, number) VALUES ('$name', '$email', '$event', '$college', '$number')";
    mysqli_query($conn, $query);

    if (mysqli_query($conn, $query)) {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'monishpk1401@gmail.com';
        $mail->Password = 'vqtznkzndvzfdovd';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('monishpk1401@gmail.com');
        $mail->addAddress($email);

        $mail->isHTML(true);

        $uniqueID = uniqid(); // Generate a unique ID

        $mail->Subject = 'Event Registration Confirmation';
        $mail->Body = 'Dear ' . $name . ',<br>Thank you for registering for the event. Your registration has been confirmed.<br>Event Details:<br>Name: ' . $name . '<br>Email: ' . $email . '<br>Event: ' . $event . '<br>College: ' . $college . '<br>Number: ' . $number . '<br>Unique ID: ' . $uniqueID . '<br>We look forward to seeing you at the event.<br>Best regards,<br>Online Event Registration System';

        if ($mail->send()) {
            // Update the unique ID in the database for the current user
            $updateQuery = "UPDATE Event SET unique_id = '$uniqueID' WHERE email = '$email'";
            mysqli_query($conn, $updateQuery);

            echo "<script>
            document.location.href='done.html';
            </script>";
        }
    }
    mysqli_close($conn);
}
?>
