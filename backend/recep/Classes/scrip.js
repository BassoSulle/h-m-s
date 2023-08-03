document.addEventListener('DOMContentLoaded', function() {
    // Fetch data from the server using AJAX (using Fetch API)
    fetch('data.php')
      .then(response => response.json())
      .then(data => {
        // Extract labels and values from the fetched data
        const labels = data.map(item => item.label);
        const values = data.map(item => item.value);
        
        // Create a new Chart instance
        const ctx = document.getElementById('circleChart').getContext('2d');
        new Chart(ctx, {
          type: 'pie', // Use 'doughnut' if you want a doughnut chart
          data: {
            labels: labels,
            datasets: [{
              data: values,
              backgroundColor: [
                'rgba(255, 99, 132, 0.8)', // Color for Category A
                'rgba(54, 162, 235, 0.8)', // Color for Category B
                'rgba(75, 192, 192, 0.8)', // Color for Category C
              ],
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
              position: 'bottom'
            }
          }
        });
      })
      .catch(error => console.log('Error fetching data:', error));
  });
  