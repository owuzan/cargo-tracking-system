<?php require_once __DIR__ . '/header.php'; global $db; ?>
<?php 
global $db;
$information = false;
$form = true;
$new_password = false;
$password_update = false;


if(isset($_POST['update-password'])) {

    if(isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['key'])) {
        if(!empty($_POST['password']) && !empty($_POST['password2']) && !empty($_POST['key'])) {
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            $key = $_POST['key'];
            $result = "";
            $error = 0;

            if (strcmp($password, $password2) !== 0) {
                $result .= "<p>Şifreler eşleşmiyor.</p>";
                $error++;
            }
            
            if(strlen($password) < 8) {
                $result .= "<p>Parolanız en az 8 karakter uzunluğunda olmalıdır.";
                $error++;
            }
            
            if($error == 0) {
                $password = md5($password);
                
                $get = $db -> query("SELECT * FROM personnel WHERE register_key='{$key}'") -> fetch(PDO::FETCH_ASSOC);
                $email = $get['email'];
                $name = $get['name'];
                $surname = $get['surname'];

                $query = $db -> prepare("UPDATE personnel SET password=:password, active=:active WHERE register_key=:key");
                $update = $query -> execute([
                    'password' => $password,
                    'active' => 1,
                    'key' => $key
                    ]);
                    
                    if($update) {
                        $password_update = true;
                        $form = false;

                        $to = $email;
                        $subject = 'Parolanız değiştirildi - ' . get_option('site_name');
                        $content = 'Merhaba <strong>' . $name . ' ' . $surname . '</strong>. Hesabınız için parolanız değiştirildi. Bu değişikliği eğer siz yapmadıysanız şifrenizi <a href="' . get_option('site_url') . '/forgot-password.php">buradan</a> sıfırlayabilirsiniz. Sorun yaşıyorsanız bizimle iletişime geçin.';

                        send_mail($to, $subject, $content);

                        $query = $db -> prepare("UPDATE personnel SET register_key=:key WHERE email=:email");
                        $reset = $query -> execute([
                            'key' => "",
                            'email' => $email
                        ]);

                    }

            }
        }
    }
}

if(isset($_GET['id']) && isset($_GET['key'])) {
    $form = false;
    $information = false;

    if(isset($_GET['id']) && isset($_GET['key'])) {
        
        if(!empty($_GET['id']) && !empty($_GET['key'])) {

            $id = $_GET['id'];
            $key = $_GET['key'];
            $query = $db -> query("SELECT * FROM personnel WHERE id='{$id}' AND register_key='{$key}'") -> fetch(PDO::FETCH_ASSOC);

            if($query) {
                $new_password = true;
            }
            
        } else {
            header('Location: ' . get_option('site_url'));
            exit;
        }
    } else {
        header('Location: ' . get_option('site_url'));
        exit;
    }
}


if(isset($_POST['reset-password'])) {

    if(isset($_POST['email'])) {
        if(!empty($_POST['email'])) {

            $email = $_POST['email'];
            $register_key = random_key();

            $query = $db -> query("SELECT * FROM personnel WHERE email='{$email}'") -> fetch(PDO::FETCH_ASSOC);

            if($query) {
                $update = $db -> prepare("UPDATE personnel SET register_key=:register_key WHERE email=:email");
                $forgot_password = $update -> execute([
                    'register_key' => $register_key,
                    'email' => $email
                ]);

                $id = $query['id'];

                if($forgot_password) {
                    $information = true;
                    $form = false;
                    $to = $email;
                    $subject = 'Şifrenizi sıfırlayın - ' . get_option('site_name');
                    $content = 'Şifre sıfırlamak için istek gönderildi. Bunun siz göndermediyseniz dikkate almayın. Eğer şifrenizi değiştirmek istiyorsanız <a href="' . get_option('site_url') . '/forgot-password.php?id=' . $id .  '&key=' . $register_key . '">buraya</a> tıklayarak yeni şifre alabilirsiniz.';
                    send_mail($to, $subject, $content);
                }
            }
        }
    }
}

