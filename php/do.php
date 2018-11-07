<?php
    include "database.php";

    class DoFunc {

        function str($type, $field) {
            return strtoupper(trim(filter_input($type, $field, FILTER_SANITIZE_SPECIAL_CHARS)));
        }

        function password($value) {
            return password_hash($value, PASSWORD_DEFAULT);
        }

        function createToken($id, $nome, $usuario, $email) {
            $date = date('Y-m-d H:i:s');
            $rand = mt_rand();
            return sha1($id.$nome.$usuario.$email.$date.$rand._SECRET_);
        }

        function isLogged($id) {
            $conn = new Conn();
            $sql = "select max(id) as id from auth
                    where (date_add(date_auth, interval validate second) > current_timestamp ) and id_user = $id";
            $res = $conn->query($sql);
            $max = (count($res) > 0) ? "" : $res[0]["id"];               
            return ($max == "") ? 'false' : 'true';
            $conn->close();
        }

        function doLogOff() {
            session_start();
            $token = $_SESSION["token"];
            $conn = new Conn();
            $sql = "update auth set date_auth=date_sub(date_auth, interval validate second) where token = '$token'";
            $conn->exec($sql);
            $conn->close();
            header("Location: ../");
        }


        function setMsg($code, $message) {
            $arr = array('id'=>$code, 'message'=>$message);
            return json_encode($arr, JSON_UNESCAPED_UNICODE);
        }

        function beginSession($id, $token) {
            session_start();
            $_SESSION["token"] = $token;
        }

        function isSession() {
            if (_TIME_ != 0) {
                $token = $_SESSION["token"];
                $conn = new Conn();
                $sql = "select id, id_user from auth where token = '$token'";
                $res = $conn->query($sql);
                if (count($res) > 0) {
                    $id = $res[0]["id"];
                    $id_user = $res[0]["id_user"];
                    $sql = "select max(id) as id from auth
                            where (date_add(date_auth, interval validate second) > current_timestamp ) and id_user = $id_user";
                    $res = $conn->query($sql);
                    $max = ($res[0]["id"] == "") ? "0" : "1";
                    if ($max == "0") {// not logged in anymore
                        session_destroy();
                        header("Location: ../");
                        exit();
                     }
                     $sql = "update auth set date_auth = current_timestamp where id = $id";
                     $conn->exec($sql);
                } else {
                    session_destroy();
                    header("Location: ../");
                    exit();
                }
            }
        }
    }
 ?>
