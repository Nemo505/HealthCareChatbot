<!-- src/Template/Email/new_appointment.ctp -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
</head>

<body>
    <p>Hello <?= $name ?>,</p>

    <p>Thank you for scheduling an appointment with us.</p>

    <p>We have received your booking for <?= $appointmentDate ?>.</p>

    <p>We will send you a confirmation email shortly.</p>

    <p>Best regards,<br>Code The Pixel</p>
</body>

</html>