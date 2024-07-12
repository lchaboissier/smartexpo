<!-- Begin Page Content -->
<div class="container-fluid">

    <?php
    $session = session();
    $successMessage = $session->getFlashdata('success');
    $warningMessage = $session->getFlashdata('warning');
    $dangerMessage = $session->getFlashdata('danger');
    $infoMessage = $session->getFlashdata('info');
    $errorMessage = $session->getFlashdata('error');

    if ($successMessage) {
        echo '<div class="alert alert-success text-center">' . $successMessage . '</div>';
    } elseif ($warningMessage) {
        echo '<div class="alert alert-warning text-center">' . $warningMessage . '</div>';
    } elseif ($dangerMessage) {
        echo '<div class="alert alert-danger text-center">' . $errorMessage . '</div>';
    } elseif ($infoMessage) {
        echo '<div class="alert alert-info text-center">' . $infoMessage . '</div>';
    } elseif ($errorMessage) {
        echo '<div class="alert alert-danger text-center">' . $errorMessage . '</div>';
    }
    ?>

    <!-- Page Heading -->
    <div class="align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-center text-gray-800">Tableau de bord</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <?php if ($session->has('administrateur')) { ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Nombre de profils</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $nbTotalProfils ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>

        <?php } ?>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Nombre d'actualités</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $nbTotalActus ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Nombre de tickets visiteurs
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $nbTotalTicketsVst ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-ticket fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Nombre de commentaires</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $nbTotalCommentaires ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->

    <div class="row">
        <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
    </div>

</div>
<!-- /.container-fluid -->