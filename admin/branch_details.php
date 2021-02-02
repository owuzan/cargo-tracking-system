<?php require_once(__DIR__ . '/header.php'); ?>

<?php 

if(isset($_POST['delete-branch'])) {
    $query = $db->prepare("DELETE FROM branches WHERE id = :id");
    $delete = $query->execute([
        'id' => $_POST['id']
    ]);

    if($query) {
        header('Location:' . get_option('site_url') . '/admin/branches.php');
        exit;
    }
}

if(isset($_POST['update-branch'])) {

    $query = $db->prepare("UPDATE branches SET
        name =:name,
        address =:address,
        phone =:phone
        WHERE id = :id");
    $update = $query -> execute([
        'name' => $_POST['name'],
        'address' => $_POST['address'],
        'phone' => $_POST['phone'],
        'id' => $_POST['id']

    ]);
    if ( $update ){ 
         
        $id = $_POST['id']; 
        $query = $db->query("SELECT * FROM branches WHERE id = '{$id}'")->fetch(PDO::FETCH_ASSOC);
    }

}


if(isset($_POST['branch-details'])) {
    $id = $_POST['id']; 
    $query = $db->query("SELECT * FROM branches WHERE id = '{$id}'")->fetch(PDO::FETCH_ASSOC);
} 
?>

            <!-- ############ Content START-->
            <div id="content" class="flex ">
                <!-- ############ Main START-->
                <div>
                    <div class="page-hero page-container " id="page-hero">
                        <div class="padding d-flex">
                            <div class="page-title">
                                <h2 class="text-md text-highlight">Şube Detayları</h2>
                                <small class="text-muted"><strong><?php echo $query['name']; ?></strong> şubesine ait bilgileri görüyorsunuz.</small>
                            </div>
                            <div class="flex"></div>
                            <div>
                                <a href="<?php echo get_option('site_url') . '/admin/new_branch.php'; ?>" class="btn btn-md text-muted">
                                    <span class="d-none d-sm-inline mx-1">Yeni Şube</span>
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
                                <span class="mx-2"><strong><?php echo $query['name']; ?></strong> isimli şube ayarları güncellendi.</span>
                            </div>
                            
                            <?php
                        }
                        ?>

                        <?php if(isset($query)) { ?>

                            <form action="" method="POST">
                                <div class="card">
                                    <div class="card-header">
                                        <strong>Şube Detayları</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Şube Adı</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="name" class="form-control" value="<?php echo $query['name']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Şube Adresi</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="address" class="form-control" value="<?php echo $query['address']; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Şube Telefonu</label>
                                            <div class="col-sm-8">
                                                <input type="text" required name="phone" class="form-control" value="<?php echo $query['phone']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <input type="hidden" name="id" value="<?php echo $query['id']; ?>">
                                    <div class="btn" data-toggle="modal" data-target="#modal">Sil</div>
                                    <input type="submit" name="update-branch" value="Kaydet" class="btn btn-success">
                                </div>


                                <div id="modal" class="modal fade show" data-backdrop="true" aria-modal="true">
                                    <div class="modal-dialog ">
                                        <div class="modal-content ">
                                            <div class="modal-header ">
                                                <div class="modal-title text-md">Şubeyi Sil</div>
                                                <button class="close" data-dismiss="modal">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="p-4 text-center">
                                                    <p><strong><?php echo $query['name'] ;?></strong> isimli şubeyi silmek istediğinize emin misiniz?</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-dismiss="modal">Kapat</button>
                                                <input type="submit" value="Evet, sil" name="delete-branch" class="btn btn-danger">
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                </div>
                            </form>

                        <?php } else { ?>

                            <div class="alert alert-danger" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="8"></line></svg>
                                <span class="mx-2">Şube detayları gelirken bir sorun oluştu.</span>
                            </div>

                        <?php } ?>
                            
                        </div>
                    </div>
                </div>
                <!-- ############ Main END-->
            </div>
            <!-- ############ Content END-->
<?php require_once(__DIR__ . '/footer.php'); ?>
