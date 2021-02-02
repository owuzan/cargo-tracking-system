<?php require_once(__DIR__ . '/header.php'); ?>

<?php 
$id;
$movement_update;
$new_movement;
$send_movement = false;

if(isset($_POST['delete-cargo'])) {
    $query = $db->prepare("DELETE FROM cargoes WHERE tracking_number = :tracking_number");
    $delete = $query->execute([
        'tracking_number' => $_POST['tracking_number']
    ]);

    if($query) {
        header('Location:' . get_option('site_url') . '/admin/cargoes.php');
        exit;
    }
}

if(isset($_POST['update-cargo'])) {

    $t_number = $_POST['tracking_number'];
    $movement = $db -> query("SELECT id, status FROM cargoes WHERE tracking_number= '{$t_number}' ") -> fetch(PDO::FETCH_ASSOC);
    $id = $movement['id'];
    $old_movement = $movement['status'];
    $new_movement = $_POST['status'];
    if($old_movement != $new_movement) {
        $cargo_movement = $db -> prepare("INSERT INTO cargo_movements SET cargo_id=:cargo_id, movement=:movement");
        $movement_update = $cargo_movement -> execute([
            'cargo_id' => $id,
            'movement' => $new_movement
        ]);

        if($movement_update) {
            $send_movement = true;
        }
    }
    $information;
    if(isset($_POST['information'])) { $information = 1; } else { $information = 0; }

    $query = $db->prepare("UPDATE cargoes SET
        weight =:weight,
        outlet_center =:outlet_center,
        target_center =:target_center,
        status =:status,
        cost =:cost,
        sender_name =:sender_name,
        sender_surname =:sender_surname,
        sender_phone =:sender_phone,
        sender_tc =:sender_tc,
        sender_address =:sender_address,
        receiver_name =:receiver_name,
        receiver_surname =:receiver_surname,
        receiver_phone =:receiver_phone,
        information =:information,
        information_email =:email,
        receiver_tc =:receiver_tc,
        receiver_address =:receiver_address
    WHERE tracking_number = :tracking_number");
    $update = $query -> execute([
        'tracking_number' => $_POST['tracking_number'],
        'weight' => $_POST['weight'],
        'outlet_center' => $_POST['outlet_center'],
        'target_center' => $_POST['target_center'],
        'status' => $_POST['status'],
        'cost' => $_POST['cost'],
        'sender_name' => $_POST['sender_name'],
        'sender_surname' => $_POST['sender_surname'],
        'sender_phone' => $_POST['sender_phone'],
        'sender_tc' => $_POST['sender_tc'],
        'sender_address' => $_POST['sender_address'],
        'receiver_name' => $_POST['receiver_name'],
        'receiver_surname' => $_POST['receiver_surname'],
        'receiver_phone' => $_POST['receiver_phone'],
        'information' => $information,
        'email' => $_POST['email'],
        'receiver_tc' => $_POST['receiver_tc'],
        'receiver_address' => $_POST['receiver_address'] 

    ]);
    if ( $update ){ 
         
        $tracking_number = $_POST['tracking_number']; 
        $query = $db->query("SELECT * FROM cargoes WHERE tracking_number = '{$tracking_number}'")->fetch(PDO::FETCH_ASSOC);
    }

    if($send_movement) {
        $tracking_number = $_POST['tracking_number']; 
        send_movement_information($tracking_number, $new_movement);
    }

}

if(isset($_POST['cargo-details'])) {
    $id = $_POST['id']; 
    $query = $db->query("SELECT * FROM cargoes WHERE id = '{$id}'")->fetch(PDO::FETCH_ASSOC);
} 
?>

            <!-- ############ Content START-->
            <div id="content" class="flex ">
                <!-- ############ Main START-->
                <div>
                    <div class="page-hero page-container " id="page-hero">
                        <div class="padding d-flex">
                            <div class="page-title">
                                <h2 class="text-md text-highlight">Kargo Detayları</h2>
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
                            ?>
                            <div class="alert alert-success" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span class="mx-2"><strong><?php echo $query['tracking_number']; ?></strong> takip numaralı kargo ayarları güncellendi.</span>
                            </div>
                            
                            <?php
                        }
                        ?>


                    <div class="card">
                        <div class="card-header">
                        <strong>Kargo Hareketleri</strong>
                        </div>
                        <div class="card-body">
                                                    
                            <?php
                            $movement_order = 0;
                            $movements = $db -> query("SELECT * FROM cargo_movements WHERE cargo_id='{$id}' ORDER BY time DESC ", PDO::FETCH_ASSOC);
                            if(isset($movements)) {

                                foreach($movements as $movement) { ?>
                                <div class="tl-item <?php if($movement_order == 0) { echo 'active'; $movement_order++; } ?>">
                                    <div class="tl-dot <?php
                                            if($movement['movement'] == 1) {
                                                echo 'b-primary';
                                            } elseif($movement['movement'] == 2) {
                                                echo 'b-warning';
                                            } elseif($movement['movement'] == 3) {
                                                echo 'b-warning';
                                            } elseif($movement['movement'] == 4) {
                                                echo 'b-success';
                                            } elseif($movement['movement'] == 5) {
                                                echo 'b-danger';
                                            }
                                        ?>">
                                    </div>
                                    <div class="tl-content">
                                        <div class="">
                                        <?php
                                            if($movement['movement'] == 1) {
                                                echo 'Hazırlanıyor';
                                            } elseif($movement['movement'] == 2) {
                                                echo 'Çıkış Şubesinde';
                                            } elseif($movement['movement'] == 3) {
                                                echo 'Varış Şubesinde';
                                            } elseif($movement['movement'] == 4) {
                                                echo 'Teslim edildi';
                                            } elseif($movement['movement'] == 5) {
                                                echo 'Alıcıya Ulaşılamadı';
                                            }
                                        ?>
                                        </div>
                                        <div class="tl-date text-muted mt-1"><?php echo $movement['time'] ?></div>
                                    </div>
                                </div>
                            <?php 
                                }
                            } ?>
                        </div>
                    </div>



                        <?php if(isset($query)) { ?>

                            <form action="" method="POST">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Kargo Detayları</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Takip Numarası</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control" value="<?php echo $query['tracking_number']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Kargoya Veriliş Zamanı</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control" value="<?php echo $query['time']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Ağırlık</label>
                                            <div class="col-sm-8">
                                                <input type="number" required name="weight" class="form-control" value="<?php echo $query['weight']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Çıkış Şubesi</label>
                                            <div class="col-sm-8">
                                                <select required name="outlet_center" class="form-control">
                                                <?php 
                                                $branches = $db -> query("SELECT * FROM branches", PDO::FETCH_ASSOC); 
                                                foreach($branches as $branch) { ?>
                                                    <option value="<?php echo $branch['id']; ?>" <?php if($branch['id'] == $query["outlet_center"]) { echo 'selected'; } ?>>
                                                        <?php echo $branch['name'] . ' - ' . $branch['address']; ?>
                                                    </option>
                                                <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Varış Şubesi</label>
                                            <div class="col-sm-8">
                                                <select required name="target_center" class="form-control">
                                                <?php 
                                                $branches = $db -> query("SELECT * FROM branches", PDO::FETCH_ASSOC); 
                                                foreach($branches as $branch) { ?>
                                                    <option value="<?php echo $branch['id']; ?>" <?php if($branch['id'] == $query["target_center"]) { echo 'selected'; } ?>>
                                                        <?php echo $branch['name'] . ' - ' . $branch['address']; ?>
                                                    </option>
                                                <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Kargo Durumu</label>
                                            <div class="col-sm-8">
                                                <select required name="status" class="form-control">
                                                    <option <?php if($query['status'] == 1) { echo 'selected'; } ?> value="1">Hazırlanıyor</option>
                                                    <option <?php if($query['status'] == 2) { echo 'selected'; } ?> value="2">Çıkış Şubesinde</option>
                                                    <option <?php if($query['status'] == 3) { echo 'selected'; } ?> value="3">Varış Şubesinde</option>
                                                    <option <?php if($query['status'] == 4) { echo 'selected'; } ?> value="4">Teslim Edildi</option>
                                                    <option <?php if($query['status'] == 5) { echo 'selected'; } ?> value="5">Alıcıya Ulaşılamadı</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Ücret</label>
                                            <div class="col-sm-8">
                                                <input type="number" required name="cost" class="form-control" value="<?php echo $query['cost']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Gönderen Detayları</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Gönderen Adı</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="sender_name" class="form-control" value="<?php echo $query['sender_name']; ?>" minlength="2">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Gönderen Soyadı</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="sender_surname" class="form-control" value="<?php echo $query['sender_surname']; ?>" minlength="2">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Gönderen Telefonu</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="sender_phone"  class="form-control" value="<?php echo $query['sender_phone']; ?>" maxlength="11" minlength="11" placeholder="05XXXXXXXXX" pattern="[0]{1}[5]{1}[0-9]{9}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Gönderen T.C. No</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="sender_tc" class="form-control" value="<?php echo $query['sender_tc']; ?>" maxlength="11" minlength="11" placeholder="XXXXXXXXXXX" pattern="[1-9]{1}[0-9]{9}[0,2,4,6,8]{1}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Gönderen Adres</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="sender_address" class="form-control" value="<?php echo $query['sender_address']; ?>" minlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Alıcı Detayları</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Alıcı Adı</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="receiver_name" class="form-control" value="<?php echo $query['receiver_name']; ?>" minlength="2">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Alıcı Soyadı</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="receiver_surname" class="form-control" value="<?php echo $query['receiver_surname']; ?>" minlength="2">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Alıcı Telefonu</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="receiver_phone" class="form-control" value="<?php echo $query['receiver_phone']; ?>" minlength="11" class="form-control" placeholder="05XXXXXXXXX" pattern="[0]{1}[5]{1}[0-9]{9}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Alıcı T.C. No</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="receiver_tc" class="form-control" value="<?php echo $query['receiver_tc']; ?>" maxlength="11" minlength="11" placeholder="XXXXXXXXXXX" pattern="[1-9]{1}[0-9]{9}[0,2,4,6,8]{1}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Alıcı Adres</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="receiver_address" class="form-control" value="<?php echo $query['receiver_address']; ?>" minlength="10">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Alıcıyı E-Posta ile Bilgilendir</label>
                                            <div class="col-sm-8">
                                                <div class="checkbox mb-32222">
                                                    <label class="ui-check">
                                                        <input type="checkbox" <?php echo $query['information'] ? 'checked' : ''; ?> id="information" name="information">
                                                        <i></i>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row information <?php echo $query['information'] ? '' : 'd-none'; ?>">
                                            <label class="col-sm-4 col-form-label">Alıcı E-Posta Adresi</label>
                                            <div class="col-sm-8">
                                                <input type="email" name="email" <?php echo $query['information'] ? 'required' : ''; ?> id="information_email" value="<?php echo $query['information_email']; ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <input type="hidden" required name="tracking_number" value="<?php echo $query['tracking_number']; ?>">
                                    <div class="btn" data-toggle="modal" data-target="#modal">Sil</div>
                                    <input type="submit" name="update-cargo" value="Kaydet" class="btn btn-success">
                                </div>
                                
                                <div id="modal" class="modal fade show" data-backdrop="true" aria-modal="true">
                                    <div class="modal-dialog ">
                                        <div class="modal-content ">
                                            <div class="modal-header ">
                                                <div class="modal-title text-md">Kargoyu Sil</div>
                                                <button class="close" data-dismiss="modal">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="p-4 text-center">
                                                    <p><strong><?php echo $query['tracking_number'] ;?></strong> takip numaralı kargoyu silmek istediğinize emin misiniz?</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-dismiss="modal">Kapat</button>
                                                <input type="submit" value="Evet, sil" name="delete-cargo" class="btn btn-danger">
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                </div>



                            </form>

                        <?php } else { ?>

                            <div class="alert alert-danger" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="8"></line></svg>
                                <span class="mx-2">Kargo detayları gelirken bir sorun oluştu.</span>
                            </div>

                        <?php } ?>
                            
                        </div>
                    </div>
                </div>
                <!-- ############ Main END-->
            </div>
            <!-- ############ Content END-->


            
            <script>
                var checkbox = jQuery("#information");
                var information_form = jQuery(".information");
                var information_input = jQuery("#information_email");
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
