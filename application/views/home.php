<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Click call application</title>
    <!-- Bootstrap Core CSS -->
    <link href="/clicktocall/innerstyle/css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="/clicktocall/innerstyle/css/helper.css" rel="stylesheet">
    <link href="/clicktocall/innerstyle/css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
        <div class="header">
                <nav class="navbar top-navbar navbar-expand-md navbar-light">
                    <!-- Logo -->
                    <div class="navbar-header">
                        <a class="navbar-brand" href="index.html">
                            <!-- Logo icon -->
                            <b></b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            <span style="font-weight: bold;">Click Call Application</span>
                        </a>
                    </div>
                    <!-- End Logo -->
                   
                </nav>
            </div>
        <!-- End header header -->
        <!-- Left Sidebar  -->
        <div class="left-sidebar">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="nav-devider"></li>
                            <li class="nav-label">Home</li>
                            <li> <a  href="" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard</span></a></li>
                            <li> <a  href="<?php echo base_url() ?>user/logout/<?php echo $ky; ?>" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Logout</span></a></li>
                           
                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </div>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary"><?php echo $companyname; ?></h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo $companyname; ?></li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>Message</th>
                                                <th>Device</th>
                                                <th>Location</th>
                                            </tr>
                                        </thead>
                                        
                                           
                                        <tbody>

                                 <?php  
                                  
                                  if(count($alldata)!=0)
                                  {
                                    foreach($alldata as $check)
                                    {
                                       if(trim($check->name) !='')
                                       {
                                 ?>

                                            <tr>
                                                <td><?php echo $check->name; ?></td>
                                                <td><?php echo $check->email; ?></td>
                                                <td><?php echo $check->phone_number; ?></td>
                                                <td><?php echo $check->message; ?></td>
                                                <td><?php echo $check->device; ?></td>
                                                <td><?php echo $check->location; ?></td>
                                               
                                            </tr>
                                   <?php } }}else {?>
                                   
                                   <tr><td colspan="6">Nothing to show</td></tr><?php } ?>
                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                
                    </div>
                </div>

               
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2018 All rights reserved.inaip</footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="/clicktocall/innerstyle/js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="/clicktocall/innerstyle/js/lib/bootstrap/js/popper.min.js"></script>
    <script src="/clicktocall/innerstyle/js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="/clicktocall/innerstyle/js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="/clicktocall/innerstyle/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="/clicktocall/innerstyle/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="/clicktocall/innerstyle/js/custom.min.js"></script>


    <script src="/clicktocall/innerstyle/js/lib/datatables/datatables.min.js"></script>
    <script src="/clicktocall/innerstyle/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="/clicktocall/innerstyle/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="/clicktocall/innerstyle/js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="/clicktocall/innerstyle/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="/clicktocall/innerstyle/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="/clicktocall/innerstyle/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="/clicktocall/innerstyle/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="/clicktocall/innerstyle/js/lib/datatables/datatables-init.js"></script>

    




</body>

</html>