<?php require_once(__DIR__ . '/header.php'); ?>

<?php 



if(isset($_POST['add-cargo'])) {

    $tracking_number = uniqid();
    $information;
    if(isset($_POST['information'])) { $information = 1; } else { $information = 0; }

    $query = $db->prepare("INSERT INTO cargoes SET
        tracking_number =:tracking_number,
        weight =:weight,
        outlet_center =:outlet_center,
        target_center =:target_center,
        cost =:cost,
        sender_name =:sender_name,
        sender_surname =:sender_surname,
        sender_phone =:sender_phone,
        sender_tc =:sender_tc,
        sender_address =:sender_address,
        receiver_name =:receiver_name,
        information =:information,
        information_email =:email,
        receiver_surname =:receiver_surname,
        receiver_phone =:receiver_phone,
        receiver_tc =:receiver_tc,
        receiver_address =:receiver_address");
    $update = $query -> execute([
        'tracking_number' => $tracking_number,
        'weight' => $_POST['weight'],
        'outlet_center' => $_POST['outlet_center'],
        'target_center' => $_POST['target_center'],
        'cost' => $_POST['cost'],
        'sender_name' => $_POST['sender_name'],
        'sender_surname' => $_POST['sender_surname'],
        'sender_phone' => $_POST['sender_phone'],
        'sender_tc' => $_POST['sender_tc'],
        'sender_address' => $_POST['sender_address'],
        'receiver_name' => $_POST['receiver_name'],
        'information' => $information,
        'email' => $_POST['email'],
        'receiver_surname' => $_POST['receiver_surname'],
        'receiver_phone' => $_POST['receiver_phone'],
        'receiver_tc' => $_POST['receiver_tc'],
        'receiver_address' => $_POST['receiver_address'] 
    ]);

    if(isset($update)) {
        $query = $db->query("SELECT id, tracking_number, information, information_email FROM cargoes ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        $cargo_id = $query['id'];
        $cargo_movement = $db -> prepare("INSERT INTO cargo_movements SET cargo_id=:cargo_id, movement=:movement");
        $movement_update = $cargo_movement -> execute([
            'cargo_id' => $cargo_id,
            'movement' => 1
        ]);

        if($query['information']) {
            $to = $query['information_email'];
            $subject = 'Kargonuz oluşturuldu - ' . get_option('site_name');
            $content = $query['tracking_number'] . ' takip numaralı kargonuz hazırlanıyor. Kargonuzun durumunu takip etmek için <a href="' . get_option('site_url') . '/?tracking-number=' . $query['tracking_number'] . '">buraya</a> tıklayın.';
            send_mail($to, $subject, $content);
        }


    }
}

?>

            <!-- ############ Content START-->
            <div id="content" class="flex ">
                <!-- ############ Main START-->
                <div>
                    <div class="page-hero page-container " id="page-hero">
                        <div class="padding d-flex">
                            <div class="page-title">
                                <h2 class="text-md text-highlight">Yeni Kargo</h2>
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

                            $query = $db->query("SELECT tracking_number FROM cargoes ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                            
                            ?>
                            <div class="alert alert-success" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span class="mx-2"><strong><?php echo $query['tracking_number']; ?></strong> takip numaralı kargo oluşturuldu.</span>
                            </div>
                            
                            <?php
                        }
                        ?>


                            <form action="" method="POST">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Gönderen Bilgileri</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Gönderen Adı</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="sender_name" class="form-control" minlength="2">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Gönderen Soyadı</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="sender_surname" class="form-control" minlength="2">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Gönderen Telefonu</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="sender_phone" maxlength="11" minlength="11" class="form-control" placeholder="05XXXXXXXXX" pattern="[0]{1}[5]{1}[0-9]{9}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Gönderen T.C. No</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="sender_tc" maxlength="11" minlength="11" class="form-control" placeholder="XXXXXXXXXXX" pattern="[1-9]{1}[0-9]{9}[0,2,4,6,8]{1}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Gönderen Adres</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="sender_address" class="form-control" minlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Alıcı Bilgileri</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Alıcı Adı</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="receiver_name" class="form-control" minlength="2">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Alıcı Soyadı</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="receiver_surname" class="form-control" minlength="2">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Alıcı Telefonu</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="receiver_phone" class="form-control" maxlength="11" minlength="11" class="form-control" placeholder="05XXXXXXXXX" pattern="[0]{1}[5]{1}[0-9]{9}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Alıcı T.C. No</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="receiver_tc" class="form-control" maxlength="11" minlength="11" class="form-control" placeholder="XXXXXXXXXXX" pattern="[1-9]{1}[0-9]{9}[0,2,4,6,8]{1}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Alıcı Adres</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="receiver_address" class="form-control" minlength="10">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Alıcıyı E-Posta ile Bilgilendir</label>
                                            <div class="col-sm-8">
                                                <div class="checkbox mb-32222">
                                                    <label class="ui-check">
                                                        <input type="checkbox" id="information" name="information">
                                                        <i></i>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row information d-none">
                                            <label class="col-sm-4 col-form-label">Alıcı E-Posta Adresi</label>
                                            <div class="col-sm-8">
                                                <input type="email" name="email" id="information_email" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Kargo Bilgileri</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Ağırlık(kg)</label>
                                            <div class="col-sm-8">
                                                <input type="number" required name="weight" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Çıkış Şubesi</label>
                                            <div class="col-sm-8">
                                                <select required name="outlet_center" class="form-control">
                                                    <?php $branches = $db->query("SELECT * FROM branches", PDO::FETCH_ASSOC);
                                                    if ( $branches->rowCount() ){
                                                        foreach( $branches as $branch ){ ?>
                                                            <option class="text-uppercase" value="<?php echo $branch['id']; ?>"><?php echo $branch['name']; ?></option>
                                                        <?php 
                                                        }
                                                   }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Varış Şubesi</label>
                                            <div class="col-sm-8">
                                                <select required name="target_center" class="form-control">
                                                    <?php $branches = $db->query("SELECT * FROM branches", PDO::FETCH_ASSOC);
                                                    if ( $branches->rowCount() ){
                                                        foreach( $branches as $branch ){ ?>
                                                            <option class="text-uppercase" value="<?php echo $branch['id']; ?>"><?php echo $branch['name']; ?></option>
                                                        <?php 
                                                        }
                                                    }
                                                 ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Ücret</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">TL</span>
                                                    </div>
                                                    <input type="number" required name="cost" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <input type="submit" name="add-cargo" value="Ekle" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- ############ Main END-->
            </div>
            <!-- ############ Content END-->

            <script>
                var checkbox = jQuery("#information");
                var information_form = jQuery(".information");
                var information_input = jQuery("#information-email");
                checkbox.change(function () {
                    information_form.toggleClass("d-none");
                    if(information_input.attr("required")) {
                        information_input.removeAttr("required");
                    } else {
                        information_input.attr("required", "");
                    }
                });
            </script>

<?php require_once(__DIR__ . '/footer.php'); ?>
