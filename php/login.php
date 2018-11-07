<?php
    include "do.php";


    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

        $conn = new Conn();
        $do   = new DoFunc();
        $user = $do->str(INPUT_POST, "user");
        $pass = $do->str(INPUT_POST, "pass");
        $passC = $do->password($pass);

        // Pega o IP do usuário
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $sql = "select id, name, user, email, pass
                  from users
                  where (user = '$user' or email = '$user') limit 1";
        $res = $conn->query($sql);

        if (count($res) > 0) {
            $passB = $res[0]["pass"];
            if (password_verify($pass, $passB)) {
                $id = $res[0]["id"];
                $name = $res[0]["name"];
                $user = $res[0]["user"];
                $email = $res[0]["email"];

                $isLogged = $do->isLogged($id);
                if ($isLogged == 'true') {
                    echo $do->setMsg('0', 'success');
                } else {
                    $token = $do->createToken($id, $name, $user, $email);
                    $sql = "insert into auth (id_user, token, validate, ip) values ($id, '$token', "._TIME_.", '$ip')";
                    $r = $conn->exec($sql);
                    $error = mysqli_error($conn->getConn());

                    if ($error) {
                        echo $do->setMsg('-1', 'error');
                    } else {
                        echo $do->setMsg('0', 'success');
                        $do->beginSession($id, $token);
                    }
                }
            } else {
                echo $do->setMsg('-1', 'User or pass invalid!');
            }
        } else {
            echo $do->setMsg('-1', 'User not found!');
        }

        $conn->close();


    }






?>
