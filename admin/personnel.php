<?php require_once(__DIR__ . '/header.php'); ?>

            <!-- ############ Content START-->
            <div id="content" class="flex ">
                <!-- ############ Main START-->
                <div>
                    <div class="page-hero page-container " id="page-hero">
                        <div class="padding d-flex">
                            <div class="page-title">
                                <h2 class="text-md text-highlight">Çalışanlar</h2>
                                <small class="text-muted"><strong><?php echo get_option('site_name'); ?></strong> çalışanlarını görüntülüyorsunuz.</small>
                            </div>
                            <div class="flex"></div>
                            <div>
                                <a href="<?php echo get_option('site_url') . '/admin/new_personnel.php'; ?>" class="btn btn-md text-muted">
                                    <span class="d-none d-sm-inline mx-1">Personel Ekle</span>
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
                                            <!-- <th><span class="text-muted">ID</span></th> -->
                                            <th><span class="text-muted">Ad ve Soyad</span></th>
                                            <th><span class="text-muted">Cinsiyet</span></th>
                                            <th><span class="text-muted">T.C. Kimlik Numarası</span></th>
                                            <th><span class="text-muted">Adres</span></th>
                                            <th><span class="text-muted">Telefon</span></th>
                                            <th style="width: 100px;"><span class="text-muted">Seçenekler</span></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $query = $db -> query("SELECT * FROM personnel", PDO::FETCH_ASSOC);
                                    if ( $query -> rowCount() ){
                                        foreach( $query as $row ){ ?>
                                            
                                        <tr data-id="<?php echo $row['id']; ?>">
                                            <td class="flex">
                                                <span class="text-color"><?php echo $row['name'] . ' ' . $row['surname']; ?></span>
                                            </td>
                                            <td class="flex">
                                                <span class="text-color"><?php if($row['gender'] == 0) { echo 'Kadın'; } elseif($row['gender'] == 1) { echo 'Erkek'; } else { echo 'Bilinmiyor'; } ?></span>
                                            </td>
                                            <td class="flex">
                                                <span class="text-color"><?php echo $row['tc']; ?></span>
                                            </td>
                                            <td class="flex">
                                                <span class="text-color"><?php echo $row['address']; ?></span>
                                            </td>
                                            <td class="flex">
                                                <span class="text-color"><?php echo $row['phone']; ?></span>
                                            </td>
                                            <td>
                                                <form method="POST" action="<?php echo get_option('site_url') . '/admin/personnel_details'; ?>">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">    
                                                    <input type="submit" name="personnel-details" value="Detaylar" class="btn btn-dark btn-xs" />
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
