<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>Dashboard GoHappyMart</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @include('layouts/links')
  @yield('link')
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<!-- [ Pre-loader ] End -->
 <!-- [ Sidebar Menu ] start -->
 @include('layouts/sidebar')
<!-- [ Sidebar Menu ] end --> 

<!-- [ Header Topbar ] start -->
@include('layouts/header')
<!-- [ Header ] end -->



  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
        @yield('content')
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <footer class="pc-footer">
  </footer>

  
  <!-- Required Js -->
  <script src="{{ asset('../assets') }}/js/plugins/popper.min.js"></script>
  <script src="{{ asset('../assets') }}/js/plugins/simplebar.min.js"></script>
  <script src="{{ asset('../assets') }}/js/plugins/bootstrap.min.js"></script>
  <script src="{{ asset('../assets') }}/js/fonts/custom-font.js"></script>
  <script src="{{ asset('../assets') }}/js/pcoded.js"></script>
  <script src="{{ asset('../assets') }}/js/plugins/feather.min.js"></script>
  
  <script>layout_change('light');</script>
    
  
  <script>change_box_container('false');</script>
  
  
  
  <script>layout_rtl_change('false');</script>
  
  
  <script>preset_change("preset-1");</script>
  
  
  <script>font_change("Public-Sans");</script>

  @yield('script')
  
    

</body>
<!-- [Body] end -->

</html>