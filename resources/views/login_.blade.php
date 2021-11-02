<html>
    <head></head>


    <body>

        <div>
            <form method = 'POST' action = 'login'>
                @CSRF
                <label for = 'email'>email</label>
                <input id = 'email' name = 'email'>

                <label for = 'password'>password</label>
                <input id = 'password' name = 'password' type = 'password'>

                <input type = 'submit'>
</form>
</div>
    </body>



</html>