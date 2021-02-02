<?php require_once(__DIR__ . '/header.php'); ?>

<?php 

if(isset($_POST['delete-personnel'])) {
    $query = $db->prepare("DELETE FROM personnel WHERE id = :id");
    $delete = $query->execute([
        'id' => $_POST['id']
    ]);

    if($query) {
        header('Location:' . get_option('site_url') . '/admin/personnel.php');
        exit;
    }
}

if(isset($_POST['update-personnel'])) {

    $query = $db->prepare("UPDATE personnel SET
        name =:name,
        surname =:surname,
        address =:address,
        phone =:phone,
        tc=:tc,
        email=:email,
        gender =:gender
        WHERE id =:id");
    $update = $query -> execute([
        'name' => $_POST['name'],
        'surname' => $_POST['surname'],
        'address' => $_POST['address'],
        'phone' => $_POST['phone'],
        'tc' => $_POST['tc'],
        'email' => $_POST['email'],
        'gender' => $_POST['gender'],
        'id' => $_POST['id']

    ]);

    if ( $update ){ 
         
        $id = $_POST['id']; 
        $query = $db->query("SELECT * FROM personnel WHERE id = '{$id}'")->fetch(PDO::FETCH_ASSOC);
    }

}


if(isset($_POST['personnel-details'])) {
    $id = $_POST['id']; 
    $query = $db->query("SELECT * FROM personnel WHERE id = '{$id}'")->fetch(PDO::FETCH_ASSOC);
} 
?>

            <!-- ############ Content START-->
            <div id="content" class="flex ">
                <!-- ############ Main START-->
                <div>
                    <div class="page-hero page-container " id="page-hero">
                        <div class="padding d-flex">
                            <div class="page-title">
                                <h2 class="text-md text-highlight">Personel Detayları</h2>
                                <small class="text-muted"><strong><?php echo $query['name'] . ' ' . $query['surname']; ?></strong> çalışanına ait bilgileri görüyorsunuz.</small>
                            </div>
                            <div class="flex"></div>
                            <div>
                                <a href="<?php echo get_option('site_url') . '/admin/new_personnel.php'; ?>" class="btn btn-md text-muted">
                                    <span class="d-none d-sm-inline mx-1">Yeni Personel</span>
                                    <i data-feather="arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="page-content page-container" id="page-content">
                        <div class="padding">

                        <?php
                        if(isset($update)) {
                            ?>
                            <div class="alert alert-success" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span class="mx-2"><strong><?php echo $query['name'] . ' ' . $query['surname']; ?></strong> personeli için bilgiler güncellendi.</span>
                            </div>
                            
                            <?php
                        }
                        ?>

                        <?php if(isset($query)) { ?>

                            <form action="" method="POST">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Personel Detayları</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Ad</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="name" class="form-control" value="<?php echo $query['name']; ?>" pattern="[A-Za-zğĞçÇşŞıİöÖüÜ]{2,}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Soyad</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="surname" class="form-control" value="<?php echo $query['surname']; ?>" pattern="[A-Za-zğĞçÇşŞıİöÖüÜ]{2,}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Adres</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="address" class="form-control" value="<?php echo $query['address']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Telefonu</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="phone" class="form-control" value="<?php echo $query['phone']; ?>" maxlength="11" minlength="11" placeholder="05XXXXXXXXX" pattern="[0]{1}[5]{1}[0-9]{9}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">T.C. Kimlik No</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="tc" class="form-control" value="<?php echo $query['tc']; ?>" maxlength="11" minlength="11" placeholder="xxXXXXXXXXX" pattern="[1-9]{1}[0-9]{9}[0,2,4,6,8]{1}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">E-Posta Adresi</label>
                                            <div class="col-sm-8">
                                                <input type="email" required name="email" class="form-control" value="<?php echo $query['email']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Cinsiyet</label>
                                            <div class="col-sm-8">
                                                <select required name="gender" class="form-control">
                                                    <option value="0" <?php if($query['gender'] == 0) { echo 'selected'; } ?>>Kadın</option>
                                                    <option value="1" <?php if($query['gender'] == 1) { echo 'selected'; } ?>>Erkek</option>
                                                    <option value="2" <?php if($query['gender'] == 2) { echo 'selected'; } ?>>Bilinmiyor</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <input type="hidden" name="id" value="<?php echo $query['id']; ?>">
                                    <div class="btn" data-toggle="modal" data-target="#modal">Sil</div>
                                    <input type="submit" name="update-personnel" value="Kaydet" class="btn btn-success">
                                </div>


                                <div id="modal" class="modal fade show" data-backdrop="true" aria-modal="true">
                                    <div class="modal-dialog ">
                                        <div class="modal-content ">
                                            <div class="modal-header ">
                                                <div class="modal-title text-md">Personeli Sil</div>
                                                <button class="close" data-dismiss="modal">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="p-4 text-center">
                                                    <p><strong><?php echo $query['name'] . ' ' . $query['surname'];?></strong> isimli personeli silmek istediğinize emin misiniz?</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-dismiss="modal">Kapat</button>
                                                <input type="submit" value="Evet, sil" name="delete-personnel" class="btn btn-danger">
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                </div>
                            </form>

                        <?php } else { ?>

                            <div class="alert alert-danger" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="8"></line></svg>
                                <span class="mx-2">Personel detayları gelirken bir sorun oluştu.</span>
                            </div>

                        <?php } ?>
                            
                        </div>
                    </div>
                </div>
                <!-- ############ Main END-->
            </div>
            <!-- ############ Content END-->
<?php require_once(__DIR__ . '/footer.php'); ?>
