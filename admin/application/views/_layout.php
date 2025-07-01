<?php $site_settings = $this->db->get_where('settings')->row(); 

if($_SESSION['login_s'] != 1){
    redirect(base_url("login"));
}



?>
<!doctype html>
<html class="no-js " lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?= $title ?></title>
    <link rel="icon" href="<?= base_url("uploads/" . $site_settings->favicon) ?>"> <!-- Favicon-->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css') ?>">
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?= base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') ?>" rel="stylesheet" />
    <!-- Bootstrap Select Css -->
    <link href="<?= base_url('assets/plugins/bootstrap-select/css/bootstrap-select.css') ?>" rel="stylesheet" />
    <!-- Bootstrap Spinner Css -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/jquery-spinner/css/bootstrap-spinner.css') ?>">
    <!-- Multi Select Css -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/multi-select/css/multi-select.css') ?>">
    <!-- Bootstrap Tagsinput Css -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') ?>">
    <!-- JQuery DataTable Css -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') ?>">
    <!-- Light Gallery Plugin Css -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/light-gallery/css/lightgallery.css') ?>">
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/chatapp.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/summernote/dist/summernote.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/color_skins.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Jquery Core Js -->

    <script src="<?= base_url('assets/bundles/libscripts.bundle.js') ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/plugins/nestable/jquery-nestable.css') ?>" />

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <style type="text/css">
        .theme-black .minileftbar {
            background: #000000;
        }

        .sidebar .menu .list a {
            color: #ffffff;
        }

        .sidebar .menu .list a:hover {
            color: #000000;
        }

        .sidebar {
            background: #0d757a;
        }

        .sidebar .user-info {
            color: #ffffff;
        }

        a {
            color: #0d757a;
        }

        a:hover {
            color: #000000;
        }

        .theme-black .btn-primary {
            background: #0d757a;
        }

        .dropdown-menu .dropdown-item {
            color: white;
        }

        .dropdown-item.active,
        .dropdown-item:active {
            text-decoration: none;
            background-color: white;
        }
    </style>
</head>

<body class="theme-black">
    <!-- Page Loader -->
    <!-- <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img src="<?= base_url("uploads/$site_settings->logo") ?>" height="48" alt="<?= $site_settings->site_name ?>"></div>
            <p>Please wait...</p>
        </div>
    </div> -->
    <!-- Noida Greater Noida Expressway
›
Sector 150 Noida
›
ATS Pristine
 -->
    <div class="modal fade" id="success_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body form-control-plain text-center" style="margin-top: 30px">
                    <i class="zmdi zmdi-check-circle text-success" style="font-size: 150px"></i>
                    <h3 style="margin-top: 25px"><b>SUCCESS</b></h3>
                </div>
                <div class="text-center">
                    <button type="button" class="btn btn-success waves-effect btn-round btn-lg" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <?php include 'components/header.php'; ?>
    <?php include 'components/navigation.php'; ?>
    <?php include $sub_view . '.php'; ?>
    <?php include 'components/footer.php'; ?>

    <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
    <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
    <script src="<?= base_url('assets/bundles/vendorscripts.bundle.js') ?>"></script> <!-- slimscroll, waves Scripts Plugin Js -->

    <script src="<?= base_url('assets/bundles/knob.bundle.js') ?>"></script> <!-- Jquery Knob-->
    <script src="<?= base_url('assets/bundles/jvectormap.bundle.js') ?>"></script> <!-- JVectorMap Plugin Js -->
    <script src="<?= base_url('assets/bundles/morrisscripts.bundle.js') ?>"></script> <!-- Morris Plugin Js -->
    <script src="<?= base_url('assets/bundles/sparkline.bundle.js') ?>"></script> <!-- sparkline Plugin Js -->
    <script src="<?= base_url('assets/bundles/doughnut.bundle.js') ?>"></script>

    <script src="<?= base_url('assets/bundles/mainscripts.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/js/pages/index.js') ?>"></script>

    <script src="<?= base_url('assets/plugins/momentjs/moment.js') ?>"></script> <!-- Moment Plugin Js -->
    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="<?= base_url('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') ?>"></script>
    <script src="<?= base_url('assets/js/pages/forms/basic-form-elements.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/multi-select/js/jquery.multi-select.js') ?>"></script> <!-- Multi Select Plugin Js -->
    <script src="<?= base_url('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') ?>"></script> <!-- Bootstrap Tags Input Plugin Js -->

    <!-- Jquery DataTable Plugin Js -->
    <script src="<?= base_url('assets/bundles/datatablescripts.bundle.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/jquery-datatable/buttons/buttons.html5.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/jquery-datatable/buttons/buttons.print.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/pages/tables/jquery-datatable.js') ?>"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

    <script src="<?= base_url('assets/plugins/light-gallery/js/lightgallery-all.min.js') ?>"></script> <!-- Light Gallery Plugin Js -->
    <script src="<?= base_url('assets/js/pages/medias/image-gallery.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/nestable/jquery.nestable.js') ?>"></script> <!-- Jquery Nestable -->
    <!-- <script src="https://thememakker.com/templates/alpino/main/assets/plugins/ckeditor/ckeditor.js"></script>
<script src="https://thememakker.com/templates/alpino/main/assets/js/pages/forms/editors.js"></script>
 -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.js"></script> -->
    <script src="<?= base_url('assets/js/pages/ui/sortable-nestable.js') ?>"></script>
    <script src="<?= base_url('assets/js/pages/forms/advanced-form-elements.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script src="<?= base_url('assets/plugins/summernote/dist/summernote.js') ?>"></script>
    <script>
        jQuery(document).ready(function() {
            // $('#myTable').DataTable({
            //     dom: 'Bfrtip',
            //     responsive: true,
            //     lengthMenu: [
            //         [10, 25, 50, 100],
            //         ['10', '25', '50', '100']
            //     ],
            //     buttons: [
            //         'csv', 'excel', 'pageLength',
            //     ],
            //     "order": [
            //         [0, "desc"]
            //     ],

            // });
            $('#myTable').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                lengthMenu: [
                    [10, 25, 50, 100],
                    ['10', '25', '50', '100']
                ],
                buttons: [{
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 3], // Include columns 0, 1, and 3 (exclude column 2)
                            // You can adjust the column indices as needed
                        },
                    },
                    'excel', 'pageLength',
                ],
                "order": [
                    [0, "desc"]
                ],
            });

            $('.summernote').summernote({
                height: 350, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: false, // set focus to editable area after initializing summernote
                popover: {
                    image: [],
                    link: [],
                    air: []
                }
            });

            $('.inline-editor').summernote({
                airMode: true
            });

        });

        window.edit = function() {
                $(".click2edit").summernote()
            },
            window.save = function() {
                $(".click2edit").summernote('destroy');
            }
    </script>

    <script>

        

    </script>

</body>

</html>