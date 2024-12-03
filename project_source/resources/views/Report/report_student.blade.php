<script src={{ asset('report_student.js')}}></script>

<x-app-layout>
    <head>
        <link rel="stylesheet" href="{{ asset('css/Report/Report.css') }}" type="text/css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    </head>

    <div class="container">
        <div class="header">
            <h2 class="title">Receipt Report</h2>
            <div class="right-header">
                <div class="menu">
                    <button id="menu-btn" onclick="togglePanel()">Filter</button>
                </div>
                <div class="search">
                    <input type="text" placeholder="Search">
                </div>
            </div>
        </div>

        <div class="info-pie">
            <div id="receipt-info" class="info-box"></div>

            <div class="pie-chart">
                <h3>Receipt Type</h3>
                <canvas id="receipt-type-chart"></canvas>
            </div>
        </div>
        <div class="charts">
            <div class="chart-container">
                <h3>Receipt Type cost per Month</h3>
                <canvas id="combined-chart" class="chart"></canvas>
            </div>
        </div>
    </div>

    <div id="filter-popup" class="popup hidden" onclick="closePanel(event)">
        <div class="popup-content">
            <h2>Filter</h2>
            <form>
                <div class="form-group-stu">
                    <label for="receiptType">Receipt type:</label>
                    <select id="receiptType" name="receiptType">
                        <option value="">Select...</option>
                    </select>
                </div>
                <div class="form-group-stu">
                    <label for="receiptStatus">Receipt status:</label>
                    <select id="receiptStatus" name="receiptStatus">
                        <option value="">Select...</option>
                    </select>
                </div>
                <div class="form-group-stu">
                    <label for="receiptDate">Receipt date:</label>
                    <input type="date" id="receiptDate" name="receiptDate">
                </div>
                <div class="form-actions">
                    <button type="submit">Apply Filter</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
