<?php require_once __DIR__ . '/header.php'; global $db; ?>

<?php 
$update = false;
$login = login();

if(isset($_GET['activation_key'])) {
    if(!empty($_GET['activation_key'])) {

        $key = $_GET['activation_key'];
        $query = $db -> query("SELECT * FROM personnel WHERE register_key='$key'") -> fetch(PDO::FETCH_ASSOC);
        
        $id = $query['id'];
        
        $query = $db->prepare("UPDATE personnel SET active = :active , register_key=:register_key WHERE id = :id");
        $update = $query->execute(array(
            "active" => 1,
            "register_key" => "",
            "id" => $id
        ));
    }
}

?>

        <div class="row">
            <div class="col-md-6 mx-auto">
            <?php 
            if($update) {
                echo '<strong><p>Hesabınız onaylandı. Giriş yapabilirsiniz.</p></strong>';
            }
            if($login) {
                echo $login;
            } ?>
            

                <div class="card">
                
                    <div id="content-body">
                        <div class="p-3 p-md-5">
                            <h5>Yönetici Girişi</h5>
                            <p>
                                <small class="text-muted">Kargoları düzenlemek için giriş yapın</small>
                            </p>
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label>E-Posta</label>
                                    <input type="email" required name="email" class="form-control" <?php if(isset($_COOKIE['password'])) { echo "value='" . $_COOKIE['email'] . "'"; } ?> placeholder="E-Posta adresinizi girin">
                                </div>
                                <div class="form-group">
                                    <label>Parola</label>
                                    <input type="password" required name="password" class="form-control" <?php if(isset($_COOKIE['password'])) { echo "value='" . $_COOKIE['password'] . "'"; } ?> placeholder="Parolanızı girin(En az 8 karakter)" minlength="8">
                                    <div class="my-3 text-right">
                                        <a href="<?php echo get_option('site_url') . '/forgot-password.php'; ?>" class="text-muted">Şifreni mi unuttun?</a>
                                    </div>
                                </div>
                                <div class="checkbox mb-3">
                                    <label class="ui-check">
                                        <input type="checkbox" <?php if(isset($_COOKIE['email'])) { echo "checked"; } ?> name="remember-me">
                                        <i></i> Beni hatırla
                                    </label>
                                </div>
                                <button type="submit" name="sign-in" class="btn btn-primary mb-4">Giriş yap</button>
                                <div>Henüz hesabın yok mu?
                                    <a href="<?php echo get_option('site_url') . '/sign-up.php'; ?>" class="text-primary">Kayıt ol</a>
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