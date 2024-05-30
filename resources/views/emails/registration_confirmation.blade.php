<!DOCTYPE html>
<html>
<head>
    <title>Registration Confirmation</title>
</head>
<body>
    <h2>Thank you for registering!</h2>
    <p>Please click the following link to confirm your registration:</p>
    <a href="{{ url('set-password?token=' . $token) }}">Confirm Registration</a>
</body>
</html>
