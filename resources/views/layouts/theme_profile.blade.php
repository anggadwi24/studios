
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/x-icon" href="{{ url('src/assets/img/favicon.ico')}}"/>
    <link href="{{ url('layouts/vertical-light-menu/css/light/loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('layouts/vertical-light-menu/css/dark/loader.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{ url('layouts/vertical-light-menu/loader.js')}}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ url('src/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('layouts/vertical-light-menu/css/light/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('layouts/vertical-light-menu/css/dark/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('/src/plugins/css/dark/sweetalerts2/custom-sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ url('src/plugins/src/font-icons/fontawesome/css/regular.css')}}">
    <link rel="stylesheet" href="{{ url('src/plugins/src/font-icons/fontawesome/css/fontawesome.css')}}">
    
  
    <link href="{{ url('src/assets/css/light/components/font-icons.css')}}" type="text/css')}}">
    
    <link rel="stylesheet" href="{{ url('src/plugins/src/filepond/filepond.min.css')}}">
    <link rel="stylesheet" href="{{ url('src/plugins/src/filepond/FilePondPluginImagePreview.min.css')}}">
    <link href="{{ url('src/plugins/src/notification/snackbar/snackbar.min.css" rel="stylesheet')}}" type="text/css" />
    <link href="{{ url('src/assets/css/dark/components/font-icons.css')}}" type="text/css')}}">
    <link href="{{ url('src/plugins/css/light/filepond/custom-filepond.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ url('src/plugins/css/light/notification/snackbar/custom-snackbar.css')}}" type="text/css" />
 
    <link href="{{ url('src/assets/css/light/components/list-group.css')}}" type="text/css">

    <link href="{{ url('src/assets/css/light/users/account-setting.css')}}" type="text/css" />
    <link href="{{ url('src/assets/css/light/components/list-group.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ url('src/assets/css/light/users/user-profile.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{ url('src/assets/css/dark/components/list-group.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ url('src/assets/css/dark/users/user-profile.css')}}" rel="stylesheet" type="text/css" />


    <link href="{{ url('src/plugins/css/dark/filepond/custom-filepond.css')}}" type="text/css" />
    <link href="{{ url('src/plugins/css/dark/notification/snackbar/custom-snackbar.css')}}" type="text/css" />
    <link href="{{ url('src/assets/css/dark/components/list-group.css')}}" type="text/css">

    <link href="{{ url('src/assets/css/dark/users/account-setting.css')}}" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <script src="{{ url('src/plugins/src/global/vendors.min.js')}}"></script>
    <script src="{{ url('src/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- BEGIN PAGE LEVEL STYLES -->

    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

</head>
<body class="layout-boxed">
    @include('sweetalert::alert');
    <!-- BEGIN LOADER -->
    <div id="load_screen"> <div class="loader"> <div class="loader-content">
        <div class="spinner-grow align-self-center"></div>
    </div></div></div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    @include('partials.navbar')
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @include('partials.sidebar')
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="middle-content container-xxl p-0">
                    <div class="row">
                        <div class="col-6">
                            <div class="page-meta">
                                <nav class="breadcrumb-style-one" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    
                                      <?= $breadcrumb; ?>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="col-6">
                            <?= $right ?>
                        </div>
                    </div>
                    
                 
                    <div class="row layout-top-spacing">
                     
                        
           
                                 @yield('content')
                             
                    </div>
                   
                </div>
            </div>
            <!--  BEGIN FOOTER  -->
            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">Copyright ?? <span class="dynamic-year">2022</span> <a target="_blank" href="https://designreset.com/cork-admin/">DesignReset</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
                </div>
            </div>
            <!--  END FOOTER  -->
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
   
    <script src="{{ url('src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{ url('src/plugins/src/mousetrap/mousetrap.min.js')}}"></script>
    <script src="{{ url('layouts/vertical-light-menu/app.js')}}"></script>
    <script src="{{ url('src/assets/js/custom.js')}}"></script>

    <script src="{{ url('src/plugins/src/highlight/highlight.pack.js')}}"></script>
    <script src="{{ url('src/plugins/src/sweetalerts2/sweetalerts2.min.js')}}"></script>
    <script src="{{ url('src/plugins/src/sweetalerts2/custom-sweetalert.js')}}"></script>

    <script src="{{ url('src/plugins/src/font-icons/feather/feather.min.js')}}"></script>

    @if(isset($js))
       
            <script src="{{ url('ajax/'.$js)}}" type="module"></script>
      
    @endif
    
    <script>
        feather.replace();
    </script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
 

</body>
</html>