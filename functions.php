<?php

ob_start();
session_start();

function get_option($param) {
     
     try {
          global $db;
          
          $query = $db -> query("SELECT value FROM options WHERE option_name='$param'") -> fetch(PDO::FETCH_ASSOC);
          
          return $query['value'];
          
     } catch ( PDOException $e ){
          echo "Bir Hata Oluştu: ".$e->getMessage();
     }
}


function set_option($option, $value) {
    global $db;

    $update = $db -> prepare("UPDATE options SET value=:value WHERE option_name=:option");
    $updated = $update -> execute([
        'option' => $option,
        'value' => $value
    ]);

}

function current_user($param) {
    if(isset($_SESSION['id'])) {
        if(!empty($_SESSION['id'])) {
            
            global $db;
            $id = $_SESSION['id'];

            $query = $db -> query("SELECT $param FROM personnel WHERE id='{$id}' ") -> fetch(PDO::FETCH_ASSOC);
            return $query[$param];
        }
    }
}

function number_of_cargo_cost() {
    global $db;
    $total = 0;
    $query = $db -> query("SELECT cost FROM cargoes", PDO::FETCH_ASSOC);

    foreach($query as $cost) {
        if(!empty($cost['cost'])) {
            $total += $cost['cost'];
        }
    }
    return $total;
}

function number_of_prepared_cargo() {
    global $db;
    $total = 0;
    $query = $db -> query("SELECT COUNT(*) AS number FROM cargoes WHERE status='1'") -> fetch(PDO::FETCH_ASSOC);

    return $query['number'];
}

function number_of_prepared_cargo_cost() {
    global $db;
    $total = 0;
    $query = $db -> query("SELECT cost FROM cargoes WHERE status='1'", PDO::FETCH_ASSOC);

    foreach($query as $cost) {
        if(!empty($cost['cost'])) {
            $total += $cost['cost'];
        }
    }
    return $total;
}

function number_of_outlet_cargo() {
    global $db;
    $total = 0;
    $query = $db -> query("SELECT COUNT(*) AS number FROM cargoes WHERE status='2'") -> fetch(PDO::FETCH_ASSOC);

    return $query['number'];
}

function number_of_outlet_cargo_cost() {
    global $db;
    $total = 0;
    $query = $db -> query("SELECT cost FROM cargoes WHERE status='2'", PDO::FETCH_ASSOC);

    foreach($query as $cost) {
        if(!empty($cost['cost'])) {
            $total += $cost['cost'];
        }
    }
    return $total;
}

function number_of_target_cargo() {
    global $db;
    $total = 0;
    $query = $db -> query("SELECT COUNT(*) AS number FROM cargoes WHERE status='3'") -> fetch(PDO::FETCH_ASSOC);

    return $query['number'];
}

function number_of_target_cargo_cost() {
    global $db;
    $total = 0;
    $query = $db -> query("SELECT cost FROM cargoes WHERE status='3'", PDO::FETCH_ASSOC);

    foreach($query as $cost) {
        if(!empty($cost['cost'])) {
            $total += $cost['cost'];
        }
    }
    return $total;
}

function number_of_delivered_cargo() {
    global $db;
    $total = 0;
    $query = $db -> query("SELECT COUNT(*) AS number FROM cargoes WHERE status='4'") -> fetch(PDO::FETCH_ASSOC);

    return $query['number'];
}

function number_of_undelivered_cargo_cost() {
    global $db;
    $total = 0;
    $query = $db -> query("SELECT cost FROM cargoes WHERE status='5'", PDO::FETCH_ASSOC);

    foreach($query as $cost) {
        if(!empty($cost['cost'])) {
            $total += $cost['cost'];
        }
    }
    return $total;
}

function number_of_undelivered_cargo() {
    global $db;
    $total = 0;
    $query = $db -> query("SELECT COUNT(*) AS number FROM cargoes WHERE status='5'") -> fetch(PDO::FETCH_ASSOC);

    return $query['number'];
}

function number_of_delivered_cargo_cost() {
    global $db;
    $total = 0;
    $query = $db -> query("SELECT cost FROM cargoes WHERE status='4'", PDO::FETCH_ASSOC);
    
    foreach($query as $cost) {
        if(!empty($cost['cost'])) {
            $total += $cost['cost'];
        }
    }
    return $total;
}

function number_of_branch() {
    global $db;
    $total = 0;
    $query = $db -> query("SELECT COUNT(*) AS number FROM branches") -> fetch(PDO::FETCH_ASSOC);

    return $query['number'];
}

function number_of_personnel() {
    global $db;
    $total = 0;
    $query = $db -> query("SELECT COUNT(*) AS number FROM personnel") -> fetch(PDO::FETCH_ASSOC);

    return $query['number'];
}

function random_key($length = 55) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function get_branch($id, $param) {
    global $db;

    $query = $db -> query("SELECT $param FROM branches WHERE id='{$id}'") -> fetch(PDO::FETCH_ASSOC);
    return $query[$param];
}

