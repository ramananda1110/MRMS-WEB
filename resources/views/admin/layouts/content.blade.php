<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <!-- <h1 class="mt-4">Dashboard</h1> -->

                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><p class="mt-2"></p></li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Total Meeting
                                        <p><i class="fas fa-user fa-fw" style="font-size:20px;"></i></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" style="font-size:18;" href="#">  {{$totalMeeting ?? '0'}}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Completed Meeting
                                        <p><i class="fas fa-home" style="font-size:18;"></i></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">
                                            {{$completedCount ?? '0'}}
                                        </a>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Upcoming Meeting
                                        <p><i class="fas fa-book" style="font-size:20px;"></i></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">
                                          
                                        {{$upcomingCount ?? '0'}}

                                        </a>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Pending Meeting
                                        <p><i class="fas fa-book" style="font-size:20px;"></i></p>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">  {{ $pendingCount ?? '0' }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Area Chart Example
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Daily Meetings
                                    </div>
                                    <div class="card-body"><canvas id="weeklyChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">Yor details</div>
                                    <div class="card-header" style="background-color:orange">
                                        Name: {{Auth::user()->name}}
                                    </div>
                                    <div class="card-header" style="background-color:orange">
                                        Email: {{Auth::user()->email}}
                                    </div>
                                    <div class="card-header" style="background-color:orange">
                                        Address: {{Auth::user()->address}}
                                    </div>
                                    <div class="card-header" style="background-color:orange">
                                        Mobile: {{Auth::user()->mobile_number}}
                                    </div>
                                    <div class="card-header" style="background-color:orange">
                                        Designation: {{Auth::user()->designation}}
                                    </div>
                                    <div class="card-header" style="background-color:orange">
                                        Join Date: {{Auth::user()->start_from}}
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        
                    </div>
                </main>


                 <!-- JavaScript code -->
   <!-- JavaScript code -->
<script>
    // PHP data passed to JavaScript
    
    var weekData = <?php echo json_encode($weekendData); ?>;
    
    console.log(weekData); // Debugging statement

    // Convert PHP data to arrays for Chart.js
    var labels = Object.keys(weekData);
    var data = Object.values(weekData);

    // Get the canvas element
    var weeklyChart = document.getElementById('weeklyChart').getContext('2d');

    // Create the chart
    var myWeeklyChart = new Chart(weeklyChart, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Weekly Data',
                data: data,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {}
    });
</script>