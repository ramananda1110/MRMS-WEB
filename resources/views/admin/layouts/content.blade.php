<div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <!-- <h1 class="mt-4">Dashboard</h1> -->

                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><p class="mt-2"></p></li>
                        </ol>
                        <div class="row">

                        
                        <div class="col-xl-3 col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-body d-flex align-items-center ">
                                   
                                    <div class="icon">
                                            <image src="{{asset('/images/Group.svg')}}" height="80" width="80" />
                                                                          
                                   </div>
                                    <div class="ps-4">
                                        <div class="card-title">Total Meetings</div>
                                        <div class="card-text">
                                            <span style="font-size: 2rem;">{{$totalMeeting ?? '0'}}</span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-body d-flex align-items-center ">
                                   
                                    <div class="icon">
                                        <image src="{{asset('/images/Group-1.svg')}}" height="80" width="80" />
                                    </div>
                                    <div class="ps-4">
                                        <div class="card-title">Completed Meetings</div>
                                        <div class="card-text">
                                            <span style="font-size: 2rem;">{{$completedCount ?? '0'}}</span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-body d-flex align-items-center ">
                                   
                                    <div class="icon">
                                        <image src="{{ asset('/images/Group-3.svg') }}" height="80" width="80" />
                                    </div>
                                    <div class="ps-4">
                                        <div class="card-title">Upcoming Meetings</div>
                                        <div class="card-text">
                                            <span style="font-size: 2rem;">{{$upcomingCount ?? '0'}}</span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card shadow mb-4">
                                <div class="card-body d-flex align-items-center ">
                                   
                                    <div class="icon">
                                        <image src="{{asset('/images/Group-4.svg')}}" height="80" width="80" />
                                    </div>
                                    <div class="ps-4">
                                        <div class="card-title">Pending Meetings</div>
                                        <div class="card-text">
                                            <span style="font-size: 2rem;">{{$pendingCount ?? '0'}}</span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        </div>

                        
                        <div class="row">
                            
                            

                            

                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Daily Meetings
                                    </div>
                                    <div class="card-body"><canvas id="myWeeklyChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Yearly Meetings
                                    </div>
                                    <div class="card-body"><canvas id="yearlyDataChart" width="100%" height="40"></canvas></div>
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
    
    // Convert PHP data to arrays for Chart.js
    var labels = Object.keys(weekData);
    var data = Object.values(weekData);

    // Determine the current day
    var currentDate = new Date();
    var currentDay = currentDate.toLocaleString('en-US', { weekday: 'long' });

   // Set colors for each day
   var backgroundColors = labels.map(day => {
        if (day === 'Saturday' || day === 'Friday') {
            return '#EF5350';  // S  // Solid red for weekend days
        } else if (day === currentDay) {
            return '#66BB6A';  // S  // Solid green for current day
        } else {
            return '#42A5F5';  // Solid yellow for other days
        }
    });

    var borderColors = backgroundColors;  // Same as background colors for solid effect


    // Get the canvas element

    var weeklyChart = document.getElementById('myWeeklyChart').getContext('2d');


    // Create the chart
    var myWeeklyChart = new Chart(weeklyChart, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: "Weekly",
                data: data,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        generateLabels: function(chart) {
                            return [
                                {
                                    text: 'Off Day',
                                    fillStyle: '#EF5350',
                                    strokeStyle: '#EF5350',
                                    hidden: false,
                                    lineCap: 'butt',
                                    lineDash: [],
                                    lineDashOffset: 0,
                                    lineJoin: 'miter',
                                    pointStyle: 'rect',
                                    rotation: 0
                                },
                                {
                                    text: 'Present Day',
                                    fillStyle: '#66BB6A',
                                    strokeStyle: '#66BB6A',
                                    hidden: false,
                                    lineCap: 'butt',
                                    lineDash: [],
                                    lineDashOffset: 0,
                                    lineJoin: 'miter',
                                    pointStyle: 'rect',
                                    rotation: 0
                                },
                                {
                                    text: 'Others',
                                    fillStyle: '#42A5F5',
                                    strokeStyle: '#42A5F5',
                                    hidden: false,
                                    lineCap: 'butt',
                                    lineDash: [],
                                    lineDashOffset: 0,
                                    lineJoin: 'miter',
                                    pointStyle: 'rect',
                                    rotation: 0
                                }
                            ];
                        }
                    }
                }
            }
        }
    });




    var montlyData = <?php echo json_encode($yearlyData); ?>;
    
    // Convert PHP data to arrays for Chart.js
    var monthLavels = Object.keys(montlyData);
    var monthData = Object.values(montlyData);


    var currentMonth = currentDate.toLocaleString('en-US', { month: 'long' });

    console.log("Current Month: " + currentMonth.substring(0, 3));

     // Set colors for each day
    var bgColors = monthLavels.map(month => {
         if (month === currentMonth.substring(0, 3)) {
            return '#66BB6A';  // S  // Solid green for current day
        } else {
            return '#42A5F5';  // Solid yellow for other days
        }
    });

    var border_Colors = bgColors;  // Same as background colors for solid effect




    // Get the canvas element

    var yearlyChart = document.getElementById('yearlyDataChart').getContext('2d');


    // Create the chart
    var yearlyDataChart = new Chart(yearlyChart, {
        type: 'line',
        data: {
            labels: monthLavels,
            datasets: [{
                label: "2024",
                data: monthData,
                backgroundColor: bgColors,
                borderColor: border_Colors,
                borderWidth: 1.5
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    labels: {
                        generateLabels: function(chart) {
                            return [
                                {
                                    text: 'Present Month',
                                    fillStyle: '#66BB6A',
                                    strokeStyle: '#66BB6A',
                                    hidden: false,
                                    lineCap: 'butt',
                                    lineDash: [],
                                    lineDashOffset: 0,
                                    lineJoin: 'miter',
                                    pointStyle: 'rect',
                                    rotation: 0
                                },
                                {
                                    text: 'Others',
                                    fillStyle: '#42A5F5',
                                    strokeStyle: '#42A5F5',
                                    hidden: false,
                                    lineCap: 'butt',
                                    lineDash: [],
                                    lineDashOffset: 0,
                                    lineJoin: 'miter',
                                    pointStyle: 'rect',
                                    rotation: 0
                                }
                            ];
                        }
                    }
                }
            }
        }
    });


</script>

 