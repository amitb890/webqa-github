<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">`
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin Panel</title>
    <!-- Google Font: Source Sans Pro -->
    <link 
  href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" 
  rel="stylesheet"  type='text/css'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include("admin.components.header")
        @include("admin.components.sidebar")

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          @yield("content")
        </div>
        <!-- /.content-wrapper -->


        @include("admin.components.footer")

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->


    </div>

    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js" integrity="sha384-SlE991lGASHoBfWbelyBPLsUlwY1GwNDJo3jSJO04KZ33K2bwfV9YBauFfnzvynJ" crossorigin="anonymous"></script>
    <script src="{{ asset('js/admin.js') }}" defer></script>
    @yield("js")
</body>
</html>