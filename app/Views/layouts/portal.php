<!doctype html>
<html lang="en">
    
<head>

    <?=view('components/portal/head')?>
    <?= $this->renderSection('css') ?>

</head>

<body data-sidebar="dark" data-layout-mode="light">

    <!-- Begin page -->
    <div id="layout-wrapper">
        <?=view('components/portal/header')?>
        <?=view('components/portal/sidebar')?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page breadcrumb -->
                    <?=view('components/portal/breadcrumb')?>
                    <!-- end page breadcrumb -->
                    <?= $this->renderSection('content') ?>
                    <!-- end row -->
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->



            <?=view('components/portal/footer')?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <?=view('components/portal/script')?>
    <?= $this->renderSection('js') ?>
</body>

</html>