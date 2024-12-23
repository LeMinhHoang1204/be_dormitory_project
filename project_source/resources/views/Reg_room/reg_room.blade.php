{{--@extends('Auth_.index')--}}

{{--@if (session('notification'))--}}
{{--    <script>--}}
{{--        document.addEventListener("DOMContentLoaded", function () {--}}
{{--            const notification = @json(session('notification'));--}}
{{--            // Display the notification--}}
{{--            toastr.info(--}}
{{--                `${notification.message} `--}}
{{--            );--}}
{{--        });--}}
{{--    </script>--}}
{{--@endif--}}

{{--<head>--}}
{{--    <title>Room Registration</title>--}}
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>--}}
{{--    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">--}}
{{--    <link rel="stylesheet" href="{{ asset('./css/reg_room.css') }}" type="text/css">--}}
{{--    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>--}}
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">--}}

{{--    <style>--}}
{{--        .toast-warning {--}}
{{--            color: #ffffff !important; /* Text color for warning notification */--}}
{{--            background-color: #ffc107 !important; /* Background color */--}}
{{--            font-family: "Poppins", sans-serif !important; /* Font family */--}}
{{--            border-left: 5px solid #ff9800 !important; /* Left border color */--}}
{{--        }--}}

{{--        .toast-info {--}}
{{--            color: #ffffff !important; /* Màu chữ cho thông báo thông tin */--}}
{{--            background-color: #17a2b8 !important; /* Màu nền */--}}
{{--            font-family: "Poppins", sans-serif !important; /* Font chữ */--}}
{{--        }--}}
{{--    </style>--}}

{{--    <script>--}}
{{--        // fix show room + pagination (DONE)--}}
{{--        // Create room--}}
{{--    //     function createRoom(room) {--}}
{{--    //         const assets = room.has_room_assets.map(asset => `--}}
{{--    //     <span class="detail-item">${asset.asset.name}: ${asset.quantity}</span>--}}
{{--    // `).join("");--}}
{{--    //         return `--}}
{{--    //     <div class="room-item"--}}
{{--    //         data-room-id="${room.id}" data-room-name="${room.name}" data-room-price="${room.unit_price}"--}}
{{--    //         data-room-building="${room.building_id}" data-room-type="${room.type}" data-room-floor="${room.floor_number}"--}}
{{--    //         data-room-capacity="${room.member_count}">--}}
{{--    //         <img src="/img/room.png" alt="${room.name}">--}}
{{--    //         <div class="form-group">--}}
{{--    //             <div class="roomname">Room ${room.name}</div>--}}
{{--    //             <div id="room-price">--}}
{{--    //                 <span class="price">${room.unit_price}</span>--}}
{{--    //                 <span class="per-month">/month</span>--}}
{{--    //             </div>--}}
{{--    //             <div class="room-info">Phòng được thiết kế mới mẻ với đầy đủ các vật dụng cần thiết</div>--}}
{{--    //             <div class="type-group">--}}
{{--    //                 ${assets}--}}
{{--    //             </div>--}}
{{--    //             <div class="type-group">--}}
{{--    //             <button class="change-button" onclick="toggleConfirm()">Register</button>--}}
{{--    //             </div>--}}
{{--    //         </div>--}}
{{--    //     </div>--}}
{{--    // `;--}}
{{--    //     }--}}
{{--    //--}}
{{--    //     async function fetchRooms() {--}}
{{--    //         try {--}}
{{--    //             const response = await fetch("/students/room-registration/rooms"); // Đường dẫn API trả về danh sách phòng--}}
{{--    //             if (!response.ok) throw new Error("Failed to fetch rooms data");--}}
{{--    //             const data = await response.json(); // Chuyển đổi dữ liệu JSON--}}
{{--    //             return data;--}}
{{--    //         } catch (error) {--}}
{{--    //             console.error("Error fetching rooms:", error);--}}
{{--    //             return [];--}}
{{--    //         }--}}
{{--    //     }--}}
{{--    //--}}
{{--        // Display rooms--}}
{{--        // async function displayRoom() {--}}
{{--        //     const roomList = document.getElementById("room-list");--}}
{{--        //     const roomsData = await fetchRooms(); // Lấy dữ liệu từ database thông qua API--}}
{{--        //     roomList.innerHTML = roomsData.map(createRoom).join("");--}}
{{--        //     const roomItems = document.querySelectorAll(".room-item");--}}
{{--        //     roomItems.forEach((item) => {--}}
{{--        //         item.addEventListener("click", function () {--}}
{{--        //             const roomId = this.dataset.roomId;--}}
{{--        //             const roomName = this.dataset.roomName;--}}
{{--        //             const roomPrice = this.dataset.roomPrice;--}}
{{--        //             const building = this.dataset.roomBuilding;--}}
{{--        //             const roomFloor = this.dataset.roomFloor;--}}
{{--        //             const roomType = this.dataset.roomType;--}}
{{--        //             const roomCapacity = this.dataset.roomCapacity;--}}
{{--        //--}}
{{--        //--}}
{{--        //             // Luu data room-item vao localStorage--}}
{{--        //             localStorage.setItem(--}}
{{--        //                 "selectedRoom",--}}
{{--        //                 JSON.stringify({ roomId, roomName, roomPrice, building, roomFloor, roomType, roomCapacity })--}}
{{--        //             );--}}
{{--        //--}}
{{--        //             // window.location.href = `/roomInfor/${roomId}`;--}}
{{--        //         });--}}
{{--        //     });--}}
{{--        // }--}}

{{--        async function getSelectedRoom() {--}}
{{--            // const roomList = document.getElementById("room-list");--}}
{{--            // const roomsData = await fetchRooms(); // Lấy dữ liệu từ database thông qua API--}}
{{--            // roomList.innerHTML = roomsData.map(createRoom).join("");--}}
{{--            const roomItems = document.querySelectorAll(".room-item");--}}
{{--            roomItems.forEach((item) => {--}}
{{--                item.addEventListener("click", function () {--}}
{{--                    const roomId = this.dataset.roomId;--}}
{{--                    const roomName = this.dataset.roomName;--}}
{{--                    const roomPrice = this.dataset.roomPrice;--}}
{{--                    const building = this.dataset.roomBuilding;--}}
{{--                    const roomFloor = this.dataset.roomFloor;--}}
{{--                    const roomType = this.dataset.roomType;--}}
{{--                    const roomCapacity = this.dataset.roomCapacity;--}}


{{--                    // Luu data room-item vao localStorage--}}
{{--                    localStorage.setItem(--}}
{{--                        "selectedRoom",--}}
{{--                        JSON.stringify({ roomId, roomName, roomPrice, building, roomFloor, roomType, roomCapacity })--}}
{{--                    );--}}

{{--                    // window.location.href = `/roomInfor/${roomId}`;--}}
{{--                });--}}
{{--            });--}}
{{--        }--}}

{{--        document.addEventListener("DOMContentLoaded", async function () {--}}
{{--            try {--}}
{{--                const response = await fetch("/students/room-registration/current-student-user"); // Adjust the endpoint as needed--}}
{{--                if (!response.ok) throw new Error("Failed to fetch user data");--}}
{{--                const userData = await response.json();--}}
{{--                localStorage.setItem("currentUser", JSON.stringify(userData));--}}
{{--                if (userData.residenceStatus === "Paid") {--}}
{{--                    document.getElementById("res-certifi").style.display = "block";--}}
{{--                }--}}
{{--            } catch (error) {--}}
{{--                console.error("Error fetching user data:", error);--}}
{{--            }--}}
{{--            getSelectedRoom();--}}
{{--        });--}}


{{--        // Sự kiện khi nhấn vào nút "Yes"--}}
{{--    document.addEventListener("DOMContentLoaded", function () {--}}
{{--        document.querySelector(".confirm-regis .yes-btn").addEventListener("click", async function() {--}}
{{--            const selectedRoom = JSON.parse(localStorage.getItem("selectedRoom"));--}}
{{--            const currentUser = JSON.parse(localStorage.getItem("currentUser"));--}}
{{--            if (selectedRoom) {--}}
{{--                try {--}}
{{--                    const response = await fetch(`/students/room-registration/latest-residence/${currentUser.userId}`);--}}
{{--                    const data = await response.json();--}}
{{--                    if (data.residence && data.residence.status !== 'Checked out') {--}}
{{--                        closeConfirm();--}}
{{--                        toastr.warning('You already have a registered room.');--}}
{{--                        return;--}}
{{--                    }--}}

{{--                    const roomData = {--}}
{{--                        dormId: currentUser.userId,--}}
{{--                        roomId: selectedRoom.roomId,--}}
{{--                        studentId: currentUser.studentId,--}}
{{--                        fullName: currentUser.name,--}}
{{--                        buildingId: selectedRoom.building,--}}
{{--                        floor: selectedRoom.roomFloor,--}}
{{--                        price: selectedRoom.roomPrice,--}}
{{--                        capacity: selectedRoom.roomCapacity,--}}
{{--                        gender: currentUser.gender,--}}
{{--                        roomType: selectedRoom.roomType,--}}
{{--                    };--}}

{{--                    populateRoomInfo(roomData);--}}
{{--                    showConfirmInfoContainer();--}}
{{--                } catch (error) {--}}
{{--                    console.error('Error fetching residence data:', error);--}}
{{--                    toastr.error('Failed to check residence status.');--}}
{{--                }--}}
{{--            }--}}
{{--        });--}}
{{--    });--}}

{{--    function populateRoomInfo(data) {--}}
{{--        document.getElementById("dorm-id").value = data.dormId || "";--}}
{{--        document.getElementById("room-id").value = data.roomId || "";--}}
{{--        document.getElementById("student-id").value = data.studentId || "";--}}
{{--        document.getElementById("full-name").value = data.fullName || "";--}}
{{--        document.getElementById("building-id").value = data.buildingId || "";--}}
{{--        document.getElementById("floor").value = data.floor || "";--}}
{{--        document.getElementById("price").value = data.price || "";--}}
{{--        document.getElementById("capacity").value = data.capacity || "";--}}
{{--        document.getElementById("gender").value = data.gender || "";--}}
{{--        document.getElementById("room-type").value = data.roomType || "";--}}
{{--    }--}}

{{--    function showConfirmInfoContainer() {--}}
{{--        const confirmPanel = document.querySelector(".confirm-regis");--}}
{{--        const confirmInfoContainer = document.querySelector(--}}
{{--            ".confirm-info-container"--}}
{{--        );--}}
{{--        const overlay2 = document.querySelector(".overlay2");--}}

{{--        if (confirmPanel && confirmInfoContainer && overlay2) {--}}
{{--            confirmPanel.classList.remove("active"); // Ẩn confirm-regis--}}
{{--            confirmInfoContainer.classList.add("active"); // Hiển thị popup confirm-info-container--}}
{{--            overlay2.classList.add("active"); // Hiển thị overlay--}}
{{--        }--}}
{{--    }--}}

{{--    // Hàm bật/tắt filter panel--}}
{{--    function toggleFilter() {--}}
{{--        const filterPanel = document.querySelector(".filter-panel");--}}
{{--        const overlay = document.querySelector(".overlay");--}}

{{--        if (filterPanel && overlay) {--}}
{{--            const isActive = filterPanel.classList.toggle("active");--}}
{{--            overlay.classList.toggle("active", isActive);--}}
{{--        }--}}
{{--    }--}}

{{--        // Đóng filter panel và overlay khi nhấn ra ngoài--}}
{{--        const overlay = document.querySelector(".overlay");--}}
{{--        if (overlay) {--}}
{{--            overlay.addEventListener("click", () => {--}}
{{--                const filterPanel = document.querySelector(".filter-panel");--}}
{{--                if (filterPanel) {--}}
{{--                    filterPanel.classList.remove("active");--}}
{{--                }--}}
{{--                overlay.classList.remove("active");--}}
{{--            });--}}
{{--        }--}}

{{--        // Nhấn mở filter panel--}}
{{--        document.querySelector(".filter-sgv").addEventListener("click", toggleFilter);--}}

{{--        // Bắt sự kiện khi nhấn nút Apply--}}
{{--        document.getElementById("apply-filter").addEventListener("click", () => {--}}
{{--            const filterPanel = document.querySelector(".filter-panel");--}}
{{--            const overlay = document.querySelector(".overlay");--}}

{{--            // Thực hiện hành động khi áp dụng bộ lọc--}}
{{--            console.log("Filter applied!");--}}
{{--            // TODO: Viết logic để áp dụng bộ lọc tại đây--}}

{{--            // Đóng filter-panel và overlay sau khi nhấn Apply--}}
{{--            filterPanel.classList.remove("active");--}}
{{--            overlay.classList.remove("active");--}}
{{--        });--}}
{{--    --}}{{-- WEBSITE: tabler icons --}}
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/@tabler/icons@1.74.0/icons-react/dist/index.umd.min.js"></script>--}}


{{--    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">--}}

{{--    <link rel="stylesheet" href="{{ asset('./css/reg_room.css') }}" type="text/css">--}}
{{--    <script src="{{ asset('./javascript/reg_room.js') }}"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>--}}
{{--</head>--}}

{{--@section('content')--}}
{{--    @include('layouts.sidebar_student')--}}
{{--    <div class="regisster">--}}
{{--<div class="register">--}}
{{--        <h3 class="title">Room Registration</h3>--}}

{{--        --}}{{--            Residence certificate: TODO: link đi đến phiếu xác nhận chưa trú (DONE) --}}

{{--        <div class="res-certifi" id="res-certifi" style="display: none;">--}}
{{--            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="24" viewBox="0 0 22 24" fill="none">--}}
{{--                <path--}}
{{--                    d="M10.181 0.560828C10.6414 0.388572 11.1444 0.366116 11.6183 0.496662L11.819 0.560828L19.9857 3.62333C20.3997 3.7786 20.7612 4.04835 21.0278 4.40115C21.2945 4.75394 21.4554 5.17526 21.4918 5.61599L21.5 5.80849V12.0653C21.5 13.9558 20.9895 15.8112 20.0225 17.4357C19.0556 19.0602 17.668 20.3935 16.0062 21.2948L15.6958 21.457L11.7828 23.4135C11.5674 23.5211 11.332 23.583 11.0915 23.5955C10.851 23.6079 10.6106 23.5706 10.3852 23.4858L10.2172 23.4135L6.30417 21.457C4.61321 20.6115 3.1819 19.3251 2.16134 17.7337C1.14077 16.1423 0.568811 14.3048 0.505833 12.4153L0.5 12.0653V5.80849C0.500007 5.36648 0.625564 4.93356 0.862056 4.56013C1.09855 4.1867 1.43624 3.88812 1.83583 3.69916L2.01433 3.62333L10.181 0.560828ZM11 2.74599L2.83333 5.80849V12.0653C2.83336 13.5295 3.22703 14.9667 3.97311 16.2266C4.7192 17.4864 5.79026 18.5225 7.07417 19.2263L7.34833 19.3698L11 21.1957L14.6517 19.3698C15.9615 18.715 17.0712 17.7201 17.8645 16.4892C18.6578 15.2583 19.1056 13.8367 19.1608 12.3733L19.1667 12.0653V5.80849L11 2.74599ZM15.0052 8.06716C15.2151 7.85792 15.4968 7.73644 15.7931 7.72739C16.0894 7.71835 16.378 7.82241 16.6003 8.01845C16.8226 8.21449 16.962 8.48781 16.9901 8.78288C17.0182 9.07796 16.933 9.37267 16.7517 9.60716L16.6548 9.71683L10.5485 15.8243C10.3261 16.0467 10.0297 16.1797 9.7157 16.198C9.40169 16.2163 9.0919 16.1186 8.84517 15.9235L8.73317 15.8243L5.9285 13.0197C5.71704 12.8102 5.59363 12.5278 5.58354 12.2304C5.57344 11.9329 5.67743 11.6428 5.87421 11.4195C6.07099 11.1962 6.34568 11.0565 6.64206 11.0291C6.93844 11.0017 7.23409 11.0886 7.4685 11.272L7.57817 11.3688L9.64083 13.4315L15.0052 8.06716Z"--}}
{{--                    fill="#005D4D" />--}}
{{--            </svg> <!-- SVG code giữ nguyên -->--}}
{{--            <a href="#" class="ul-res-certifi" data-bs-toggle="modal" data-bs-target="#resCertModal">Residence--}}
{{--                certificate</a>--}}
{{--        </div>--}}

{{--        <!-- Modal hiển thị hình ảnh mẫu phiếu xác nhận -->--}}
{{--        <div class="modal fade" id="resCertModal" tabindex="-1" aria-labelledby="resCertModalLabel" aria-hidden="true">--}}
{{--            <div class="modal-dialog modal-lg">--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <h5 class="modal-title" id="resCertModalLabel">Residence Certificate</h5>--}}
{{--                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body text-center">--}}
{{--                        <img src="{{ asset('img/xacnhancutru1.png') }}" alt="Residence Certificate Sample 1"--}}
{{--                            class="img-fluid mb-3">--}}
{{--                        <img src="{{ asset('img/xacnhancutru2.png') }}" alt="Residence Certificate Sample 2"--}}
{{--                            class="img-fluid">--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <a href="{{ asset('pdf/mau-xac-nhan-thong-tin-ve-cu-tru-ct-07_0112100225.pdf') }}"--}}
{{--                            class="btn btn-primary" download>Download PDF</a>--}}
{{--                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}




{{--        --}}{{--        button loc filter --}}
{{--        <div class="filter-sgv" onclick="toggleFilter()">--}}
{{--            <svg xmlns="http://www.w3.org/2000/svg" width="67" height="66" viewBox="0 0 67 66" fill="none">--}}
{{--                <g filter="url(#filter0_d_1132_2655)">--}}
{{--                    <g filter="url(#filter1_d_1132_2655)">--}}
{{--                        <path--}}
{{--                            d="M4 15C4 6.71573 10.7157 0 19 0H48C56.2843 0 63 6.71573 63 15V41C63 49.2843 56.2843 56 48 56H19C10.7157 56 4 49.2843 4 41V15Z"--}}
{{--                            fill="white" />--}}
{{--                        <path--}}
{{--                            d="M4.5 15C4.5 6.99187 10.9919 0.5 19 0.5H48C56.0081 0.5 62.5 6.99187 62.5 15V41C62.5 49.0081 56.0081 55.5 48 55.5H19C10.9919 55.5 4.5 49.0081 4.5 41V15Z"--}}
{{--                            stroke="#CBD4F3" />--}}
{{--                    </g>--}}
{{--                    <path--}}
{{--                        d="M22.5315 20.6021H26.2999C26.4294 21.3213 26.8154 21.9731 27.3899 22.4427C27.9645 22.9124 28.6908 23.1698 29.4412 23.1698C30.1915 23.1698 30.9179 22.9124 31.4924 22.4427C32.067 21.9731 32.4529 21.3213 32.5824 20.6021H43.792C43.933 20.6021 44.0682 20.5476 44.1679 20.4506C44.2675 20.3536 44.3235 20.2221 44.3235 20.0849C44.3235 19.9477 44.2675 19.8162 44.1679 19.7192C44.0682 19.6222 43.933 19.5677 43.792 19.5677H32.5824C32.4529 18.8485 32.067 18.1968 31.4924 17.7271C30.9179 17.2575 30.1915 17 29.4412 17C28.6908 17 27.9645 17.2575 27.3899 17.7271C26.8154 18.1968 26.4294 18.8485 26.2999 19.5677H22.5315C22.3905 19.5677 22.2554 19.6222 22.1557 19.7192C22.056 19.8162 22 19.9477 22 20.0849C22 20.2221 22.056 20.3536 22.1557 20.4506C22.2554 20.5476 22.3905 20.6021 22.5315 20.6021ZM29.4412 18.0161C29.8617 18.0161 30.2727 18.1375 30.6223 18.3648C30.972 18.5921 31.2445 18.9152 31.4054 19.2932C31.5663 19.6712 31.6084 20.0872 31.5264 20.4885C31.4443 20.8898 31.2419 21.2584 30.9445 21.5478C30.6472 21.8371 30.2684 22.0341 29.8559 22.1139C29.4435 22.1938 29.0161 22.1528 28.6276 21.9962C28.2391 21.8396 27.907 21.5745 27.6734 21.2343C27.4398 20.8941 27.3151 20.4941 27.3151 20.0849C27.3151 19.5362 27.5391 19.01 27.9378 18.6221C28.3365 18.2341 28.8773 18.0161 29.4412 18.0161ZM43.792 27.3257H40.0236C39.8941 26.6065 39.5082 25.9547 38.9336 25.4851C38.3591 25.0154 37.6327 24.7579 36.8824 24.7579C36.132 24.7579 35.4056 25.0154 34.8311 25.4851C34.2566 25.9547 33.8706 26.6065 33.7411 27.3257H22.5315C22.3905 27.3257 22.2554 27.3802 22.1557 27.4771C22.056 27.5741 22 27.7057 22 27.8429C22 27.98 22.056 28.1116 22.1557 28.2086C22.2554 28.3056 22.3905 28.3601 22.5315 28.3601H33.7411C33.8706 29.0793 34.2566 29.731 34.8311 30.2007C35.4056 30.6703 36.132 30.9278 36.8824 30.9278C37.6327 30.9278 38.3591 30.6703 38.9336 30.2007C39.5082 29.731 39.8941 29.0793 40.0236 28.3601H43.792C43.933 28.3601 44.0682 28.3056 44.1679 28.2086C44.2675 28.1116 44.3235 27.98 44.3235 27.8429C44.3235 27.7057 44.2675 27.5741 44.1679 27.4771C44.0682 27.3802 43.933 27.3257 43.792 27.3257ZM36.8824 29.9116C36.4619 29.9116 36.0508 29.7903 35.7012 29.563C35.3516 29.3357 35.0791 29.0126 34.9181 28.6345C34.7572 28.2565 34.7151 27.8406 34.7972 27.4393C34.8792 27.038 35.0817 26.6693 35.379 26.38C35.6763 26.0907 36.0552 25.8936 36.4676 25.8138C36.88 25.734 37.3075 25.775 37.696 25.9315C38.0844 26.0881 38.4165 26.3533 38.6501 26.6935C38.8837 27.0337 39.0084 27.4337 39.0084 27.8429C39.0084 28.3915 38.7844 28.9177 38.3857 29.3057C37.987 29.6937 37.4462 29.9116 36.8824 29.9116ZM43.792 35.0836H32.5824C32.4529 34.3644 32.067 33.7127 31.4924 33.243C30.9179 32.7734 30.1915 32.5159 29.4412 32.5159C28.6908 32.5159 27.9645 32.7734 27.3899 33.243C26.8154 33.7127 26.4294 34.3644 26.2999 35.0836H22.5315C22.3905 35.0836 22.2554 35.1381 22.1557 35.2351C22.056 35.3321 22 35.4636 22 35.6008C22 35.738 22.056 35.8695 22.1557 35.9665C22.2554 36.0635 22.3905 36.118 22.5315 36.118H26.2999C26.4294 36.8372 26.8154 37.489 27.3899 37.9586C27.9645 38.4283 28.6908 38.6857 29.4412 38.6857C30.1915 38.6857 30.9179 38.4283 31.4924 37.9586C32.067 37.489 32.4529 36.8372 32.5824 36.118H43.792C43.933 36.118 44.0682 36.0635 44.1679 35.9665C44.2675 35.8695 44.3235 35.738 44.3235 35.6008C44.3235 35.4636 44.2675 35.3321 44.1679 35.2351C44.0682 35.1381 43.933 35.0836 43.792 35.0836ZM29.4412 37.6696C29.0207 37.6696 28.6096 37.5483 28.26 37.3209C27.9104 37.0936 27.6379 36.7705 27.477 36.3925C27.316 36.0145 27.2739 35.5985 27.356 35.1972C27.438 34.7959 27.6405 34.4273 27.9378 34.138C28.2352 33.8486 28.614 33.6516 29.0264 33.5718C29.4388 33.4919 29.8663 33.5329 30.2548 33.6895C30.6433 33.8461 30.9753 34.1112 31.2089 34.4515C31.4425 34.7917 31.5672 35.1916 31.5672 35.6008C31.5672 36.1495 31.3432 36.6757 30.9445 37.0637C30.5458 37.4516 30.005 37.6696 29.4412 37.6696Z"--}}
{{--                        fill="#757575" />--}}
{{--                </g>--}}
{{--                <defs>--}}
{{--                    <filter id="filter0_d_1132_2655" x="0" y="0" width="67" height="66" filterUnits="userSpaceOnUse"--}}
{{--                        color-interpolation-filters="sRGB">--}}
{{--                        <feFlood flood-opacity="0" result="BackgroundImageFix" />--}}
{{--                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"--}}
{{--                            result="hardAlpha" />--}}
{{--                        <feOffset dy="6" />--}}
{{--                        <feGaussianBlur stdDeviation="2" />--}}
{{--                        <feComposite in2="hardAlpha" operator="out" />--}}
{{--                        <feColorMatrix type="matrix" values="0 0 0 0 0.925499 0 0 0 0 0.937916 0 0 0 0 1 0 0 0 1 0" />--}}
{{--                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1132_2655" />--}}
{{--                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1132_2655" result="shape" />--}}
{{--                    </filter>--}}
{{--                    <filter id="filter1_d_1132_2655" x="0" y="0" width="67" height="66" filterUnits="userSpaceOnUse"--}}
{{--                        color-interpolation-filters="sRGB">--}}
{{--                        <feFlood flood-opacity="0" result="BackgroundImageFix" />--}}
{{--                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"--}}
{{--                            result="hardAlpha" />--}}
{{--                        <feOffset dy="6" />--}}
{{--                        <feGaussianBlur stdDeviation="2" />--}}
{{--                        <feComposite in2="hardAlpha" operator="out" />--}}
{{--                        <feColorMatrix type="matrix" values="0 0 0 0 0.925499 0 0 0 0 0.937916 0 0 0 0 1 0 0 0 1 0" />--}}
{{--                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1132_2655" />--}}
{{--                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1132_2655" result="shape" />--}}
{{--                    </filter>--}}
{{--                </defs>--}}
{{--            </svg>--}}
{{--        </div>--}}

{{--        --}}{{--        Group Thanh tìm kiếm + filter --}}
{{--        <div class="notification-container">--}}
{{--            --}}{{--                // Hình kính lúp: thay cho button, nhấn vào sẽ tiến hành lọc --}}
{{--            <svg xmlns="http://www.w3.org/2000/svg" width="368" height="66" viewBox="0 0 368 66" fill="none"--}}
{{--                onclick="toggleFilter()">--}}
{{--                <g filter="url(#filter0_d_1132_2652)">--}}
{{--                    <path--}}
{{--                        d="M4 28C4 15.7921 4 9.68822 7.34281 5.56019C8.00244 4.74562 8.74562 4.00244 9.56019 3.34281C13.6882 0 19.7921 0 32 0H336C348.208 0 354.312 0 358.44 3.34281C359.254 4.00244 359.998 4.74562 360.657 5.56019C364 9.68822 364 15.7921 364 28C364 40.2079 364 46.3118 360.657 50.4398C359.998 51.2544 359.254 51.9976 358.44 52.6572C354.312 56 348.208 56 336 56H32C19.7922 56 13.6882 56 9.56019 52.6572C8.74562 51.9976 8.00244 51.2544 7.34281 50.4398C4 46.3118 4 40.2079 4 28Z"--}}
{{--                        fill="white" />--}}
{{--                    <path--}}
{{--                        d="M4.5 28C4.5 21.884 4.5008 17.3405 4.91446 13.8083C5.32684 10.287 6.14372 7.83545 7.73138 5.87485C8.36902 5.08744 9.08744 4.36902 9.87485 3.73138C11.8354 2.14372 14.287 1.32684 17.8083 0.914457C21.3405 0.500803 25.884 0.5 32 0.5H336C342.116 0.5 346.66 0.500803 350.192 0.914457C353.713 1.32684 356.165 2.14372 358.125 3.73138C358.913 4.36902 359.631 5.08743 360.269 5.87486C361.856 7.83545 362.673 10.287 363.086 13.8083C363.499 17.3405 363.5 21.884 363.5 28C363.5 34.1161 363.499 38.6595 363.086 42.1917C362.673 45.713 361.856 48.1646 360.269 50.1251C359.631 50.9126 358.913 51.631 358.125 52.2686C356.165 53.8563 353.713 54.6732 350.192 55.0855C346.66 55.4992 342.116 55.5 336 55.5H32C25.884 55.5 21.3405 55.4992 17.8083 55.0855C14.287 54.6732 11.8354 53.8563 9.87485 52.2686C9.08744 51.631 8.36902 50.9126 7.73138 50.1251C6.14372 48.1646 5.32684 45.713 4.91446 42.1917C4.5008 38.6595 4.5 34.1161 4.5 28Z"--}}
{{--                        stroke="#CBD4F3" />--}}
{{--                </g>--}}
{{--                <defs>--}}
{{--                    <filter id="filter0_d_1132_2652" x="0" y="0" width="368" height="66"--}}
{{--                        filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">--}}
{{--                        <feFlood flood-opacity="0" result="BackgroundImageFix" />--}}
{{--                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"--}}
{{--                            result="hardAlpha" />--}}
{{--                        <feOffset dy="6" />--}}
{{--                        <feGaussianBlur stdDeviation="2" />--}}
{{--                        <feComposite in2="hardAlpha" operator="out" />--}}
{{--                        <feColorMatrix type="matrix" values="0 0 0 0 0.925499 0 0 0 0 0.937916 0 0 0 0 1 0 0 0 1 0" />--}}
{{--                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1132_2652" />--}}
{{--                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1132_2652" result="shape" />--}}
{{--                    </filter>--}}
{{--                </defs>--}}
{{--            </svg>--}}
{{--            --}}{{--                Thanh tìm kiếm --}}
{{--            <div class="search-input-container">--}}
{{--                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 19 19"--}}
{{--                    fill="none" class="search-icon" onclick="handleSearch(event)">--}}
{{--                    <path--}}
{{--                        d="M13.0429 12.1366C14.1019 10.8532 14.7708 9.20705 14.7708 7.39354C14.7708 3.32012 11.4543 0 7.3854 0C3.31646 0 0 3.32012 0 7.39354C0 11.467 3.31646 14.7871 7.3854 14.7871C9.16905 14.7871 10.8412 14.1454 12.1232 13.0573L17.8643 18.8047C18.0037 18.9442 18.1709 19 18.3381 19C18.5053 19 18.6725 18.9442 18.8119 18.8047C19.0627 18.5536 19.0627 18.1072 18.8119 17.8561L13.0429 12.1366ZM7.35754 13.4479C4.0132 13.4479 1.30986 10.7416 1.30986 7.39354C1.30986 4.04552 4.0132 1.33921 7.35754 1.33921C10.7019 1.33921 13.4052 4.04552 13.4052 7.39354C13.4052 10.7416 10.7019 13.4479 7.35754 13.4479Z"--}}
{{--                        fill="#757575" />--}}
{{--                </svg>--}}
{{--                <input type="search" id="searchInput" placeholder="Search notification" oninput="handleInput(event)">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--        @if (session('success'))--}}
{{--            <div class="alert alert-success">--}}
{{--                {{ session('success') }}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        @if (session('error'))--}}
{{--            <div class="alert alert-error" style="max-width: 50%; margin-left: 430px; margin-bottom: -40px; margin-top: 20px">--}}
{{--                {{ session('error') }}--}}
{{--            </div>--}}
{{--        @endif--}}
{{--    --}}{{--    Hien thi panel filter lọc --}}
{{--    <div class="overlay hidden" onclick="toggleFilter()"></div>--}}
{{--    <div id="filter-panel" class="filter-panel hidden">--}}
{{--        --}}{{----}}{{--        <div class="filter-sections"> --}}
{{--        <div class="filter-section">--}}
{{--            <h3>Room status</h3>--}}
{{--            <label><input type="checkbox" /> Vacancy</label>--}}
{{--            <label><input type="checkbox" /> Full</label>--}}
{{--        </div>--}}
{{--        <div class="filter-section">--}}
{{--            <h3>Building type</h3>--}}
{{--            <label><input type="checkbox" /> Male</label>--}}
{{--            <label><input type="checkbox" /> Female</label>--}}
{{--        </div>--}}
{{--        <div class="filter-section floor-number-container">--}}
{{--            <h3>Floor number</h3>--}}
{{--            <input type="number" placeholder="Floor 1" min="1" />--}}
{{--        </div>--}}
{{--        <div class="filter-section">--}}
{{--            <h3>Room type</h3>--}}
{{--            <label><input type="checkbox" /> 1 person</label>--}}
{{--            <label><input type="checkbox" /> 2 people</label>--}}
{{--            <label><input type="checkbox" /> 4 people</label>--}}
{{--            <label><input type="checkbox" /> 6 people</label>--}}
{{--            <label><input type="checkbox" /> 8 people</label>--}}
{{--        </div>--}}
{{--        <div class="filter-section">--}}
{{--            <h3>Price</h3>--}}
{{--            <label><input type="checkbox" /> &lt; 500.000 VND</label>--}}
{{--            <label><input type="checkbox" /> &lt; 1.000.000 VND</label>--}}
{{--            <label><input type="checkbox" /> &lt; 2.000.000 VND</label>--}}
{{--            <label><input type="checkbox" /> &lt; 3.000.000 VND</label>--}}
{{--        </div>--}}
{{--        <div class="filter-section">--}}
{{--            <h3>Facilities</h3>--}}
{{--            <label><input type="checkbox" /> Fridge</label>--}}
{{--            <label><input type="checkbox" /> Washing machine</label>--}}
{{--            <label><input type="checkbox" /> Air-Conditioner</label>--}}
{{--            <label><input type="checkbox" /> Water heater</label>--}}
{{--            <label><input type="checkbox" /> Study desk</label>--}}
{{--        </div>--}}
{{--        <button id="apply-filter" class="apply-button">Apply</button>--}}

{{--    </div>--}}
{{--    <div class="container">--}}
{{--        <div class="header-container">--}}
{{--            <h1 class="title">Room Registration</h1>--}}
{{--            <div class="header-controls">--}}
{{--                --}}{{----}}{{-- Button filter --}}
{{--                <div class="filter-icon" onclick="toggleFilter()">--}}
{{--                    <i class="ti ti-adjustments-horizontal"></i>--}}
{{--                </div>--}}

{{--                --}}{{----}}{{-- Search bar --}}
{{--                <div class="search-bar">--}}
{{--                    <input type="text" placeholder="Search rooms..." class="search-input"--}}
{{--                        onkeyup="handleSearchKeyup(event)" autocomplete="off" aria-label="Search rooms">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    --}}{{-- Danh sach phong --}}
{{--    <div class="rooms" id="room-list">--}}
{{--        <div class="room-item"></div>--}}
{{--    </div>--}}
{{--        <div class="rooms" id="room-list">--}}
{{--            @foreach ($rooms as $room)--}}
{{--                <div class="room-item"--}}
{{--                     data-room-id="{{ $room->id }}"--}}
{{--                     data-room-name="{{ $room->name }}"--}}
{{--                     data-room-price="{{ $room->unit_price }}"--}}
{{--                     data-room-building="{{ $room->building_id }}"--}}
{{--                     data-room-type="{{ $room->type }}"--}}
{{--                     data-room-floor="{{ $room->floor_number }}"--}}
{{--                     data-room-capacity="{{ $room->member_count }}">--}}
{{--                    <img src="/img/room.png" alt="Room {{ $room->name }}">--}}
{{--                    <div class="form-group">--}}
{{--                        <div class="roomname">Room {{ $room->name }}</div>--}}
{{--                        <div id="room-price">--}}
{{--                            <span class="price">{{ $room->unit_price }}</span>--}}
{{--                            <span class="per-month">/month</span>--}}
{{--                        </div>--}}
{{--                        <div class="room-info">Phòng được thiết kế mới mẻ với đầy đủ các vật dụng cần thiết</div>--}}
{{--                        <div class="type-group">--}}
{{--                            @foreach ($room->hasRoomAssets as $asset)--}}
{{--                                <span class="detail-item">{{ $asset->asset->name }}: {{ $asset->quantity }}</span>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                        <div class="type-group">--}}
{{--                            <button class="blue-btn" onclick="toggleConfirm()">Register</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--        <div class="grid-container" id="room-list">--}}
{{--            @foreach ($rooms as $room)--}}
{{--                <div class="room-item" onclick="redirectToRoomInfo({{ $room->id }})"--}}
{{--                    data-floor="{{ $room->floor_number }}" data-type="{{ $room->type }}"--}}
{{--                    data-capacity="{{ $room->member_count }}">--}}
{{--                    <img src="/img/room.png">--}}
{{--                    <div class="room-item-group">--}}
{{--                        <div class="roomname">{{ $room->name }}</div>--}}
{{--                        <div id="room-price">--}}
{{--                            <span class="price">{{ $room->unit_price }}₫</span>--}}
{{--                            <span class="per-month">/month</span>--}}
{{--                        </div>--}}
{{--                        <div class="room-info">Phòng được thiết kế mới mẻ với đầy đủ các vật dụng cần thiết</div>--}}
{{--                        <div class="type-group">--}}
{{--                            @foreach ($room->hasRoomAssets as $asset)--}}
{{--                                <span class="detail-item">--}}
{{--                                    @php--}}
{{--                                        $iconMap = [--}}
{{--                                            'bed' => 'bed',--}}
{{--                                            'table' => 'desk',--}}
{{--                                            'chair' => 'armchair',--}}
{{--                                            'fan' => 'propeller',--}}
{{--                                            'air conditioner' => 'air-conditioning',--}}
{{--                                            'fridge' => 'fridge',--}}
{{--                                        ];--}}
{{--                                        $icon = $iconMap[strtolower($asset->asset->name)] ?? 'box';--}}
{{--                                    @endphp--}}
{{--                                    <i class="ti ti-{{ $icon }}"></i>--}}
{{--                                    {{ $asset->quantity }}--}}
{{--                                </span>--}}
{{--                            @endforeach--}}
{{--                            <button class="change-button"--}}
{{--                                onclick="handleRegisterClick(event, {{ $room->id }})">Register</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--        </div>--}}
{{--    </div>--}}


{{--    <!-- Pagination -->--}}
{{--     <div class="pagination">--}}
{{--        @if ($rooms->onFirstPage())--}}
{{--            <span class="gap">Previous</span>--}}
{{--        @else--}}
{{--            <a href="{{ $rooms->previousPageUrl() }}" class="previous">Previous</a>--}}
{{--        @endif--}}

{{--        @php--}}
{{--            $currentPage = $rooms->currentPage();--}}
{{--            $lastPage = $rooms->lastPage();--}}
{{--        @endphp--}}

{{--        <!-- Nếu số trang ít hơn hoặc bằng 5, hiển thị tất cả các trang -->--}}
{{--        @if ($lastPage <= 5)--}}
{{--            @for ($i = 1; $i <= $lastPage; $i++)--}}
{{--                @if ($i == $currentPage)--}}
{{--                    <span class="pagination-page current">{{ $i }}</span>--}}
{{--                @else--}}
{{--                    <a href="{{ $rooms->url($i) }}" class="pagination-page">{{ $i }}</a>--}}
{{--                @endif--}}
{{--            @endfor--}}
{{--        @else--}}
{{--            @if ($currentPage > 3)--}}
{{--                <a href="{{ $rooms->url(1) }}" class="pagination-page">1</a>--}}
{{--                <span class="ellipsis">...</span>--}}
{{--            @endif--}}

{{--            @for ($i = max(1, $currentPage - 1); $i <= min($lastPage, $currentPage + 1); $i++)--}}
{{--                @if ($i == $currentPage)--}}
{{--                    <span class="pagination-page current">{{ $i }}</span>--}}
{{--                @else--}}
{{--                    <a href="{{ $rooms->url($i) }}" class="pagination-page">{{ $i }}</a>--}}
{{--                @endif--}}
{{--            @endfor--}}

{{--            @if ($currentPage < $lastPage - 2)--}}
{{--                <span class="ellipsis">...</span>--}}
{{--                <a href="{{ $rooms->url($lastPage) }}" class="pagination-page">{{ $lastPage }}</a>--}}
{{--            @endif--}}
{{--        @endif--}}

{{--        @if ($rooms->hasMorePages())--}}
{{--            <a href="{{ $rooms->nextPageUrl() }}" class="next">Next</a>--}}
{{--        @else--}}
{{--            <span class="gap">Next</span>--}}
{{--        @endif--}}
{{--    </div>--}}



{{--<!-- Modal Filter Popup -->--}}
{{--        <div id="filter-popup" class="filter-popup">--}}
{{--    <div class="filter-popup-content">--}}
{{--        <div class="filter-container">--}}
{{--            <!-- Room Status -->--}}
{{--            <div class="filter-group">--}}
{{--                <h3>Room Status</h3>--}}
{{--                <div class="checkbox-list">--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">Vacancy</span>--}}
{{--                    </label>--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">Full</span>--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Building Type -->--}}
{{--            <div class="filter-group">--}}
{{--                <h3>Building Type</h3>--}}
{{--                <div class="checkbox-list">--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">Male</span>--}}
{{--                    </label>--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">Female</span>--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Floor Number -->--}}
{{--            <div class="filter-group">--}}
{{--                <h3>Floor Number</h3>--}}
{{--                <div class="select-wrapper">--}}
{{--                    <select class="floor-select">--}}
{{--                        <option value="">Choose a floor</option>--}}
{{--                        <option value="1">Floor 1</option>--}}
{{--                        <option value="2">Floor 2</option>--}}
{{--                        <option value="3">Floor 3</option>--}}
{{--                        <option value="4">Floor 4</option>--}}
{{--                        <option value="5">Floor 5</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Room Type -->--}}
{{--            <div class="filter-group">--}}
{{--                <h3>Room Type</h3>--}}
{{--                <div class="checkbox-list">--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">1 person</span>--}}
{{--                    </label>--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">2 people</span>--}}
{{--                    </label>--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">4 people</span>--}}
{{--                    </label>--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">6 people</span>--}}
{{--                    </label>--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">8 people</span>--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Price -->--}}
{{--            <div class="filter-group">--}}
{{--                <h3>Price</h3>--}}
{{--                <div class="checkbox-list">--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">--}}
{{--                            < 500.000 VND</span>--}}
{{--                    </label>--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">--}}
{{--                            < 1.000.000 VND</span>--}}
{{--                    </label>--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">--}}
{{--                            < 2.000.000 VND</span>--}}
{{--                    </label>--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">--}}
{{--                            < 3.000.000 VND</span>--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Facilities -->--}}
{{--            <div class="filter-group">--}}
{{--                <h3>Facilities</h3>--}}
{{--                <div class="checkbox-list">--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">Fridge</span>--}}
{{--                    </label>--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">Washing machine</span>--}}
{{--                    </label>--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">Air-Conditioner</span>--}}
{{--                    </label>--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">Water heater</span>--}}
{{--                    </label>--}}
{{--                    <label class="checkbox-item">--}}
{{--                        <input type="checkbox">--}}
{{--                        <span class="checkmark"></span>--}}
{{--                        <span class="label-text">Study desk</span>--}}
{{--                    </label>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="confirm-info-body">--}}
{{--                <div class="left-column">--}}
{{--                    <div class="confirm-info-field">--}}
{{--                        <label for="dorm-id">Dorm ID</label>--}}
{{--                        <input type="text" id="dorm-id" name="dormId" readonly>--}}
{{--                    </div>--}}
{{--                    <div class="confirm-info-field">--}}
{{--                        <label for="full-name">Full name</label>--}}
{{--                        <input type="text" id="full-name" name="fullName" readonly>--}}
{{--                    </div>--}}
{{--                    <div class="confirm-info-field">--}}
{{--                        <label for="room-id">Room ID</label>--}}
{{--                        <input type="text" id="room-id" name="roomId" readonly>--}}
{{--                    </div>--}}
{{--                    <div class="confirm-info-field">--}}
{{--                        <label for="building-id">Building ID</label>--}}
{{--                        <input type="text" id="building-id" name="buildingId" readonly>--}}
{{--                    </div>--}}
{{--                    <div class="confirm-info-field">--}}
{{--                        <label for="floor">Floor</label>--}}
{{--                        <input type="text" id="floor" name="floor" readonly>--}}
{{--                    </div>--}}
{{--                    <div class="confirm-info-field">--}}
{{--                        <label for="start-date">Start date</label>--}}
{{--                        <input type="date" id="start-date" name="startDate">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="right-column">--}}
{{--                    <div class="confirm-info-field">--}}
{{--                        <label for="student-id">Student ID</label>--}}
{{--                        <input type="text" id="student-id" name="studentId" readonly>--}}
{{--                    </div>--}}
{{--                    <div class="confirm-info-field">--}}
{{--                        <label for="gender">Gender</label>--}}
{{--                        <input type="text" id="gender" name="gender" readonly>--}}
{{--                    </div>--}}
{{--                    <div class="confirm-info-field">--}}
{{--                        <label for="price">Price</label>--}}
{{--                        <input type="text" id="price" name="price" readonly>--}}
{{--                    </div>--}}
{{--                    <div class="confirm-info-field">--}}
{{--                        <label for="room-type">Room type</label>--}}
{{--                        <input type="text" id="room-type" name="roomType" readonly>--}}
{{--                    </div>--}}
{{--                    <div class="confirm-info-field">--}}
{{--                        <label for="capacity">Current Number of Members</label>--}}
{{--                        <input type="text" id="capacity" name="capacity" readonly>--}}
{{--                    </div>--}}
{{--                    <div class="confirm-info-field">--}}
{{--                        <label for="duration">Duration</label>--}}
{{--                        <select id="duration" name="duration">--}}
{{--                            <option value="3">3 months</option>--}}
{{--                            <option value="6">6 months</option>--}}
{{--                            <option value="9">9 months</option>--}}
{{--                            <option value="12">12 months</option>--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <!-- Button -->--}}
{{--            <div class="button-group">--}}
{{--                <button type="button" class="btn btn-secondary cancel-btn" onclick="closePopup()">Cancel</button>--}}
{{--                <button class="btn btn-primary apply-btn">Apply</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<!-- Modal Confirm Register -->--}}
{{--        <div id="confirm-register-modal" class="register-popup">--}}
{{--    <div class="register-popup-content">--}}
{{--        <div class="popup-header">--}}
{{--            <h2>Confirm Registration</h2>--}}
{{--        </div>--}}
{{--        <div class="popup-body">--}}
{{--            <p>Are you sure you want to register for this room?</p>--}}
{{--            <div class="button-group mt-4">--}}
{{--                <button type="button" class="btn btn-secondary" onclick="closeConfirmModal()">Cancel</button>--}}
{{--                <button type="button" class="btn btn-primary" onclick="proceedToRegistration()">Confirm</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<!-- Modal Register Popup -->--}}
{{--        <div id="register-popup" class="register-popup">--}}
{{--    <div class="register-popup-content">--}}
{{--        <div class="popup-header">--}}
{{--            <h2>Room Registration</h2>--}}
{{--        </div>--}}
{{--        <div class="popup-body">--}}
{{--            <form action="{{ route('register.room') }}" method="POST" id="registration-form"--}}
{{--                onsubmit="return handleFormSubmit(event)">--}}
{{--                @csrf--}}
{{--                <input type="hidden" id="room-id-input" name="room_id">--}}

{{--                <div class="form-group">--}}
{{--                    <div class="room-info-display">--}}
{{--                        <div class="info-column">--}}
{{--                            <div class="info-item">--}}
{{--                                <span class="label-text">Room: </span>--}}
{{--                                <span class="room-detail" id="display-room-name"></span>--}}
{{--                            </div>--}}
{{--                            <div class="info-item">--}}
{{--                                <span class="label-text">Price: </span>--}}
{{--                                <span class="room-detail" id="display-room-price"></span>--}}
{{--                            </div>--}}
{{--                            <div class="info-item">--}}
{{--                                <span class="label-text">Floor number: </span>--}}
{{--                                <span class="room-detail" id="display-floor-number"></span>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="info-column">--}}
{{--                            <div class="info-item">--}}
{{--                                <span class="label-text">Type: </span>--}}
{{--                                <span class="room-detail" id="display-room-type"></span>--}}
{{--                            </div>--}}
{{--                            <div class="info-item">--}}
{{--                                <span class="label-text">Capacity: </span>--}}
{{--                                <span class="room-detail" id="display-room-capacity"></span>--}}
{{--                            </div>--}}
{{--                            <div class="info-item">--}}
{{--                                <span class="label-text">Member number: </span>--}}
{{--                                <span class="room-detail" id="display-room-member-number"></span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="form-fields-row">--}}
{{--                        <div class="form-field">--}}
{{--                            <label>Check-in Date:</label>--}}
{{--                            <input type="date" name="check_in_date" class="form-control" required>--}}
{{--                        </div>--}}

{{--                        <div class="form-field">--}}
{{--                            <label>Duration (months):</label>--}}
{{--                            <select name="duration" class="form-control" required>--}}
{{--                                <option value="3">3 months</option>--}}
{{--                                <option value="6">6 months</option>--}}
{{--                                <option value="9">9 months</option>--}}
{{--                                <option value="12">12 months</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="description">--}}
{{--                        <div class="form-field">--}}
{{--                            <label>Note:</label>--}}
{{--                            <textarea name="note" class="form-control" rows="3" placeholder="Enter any additional notes"></textarea>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="button-group mt-4">--}}
{{--                    <button type="button" class="btn btn-secondary" onclick="closePopup()">Cancel</button>--}}
{{--                    <button type="submit" class="btn btn-primary">Agree</button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<!-- Modal payment info -->--}}
{{--        <div id="payment-info-modal" class="register-popup">--}}
{{--    <div class="register-popup-content">--}}
{{--        <div class="popup-header">--}}
{{--            <h2>Payment Information</h2>--}}
{{--        </div>--}}
{{--        <div class="popup-body">--}}
{{--            <div class="payment-info">--}}
{{--                <div class="payment-alert">--}}
{{--                    <i class="ti ti-alert-circle"></i>--}}
{{--                    <p>Please complete your payment within <strong>7 days</strong> to confirm your registration</p>--}}
{{--                </div>--}}

{{--                <div class="payment-details">--}}
{{--                    <div class="info-row">--}}
{{--                        <span class="label">Total Amount:</span>--}}
{{--                        <span class="value" id="payment-amount"></span>--}}
{{--                    </div>--}}
{{--                    <div class="info-row">--}}
{{--                        <span class="label">Due Date:</span>--}}
{{--                        <span class="value" id="payment-due-date"></span>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="bank-details">--}}
{{--                    <h3>Bank Transfer Information</h3>--}}
{{--                    <div class="bank-info">--}}
{{--                        <div class="info-row">--}}
{{--                            <span class="label">Bank Name:</span>--}}
{{--                            <span class="value">VietcomBank</span>--}}
{{--                        </div>--}}
{{--                        <div class="info-row">--}}
{{--                            <span class="label">Account Number:</span>--}}
{{--                            <span class="value">1234567890</span>--}}
{{--                        </div>--}}
{{--                        <div class="info-row">--}}
{{--                            <span class="label">Account Holder:</span>--}}
{{--                            <span class="value">DORMITORY MANAGEMENT</span>--}}
{{--                        </div>--}}
{{--                        <div class="info-row">--}}
{{--                            <span class="label">Transfer Description:</span>--}}
{{--                            <span class="value">ROOM_[Room Number]_[Student ID]</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="payment-note">--}}
{{--                    <i class="ti ti-info-circle"></i>--}}
{{--                    <p>After completing the payment, please keep your transfer receipt for verification purposes.</p>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="button-group mt-4">--}}
{{--                <button type="button" class="btn btn-secondary" onclick="closePopup()">Close</button>--}}
{{--                <button type="button" class="btn btn-primary" onclick="downloadPaymentInfo()">Download Info</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


{{--    </div>--}}



































{{--<!-- Thong bao -->--}}
{{--@if (session('success'))--}}
{{--    <script>--}}
{{--        Swal.fire({--}}
{{--            icon: 'success',--}}
{{--            title: 'Success!',--}}
{{--            text: "{{ session('success') }}",--}}
{{--            confirmButtonColor: '#3085d6',--}}
{{--        });--}}
{{--    </script>--}}
{{--@endif--}}

{{--@if (session('error'))--}}
{{--    <script>--}}
{{--        Swal.fire({--}}
{{--            icon: 'error',--}}
{{--            title: 'Oops...',--}}
{{--            text: "{{ session('error') }}",--}}
{{--            confirmButtonColor: '#d33',--}}
{{--        });--}}
{{--    </script>--}}
{{--@endif--}}

{{--<script src="{{ asset('./javascript/reg_room.js') }}"></script>--}}
{{--@endsection--}}



@extends('Auth_.index')

@if (session('notification'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const notification = @json(session('notification'));
            // Display the notification
            toastr.info(
                `${notification.message} `
            );
        });
    </script>
@endif

<head>
    <title>Room Registration</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('./css/button.css') }}" type="text/css">

    {{-- WEBSITE: tabler icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@tabler/icons@1.74.0/icons-react/dist/index.umd.min.js"></script>

    {{-- WEBSITE: toastr --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('./css/reg_room.css') }}" type="text/css">
    <script src="{{ asset('./javascript/reg_room.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

</head>

<style>
    .toast-warning {
        color: #ffffff !important; /* Text color for warning notification */
        background-color: #ffc107 !important; /* Background color */
        font-family: "Poppins", sans-serif !important; /* Font family */
        border-left: 5px solid #ff9800 !important; /* Left border color */
    }

    .toast-info {
        color: #ffffff !important; /* Màu chữ cho thông báo thông tin */
        background-color: #17a2b8 !important; /* Màu nền */
        font-family: "Poppins", sans-serif !important; /* Font chữ */
    }

</style>

        @section('content')
            @include('layouts.sidebar_student')
        <div class="container">
            <div class="header-container">
                <h1 class="title">Room Registration</h1>
                <div class="header-controls">
                    {{-- Button filter --}}
                <div class="filter-icon" onclick="toggleFilter()">
                    <i class="ti ti-adjustments-horizontal"></i>
                </div>

                {{-- Search bar --}}
                    <div class="search-bar" style="margin-bottom: -15px">
                        <form method="GET" action="{{ route('students.register-room.list') }}">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Search rooms..." class="search-input"
                                   aria-label="Search rooms">
                        </form>
                    </div>

            </div>
        </div>

        <div class="grid-container" id="room-list">
            @foreach ($rooms as $room)
                <div class="room-item" onclick="redirectToRoomInfo({{ $room->id }})"
                     data-floor="{{ $room->floor_number }}" data-type="{{ $room->type }}"
                     data-capacity="{{ $room->member_count }}">
                    <img src="/img/room.png">
                    <div class="room-item-group">
                        <div class="roomname">{{ $room->name }}</div>
                        <div id="room-price">
                            <span class="price">{{ $room->unit_price }}₫</span>
                            <span class="per-month">/month</span>
                        </div>
                        <div class="room-info">Phòng được thiết kế mới mẻ với đầy đủ các vật dụng cần thiết</div>
                        <div class="type-group">
                            @foreach ($room->hasRoomAssets as $asset)
                                <span class="detail-item">
                                    @php
                                        $iconMap = [
                                            'bed' => 'bed',
                                            'table' => 'desk',
                                            'chair' => 'armchair',
                                            'fan' => 'propeller',
                                            'air conditioner' => 'air-conditioning',
                                            'fridge' => 'fridge',
                                        ];
                                        $icon = $iconMap[strtolower($asset->asset->name)] ?? 'box';
                                    @endphp
                                    <i class="ti ti-{{ $icon }}"></i>
                                    {{ $asset->quantity }}
                                </span>
                            @endforeach
                            <button class="change-button"
                                    onclick="handleRegisterClick(event, {{ $room->id }})">Register</button>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>



    <!-- Pagination -->
            <div class="pagination">
{{--                {{ $rooms->appends(request()->except('page'))->links() }}--}}

            @if ($rooms->onFirstPage())
                    <span class="gap">Previous</span>
                @else
                    <a href="{{ $rooms->previousPageUrl() }}" class="previous">Previous</a>
                @endif

                @php
                    $currentPage = $rooms->currentPage();
                    $lastPage = $rooms->lastPage();
                @endphp

                    <!-- Nếu số trang ít hơn hoặc bằng 5, hiển thị tất cả các trang -->
                @if ($lastPage <= 5)
                    @for ($i = 1; $i <= $lastPage; $i++)
                        @if ($i == $currentPage)
                            <span class="pagination-page current">{{ $i }}</span>
                        @else
                            <a href="{{ $rooms->appends(request()->all())->url($i) }}" class="pagination-page">{{ $i }}</a>
                        @endif
                    @endfor
                @else
                    @if ($currentPage > 3)
                        <a href="{{ $rooms->appends(request()->all())->url(1) }}" class="pagination-page">1</a>
                        <span class="ellipsis">...</span>
                    @endif

                    @for ($i = max(1, $currentPage - 1); $i <= min($lastPage, $currentPage + 1); $i++)
                        @if ($i == $currentPage)
                            <span class="pagination-page current">{{ $i }}</span>
                        @else
                            <a href="{{ $rooms->appends(request()->all())->url($i) }}" class="pagination-page">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($currentPage < $lastPage - 2)
                        <span class="ellipsis">...</span>
                        <a href="{{ $rooms->appends(request()->all())->url($lastPage) }}" class="pagination-page">{{ $lastPage }}</a>
                    @endif
                @endif

                @if ($rooms->hasMorePages())
                    <a href="{{ $rooms->nextPageUrl() }}" class="next">Next</a>
                @else
                    <span class="gap">Next</span>
                @endif
            </div>


        @endsection
        <script>
            document.querySelector('.apply-btn').addEventListener('click', function(event) {
                event.preventDefault();

                const status = [];
                document.querySelectorAll('input[type="checkbox"][name="status[]"]:checked').forEach(function(checkbox) {
                    status.push(checkbox.value);
                });

                const buildingType = [];
                document.querySelectorAll('input[type="checkbox"][name="buildingType[]"]:checked').forEach(function(checkbox) {
                    buildingType.push(checkbox.value);
                });

                const floorNumber = document.querySelector('select[name="floorNumber"]').value;
                const roomType = [];
                document.querySelectorAll('input[type="checkbox"][name="roomType[]"]:checked').forEach(function(checkbox) {
                    roomType.push(checkbox.value);
                });

                const price = [];
                document.querySelectorAll('input[type="checkbox"]:checked').forEach(function(checkbox) {
                    price.push(checkbox.value);
                });

                const facilities = [];
                document.querySelectorAll('input[type="checkbox"]:checked').forEach(function(checkbox) {
                    facilities.push(checkbox.value);
                });

                // Lấy giá trị của trang hiện tại nếu có
                const currentPage = new URLSearchParams(window.location.search).get('page') || 1;

                // Tạo URL với các tham số lọc và trang hiện tại
                let filterParams = `?status=${status.length ? status.join(',') : ''}&buildingType=${buildingType.length ? buildingType.join(',') : ''}&floorNumber=${floorNumber || ''}&roomType=${roomType.length ? roomType.join(',') : ''}&price=${price.length ? price.join(',') : ''}&facilities=${facilities.length ? facilities.join(',') : ''}&page=${currentPage}`;

                // Thực hiện gửi URL với các tham số lọc
                window.location.href = `{{ route('students.register-room.list') }}${filterParams}`;
            });

        </script>

<!-- Modal Filter Popup -->
<div id="filter-popup" class="filter-popup">
    <div class="filter-popup-content">
        <form action="{{ route('students.filter-rooms') }}" method="GET">
            @csrf
        <div class="filter-container">
            <!-- Thêm hidden input cho room_id -->
            <input type="hidden" id="room-id-input" name="room_id" value="{{ $room_id ?? '' }}">

            <!-- Room Status -->
            <div class="filter-group">
                <h3>Room Status</h3>
                <div class="checkbox-list">
                    <label class="checkbox-item">
                        <input type="checkbox"  name="status[]" value="1">
                        <span class="checkmark"></span>
                        <span class="label-text">Vacancy</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="status[]" value="2">
                        <span class="checkmark"></span>
                        <span class="label-text">Full</span>
                    </label>
                </div>
            </div>

            <!-- Building Type -->
            <div class="filter-group">
                <h3>Building Type</h3>
                <label class="checkbox-item">
                    <input type="checkbox" value="male" name="buildingType[]">
                    <span class="checkmark"></span>
                    <span class="label-text">Male</span>
                </label>
                <label class="checkbox-item">
                    <input type="checkbox" value="female" name="buildingType[]">
                    <span class="checkmark"></span>
                    <span class="label-text">Female</span>
                </label>
            </div>

            <!-- Floor Number -->
            <div class="filter-group">
                <h3>Floor Number</h3>
                <div class="select-wrapper">
                    <select name="floorNumber" class="floor-select" >
                        <option value="" >Choose a floor</option>
                        @for ($i = 1; $i <= 20; $i++)
                            <option value="{{ $i }}">Floor {{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <!-- Room Type -->
            <div class="filter-group">
                <h3>Room Type</h3>
                <div class="checkbox-list">
                    <label class="checkbox-item">
                        <input type="checkbox" name="roomType[]" value="2">
                        <span class="checkmark"></span>
                        <span class="label-text">2 people</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="roomType[]" value="4">
                        <span class="checkmark"></span>
                        <span class="label-text">4 people</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="roomType[]" value="6">
                        <span class="checkmark"></span>
                        <span class="label-text">6 people</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="roomType[]" value="8">
                        <span class="checkmark"></span>
                        <span class="label-text">8 people</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="roomType[]" value="10">
                        <span class="checkmark"></span>
                        <span class="label-text">10 people</span>
                    </label>
                </div>
            </div>


            <!-- Price -->
            <div class="filter-group">
                <h3>Price (VNĐ)</h3>
                <div class="checkbox-list">
                    <label class="checkbox-item">
                        <input type="checkbox" name="price[]" value="1">
                        <span class="checkmark"></span>
                        <span class="label-text"> < 500.000</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="price[]" value="2">
                        <span class="checkmark"></span>
                        <span class="label-text">500.000 - 1.000.000</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="price[]" value="3">
                        <span class="checkmark"></span>
                        <span class="label-text">1.000.000 - 2.000.000</span>
                    </label>
                    <label class="checkbox-item">
                        <input type="checkbox" name="price[]" value="4">
                        <span class="checkmark"></span>
                        <span class="label-text">2.000.000 - 3.000.000</span>
                    </label>
                </div>
            </div>


            <div class="filter-group">
                <h3>Facilities</h3>
                <div class="checkbox-list">
                    @php
                        $names = ['air conditioner', 'fridge', 'television', 'water heater'];
                    @endphp

                    @foreach ($names as $name)
                        <label class="checkbox-item">
                            <input type="checkbox" name="facilities[]" value="{{ $name }}">
                            <span class="checkmark"></span>
                            <span class="label-text">{{ ucfirst($name) }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Button -->
            <div class="button-group">
                <button type="button" class="btn btn-secondary cancel-btn" onclick="closePopup()">Cancel</button>
                <button type="submit" class="btn btn-primary apply-btn">Apply</button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal Confirm Register -->
<div id="confirm-register-modal" class="register-popup">
    <div class="register-popup-content">
        <div class="popup-header">
            <h2>Confirm Registration</h2>
        </div>
        <div class="popup-body">
            <p>Are you sure you want to register for this room?</p>
            <div class="button-group mt-4">
                <button type="button" class="btn btn-secondary" onclick="closeConfirmModal()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="proceedToRegistration()">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Register Popup -->
<div id="register-popup" class="register-popup">
    <div class="register-popup-content">
        <div class="popup-header">
            <h2>Room Registration</h2>
        </div>
        <div class="popup-body">
            <form action="{{ route('students.register-room.create') }}" method="POST" id="registration-form"
                  onsubmit="return handleFormSubmit(event)">
                @csrf
                <input type="hidden" id="room-id-input" name="room_id">

                <div class="form-group">
                    <div class="room-info-display">
                        <div class="info-column">
                            <div class="info-item">
                                <span class="label-text">Room: </span>
                                <span class="room-detail" id="display-room-name"></span>
                            </div>
                            <div class="info-item">
                                <span class="label-text">Price: </span>
                                <span class="room-detail" id="display-room-price"></span>
                            </div>
                            <div class="info-item">
                                <span class="label-text">Floor number: </span>
                                <span class="room-detail" id="display-floor-number"></span>
                            </div>
                        </div>

                        <div class="info-column">
                            <div class="info-item">
                                <span class="label-text">Type: </span>
                                <span class="room-detail" id="display-room-type"></span>
                            </div>
                            <div class="info-item">
                                <span class="label-text">Capacity: </span>
                                <span class="room-detail" id="display-room-capacity"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-fields-row">
                        <div class="form-field">
                            <label>Check-in Date:</label>
                            <input type="datetime-local" name="check_in_date" class="form-control" required>
                        </div>

                        <div class="form-field">
                            <label>Duration (months):</label>
                            <select name="duration" class="form-control" required>
                                <option value="3">3 months</option>
                                <option value="6">6 months</option>
                                <option value="9">9 months</option>
                                <option value="12">12 months</option>
                            </select>
                        </div>
                    </div>
                    <div class="description">
                        <div class="form-field">
                            <label>Note:</label>
                            <textarea name="note" class="form-control" rows="3" placeholder="Enter any additional notes"></textarea>
                        </div>
                    </div>
                </div>

                <div class="button-group mt-4">
                    <button type="button" class="btn btn-secondary" onclick="closePopup()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Agree</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal payment info -->
<div id="payment-info-modal" class="register-popup">
    <div class="register-popup-content">
        <div class="popup-header">
            <h2>Payment Information</h2>
        </div>
        <div class="popup-body">
            <div class="payment-info">
                <div class="payment-alert">
                    <i class="ti ti-alert-circle"></i>
                    <p>Please complete your payment within <strong>7 days</strong> to confirm your registration</p>
                </div>

                <div class="payment-details">
                    <div class="info-row">
                        <span class="label">Total Amount:</span>
                        <span class="value" id="payment-amount"></span>
                    </div>
                    <div class="info-row">
                        <span class="label">Due Date:</span>
                        <span class="value" id="payment-due-date"></span>
                    </div>
                </div>

                <div class="bank-details">
                    <h3>Bank Transfer Information</h3>
                    <div class="bank-info">
                        <div class="info-row">
                            <span class="label">Bank Name:</span>
                            <span class="value">VietcomBank</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Account Number:</span>
                            <span class="value">1234567890</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Account Holder:</span>
                            <span class="value">DORMITORY MANAGEMENT</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Transfer Description:</span>
                            <span class="value">ROOM_[Room Number]_[Student ID]</span>
                        </div>
                    </div>
                </div>

                <div class="payment-note">
                    <i class="ti ti-info-circle"></i>
                    <p>After completing the payment, please keep your transfer receipt for verification purposes.</p>
                </div>
            </div>

            <div class="button-group mt-4">
                <button type="button" class="btn btn-secondary" onclick="closePopup()">Close</button>
                <button type="button" class="btn btn-primary" onclick="downloadPaymentInfo()">Download Info</button>
            </div>
        </div>
    </div>
</div>



<!-- Thong bao -->
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6',
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
            confirmButtonColor: '#d33',
        });
    </script>
@endif
<script src="{{ asset('./javascript/reg_room.js') }}"></script>
