const receiptInfo = [{
    total: 10000,
    buildings: 'All',
    receiptsType: 'All'
}
]

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

displayReceiptInfo();


// Dummy data for charts
const receiptTypeData = {
    labels: ['Room', 'Water', 'Electricity', 'Other'],
    datasets: [{
        label: 'Total',
        data: [40, 20, 30, 10],
        backgroundColor: ['#3498db', '#1abc9c', '#e74c3c', '#f1c40f']
    }]
};

const receiptOfMonthData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
    datasets: [{
        label: 'Receipts',
        data: [750, 500, 1000, 250, 600, 400],
        borderColor: '#3498db',
        fill: false
    }]
};

const receiptPerBuildingData = {
    labels: ['Building A', 'Building B', 'Building C', 'Building D', 'Building E'],
    datasets: [{
        label: 'Receipts',
        data: [4500, 3000, 4000, 3500, 5000],
        backgroundColor: '#3498db'
    }]
};


// Chart.js initializations
new Chart(document.getElementById('receipt-type-chart'), {
    type: 'pie',
    data: receiptTypeData
});

new Chart(document.getElementById('receipt-of-month-chart'), {
    type: 'line',
    data: receiptOfMonthData
});

new Chart(document.getElementById('receipt-per-building-chart'), {
    type: 'bar',
    data: receiptPerBuildingData
});


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
