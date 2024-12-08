@extends('Auth_.index')

<head>
    <title>Activities List</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('./css/student/extension.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/student/activities.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">

    <script src="{{ asset('./filterpanel.js') }}"></script>

    {{--    <link rel="stylesheet" href="{{ asset('./css/reg_room.css') }}" type="text/css">--}}
<style>
    .extension{
        max-width: 60%;
    }
</style>
</head>

@section('content')
    @include('layouts.sidebar_student')
    <div class="extension">
        <h3 class="heading">Activities</h3>
        <div class="filter-sgv" onclick="toggleFilter()">
            <svg xmlns="http://www.w3.org/2000/svg" width="67" height="66" viewBox="0 0 67 66" fill="none">
                <g filter="url(#filter0_d_1132_2655)">
                    <g filter="url(#filter1_d_1132_2655)">
                        <path
                            d="M4 15C4 6.71573 10.7157 0 19 0H48C56.2843 0 63 6.71573 63 15V41C63 49.2843 56.2843 56 48 56H19C10.7157 56 4 49.2843 4 41V15Z"
                            fill="white" />
                        <path
                            d="M4.5 15C4.5 6.99187 10.9919 0.5 19 0.5H48C56.0081 0.5 62.5 6.99187 62.5 15V41C62.5 49.0081 56.0081 55.5 48 55.5H19C10.9919 55.5 4.5 49.0081 4.5 41V15Z"
                            stroke="#CBD4F3" />
                    </g>
                    <path
                        d="M22.5315 20.6021H26.2999C26.4294 21.3213 26.8154 21.9731 27.3899 22.4427C27.9645 22.9124 28.6908 23.1698 29.4412 23.1698C30.1915 23.1698 30.9179 22.9124 31.4924 22.4427C32.067 21.9731 32.4529 21.3213 32.5824 20.6021H43.792C43.933 20.6021 44.0682 20.5476 44.1679 20.4506C44.2675 20.3536 44.3235 20.2221 44.3235 20.0849C44.3235 19.9477 44.2675 19.8162 44.1679 19.7192C44.0682 19.6222 43.933 19.5677 43.792 19.5677H32.5824C32.4529 18.8485 32.067 18.1968 31.4924 17.7271C30.9179 17.2575 30.1915 17 29.4412 17C28.6908 17 27.9645 17.2575 27.3899 17.7271C26.8154 18.1968 26.4294 18.8485 26.2999 19.5677H22.5315C22.3905 19.5677 22.2554 19.6222 22.1557 19.7192C22.056 19.8162 22 19.9477 22 20.0849C22 20.2221 22.056 20.3536 22.1557 20.4506C22.2554 20.5476 22.3905 20.6021 22.5315 20.6021ZM29.4412 18.0161C29.8617 18.0161 30.2727 18.1375 30.6223 18.3648C30.972 18.5921 31.2445 18.9152 31.4054 19.2932C31.5663 19.6712 31.6084 20.0872 31.5264 20.4885C31.4443 20.8898 31.2419 21.2584 30.9445 21.5478C30.6472 21.8371 30.2684 22.0341 29.8559 22.1139C29.4435 22.1938 29.0161 22.1528 28.6276 21.9962C28.2391 21.8396 27.907 21.5745 27.6734 21.2343C27.4398 20.8941 27.3151 20.4941 27.3151 20.0849C27.3151 19.5362 27.5391 19.01 27.9378 18.6221C28.3365 18.2341 28.8773 18.0161 29.4412 18.0161ZM43.792 27.3257H40.0236C39.8941 26.6065 39.5082 25.9547 38.9336 25.4851C38.3591 25.0154 37.6327 24.7579 36.8824 24.7579C36.132 24.7579 35.4056 25.0154 34.8311 25.4851C34.2566 25.9547 33.8706 26.6065 33.7411 27.3257H22.5315C22.3905 27.3257 22.2554 27.3802 22.1557 27.4771C22.056 27.5741 22 27.7057 22 27.8429C22 27.98 22.056 28.1116 22.1557 28.2086C22.2554 28.3056 22.3905 28.3601 22.5315 28.3601H33.7411C33.8706 29.0793 34.2566 29.731 34.8311 30.2007C35.4056 30.6703 36.132 30.9278 36.8824 30.9278C37.6327 30.9278 38.3591 30.6703 38.9336 30.2007C39.5082 29.731 39.8941 29.0793 40.0236 28.3601H43.792C43.933 28.3601 44.0682 28.3056 44.1679 28.2086C44.2675 28.1116 44.3235 27.98 44.3235 27.8429C44.3235 27.7057 44.2675 27.5741 44.1679 27.4771C44.0682 27.3802 43.933 27.3257 43.792 27.3257ZM36.8824 29.9116C36.4619 29.9116 36.0508 29.7903 35.7012 29.563C35.3516 29.3357 35.0791 29.0126 34.9181 28.6345C34.7572 28.2565 34.7151 27.8406 34.7972 27.4393C34.8792 27.038 35.0817 26.6693 35.379 26.38C35.6763 26.0907 36.0552 25.8936 36.4676 25.8138C36.88 25.734 37.3075 25.775 37.696 25.9315C38.0844 26.0881 38.4165 26.3533 38.6501 26.6935C38.8837 27.0337 39.0084 27.4337 39.0084 27.8429C39.0084 28.3915 38.7844 28.9177 38.3857 29.3057C37.987 29.6937 37.4462 29.9116 36.8824 29.9116ZM43.792 35.0836H32.5824C32.4529 34.3644 32.067 33.7127 31.4924 33.243C30.9179 32.7734 30.1915 32.5159 29.4412 32.5159C28.6908 32.5159 27.9645 32.7734 27.3899 33.243C26.8154 33.7127 26.4294 34.3644 26.2999 35.0836H22.5315C22.3905 35.0836 22.2554 35.1381 22.1557 35.2351C22.056 35.3321 22 35.4636 22 35.6008C22 35.738 22.056 35.8695 22.1557 35.9665C22.2554 36.0635 22.3905 36.118 22.5315 36.118H26.2999C26.4294 36.8372 26.8154 37.489 27.3899 37.9586C27.9645 38.4283 28.6908 38.6857 29.4412 38.6857C30.1915 38.6857 30.9179 38.4283 31.4924 37.9586C32.067 37.489 32.4529 36.8372 32.5824 36.118H43.792C43.933 36.118 44.0682 36.0635 44.1679 35.9665C44.2675 35.8695 44.3235 35.738 44.3235 35.6008C44.3235 35.4636 44.2675 35.3321 44.1679 35.2351C44.0682 35.1381 43.933 35.0836 43.792 35.0836ZM29.4412 37.6696C29.0207 37.6696 28.6096 37.5483 28.26 37.3209C27.9104 37.0936 27.6379 36.7705 27.477 36.3925C27.316 36.0145 27.2739 35.5985 27.356 35.1972C27.438 34.7959 27.6405 34.4273 27.9378 34.138C28.2352 33.8486 28.614 33.6516 29.0264 33.5718C29.4388 33.4919 29.8663 33.5329 30.2548 33.6895C30.6433 33.8461 30.9753 34.1112 31.2089 34.4515C31.4425 34.7917 31.5672 35.1916 31.5672 35.6008C31.5672 36.1495 31.3432 36.6757 30.9445 37.0637C30.5458 37.4516 30.005 37.6696 29.4412 37.6696Z"
                        fill="#757575" />
                </g>
                <defs>
                    <filter id="filter0_d_1132_2655" x="0" y="0" width="67" height="66" filterUnits="userSpaceOnUse"
                            color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                       result="hardAlpha" />
                        <feOffset dy="6" />
                        <feGaussianBlur stdDeviation="2" />
                        <feComposite in2="hardAlpha" operator="out" />
                        <feColorMatrix type="matrix" values="0 0 0 0 0.925499 0 0 0 0 0.937916 0 0 0 0 1 0 0 0 1 0" />
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1132_2655" />
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1132_2655" result="shape" />
                    </filter>
                    <filter id="filter1_d_1132_2655" x="0" y="0" width="67" height="66" filterUnits="userSpaceOnUse"
                            color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                       result="hardAlpha" />
                        <feOffset dy="6" />
                        <feGaussianBlur stdDeviation="2" />
                        <feComposite in2="hardAlpha" operator="out" />
                        <feColorMatrix type="matrix" values="0 0 0 0 0.925499 0 0 0 0 0.937916 0 0 0 0 1 0 0 0 1 0" />
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1132_2655" />
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1132_2655" result="shape" />
                    </filter>
                </defs>
            </svg>
        </div>

            {{--    Hien thi panel filter lọc --}}
            <div class="overlay hidden" onclick="toggleFilter()"></div>
            <div id="filter-panel" class="filter-panel hidden">
                {{--        <div class="filter-sections"> --}}
                <div class="filter-section">
                    <h3>My status</h3>
                    <label><input type="checkbox" /> Registed</label>
                    <label><input type="checkbox" /> Joined</label>
                    <label><input type="checkbox" /> Not registered</label>
                </div>

{{--                <div class="filter-section floor-number-container">--}}
{{--                    <h3>Floor number</h3>--}}
{{--                    <input type="number" placeholder="Floor 1" min="1" />--}}
{{--                </div>--}}
                <div class="filter-section month-container">
                    <h3>Month</h3>
                    <select style="    border: 2px dashed #c2baff;">
                        <option value="" disabled selected>Select Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <h3></h3>
                    <h3></h3>
                    <h3></h3>
                        <h3>Year</h3>
                        <select style="    border: 2px dashed #c2baff;">
                            <option value="" disabled selected>Select Year</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                        </select>
                </div>
                <div class="filter-section">
                    <h3>Start Date</h3>
                    <input type="date" name="start_date" placeholder="Start Date" />
                    <h3></h3>
                    <h3></h3>
                    <h3></h3>
                    <h3>End Date</h3>
                    <input type="date" name="end_date" placeholder="End Date" />
                </div>
                <div class="filter-section">
                    <h3>Participants</h3>
                    <label><input type="checkbox" /> &lt;<10</label>
                    <label><input type="checkbox" /> &lt; 10-50</label>
                    <label><input type="checkbox" /> &lt; 50-100</label>
                    <label><input type="checkbox" /> &lt; >100</label>
                </div>
                <div class="filter-section">
                    <h3>Title</h3>
                    <label><input type="checkbox" /> Satuday Volunteer</label>
                    <label><input type="checkbox" /> Volunteer Receptionist</label>
                    <label><input type="checkbox" /> Fire Drill</label>
                    <label><input type="checkbox" /> Bloob Donation</label>
                    <label><input type="checkbox" /> Another</label>
                </div>
                {{--        </div> --}}
                {{--        <div class="apply-button"  onclick="closeFilter(event)"> --}}
                {{--            <button>Apply</button> --}}
                {{--        </div> --}}
                <button id="apply-filter" class="apply-button">Apply</button>

            </div>
            <table class="table">
                <thead class="thead">
                <tr>
                    <th>No.</th>
                    <th>Title</th>
                    <th>Creator</th>
                    <th>Participants</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Regis_expiration</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($activities as $index => $activity)
                    <tr>
                        <td>{{ $activity->id }}</td>
                        <td>{{ $activity->title }}</td>
                        <td>{{ $activity->creator->name }}</td>
                        <td>{{ $activity->registered_participants }}/{{ $activity->max_participants }}</td>
                        <td>{{ $activity->start_date }}</td>
                        <td>{{ $activity->end_date }}</td>
                        <td>{{ $activity->register_end_date }}</td>
                        <td>
                            <div class="dropdown">
                                <i class="fa-solid fa-ellipsis-vertical" onclick="toggleDropdown(event)"></i>
                                <!-- Menu dropdown -->
                                <div class="dropdown-content">
                                    <a href="{{ route('admin_activities.show', ['id' => $activity->id]) }}" class="more">
                                        More
                                    </a>
                                    <a href="#" class="register">
                                        <i class="fa-solid fa-check"></i> Register
                                    </a>
                                    <a href="#" class="delete">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>


        <div class="pagination">
            @if ($activities->onFirstPage())
                <span class="gap">Previous</span>
            @else
                <a href="{{ $activities->previousPageUrl() }}" class="previous">Previous</a>
            @endif

            @foreach ($activities->getUrlRange(1, $activities->lastPage()) as $page => $url)
                @if ($page == $activities->currentPage())
                    <span class="pagination-page current">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pagination-page">{{ $page }}</a>
                @endif
            @endforeach

            @if ($activities->hasMorePages())
                <a href="{{ $activities->nextPageUrl() }}" class="next">Next</a>
            @else
                <span class="gap">Next</span>
            @endif
        </div>

        <p>{{ $activities->currentPage() }} / {{ $activities->lastPage() }}</p>

        <script>
            // Toggle dropdown menu khi nhấn vào icon ba chấm cột Action
            function toggleDropdown(event) {
                var dropdown = event.target.closest('.dropdown');
                var dropdownContent = dropdown.querySelector('.dropdown-content');

                // Đóng tất cả các dropdown khác
                var allDropdowns = document.querySelectorAll('.dropdown-content');
                allDropdowns.forEach(function(content) {
                    if (content !== dropdownContent) {
                        content.style.display = 'none';
                    }
                });

                // Toggle trạng thái hiển thị của dropdown hiện tại
                if (dropdownContent.style.display === "block") {
                    dropdownContent.style.display = "none";
                } else {
                    dropdownContent.style.display = "block";
                }
            }

            // Đóng dropdown khi nhấn ngoài menu
            window.onclick = function(event) {
                if (!event.target.matches('.fa-ellipsis-vertical')) {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    for (var i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (openDropdown.style.display === "block") {
                            openDropdown.style.display = "none";
                        }
                    }
                }
            }

        </script>
    </div>
    <div class="overlay2 hidden" onclick="toggleDetail()"></div>
    <div class="detail hidden">
        <div class="bluefont"><h3>Detail Activities</h3></div>

        <div class="popup-details">
                <div class="info-left">
                    <p><strong>Title:</strong>{{ $activity->title }}</p>
                    <p><strong>Max Participants:</strong> {{ $activity->max_participants }}</p>
                    <p><strong>Registered Participants:</strong> {{ $activity->registered_participants }}</p>
                    <p><strong>Registration Expiry Date:</strong> {{ \Carbon\Carbon::parse($activity->register_end_date)->format('d M, Y') }}</p>
                    <p><strong>Start Date:</strong>{{ \Carbon\Carbon::parse($activity->start_date)->format('d M, Y') }}</p>

                </div>
                <div class="info-right">
                    <p><strong>Activity id:</strong>  #ACT_{{ $activity->id }}</p>
                    <p><strong>Create Date:</strong> {{ \Carbon\Carbon::parse($activity->created_at)->format('d M, Y') }}</p>
                    <p><strong>Ticket price (VND):</strong> {{ number_format($activity->ticket_price, 0, '.', ',') }}</p>
                    <p><strong>Bonus point:</strong> {{ $activity->bonus_point }}</p>
                    <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($activity->end_date)->format('d M, Y') }}</p>
                </div>
        </div>

        <!-- About Section -->
        <div class="popup-about">
            <h3>About this activity:</h3>
            <p>Sit tenetur temporibus accusamus. Vel voluptatibus harum et vero quod laboriosam ipsam. Occaecati dolores labore earum consequatur debitis perferendis adipisci beatae.</p>
        </div>

        <!-- Buttons -->
        <div class="popup-buttons">
            <button class="red-btn">Cancel</button>
            <button class="blue-btn">Register</button>
        </div>

    </div>
@endsection