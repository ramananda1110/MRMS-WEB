<footer class="py-4 bg-light mt-auto">
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
        <script src=
"https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js">
    </script>
    <script src=
"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js">
    </script>
 
    <!-- Include Moment.js CDN -->
    <script type="text/javascript" src=
"https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js">
    </script>
 
    <!-- Include Bootstrap DateTimePicker CDN -->
 
 
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js">
        </script>
        

        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script>
                $( function() {
                    $( "#datepicker" ).datepicker({dateFormat:"yy-mm-dd"}).val();
                } );
        </script>
        <script>
                $( function() {
                    $( "#datetimefrom" ).datetimepicker({format:'hh:mm:ss a'}).val();
                } );
        </script>
        <script>
                $( function() {
                    $( "#datetimeto" ).datetimepicker({format:'hh:mm:ss a'}).val();
                } );
        </script>
        <script>
                $( function() {
                    $( "#datepicker1" ).datepicker({dateFormat:"yy-mm-dd"}).val();
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

    </body>
</html>
