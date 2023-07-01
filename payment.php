<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["Register"])) {
    $utr = $_POST['utr'];
    $email = $_POST['email'];

    // Connect to the database (assuming the database credentials are defined)
    $conn = mysqli_connect("localhost", "root", "", "library");
    $query = "INSERT INTO payment(utr, email) VALUES ('$utr', '$email')";
    mysqli_query($conn, $query);
    // Check if the UTR exists in both tables
    $query = "SELECT p.utr AS payment_utr, pd.utr AS payment_done_utr
          FROM payment p
          INNER JOIN payment_done pd ON p.utr = pd.utr
          WHERE p.utr = '$utr'";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // UTRs match, proceed with sending the email
    $row = mysqli_fetch_assoc($result);
    $paymentUTR = $row['payment_utr'];
    $paymentDoneUTR = $row['payment_done_utr'];

    $mail = new PHPMailer(true); {
        // UTRs match, proceed with sending the email
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

        $mail->Subject = 'Payment Confirmation';
        $mail->Body = 'Dear ' . $email . ',<br>Your payment has been successfully received.<br>UTR: ' . $utr;

        if ($mail->send()) {
            echo "<script>
            document.location.href='done1.html';
            </script>";
        } else {
            echo "Error sending email.";
        }
    }
 } else {
        // UTRs don't match
        echo "UTR not Found, payment unsucessfull!!!";
    }

    mysqli_close($conn);
}
?>
