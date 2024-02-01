<footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; DDC 2024</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{asset('template/dist/js/scripts.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="{{asset('template/dist/assets/demo/chart-area-demo.js')}}"></script>
        <script src="{{asset('template/dist/assets/demo/chart-bar-demo.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="{{asset('template/dist/js/datatables-simple-demo.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script>
                $( function() {
                    $( "#datepicker" ).datepicker({dateFormat:"yy-mm-dd"}).val();
                } );
        </script>
        <script>
                $( function() {
                    $( "#datepicker1" ).datepicker({dateFormat:"yy-mm-dd"}).val();
                } );
        </script>
    </body>
</html>
