<script src={{ asset('report_accountant.js')}}></script>

<x-app-layout>
    <head>
        <link rel="stylesheet" href="{{ asset('css/Report/Report.css') }}" type="text/css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    </head>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-700 leading-tight">
            {{ __('Report') }}
        </h2>
    </x-slot>

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
                <h3>Receipt of Month</h3>
                <canvas id="receipt-of-month-chart" class="chart"></canvas>
            </div>
            <div class="chart-container">
                <h3>Receipt per Building</h3>
                <canvas id="receipt-per-building-chart" class="chart"></canvas>
            </div>
        </div>
    </div>

    <div id="filter-popup" class="popup hidden" onclick="closePanel(event)">
        <div class="popup-content">
            <h2>Filter</h2>
            <form>
                <div class="form-row">
                    <div class="form-group">
                        <label for="building">Building:</label>
                        <select id="building" name="building">
                            <option value="">Select...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dormStudentId">Dorm Student ID:</label>
                        <input type="text" id="dormStudentId" name="dormStudentId">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="room">Room:</label>
                        <input type="text" id="room" name="room">
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="receiptType">Receipt type:</label>
                        <select id="receiptType" name="receiptType">
                            <option value="">Select...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Gender:</label>
                        <div class="radio-group">
                            <input type="radio" id="male" name="gender" value="male" checked>
                            <label for="male">Male</label>
                            <input type="radio" id="female" name="gender" value="female">
                            <label for="female">Female</label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="receiptStatus">Receipt status:</label>
                        <select id="receiptStatus" name="receiptStatus">
                            <option value="">Select...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dob">DOB:</label>
                        <input type="date" id="dob" name="dob">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="receiptDate">Receipt date:</label>
                        <input type="date" id="receiptDate" name="receiptDate">
                    </div>
                    <div class="form-group">
                        <label for="school">School:</label>
                        <input type="text" id="school" name="school">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit">Apply Filter</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

