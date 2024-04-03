<!-- Email Template: reset_password.ctp -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; margin-bottom: 30px;">Password Reset</h2>
        <p>Hello <?= $user->username ?>,</p>
        <p>You have requested to reset your password. Please follow the link below to reset your password:</p>
        <p><a href="<?= $this->Url->build(['controller' => 'ForgotPassword', 'action' => 'reset', $user->password_reset_token], ['fullBase' => true]) ?>">Reset Password</a></p>
        <p>If you did not request this reset, you can ignore this email.</p>
        <p>Thank you!</p>
    </div>

</body>

</html>