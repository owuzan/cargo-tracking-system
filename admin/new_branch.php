<?php require_once(__DIR__ . '/header.php'); ?>

<?php 

if(isset($_POST['add-branch'])) {

    $query = $db->prepare("INSERT INTO branches SET
        name =:name,
        address =:address,
        phone =:phone
        ");
    $update = $query -> execute([
        'name' => $_POST['name'],
        'address' => $_POST['address'],
        'phone' => $_POST['phone']
    ]);
}


?>

            <!-- ############ Content START-->
            <div id="content" class="flex ">
                <!-- ############ Main START-->
                <div>
                    <div class="page-hero page-container " id="page-hero">
                        <div class="padding d-flex">
                            <div class="page-title">
                                <h2 class="text-md text-highlight">Yeni Şube</h2>
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

                        <?php
                        if(isset($update)) {

                            $query = $db->query("SELECT name FROM branches ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                            
                            ?>
                            <div class="alert alert-success" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span class="mx-2"><strong><?php echo $query['name']; ?></strong> şubesi oluşturuldu.</span>
                            </div>
                            
                            <?php
                        }
                        ?>

                            <form action="" method="POST">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Şube Bilgileri</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Şube Adı</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="name" class="form-control" pattern="[A-Za-zğĞçÇşŞıİöÖÜü]{2,}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Şube Adresi</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="address" class="form-control" minlength="10">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Şube Telefonu</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="phone" class="form-control" minlength="11" maxlength="11" pattern="[0-9]{11}" placeholder="0XXXXXXXXXX">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <input type="submit" name="add-branch" value="Ekle" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- ############ Main END-->
            </div>
            <!-- ############ Content END-->
<?php require_once(__DIR__ . '/footer.php'); ?>
