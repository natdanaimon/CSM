<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

        <form action="" method="POST">
            Email : <input type="text" name="mail">
            <br/>
            <input type="submit" value="send">
        </form>

        <?php
        if (count($_POST) > 0) {
// the message
            $msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
            $msg = wordwrap($msg, 70);

// send email
            mail($_POST['mail'], "My subject", $msg);
        }
        ?>
    </body>
</html>
