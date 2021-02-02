<?php require_once(__DIR__ . '/header.php'); ?>

            <!-- ############ Content START-->
            <div id="content" class="flex ">
                <!-- ############ Main START-->
                <div>
                    <div class="page-hero page-container " id="page-hero">
                        <div class="padding d-flex">
                            <div class="page-title">
                                <h2 class="text-md text-highlight">Şubeler</h2>
                                <small class="text-muted"><strong><?php echo get_option('site_name'); ?></strong> şubelerini görebilirsiniz.</small>
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
                        <div class="table-responsive">
                                <table id="datatable" class="table table-theme table-row v-middle" data-plugin="dataTable">
                                    <thead>
                                        <tr>
                                            <th><span class="text-muted">Şube Kodu</span></th>
                                            <th><span class="text-muted">Şube Adı</span></th>
                                            <th><span class="text-muted">Adres</span></th>
                                            <th><span class="text-muted">Telefon Numarası</span></th>
                                            <th style="width: 100px;"><span class="text-muted">Seçenekler</span></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $query = $db -> query("SELECT * FROM branches", PDO::FETCH_ASSOC);
                                    if ( $query -> rowCount() ){
                                        foreach( $query as $row ){ ?>
                                            
                                        <tr data-id="<?php echo $row['id']; ?>">
                                            <td class="flex">
                                                <span class="text-color"><?php echo $row['id']; ?></span>
                                            </td>
                                            <td class="flex">
                                                <span class="text-color text-uppercase"><?php echo $row['name']; ?></span>
                                            </td>
                                            <td class="flex">
                                                <span class="text-color"><?php echo $row['address']; ?></span>
                                            </td>
                                            <td class="flex">
                                                <span class="text-color"><?php echo $row['phone']; ?></span>
                                            </td>
                                            <td class="flex d-none">
                                            </td>
                                            <td class="flex">
                                                <form method="POST" action="<?php echo get_option('site_url') . '/admin/branch_details'; ?>">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">    
                                                    <input type="submit" name="branch-details" value="Detaylar" class="btn btn-dark btn-xs" />
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
