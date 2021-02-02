<?php require_once __DIR__ . '/header.php'; ?>


<?php 

global $db;
$result;
$error = "";

if(isset($_POST['register'])) {
    $error = 0;

    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    
    $email_control = $db -> query("SELECT * FROM personnel WHERE email='{$email}'") -> fetch(PDO::FETCH_ASSOC);
    // $email_control -> execute([($email)]);
    

    if (!empty($email_control['email'])) {
        $result .= '<p>Bu e-posta adresi zaten kullanılıyor.</p>';
        $error++;
    }
    
    if (empty($email)) {
        $result .= '<p>E-Posta adresi boş olamaz.</p>';
        $error++;
    }
    
    if (strcmp($password, $password2) !== 0) {
        $result .= "<p>Şifreler eşleşmiyor.</p>";
        $error++;
    }
    
    if(strlen($password) < 8) {
        $result .= "<p>Parolanız en az 8 karakter uzunluğunda olmalıdır.";
        $error++;
    }
    
    if (empty($name)) {
        $result .= '<p>Adınız boş olamaz.</p>';
        $error++;
    }
    
    if (empty($surname)) {
        $result .= '<p>Soyadınız boş olamaz.</p>';
        $error++;
    }

    if ($error == 0) {

        $password = md5($password);
        $register_key = random_key();
        $db -> exec("INSERT INTO personnel (name, surname, email, password, register_key) VALUES ('$name', '$surname', '$email', '$password', '$register_key')");

        $query = $db -> query("SELECT id FROM personnel WHERE email='$email'");
        $user = $query ->fetch(PDO::FETCH_ASSOC);

        

        $to = $email;
        $subject = 'Kaydınızı tamamlayın - ' . get_option('site_name');
        $content = 'Kaydınızı tamamlamak için <a href="' . get_option("site_url") . '/sign-in.php?id=' . $user['id'] . '&activation_key=' . $register_key . '">buraya</a> tıklayın.';
        
        send_mail($to, $subject, $content);

    }
}




?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <?php 
        
        if(!empty($result)) {
            echo '
            <div class="alert card alert-dismissible fade show px-4 pt-4 mb-4" role="alert">
                <div class="d-flex">
                    <div class="d-sm-flex">
                        <div class="mx-3 align-self-start">
                            <strong>' . $result . '</strong>
                        </div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            ';
        }
        if($error === 0) {
            $url = get_option('site_url') . '/sign-in.php';
            echo '<p class="text-center"><b>Kayıt başarılı, tamamlamak için e-posta adresinize gelen aktivasyon linkine tıklayın.</b></p>';
            echo '<p class="text-center">Giriş yapmak için <a href="' . $url . '">buraya</a> tıklayın.</p>';
        } else {
        
        ?>
                <div class="card">
                    <div id="content-body">
                        <div class="p-3 p-md-5">
                            <h5>Yönetici Kaydı</h5>
                            <p>
                                <small class="text-muted">Sistemi yönetmek için kayıt olun</small>
                            </p>
                            <form method="POST" role="form" action="">
                                <div class="form-group">
                                    <label>Ad</label>
                                    <input type="text" required name="name" value="<?php if(isset($_POST['register'])) { echo $_POST['name'];} ?>" class="form-control" placeholder="Adınızı girin">
                                </div>
                                <div class="form-group">
                                    <label>Soyad</label>
                                    <input type="text" required name="surname" value="<?php if(isset($_POST['register'])) { echo $_POST['surname'];} ?>" class="form-control" placeholder="Soyadınızı girin">
                                </div>
                                <div class="form-group">
                                    <label>E-Posta</label>
                                    <input type="email" required name="email" value="<?php if(isset($_POST['register'])) { echo $_POST['email'];} ?>" class="form-control" placeholder="E-Posta adresinizi girin">
                                </div>
                                <div class="form-group">
                                    <label>Parola</label>
                                    <input type="password" required name="password" class="form-control" placeholder="Parolanızı girin(En az 8 karakter)" minlength="8">
                                </div>
                                <div class="form-group">
                                    <label>Parola (Tekrar)</label>
                                    <input type="password" required name="password2" class="form-control" placeholder="Parolanızı girin(En az 8 karakter)" minlength="8">
                                </div>
                                <button type="submit" name="register" class="btn btn-primary mb-4">Kayıt Ol</button>
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

        <?php } ?>
    </div>
</div>
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