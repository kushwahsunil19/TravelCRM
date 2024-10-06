<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light"  data-sidebar-size="lg" data-sidebar-image="none">
	
<!-- Mirrored from kanakku.dreamstechnologies.com/html/template/users.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Feb 2024 11:49:49 GMT -->
<head>
        <meta name="csrf-token" content="{{ csrf_token() }}">

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Kanakku provides clean Admin Templates for managing Sales, Payment, Invoice, Accounts and Expenses in HTML, Bootstrap 5, ReactJs, Angular, VueJs and Laravel.">
        <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@dreamguystech">
        <meta name="twitter:title" content="Finance & Accounting Admin Website Templates | Kanakku">
        <meta name="twitter:description" content="Kanakku is a Sales, Invoices & Accounts Admin template for Accountant or Companies/Offices with various features for all your needs. Try Demo and Buy Now.">
        <meta name="twitter:image" content="../../../kanakku.dreamguystech.com/public/assets/img/kanakku.html">
        <meta name="twitter:image:alt" content="Kanakku">  

        <!-- Facebook -->
        <meta property="og:url" content="https://kanakku.dreamguystech.com/">
        <meta property="og:title" content="Finance & Accounting Admin Website Templates | Kanakku">
        <meta property="og:description" content="Kanakku is a Sales, Invoices & Accounts Admin template for Accountant or Companies/Offices with various features for all your needs. Try Demo and Buy Now.">
        <meta property="og:image" content="../../../kanakku.dreamguystech.com/public/assets/img/kanakku.html">
        <meta property="og:image:secure_url" content="../../../kanakku.dreamguystech.com/public/assets/img/kanakku.html">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="1200" >
        <meta property="og:image:height" content="600" >
		<title>Kanakku - Bootstrap Admin HTML Template</title>
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="{{url('public/assets/img/favicon.png')}}">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{url('public/assets/css/bootstrap.min.css')}}">
        
        <!-- Font family -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{url('public/assets/plugins/fontawesome/css/fontawesome.min.css')}}">
		<link rel="stylesheet" href="{{url('public/assets/plugins/fontawesome/css/all.min.css')}}">

		<!-- Feather CSS -->
		<link rel="stylesheet" href="{{url('public/assets/plugins/feather/feather.css')}}">

		<!-- Datepicker CSS -->
		<link rel="stylesheet" href="{{url('public/assets/css/bootstrap-datetimepicker.min.css')}}">

		<!-- Select2 CSS -->
		<link rel="stylesheet" href="{{url('public/assets/plugins/select2/css/select2.min.css')}}">
		
		<!-- Datatables CSS -->
		<link rel="stylesheet" href="{{url('public/assets/plugins/datatables/datatables.min.css')}}">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="{{url('public/assets/css/style.css')}}">
		<link rel="stylesheet" href="{{url('public/assets/css/custom-style.css')}}">

		<!-- Layout Js -->
		<script src="{{url('public/assets/js/layout.js')}}"></script>
		<!-- Summernote CSS -->
        <link rel="stylesheet" href="{{url('public/assets/plugins/summernote/summernote-bs4.min.css')}}">
        <script>
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if(Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif

        @if(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif
    </script>
	</head>
	<body>



    @yield('content')

  		<!-- /Theme Setting -->		
		<!-- jQuery -->
		<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
		<script src="{{url('public/assets/js/jquery-3.7.1.min.js')}}"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="{{url('public/assets/js/bootstrap.bundle.min.js')}}"></script>

		<!-- Datatable JS -->
		<script src="{{url('public/assets/plugins/datatables/datatables.min.js')}}"></script>

		<!-- select CSS -->
		<script src="{{url('public/assets/plugins/select2/js/select2.min.js')}}"></script>
		
		<!-- Slimscroll JS -->
		<script src="{{url('public/assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
		
		<!-- Datepicker Core JS -->
		<script src="{{url('public/assets/plugins/moment/moment.min.js')}}"></script>
		<script src="{{url('public/assets/js/bootstrap-datetimepicker.min.js')}}"></script>
		
		<!-- multiselect JS -->
		<script src="{{url('public/assets/js/jquery-ui.min.js')}}"></script>

		<!-- Theme Settings JS -->
		<script src="{{url('public/assets/js/theme-settings.js')}}"></script>
		<script src="{{url('public/assets/js/greedynav.js')}}"></script>
		
		<!-- Custom JS -->
		<script src="{{url('public/assets/js/script.js')}}"></script>
		<!-- Summernote JS -->
		<script src="{{url('public/assets/plugins/summernote/summernote-bs4.min.js')}}"></script>

	</body>

<!-- Mirrored from kanakku.dreamstechnologies.com/html/template/users.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 07 Feb 2024 11:49:49 GMT -->
</html>