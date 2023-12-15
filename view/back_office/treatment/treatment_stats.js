// Define the chart variable outside the scope of the function
var myChart;

$(document).ready(function() {
    // Fetch and display default data on page load
    fetchTreatmentData();

    // Function to fetch treatment data
    function fetchTreatmentData(selectedDate = '') {
        $.ajax({
            url: 'fetch_treatment.php',
            method: 'POST',
            data: { date: selectedDate },
            dataType: 'json',
            success: function(response) {
                var dates = []; // Array to store dates
                var treatmentCounts = []; // Array to store treatment counts
              
                // Process the response data and populate the dates and treatmentCounts arrays
                for (var key in response) {
                    dates.push(key);
                    treatmentCounts.push(response[key]);
                }
               
                console.log(dates);
                // Render the data as a bar chart using ApexCharts
                var options = {
                    
                    series: [{
                        name: 'Number of Treatments',
                        data: treatmentCounts
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: dates,
                        labels: {
                            style: {
                                colors: '#fff' // Set x-axis label color to white
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Number of Treatments',
                            style: {
                                color: '#fff' // Set y-axis title color to white
                            }
                        },
                        labels: {
                            style: {
                                colors: '#fff' // Set y-axis label color to white
                            }
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function () {
                                return "";
                            }
                        }
                    },
                    colors: ['#FF69B4'], // Set the series color
                    fill: {
                        opacity: 1
                    }
                };

                var ctx = document.getElementById('treatmentChart');

                // Check if the chart already exists, destroy it and then re-render
                if (myChart) {
                    myChart.destroy();
                }

                myChart = new ApexCharts(ctx, options);
                myChart.render();
            },
            error: function(error) {
                console.error('Error fetching treatment stats:', error);
            }
        });
    }

    // Event listener for date filter change
    $('#filterDate').on('change', function() {
        var selectedDate = $(this).val();
        fetchTreatmentData(selectedDate); // Fetch data based on the selected date
    });
});
