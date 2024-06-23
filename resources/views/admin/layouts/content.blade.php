<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <div class="dashboard-header mt-3">Meeting Dashboard</div>
            <div class="card rounded shadow my-4 bg-white">

                <div class="row px-3 mt-4">
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card card-shadow">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <div class="px-auto py-auto">
                                    <div class="card-text">
                                        <span class="h2">{{ $totalMeeting ?? '0' }}</span>
                                    </div>
                                    <div class="font-weight-bold h6">Total</div>
                                </div>
                                <div class=" ms-auto">
                                    <img src="{{ asset('/images/Group.svg') }}" height="50" width="50"
                                        alt="Total Meetings">
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card card-shadow">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <div class="px-auto py-auto">
                                    <div class="card-text">
                                        <span class="h2">{{ $completedCount ?? '0' }}</span>
                                    </div>
                                    <div class="font-weight-bold h6">Completed</div>
                                </div>
                                <div class=" ms-auto">
                                    <img src="{{ asset('/images/Group-1.svg') }}" height="50" width="50"
                                        alt="Total Meetings">
                                </div>

                            </div>
                        </div>
                    </div>

                    

                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card card-shadow">
                            <div class="card-body d-flex justify-content-center align-items-center">

                                <div class=" px-auto py-auto">
                                    <div class="card-text">
                                        <span class="h2">{{ $upcomingCount ?? '0' }}</span>
                                    </div>
                                    <div class="font-weight-bold h6">Upcoming</div>
                                   
                                </div>

                                <div class="ms-auto">
                                    <img src="{{ asset('/images/Group-3.svg') }}" height="50" width="50"
                                        alt="Upcoming Meetings">
                                </div>
                               
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card card-shadow">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <div class=" px-auto py-auto">
                                    <div class="card-text">
                                        <span class="h2">{{ $pendingCount ?? '0' }}</span>
                                    </div>
                                    <div class="font-weight-bold h6">Pending</div>
                                    
                                </div>

                                <div class="ms-auto">
                                    <img src="{{ asset('/images/Group-4.svg') }}" height="50" width="50"
                                        alt="Pending Meetings">
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card card-shadow">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <div class=" px-auto py-auto">
                                    <div class="card-text">
                                        <span class="h2">{{ $rejectedCount ?? '0' }}</span>
                                    </div>
                                    <div class="font-weight-bold h6">Rejected</div>
                                   
                                </div>

                                <div class="ms-auto">
                                    <img src="{{ asset('/images/reject.png') }}" height="60" width="60"
                                        alt="Rejected Meetings">
                                </div>
                               
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="card card-shadow">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <div class=" px-auto py-auto">
                                    <div class="card-text">
                                        <span class="h2">{{ $expiredCount ?? '0' }}</span>
                                    </div>
                                    <div class="font-weight-bold h6">Expired</div>
                                    
                                </div>

                                <div class="ms-auto">
                                    <i class="fa-regular fa-clock" style="font-size: 40px;"></i>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row px-3 chart-card">
                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-1"></i>
                                Daily Meetings
                            </div>
                            <div class="card-body">
                                <canvas id="myWeeklyChart" width="100%" height="40"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-area me-1"></i>
                                Yearly Meetings
                            </div>
                            <div class="card-body">
                                <canvas id="yearlyDataChart" width="100%" height="40"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- JavaScript code -->
    <script>
        // PHP data passed to JavaScript

        var weekData = <?php echo json_encode($weekendData); ?>;

        // Convert PHP data to arrays for Chart.js
        var labels = Object.keys(weekData);
        var data = Object.values(weekData);

        // Determine the current day
        var currentDate = new Date();
        var currentDay = currentDate.toLocaleString('en-US', {
            weekday: 'long'
        });

        // Set colors for each day
        var backgroundColors = labels.map(day => {
            if (day === 'Saturday' || day === 'Friday') {
                return '#EF5350'; // S  // Solid red for weekend days
            } else if (day === currentDay) {
                return '#66BB6A'; // S  // Solid green for current day
            } else {
                return '#42A5F5'; // Solid yellow for other days
            }
        });

        var borderColors = backgroundColors; // Same as background colors for solid effect


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

                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            generateLabels: function(chart) {
                                return [{
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


        var currentMonth = currentDate.toLocaleString('en-US', {
            month: 'long'
        });

        console.log("Current Month: " + currentMonth.substring(0, 3));

        // Set colors for each day
        var bgColors = monthLavels.map(month => {
            if (month === currentMonth.substring(0, 3)) {
                return '#66BB6A'; // S  // Solid green for current day
            } else {
                return '#42A5F5'; // Solid yellow for other days
            }
        });

        var border_Colors = bgColors; // Same as background colors for solid effect

        // Get the canvas element

        var yearlyChart = document.getElementById('yearlyDataChart').getContext('2d');


        // Create the chart
        var yearlyDataChart = new Chart(yearlyChart, {
            type: 'line',
            data: {
                labels: monthLavels,
                datasets: [{
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
                                return [{
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
