<?php require_once(__DIR__ . '/header.php'); ?>


<?php 

$query = false;
$cargo = false;
if(isset($_GET['tracking-number'])) {
    if(!empty($_GET['tracking-number'])) { 
        $tracking_number = $_GET['tracking-number'];
        $cargo = $db -> query("SELECT * FROM cargoes WHERE tracking_number='$tracking_number'") -> fetch(PDO::FETCH_ASSOC);

?>




<?php

if($cargo) { ?>
<div class="row">

    <div class="col-12 mb-4 text-right">
        <a href="<?php echo get_option('site_url'); ?>" class="btn btn-success">Yeni Sorgu</a>
    </div>

    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <strong>Kargo Hareketleri</strong>
            </div>
            <div class="card-body">
            
            <?php
            $movement_order = 0;
            $id = $cargo['id'];
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
    </div>

    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <strong>Kargo Detayları</strong>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Takip Numarası</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo $_GET['tracking-number']; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Gönderen Adı</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo $cargo['sender_name']; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Gönderen Soyadı</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo $cargo['sender_surname']; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Gönderen Telefon</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo $cargo['sender_phone']; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Gönderen T.C. No</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo $cargo['sender_tc']; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Gönderen Adres</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo $cargo['sender_address']; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Alıcı Adı</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo $cargo['receiver_name']; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Alıcı Soyadı</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo $cargo['receiver_surname']; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Alıcı Telefon</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo $cargo['receiver_phone']; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Alıcı T.C. No</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo $cargo['receiver_tc']; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Alıcı Adres</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo $cargo['receiver_address']; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Ürün Ağırlığı</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo $cargo['weight']; ?> Kg</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Çıkış Şubesi</label>
                    <div class="col-sm-8 mt-2">
                        <p class="text-uppercase"><?php echo get_branch($cargo['outlet_center'], 'name'); ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Varış Şubesi</label>
                    <div class="col-sm-8 mt-2">
                        <p class="text-uppercase"><?php echo get_branch($cargo['target_center'], 'name'); ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Kargoya Veriliş Tarihi</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo $cargo['time']; ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Kargo Durumu</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo cargo_status($cargo['status']); ?></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Ücret</label>
                    <div class="col-sm-8 mt-2">
                        <p><?php echo $cargo['cost']; ?> TL</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <?php

        } else { ?>
        

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="alert alert-info" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="8"></line></svg>
                    <span class="mx-2">Kargo bulunamadı.</span>
                </div>
            </div>
        </div>
        
        <?php

        }

?>


    <?php        
    $query = true;
    } else { ?>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="alert alert-info" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="8"></line></svg>
                <span class="mx-2">Takip numarası boş olmamalı.</span>
            </div>
        </div>
    </div>
<?php
    }
}


?>


<?php 

if($query) {

} else {
    ?>



<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div id="content-body">
                <div class="p-3 p-md-5">
                    <h5>Kargo Sorgula</h5>
                    <p>
                        <small class="text-muted">Kargo takip numaranızı girip sorgulama yapabilirsiniz</small>
                    </p>
                    <form method="GET" action="">
                        <div class="form-group">
                            <label>Takip Numarası</label>
                            <input type="text" required name="tracking-number" class="form-control" placeholder="Kargo takip numarası(13 karakter)" minlength="13" maxlength="13" pattern="[0-9a-zA-Z]{13}">
                        </div>
                        
                        <input type="submit" class="btn btn-primary mb-4"/>
                        <div class="mb-2">
                            <a href="<?php echo get_option('site_url') . '/sign-in.php'; ?>" class="text-primary">Yönetici girişi</a>
                        </div>
                        <div>
                            <a href="<?php echo get_option('site_url') . '/sign-up.php'; ?>" class="text-primary">Yönetici kaydı</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once(__DIR__ . '/footer.php'); } ?>