<?php
header("Content-Type: application/json; charset=utf-8");

$allowed = $_SERVER["REQUEST_METHOD"] == "POST";

if (!$allowed)
{
    $response["code"] = 500;
    $response["message"] = "ERR";
}
else
{ 

    $response["code"] = 300;
    $response["message"] = "UNKNOW";

    $include_lang = true;
    $include_database = true;
    $include_function = true;
    require '../config.php';

    if ($_POST['key'] == "requestLoginViaGoogle") {

    $email = $_POST['email'];  // دریافت ایمیل از $_POST
    $deviceID = $_POST['deviceID'];  // دریافت deviceID از $_POST
    $profileUrl = $_POST['profileUrl'];  // دریافت profileUrl از $_POST
    $givenName = $_POST['givenName'];  // دریافت givenName از $_POST
    $ttl = time();  // زمان کنونی (برای ایجاد زمان ایجاد و ویرایش)

    $firstID = $database->get("user", "email", ["ORDER" => ["created" => "ASC"], "email" => $email]) ?? "";
    $firstEmail = $database->get("user", "deviceID", ["ORDER" => ["created" => "ASC"], "deviceID" => $deviceID]) ?? "";

    if ($firstID == "" && $firstEmail == "" || $firstID == $email && $firstEmail == $deviceID && $email == $database->get("user", "email", ["ORDER" => ["created" => "ASC"], "deviceID" => $deviceID]) && $deviceID == $database->get("user", "deviceID", ["ORDER" => ["created" => "ASC"], "email" => $email])) {

        if (!$database->get("user", "email", ["email" => $email])) {

            $insert = $database->insert('user', [
                'email' => $email,
                'profileUrl' => $profileUrl,
                'givenName' => $givenName,
                'created' => $ttl,
                'modified' => $ttl,
                'deviceID' => $deviceID,
                "paid" => $ttl,
            ]);

            if ($insert->rowCount() > 0) {
                $response["code"] = 200;
                $response["message"] = "Data saved successfully.";
            } else {
                $response["message"] = $language["jnhbza"][$lang];
            }

        } else { 

            // عملیات‌هایی برای زمانی که کاربر وجود داشته باشد
            $response["code"] = 200;
            $response["message"] = "Data saved successfully.";
 
        }

    } else {
        $response["code"] = 201;
        $response["message"] = $firstID == ""
		? str_replace("%s", $database->get("user", "email", [ "ORDER" => ["created"=>"ASC"], "deviceID" => $deviceID ]), $language["jhnqnx"][$lang]) 
		: $language["cstqqc"][$lang];
    }

    }


    if ($_POST['key'] == "sendMessage")
    {
        sendMessage($_POST['sender'], $_POST['receiver'], $_POST['message']);
        $response["code"] = 200;
        $response["message"] = "OK";
    }

}

die(isset($response) ? json_encode($response) : "ERROR 500");
?>
