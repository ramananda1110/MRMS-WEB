<footer class="py-4 bg-light">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; DDC 2024</div>
                            <div>
                                <a href="https://ddclbd.com/about" target="_blank">Privacy Policy</a>
                                &middot;
                                <a href="https://ddclbd.com/about" target="_blank">Terms &amp; Conditions</a>
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
        
        

        <!-- Include jQuery library -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Include jQuery UI library and CSS -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

        <!-- Yield for custom scripts -->
        @yield('scripts')

        
        <script>
                $( function() {
                    $( "#datepicker2" ).datepicker({dateFormat:"yy-mm-dd"}).val();
                } );
        </script>

        <script>
                $(function() {
                    $("#datepicker").datepicker({
                        dateFormat: "yy-mm-dd",
                        minDate: 0 // Disable past dates
                    });
                });
        </script>
       
        <script>
                $( function() {
                    $( "#datepicker1" ).datetimepicker({format:"HH-mm"}).val();
                } );
        </script>

        <script type="text/javascript">
                $('#mail').on('change', function(){
                    if(this.value=="1"){
                        $("#department").show()
                    } else {
                        $("#department").hide()
                    }

                    if(this.value=="2"){
                        $("#person").show()
                    } else {
                        $("#person").hide()
                    }
                })

               
        </script>

        <script type="text/javascript">
         $(function () {
             $('#datetimepicker3').datetimepicker({
                 format: 'LT'
             });
         });
        </script>


    </body>
</html>