if($form) { ?>

        <div class="row">
            <div class="col-md-6 mx-auto">           
                <div class="card">
                    <div id="content-body">
                        <div class="p-3 p-md-5">
                            <h5>Parolamı Unuttum</h5>
                            <p>
                                <small class="text-muted">Yeni şifre almak için e-posta adresini gir</small>
                            </p>
                            <form method="POST" action="<?php echo get_option('site_url') . '/forgot-password'; ?>">
                                <div class="form-group">
                                    <label>E-Posta</label>
                                    <input type="email" required name="email" class="form-control" value="<?php if(isset($_COOKIE['email'])) { echo $_COOKIE['email']; } ?>" placeholder="E-Posta adresinizi girin">
                                </div>
                                <button type="submit" name="reset-password" class="btn btn-success mb-4">Şifremi sıfırla</button>
                                <div>Şifreni biliyor musun?
                                    <a href="<?php echo get_option('site_url') . '/sign-in.php'; ?>" class="text-primary">Giriş yap</a>
                                </div>
                                <div class="mt-3">Kargo sorgulamak mı istiyorsun?
                                    <a href="<?php echo get_option('site_url'); ?>" class="text-primary">Sorgula</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
    } 
    
    if($information) { ?>

        <div class="row">
            <div class="col-md-6 mx-auto">           
                <div class="card">
                    <div id="content-body">
                        <div class="p-3 p-md-5">
                            <h5>Parolamı Unuttum</h5>
                            <p>Yeni şifre almak için girdiğiniz e-posta adresine mesaj gönderdik. Oradaki bağlantıya tıklayarak yeni şifre oluşturabilirsiniz.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } 
    
    if($new_password) { ?>

        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div id="content-body">
                        <div class="p-3 p-md-5">
                            <h5>Yeni parola belirle</h5>
                            <p>
                                <small class="text-muted">Yeni parolanızı girin</small>
                            </p>
                            <form method="POST" role="form" action="<?php echo get_option('site_url') . '/forgot-password'; ?>">
                                <div class="form-group">
                                    <label>Parola</label>
                                    <input type="password" required name="password" class="form-control" placeholder="Parolanızı girin(En az 8 karakter)" minlength="8">
                                </div>
                                <div class="form-group">
                                    <label>Parola (Tekrar)</label>
                                    <input type="password" required name="password2" class="form-control" placeholder="Parolanızı girin(En az 8 karakter)" minlength="8">
                                </div>
                                <input type="hidden" name="key" value="<?php echo $_GET['key']; ?>">
                                <button type="submit" name="update-password" class="btn btn-success mb-4">Parolamı Değiştir</button>
                                <div>Zaten mevcut bir hesabın var mı?
                                    <a href="<?php echo get_option('site_url') . '/sign-in.php'; ?>" class="text-primary">Giriş yap</a>
                                </div>
                                <div class="mt-3">Kargo sorgulamak mı istiyorsun?
                                    <a href="<?php echo get_option('site_url'); ?>" class="text-primary">Sorgula</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>    
            </div>
        </div>


    <?php 

}

if($password_update) { ?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div id="content-body">
                <div class="p-3 p-md-5">
                    <h5>Parolanız değiştirildi</h5>
                    <p>Giriş yapmak için <a href="<?php echo get_option('site_url') . '/sign-in.php'; ?>">buraya</a> tıklayınız.</p>
                </div>
            </div>
        </div>    
    </div>
</div>
<?php } ?>











                <div class="text-center text-muted">&copy; Copyright. <?php echo get_option('site_name'); ?></div>
            </div>
        </div>
        <!-- build:js ../assets/js/site.min.js -->
        <!-- jQuery -->
        <script src="../libs/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="../libs/popper.js/dist/umd/popper.min.js"></script>
        <script src="../libs/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- ajax page -->
        <script src="../libs/pjax/pjax.min.js"></script>
        <script src="../assets/js/ajax.js"></script>
        <!-- lazyload plugin -->
        <script src="../assets/js/lazyload.config.js"></script>
        <script src="../assets/js/lazyload.js"></script>
        <script src="../assets/js/plugin.js"></script>
        <!-- scrollreveal -->
        <script src="../libs/scrollreveal/dist/scrollreveal.min.js"></script>
        <!-- feathericon -->
        <script src="../libs/feather-icons/dist/feather.min.js"></script>
        <script src="../assets/js/plugins/feathericon.js"></script>
        <!-- theme -->
        <script src="../assets/js/theme.js"></script>
        <script src="../assets/js/utils.js"></script>
        <!-- endbuild -->
    </body>
</html>