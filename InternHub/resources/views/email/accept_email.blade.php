<!DOCTYPE html>
<html>
<head>
    <title>InternHub-DCS Register Acceptence</title>
</head>

<body>

    <table>
        <tr>
            <td><b>Message:</b></td>
            <td>{{ $mail_data['message'] }}</td>
        </tr>
        <tr>
            <td><b>Username:</b></td>
            <td>{{ $mail_data['username'] }}</td>
        </tr>
        <tr>
            <td><b>Password:</b></td>
            <td>{{ $mail_data['password'] }}</td>
        </tr>

    </table><br><br>
    <p><?php echo "Please Don't reply to this email"; ?></p>

</body>

</html>
