<!-- Including Bootstrap JS (with its jQuery dependency) so that dynamic components work -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="{{ asset('admin/assets/js/bootstrap-select.js') }}"></script>

    {{-- add the page specific footer script --}}
    @yield('footer_script')
</body>

</html>