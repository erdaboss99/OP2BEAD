<?php session_start();?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Hangman</title>
    </head>
    <style>
        body {
            text-align: center;
            margin: auto;
        }
        .right {
            text-align: right;
            margin: auto;
        }
    </style>
    <body>
        <?php
            include 'config.php';
            include 'functions.php';
            include 'hangedman.php';
            if (isset($_POST['newWord'])) unset($_SESSION['answer']);
            if (!isset($_SESSION['answer']))
            {
                $_SESSION['attempts'] = 0;
                $answer = fetchWordArray($WORDLISTFILE);
                $_SESSION['answer'] = $answer;
                $_SESSION['hidden'] = hideCharacters($answer);
                echo 'Attempts remaining: '.($MAX_ATTEMPTS - $_SESSION['attempts']).'<br>';
                echo '<br/> <pre class="right">'.$hang[($MAX_ATTEMPTS - $_SESSION['attempts'])].'</pre> <br/>';
            }else
            {
                if (isset ($_POST['userInput']))
                {
                    $userInput = $_POST['userInput'];
                    $_SESSION['hidden'] = checkAndReplace(strtolower($userInput), $_SESSION['hidden'], $_SESSION['answer']);
                    checkGameOver($MAX_ATTEMPTS,$_SESSION['attempts'], $_SESSION['answer'],$_SESSION['hidden']);
                }
                $_SESSION['attempts'] = $_SESSION['attempts'] + 1;
                echo 'Attempts remaining: '.($MAX_ATTEMPTS - $_SESSION['attempts'])."<br>";
                echo '<br/> <pre>'.$hang[($MAX_ATTEMPTS - $_SESSION['attempts'])].'</pre> <br/>';
            }
            $hidden = $_SESSION['hidden'];
            foreach ((array)$hidden as $char) echo $char."  ";
        ?>
        <script type="application/javascript">
            function validateInput()
            {
                var x=document.forms["inputForm"]["userInput"].value;
                if (x=="" || x==" ")
                {
                    alert("Please enter a character.");
                    return false;
                }
                if (!isNaN(x))
                {
                    alert("Please enter a character.");
                    return false;
                }
            }
        </script>
        <form name = "inputForm" action = "" method = "post">
            Your Guess: <input name = "userInput" type = "text" size="1" maxlength="1"  />
            <input type = "submit"  value = "Check" onclick="return validateInput()"/>
            <input type = "submit" name = "newWord" value = "Try another Word"/>
        </form>
    </body>
</html>
