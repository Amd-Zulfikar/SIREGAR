<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SiReGar App')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="data:;base64,iVBORw0KGgo=">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}"> --}}
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/toastr/toastr.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">


</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fa-solid fa-bars-staggered"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ asset('adminlte/index3.html') }}" class="brand-link">
                <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">SIREGAR</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="javascript:void(0)" class="d-block">{{ Auth::user()->name }} |
                            {{ Auth::user()->role->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li
                            class="nav-item has-treeview {{ request()->routeIs('admin.dashboard') ? 'menu-open' : '' }}">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-house"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li
                            class="nav-item has-treeview {{ request()->routeIs('index.transaction') ? 'menu-open' : '' }}">
                            <a href="{{ route('index.transaction') }}"
                                class="nav-link {{ request()->routeIs('index.transaction') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-cart-shopping"></i>
                                <p>
                                    Transaksi
                                </p>
                            </a>
                        </li>
                        <li
                            class="nav-item has-treeview {{ request()->routeIs('index.role', 'add.role', 'edit.role', 'index.employee', 'add.employee', 'edit.employee', 'index.customer', 'add.customer', 'edit.customer', 'index.account', 'add.account', 'edit.account') ? 'menu-open' : '' }}">
                            <a href="javascript:void(0)"
                                class="nav-link {{ request()->routeIs('index.role', 'add.role', 'edit.role', 'index.employee', 'add.employee', 'edit.employee', 'index.customer', 'add.customer', 'edit.customer', 'index.account', 'add.account', 'edit.account') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-users"></i>
                                <p>
                                    Data User
                                    <i class="fa-solid fa-caret-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('index.role') }}"
                                        class="nav-link {{ request()->routeIs('index.role', 'add.role', 'edit.role') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Role</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.employee') }}"
                                        class="nav-link {{ request()->routeIs('index.employee', 'add.employee', 'edit.employee') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pegawai</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.customer') }}"
                                        class="nav-link {{ request()->routeIs('index.customer', 'add.customer', 'edit.customer') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Customer</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.account') }}"
                                        class="nav-link {{ request()->routeIs('index.account', 'add.account', 'edit.account') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Account</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item has-treeview {{ request()->routeIs('index.submission', 'add.submission', 'edit.submission', 'index.varian', 'add.varian', 'edit.varian', 'index.engine', 'add.engine', 'edit.engine', 'index.brand', 'add.brand', 'edit.brand', 'index.chassis', 'add.chassis', 'edit.chassis', 'index.vehicle', 'add.vehicle', 'edit.vehicle', 'index.mdata', 'add.mdata', 'edit.mdata', 'copy.mdata') ? 'menu-open' : '' }}">
                            <a href="javascript:void(0)"
                                class="nav-link {{ request()->routeIs('index.submission', 'add.submission', 'edit.submission', 'index.varian', 'add.varian', 'edit.varian', 'index.engine', 'add.engine', 'edit.engine', 'index.brand', 'add.brand', 'edit.brand', 'index.chassis', 'add.chassis', 'edit.chassis', 'index.vehicle', 'add.vehicle', 'edit.vehicle', 'index.mdata', 'add.mdata', 'edit.mdata', 'copy.mdata') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-file-signature"></i>
                                <p>
                                    Data Master
                                    <i class="fa-solid fa-caret-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('index.submission') }}"
                                        class="nav-link {{ request()->routeIs('index.submission', 'add.submission', 'edit.submission') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jenis Pengajuan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.varian') }}"
                                        class="nav-link {{ request()->routeIs('index.varian', 'add.varian', 'edit.varian') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jenis Varian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.engine') }}"
                                        class="nav-link {{ request()->routeIs('index.engine', 'add.engine', 'edit.engine') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Engine</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.brand') }}"
                                        class="nav-link {{ request()->routeIs('index.brand', 'add.brand', 'edit.brand') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Merk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.chassis') }}"
                                        class="nav-link {{ request()->routeIs('index.chassis', 'add.chassis', 'edit.chassis') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Chassis</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.vehicle') }}"
                                        class="nav-link {{ request()->routeIs('index.vehicle', 'add.vehicle', 'edit.vehicle') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Vehicle</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.mdata') }}"
                                        class="nav-link {{ request()->routeIs('index.mdata', 'add.mdata', 'edit.mdata', 'copy.mdata') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Master Data</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-header">INPUT GAMBAR</li>
                        <li
                            class="nav-item has-treeview {{ request()->routeIs('index.mgambar', 'add.mgambar', 'edit.mgambar', 'copy.mgambar') ? 'menu-open' : '' }}">
                            <a href="javascript:void(0)"
                                class="nav-link {{ request()->routeIs('index.mgambar', 'add.mgambar', 'edit.mgambar', 'copy.mgambar') ? 'active' : '' }}">
                                <i class="nav-icon fa-solid fa-images"></i>
                                <p>
                                    Gambar Master
                                    <i class="fa-solid fa-caret-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('index.mgambar') }}"
                                        class="nav-link {{ request()->routeIs('index.mgambar', 'add.mgambar', 'edit.mgambar', 'copy.mgambar') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Master Gambar</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->

            <div class="sidebar-custom">
                <a href="#" class="btn btn-link"><i class="fa-solid fa-user-gear"></i></a>
                <a href="#" class="btn btn-secondary hide-on-collapse pos-right"
                    onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();"><i
                        class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </div>
            <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
            <!-- /.sidebar-custom -->
        </aside>

        @yield('content')
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.1.0
        </div>
        <strong>Copyright &copy; 2025 <a href="https://adminlte.io">SiReGar</a>.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ asset('adminlte/dist/js/demo.js') }}"></script> --}}
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('adminlte/plugins/toastr/toastr.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ asset('adminlte/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Tambahin di layouts/app.blade.php -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true, // ubah ke true supaya muncul dropdown halaman
                "autoWidth": false,
                "paging": true, // aktifkan paging
                "info": true, // tampilkan info "Showing 1 to X of Y"
                "pageLength": 10, // default 10 baris per halaman
                "lengthMenu": [
                    [5, 10, 25, 50, 100],
                    [5, 10, 25, 50, 100]
                ],
                "order": []
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
    @stack('scripts')
</body>

</html>
