<?php require_once(__DIR__ . '/header.php'); ?>

            <!-- ############ Content START-->
            <div id="content" class="flex ">
                <!-- ############ Main START-->
                <div>
                    <div class="page-hero page-container " id="page-hero">
                        <div class="padding d-flex">
                            <div class="page-title">
                                <h2 class="text-md text-highlight">Kargolar</h2>
                                <small class="text-muted">Gelen ve giden tüm kargoları burada görebilirsiniz.</small>
                            </div>
                            <div class="flex"></div>
                            <div>
                                <a href="<?php echo get_option('site_url') . '/admin/new_cargo.php'; ?>" class="btn btn-md text-muted">
                                    <span class="d-none d-sm-inline mx-1">Yeni Kargo</span>
                                    <i data-feather="arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="page-content page-container" id="page-content">
                        <div class="padding">
                        <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                                    <thead>
                                        <tr>
                                            <th><span class="text-muted">ID</span></th>
                                            <th><span class="text-muted">Takip No</span></th>
                                            <th><span class="text-muted">Gönderen Ad</span></th>
                                            <th><span class="text-muted">Alıcı Adı</span></th>
                                            <th><span class="text-muted">Kargo Zamanı</span></th>
                                            <th><span class="text-muted">Durum</span></th>
                                            <th style="width: 100px;"><span class="text-muted">Seçenekler</span></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $query = $db -> query("SELECT * FROM cargoes", PDO::FETCH_ASSOC);
                                    if ( $query -> rowCount() ){
                                        foreach( $query as $row ){ ?>
                                            
                                        <tr data-id="<?php echo $row['id']; ?>">
                                            <td class="flex">
                                                <span class="text-color"><?php echo $row['id']; ?></span>
                                            </td>
                                            <td class="flex">
                                                <span class="text-color"><?php echo $row['tracking_number']; ?></span>
                                            </td>
                                            <td class="flex">
                                                <span class="text-color"><?php echo $row['sender_name'] . ' ' . $row['sender_surname']; ?></span>
                                            </td>
                                            <td class="flex">
                                                <span class="text-color"><?php echo $row['receiver_name'] . ' ' . $row['receiver_surname']; ?></span>
                                            </td>
                                            <td class="flex">
                                                <span class="text-color"><?php echo $row['time']; ?></span>
                                            </td>
                                            <td class="flex">
                                                <?php if($row['status'] == 1) { 
                                                    echo '<span class="badge badge-primary">Hazırlanıyor</span>'; 
                                                    } ?>
                                                <?php if($row['status'] == 2) { 
                                                    echo '<span class="badge badge-warning">Çıkış Şubesinde</span>'; 
                                                    } ?>
                                                <?php if($row['status'] == 3) { 
                                                    echo '<span class="badge badge-warning">Varış Şubesinde</span>'; 
                                                    } ?>
                                                <?php if($row['status'] == 4) { 
                                                    echo '<span class="badge badge-success">Teslim Edildi</span>'; 
                                                    } ?>
                                                <?php if($row['status'] == 5) { 
                                                    echo '<span class="badge badge-danger">Alıcıya Ulaşılamadı</span>'; 
                                                    } ?>
                                            </td>
                                            <td>
                                                <form method="POST" action="<?php echo get_option('site_url') . '/admin/cargo_details'; ?>">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">    
                                                    <input type="submit" name="cargo-details" value="Detaylar" class="btn btn-dark btn-xs" />
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ############ Main END-->
            </div>
            <!-- ############ Content END-->
<?php require_once(__DIR__ . '/footer.php'); ?>
