// Function to fetch data and create a bar chart using Chart.js
function fetchDataAndCreateChart() {
    // Fetch data from API
    fetch('http://localhost/visulationInternship/api.php')
        .then(response => response.json())
        .then(data => {
            // Assuming data is an array of objects
            const dataArray = data.slice(1); // Exclude the header row

            // Assuming you want to visualize the 'intensity' column
            const labels = dataArray.map(item => item["COL 1"]);
            console.log('Labels:', labels);
            const intensities = dataArray.map(item => parseInt(item["COL 4"])); // Convert to integers
            console.log('Intensities:', intensities);

            // Create a bar chart using Chart.js
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Intensity',
                        data: intensities,
                        backgroundColor: 'steelblue',
                        borderColor: 'black',
                        borderWidth: 1,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}

// Fetch data and create chart when the page loads
fetchDataAndCreateChart();
