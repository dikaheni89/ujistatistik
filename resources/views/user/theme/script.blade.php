 <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
 <script src="{{ asset('theme/bootstrap/js/popper.min.js') }}"></script>
 <script src="{{ asset('theme/bootstrap/js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('theme/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
 <script src="{{ asset('theme/assets/js/app.js') }}"></script>
 <script>
     $(document).ready(function() {
         App.init();
     });
 </script>
 <script src="{{ asset('theme/assets/js/custom.js') }}"></script>
 <!-- END GLOBAL MANDATORY SCRIPTS -->
 @stack('scripts')
