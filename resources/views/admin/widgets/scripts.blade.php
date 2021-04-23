<?php
/** @var JsValidator $jsValidator */
?>
<!-- jQuery 3 -->
<script src="{{ admin_asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ admin_asset('dev/jquery-migrate-3.0.0.min.js') }}"></script>

<script src="{{ admin_asset('bower_components/bootstrap-daterangepicker/moment.min.js') }}"></script>
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js"></script>

<script src="{{ admin_asset('bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ admin_asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ admin_asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ admin_asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ admin_asset('dist/js/adminlte.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ admin_asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap  -->
<script src="{{ admin_asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ admin_asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ admin_asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Nestable -->
<script src="{{ admin_asset('dev/jquery.nestable.min.js') }}"></script>
<?php /*<!-- Autocomplete -->
<script srcadmin_="{{ asset('dev/jquery.autocomplete.min.js') }}"></script>*/ ?>

<script src="{{ admin_asset('plugins/iCheck/icheck.min.js') }}"></script>

<script src="{{ admin_asset('plugins/lightbox/js/lightbox.min.js') }}"></script>
<script src="{{ admin_asset('plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ admin_asset('bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ admin_asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ admin_asset('plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ admin_asset('bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ admin_asset('dev/select2/min.js') }}"></script>
<script src="{{ admin_asset('plugins/noty/noty.js') }}"></script>
<script src="{{ admin_asset('plugins/toastr/min.js') }}"></script>
<script src="{{ admin_asset('plugins/magnific/popup.js') }}"></script>
<script src="{{ admin_asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script src="{{ admin_asset('dev/ajax-global-config.js') }}"></script>
<script src="{{ admin_asset('dev/jc/jquery-confirm.min.js') }}"></script>
<script src="{{ admin_asset('dev/custom.js') }}"></script>

@if(isset($jsValidator))
    <script src="{{ admin_url('plugins/validation/jsvalidation.js') }}"></script>
    @if(is_array($jsValidator))
        @foreach($jsValidator as $validator)
            {!! $validator !!}
        @endforeach
    @else
        {!! $jsValidator !!}
    @endif
@endif
@if(isLocal())
    <script src="https://support.wezom.agency/getScript/locotrade/ru"></script>
@endif
