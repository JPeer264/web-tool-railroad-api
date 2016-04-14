<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Verify Your Email Address</h2>

        <div>
            You have been invited to join the railway forum.
            You can login with your email and the password is $password.
            {{ URL::to('register/invite/' . $invite_expire) }}.<br/>

        </div>

    </body>
</html>