function send_movement_information($tracking_number, $new_movement) {
    
    global $db;
    $approved = false;

    if($new_movement == 1) {
        $approved = true;
        $status = "hazırlanıyor";
    } elseif($new_movement == 2) {
        $approved = true;
        $status = "çıkış şubesinde";
    } elseif($new_movement == 3) {
        $approved = true;
        $status = "varış şubesinde";
    } elseif($new_movement == 4) {
        $approved = true;
        $status = "teslim edildi";
    } elseif($new_movement == 5) {
        $approved = true;
        $status = "teslim edilemedi";
    }

    if($approved) {

        $query = $db -> query("SELECT receiver_name, receiver_surname, information, information_email FROM cargoes WHERE tracking_number='{$tracking_number}'") -> fetch(PDO::FETCH_ASSOC);
    
        if($query['information']) {
            if(!empty($query['information_email'])) {
                $name = $query['receiver_name'] . ' ' . $query['receiver_surname'];
                $to = $query['information_email'];
                $subject = 'Kargo Durumu Değişti - ' . get_option('site_name');
                $content = '<strong>' . $tracking_number . '</strong> takip numaralı kargonuzun durumu <strong>' . $status . '</strong> olarak değiştirildi. Detayları incelemek için <a href="' . get_option('site_url') . '/?tracking-number=' . $tracking_number . '">buraya</a> tıklayın.';
                
                send_mail($to, $subject, $content, $name);
            }
        }

    }
}

function cargo_status($param) {
    if($param == 1) {
        $status = "Hazırlanıyor";
    } elseif($param == 2) {
        $status = "Çıkış Şubesinde";
    } elseif($param == 3) {
        $status = "Varış Şubesinde";
    } elseif($param == 4) {
        $status = "Teslim Edildi";
    } elseif($param == 5) {
        $status = "Teslim Edilemedi";
    }
    return $status;
}
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_mail($to, $subject, $content, $name = NULL) {

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function

    // Load Composer's autoloader
    require 'vendor/autoload.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        $mail->CharSet = 'UTF-8';

        //Server settings
        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.sendgrid.net';                    // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'apikey';                                // SMTP username
        // owuzanke
        // $mail->Password   = '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';
        // owuzan
        $mail->Password   = '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';
        $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 465;                                    // TCP port to connect to

        //Recipients

        if($name == NULL) {
            $name = get_option('site_name');
        }
        $site_name = get_option('site_name');
        $domain = get_option('domain');
        $mail->setFrom('noreply@' . $domain, $site_name);
        $mail->addAddress($to, $name);     // Add a recipient
        $mail->addReplyTo('reply@' . $domain, $site_name);
        // $mail->addCC('ooguzhanyilmazz41@gmail.com');
        // $mail->addBCC('ooguzhanyilmazz41@gmail.com');

        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
     //    echo '<p><b>E-Posta başarılı bir şekilde gönderildi.</b></p><br>';
    } catch (Exception $e) {
        echo "<p><b>E-Posta gönderme başarısız: </b> {$mail->ErrorInfo} </p><br>";
    }
}





 function login() {
    
     global $db;
 
     if(isset($_POST['sign-in'])) {
     
         $email = $_POST['email'];
         $pass = $_POST['password'];
         $passCOOKIE = $pass;
         $pass = md5($pass);
         $result = "";
 
         if(isset($_POST['remember-me'])) {
             $remember = $_POST['remember-me'];
         }
         if(empty($email)) {
             $result .= "<p>E-Posta adresi boş olamaz.</p>";
         }
         if(empty($_POST['password'])) {
             $result .= "<p>Şifre boş olamaz.</p>";
         }
     
         $user = $db -> query("SELECT * FROM personnel WHERE email='$email'") -> fetch(PDO::FETCH_ASSOC);
 
     
         if($user) {
     
                 $user_password = $user['password'];
     
                 if($user_password == $pass) {

                    if($user['active']) {

                         $_SESSION['id'] = $user['id'];
                     
                         if(isset($remember)) {
                            //  Çerez 1 ay boyunca saklanacak
                             setcookie('email', $email, time() + (60*60*24*30));
                             setcookie('password', $passCOOKIE, time() + (60*60*24*30));
                             setcookie('remember-me', 'checked=""', time() + (60*60*24*30));
                         } else {
                             setcookie('email', $email, time() - 3600);
                             setcookie('password', $passCOOKIE, time() - 3600);
                             setcookie('remember-me', 'checked=""', time() - 3600);
                         }
                         
                         header('Location:' . get_option('site_url'));
                         exit;
                    }
 
 
                 } else {
                     $result .= '<p>Yanlış şifre girildi.</p>';
                 }
     
         } else {
             $result .= '<p>Kullanıcı bulunamadı!</p>';
         }
 
         return $result;
     
     }
 }





?>