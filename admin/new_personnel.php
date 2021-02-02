<?php require_once(__DIR__ . '/header.php'); ?>

<?php 

if(isset($_POST['add-personnel'])) {

    $tracking_number = uniqid();

    $query = $db->prepare("INSERT INTO personnel SET
        name =:name,
        surname =:surname,
        phone =:phone,
        tc =:tc,
        email =:email,
        address =:address,
        gender =:gender
        ");
    $update = $query -> execute([
        'name' => $_POST['name'],
        'surname' => $_POST['surname'],
        'phone' => $_POST['phone'],
        'tc' => $_POST['tc'],
        'email' => $_POST['email'],
        'address' => $_POST['address'],
        'gender' => $_POST['gender']
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
                                <h2 class="text-md text-highlight">Yeni Personel</h2>
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

                            $query = $db->query("SELECT name, surname FROM personnel ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                            
                            ?>
                            <div class="alert alert-success" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span class="mx-2"><strong><?php echo $query['name'] . ' ' . $query['surname'] ; ?></strong> personeli eklendi.</span>
                            </div>
                            
                            <?php
                        }
                        ?>


                            <form action="" method="POST">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Personel Bilgileri</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Ad</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="name" class="form-control" pattern="[A-Za-zğĞçÇşŞıİöÖüÜ]{2,}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Soyad</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="surname" class="form-control" pattern="[A-Za-zğĞçÇşŞıİöÖüÜ]{2,}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Telefon</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="phone" class="form-control" maxlength="11" minlength="11" class="form-control" placeholder="05XXXXXXXXX" pattern="[0]{1}[5]{1}[0-9]{9}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">T.C. Kimlik Numarası</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="tc" class="form-control" maxlength="11" minlength="11" class="form-control" placeholder="0XXXXXXXXXX" pattern="[1-9]{1}[0-9]{9}[0,2,4,6,8]{1}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">E-Posta Adresi</label>
                                            <div class="col-sm-8">
                                                <input type="email" required name="email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Adres</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="address" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Cinsiyet</label>
                                            <div class="col-sm-8">
                                                <select required name="gender" class="form-control">
                                                    <option value="2">Bilinmiyor</option>
                                                    <option value="1">Erkek</option>
                                                    <option value="0">Kadın</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <input type="submit" name="add-personnel" value="Ekle" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- ############ Main END-->
            </div>
            <!-- ############ Content END-->
<?php require_once(__DIR__ . '/footer.php'); ?>
