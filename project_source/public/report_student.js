const receiptInfo = [{
    total: 10000,
    buildings: 'All',
    receiptsType: 'All'
}];

function createReceiptInfo(receipt) {
    return `
    <p class="receipt-total">Total: ${receipt.total}</p>
    <p class="receipt-building">Building: ${receipt.buildings} </p>
    <p class="receipt-type">Type: ${receipt.receiptsType} </p>
    <p>Room:</p>
    <p>Dorm Stu ID:</p>
    <p>Date:</p>
  `;
}

function displayReceiptInfo() {
    const receipt = document.getElementById('receipt-info');
    receipt.innerHTML = receiptInfo.map(createReceiptInfo).join('');
}

document.addEventListener('DOMContentLoaded', displayReceiptInfo);


// Data for the combined chart
const receiptData = {
    labels: ['1', '2', '3', '4', '5', '6'], // Months
    datasets: [
        {
            type: 'line',
            label: 'Room',
            data: [200, 300, 400, 350, 450, 500],
            borderColor: '#3498db',
            borderWidth: 2,
            fill: false,
        },
        {
            type: 'line',
            label: 'Electricity',
            data: [150, 200, 250, 300, 200, 400],
            borderColor: '#1abc9c',
            borderWidth: 2,
            fill: false,
        },
        {
            type: 'line',
            label: 'Water',
            data: [100, 120, 180, 200, 160, 300],
            borderColor: '#f1c40f',
            borderWidth: 2,
            fill: false,
        },
        {
            type: 'line',
            label: 'Other',
            data: [80, 100, 120, 150, 130, 170],
            borderColor: '#e74c3c',
            borderWidth: 2,
            fill: false,
        },
        {
            type: 'bar',
            label: 'Total Cost',
            data: [], // This will be calculated
            backgroundColor: 'rgba(52, 152, 219, 0.5)',
            borderWidth: 1,
        },
    ],
};

// Calculate total cost for each month
receiptData.datasets[4].data = receiptData.labels.map((_, index) => {
    return receiptData.datasets.slice(0, 4).reduce((sum, dataset) => sum + dataset.data[index], 0);
});

// Configuration for the chart
const config = {
    type: 'bar',
    data: receiptData,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Receipt Type Cost per Month',
            },
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Month',
                },
            },
            y: {
                title: {
                    display: true,
                    text: 'Cost',
                },
                beginAtZero: true,
            },
        },
    },
};

const receiptTypeData = {
    labels: ['Room', 'Water', 'Electricity', 'Other'],
    datasets: [{
        label: 'Total',
        data: [40, 20, 30, 10],
        backgroundColor: ['#3498db', '#1abc9c', '#e74c3c', '#f1c40f']
    }]
};
document.addEventListener('DOMContentLoaded', () => {
new Chart(document.getElementById('receipt-type-chart'), {
    type: 'pie',
    data: receiptTypeData,
    options: {
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        let total = tooltipItem.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        let value = tooltipItem.raw; // Giá trị của phần hiện tại
                        let percentage = ((value / total) * 100).toFixed(1); // Tính phần trăm
                        return `${tooltipItem.label}: ${value} (${percentage}%)`;
                    }
                }
            }
        }
    }
})});

// Render the chart
// const ctx = document.getElementById('combined-chart').getContext('2d');
document.addEventListener('DOMContentLoaded', () => {
new Chart(document.getElementById('combined-chart'), config)});

function togglePanel() {
    const popup = document.getElementById('filter-popup');
    popup.classList.toggle('hidden'); ;
};

function closePanel(event) {
    const popup = document.getElementById('filter-popup');
    if (event.target === popup) {
        popup.classList.add('hidden');
    }
}
