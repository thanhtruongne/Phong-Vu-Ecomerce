
<script src="{{asset('backend2/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('backend2/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<script type="text/javascript">
  var base_url = '{{ config('app.env') }}' + 'private/system';
  window._app_env_ = '{{ config('app.env') }}';
</script>

<!-- Bootstrap 4 -->
<script src="{{asset('backend2/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

{{-- <script src="{{asset('backend2/plugins/bootstrap/js/bootstrap.min.js')}}"></script> --}}

<script src="{{asset('backend2/plugins/select2/js/select2.min.js')}}"></script>

<script src="{{asset('backend2/js/popper.min.js')}}"></script>
{{-- LoadBootstrapTable --}}
<script src="{{asset('backend2/js/bootstrap-table.min.js')}}"></script>
<script src="{{asset('backend2/js/bootstrap-table-vi-VN.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('backend2/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('backend2/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('backend2/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('backend2/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('backend2/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('backend2/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('backend2/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('backend2/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('backend2/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('backend2/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('backend2/js/adminlte.js')}}"></script>

<script src="{{asset('backend2/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{asset('backend2/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('backend2/js/pages/dashboard.js')}}"></script>

<script src="{{asset('backend2/js/backend2.js')}}"></script>

{{-- boostrap-iconpicker --}}
<script src="{{asset('backend2/plugins/boostrap-iconpicker/boostrap-iconpicker.js')}}"></script>

{{-- Ckeditor --}}
<script src="{{asset('backend2/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('backend2/plugins/ckeditor/ckeditorClassic.js')}}"></script>
{{-- CkFinder --}}
<script src="{{asset('js/ckfinder/ckfinder.js')}}"></script>
{{-- <script>CKFinder.config( { connectorPath: '/ckfinder/connector' } );</script> --}}
<script src="{{asset('js/run_prettify.js')}}"></script>
<script>CKFinder.config( { connectorPath: @json(route('ckfinder_connector')) } )</script>



<script src="{{asset('backend2/js/load-ajax.js')}}"></script>

<script src="{{asset('backend2/js/load-select.js')}}"></script>

