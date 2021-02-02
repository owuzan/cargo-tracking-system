<?php require_once(__DIR__ . '/header.php'); ?>

            <!-- ############ Content START-->
            <div id="content" class="flex ">
                <!-- ############ Main START-->
                <div>
                    <div class="page-hero page-container " id="page-hero">
                        <div class="padding d-flex">
                            <div class="page-title">
                                <h2 class="text-md text-highlight">Raporlar</h2>
                                <small class="text-muted">Raporlara göz atın</small>
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
                            

                            <div class="row">

                                <div class="col-12">
                                    <div class="alert card alert-dismissible fade show p-4 mb-4" role="alert">
                                        <div class="d-flex">
                                            <span class="w-40 avatar circle gd-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></span>
                                            <div class="d-sm-flex">
                                                <div class="mx-3 align-self-start">
                                                    <h6>Hoşgeldin, <?php echo current_user('name') . ' ' . current_user('surname'); ?></h6>
                                                    <small>İstatistikleri buradan inceleyebilirsin</small>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="card bg-light">
                                        <div class="card-header no-border"><strong>Kargoların toplam getirisi</strong></div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="text-lg"><?php echo number_of_cargo_cost(); ?> TL</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-md-4">
                                    <div class="card bg-primary">
                                        <div class="card-header no-border"><strong>Hazırlanan kargo sayısı</strong></div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="text-lg"><?php echo number_of_prepared_cargo(); ?></span>
                                            </div>
                                            <div class="py-3 text-sm">
                                                <small>Hazırlanan kargoların toplam ücreti: <strong class="text-white"><?php echo number_of_prepared_cargo_cost(); ?> TL</strong></small>
                                            </div>
                                            <div>
                                                <a href="<?php echo get_option('site_url') . '/admin/cargoes.php'; ?>" class="btn btn-sm btn-rounded btn-white">Kargolar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-md-4">
                                    <div class="card bg-success">
                                        <div class="card-header no-border"><strong>Teslim edilen kargo sayısı</strong></div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="text-lg"><?php echo number_of_delivered_cargo(); ?></span>
                                            </div>
                                            <div class="py-3 text-sm">
                                                <small>Teslim edilen kargoların toplam ücreti: <strong class="text-white"><?php echo number_of_delivered_cargo_cost(); ?> TL</strong></small>
                                            </div>
                                            <div>
                                                <a href="<?php echo get_option('site_url') . '/admin/cargoes.php'; ?>" class="btn btn-sm btn-rounded btn-white">Kargolar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="card bg-danger">
                                        <div class="card-header no-border"><strong>Teslim edilemeyen kargo sayısı</strong></div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="text-lg"><?php echo number_of_undelivered_cargo(); ?></span>
                                            </div>
                                            <div class="py-3 text-sm">
                                                <small>Teslim edilemeyen kargoların toplam ücreti: <strong class="text-white"><?php echo number_of_undelivered_cargo_cost(); ?> TL</strong></small>
                                            </div>
                                            <div>
                                                <a href="<?php echo get_option('site_url') . '/admin/cargoes.php'; ?>" class="btn btn-sm btn-rounded btn-white">Kargolar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="card bg-warning">
                                        <div class="card-header no-border"><strong>Çıkış şubesindeki kargo sayısı</strong></div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="text-lg"><?php echo number_of_outlet_cargo(); ?></span>
                                            </div>
                                            <div class="py-3 text-sm">
                                                <small>Çıkış şubesindeki kargoların toplam ücreti: <strong class="text-white"><?php echo number_of_outlet_cargo_cost(); ?> TL</strong></small>
                                            </div>
                                            <div>
                                                <a href="<?php echo get_option('site_url') . '/admin/cargoes.php'; ?>" class="btn btn-sm btn-rounded btn-white">Kargolar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-md-6">
                                    <div class="card bg-warning">
                                        <div class="card-header no-border"><strong>Varış şubesindeki kargo sayısı</strong></div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="text-lg"><?php echo number_of_target_cargo(); ?></span>
                                            </div>
                                            <div class="py-3 text-sm">
                                                <small>Varış şubesindeki kargoların toplam ücreti: <strong class="text-white"><?php echo number_of_target_cargo_cost(); ?> TL</strong></small>
                                            </div>
                                            <div>
                                                <a href="<?php echo get_option('site_url') . '/admin/cargoes.php'; ?>" class="btn btn-sm btn-rounded btn-white">Kargolar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-md-6">
                                    <div class="card bg-secondary">
                                        <div class="card-header no-border"><strong>Toplam şube sayısı</strong></div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="text-lg"><?php echo number_of_branch(); ?></span>
                                            </div>
                                            <div class="py-3 text-sm">
                                                <small><?php echo get_option('site_name') . ' olarak toplamda <strong>' . number_of_branch() . '</strong> şubeniz mevcut.'; ?></small>
                                            </div>
                                            <div>
                                                <a href="<?php echo get_option('site_url') . '/admin/branches.php'; ?>" class="btn btn-sm btn-rounded btn-white">Şubeler</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-md-6">
                                    <div class="card bg-secondary">
                                        <div class="card-header no-border"><strong>Toplam personel sayısı</strong></div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <span class="text-lg"><?php echo number_of_personnel(); ?></span>
                                            </div>
                                            <div class="py-3 text-sm">
                                                <small><?php echo get_option('site_name') . ' olarak toplamda <strong>' . number_of_personnel() . '</strong> personel mevcut.'; ?></small>
                                            </div>
                                            <div>
                                                <a href="<?php echo get_option('site_url') . '/admin/personnel.php'; ?>" class="btn btn-sm btn-rounded btn-white">Personeller</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                
                            </div>



                        </div>
                    </div>
                </div>
                <!-- ############ Main END-->
            </div>
            <!-- ############ Content END-->
<?php require_once(__DIR__ . '/footer.php'); ?>
