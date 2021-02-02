<?php require_once(__DIR__ . '/header.php'); ?>

<?php

$update_settings = false;
if(isset($_POST['update-settings'])) {

    set_option('site_name', $_POST['site-name']);
    set_option('site_url', $_POST['site-url']);
    set_option('domain', $_POST['domain']);
    $to = current_user('email');
    $subject = 'Sistem ayarları güncellendi';
    $content = 'Sistem ayarları az önce değiştirildi. Bu değişikliği siz yapmadıysanız <a href="' . get_option('site_url') . '">buradan</a> sistemi kontrol edin.';
    send_mail($to, $subject, $content);

    $update_settings = true;

}
?>

            <!-- ############ Content START-->
            <div id="content" class="flex ">
                <!-- ############ Main START-->
                <div>
                    <div class="page-hero page-container " id="page-hero">
                        <div class="padding d-flex">
                            <div class="page-title">
                                <h2 class="text-md text-highlight">Ayarlar</h2>
                                <small class="text-muted">Sistem ayarları</small>
                            </div>
                            <div class="flex"></div>
                            <!-- <div>
                                <a href="https://themeforest.net/item/Kolay Gelsin-responsive-bootstrap-web-admin-template/23365964" class="btn btn-md text-muted">
                                    <span class="d-none d-sm-inline mx-1">Buy this Item</span>
                                    <i data-feather="arrow-right"></i>
                                </a>
                            </div> -->

                        </div>
                    </div>
                    <div class="page-content page-container" id="page-content">
                        <div class="padding">

                        <?php if($update_settings) { ?>
                            <div class="alert alert-success" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span class="mx-2"><strong>Sistem ayarları</strong> güncellendi.</span>
                            </div>
                        <?php } ?>

                            <form action="" method="POST">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Sistem Ayarları</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="site-name" class="col-sm-4 col-form-label">Kargo Şirketinin Adı</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="site-name" name="site-name" class="form-control" value="<?php echo get_option('site_name'); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="site-url" class="col-sm-4 col-form-label">Site URL</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="site-url" name="site-url" class="form-control" value="<?php echo get_option('site_url'); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="domain" class="col-sm-4 col-form-label">Domain</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="domain" name="domain" class="form-control" value="<?php echo get_option('domain'); ?>">
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <input type="submit" value="Kaydet" name="update-settings" class="btn btn-success">
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- ############ Main END-->
            </div>
            <!-- ############ Content END-->
<?php require_once(__DIR__ . '/footer.php'); ?>
