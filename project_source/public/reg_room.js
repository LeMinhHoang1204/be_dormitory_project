const roomsData = [
    {
        id: "room001",
        name: "A101",
        price: 800000.0,
        img: "room.png",
    },
    {
        id: "room002",
        name: "A102",
        price: 800000.0,
        img: "room.png",
    },
    {
        id: "room003",
        name: "A103",
        price: 800000.0,
        img: "room.png",
    },
    {
        id: "room004",
        name: "A104",
        price: 800000.0,
        img: "room.png",
    },
    {
        id: "room00",
        name: "A105",
        price: 800000.0,
        img: "room.png",
    },
    {
        id: "room006",
        name: "A106",
        price: 800000.0,
        img: "room.png",
    },
];

function createRoom(room1) {
    return `
        <div class="room-item" data-room-id="${room1.id}">
            <img src="/img/room.png" alt="${room1.name}">
            <div class="form-group">
                <div class="roomname">Room ${room1.name}</div>
                <div id="room-price">
                    <span class="price">${room1.price}</span>
                    <span class="per-month">/month</span>
                </div>
                <div class="room-info">Phòng được thiết kế mới mẻ với đầy đủ các vật dụng cần thiết</div>
                <div class="type-group">
                    <span class="detail-item">2 Bed</span>
                    <span class="detail-item">Modern Furniture</span>
                    <button class="change-button" onclick="toggleConfirm()">Register</button>
                </div>
            </div>
        </div>
    `;
}

// Display roomInfor
function displayRoom() {
    const roomList = document.getElementById("room-list");
    roomList.innerHTML = roomsData.map(createRoom).join("");

    const roomItems = document.querySelectorAll(".room-item");
    roomItems.forEach((item) => {
        item.addEventListener("click", function () {
            const id = this.dataset.id;
            if (id) {
                window.location.href = `/roomInfor/${id}`;
            } else {
                console.error("Room ID is undefined");
            }
        });
    });
}

document.addEventListener("DOMContentLoaded", function () {
    displayRoom();
});

// Hàm bật/tắt filter panel
function toggleFilter() {
    const filterPanel = document.querySelector(".filter-panel");
    const overlay = document.querySelector(".overlay");

    if (filterPanel && overlay) {
        const isActive = filterPanel.classList.toggle("active");
        overlay.classList.toggle("active", isActive);
    }
}

// Đóng filter panel và overlay khi nhấn ra ngoài
document.querySelector(".overlay").addEventListener("click", () => {
    const filterPanel = document.querySelector(".filter-panel");
    const overlay = document.querySelector(".overlay");

    if (filterPanel && overlay) {
        filterPanel.classList.remove("active");
        overlay.classList.remove("active");
    }
});

// Nhấn mở filter panel
document.querySelector(".filter-sgv").addEventListener("click", toggleFilter);

// Bắt sự kiện khi nhấn nút Apply
document.getElementById("apply-filter").addEventListener("click", () => {
    const filterPanel = document.querySelector(".filter-panel");
    const overlay = document.querySelector(".overlay");

    // Thực hiện hành động khi áp dụng bộ lọc
    console.log("Filter applied!");
    // TODO: Viết logic để áp dụng bộ lọc tại đây

    // Đóng filter-panel và overlay sau khi nhấn Apply
    filterPanel.classList.remove("active");
    overlay.classList.remove("active");
});

// Hàm bật/tắt Confirm regis panel
function toggleConfirm() {
    const confirmPanel = document.querySelector(".confirm-regis");
    const overlay2 = document.querySelector(".overlay2");

    if (confirmPanel && overlay2) {
        const isActive = confirmPanel.classList.toggle("active");
        overlay2.classList.toggle("active", isActive); // Sync the state
    }
}

// Đóng confirm panel và overlay khi nhấn ra ngoài overlay2 hoặc nhấn vào nút "No"
function closeConfirm() {
    const confirmPanel = document.querySelector(".confirm-regis");
    const overlay2 = document.querySelector(".overlay2");

    if (confirmPanel && overlay2) {
        confirmPanel.classList.remove("active");
        overlay2.classList.remove("active");
    }
}

// Đóng confirm panel và overlay khi nhấn ra ngoài
document.querySelector(".overlay2").addEventListener("click", closeConfirm);

// Sự kiện khi nhấn vào nút "No" (để đóng cả overlay và confirm panel)
document
    .querySelector(".confirm-regis .no-btn")
    .addEventListener("click", closeConfirm);

// Nhấn mở confirm panel
document
    .getElementById("room-list")
    .addEventListener("click", function (event) {
        if (event.target && event.target.classList.contains("change-button")) {
            toggleConfirm();
        }
    });

// document.querySelector('.yes-btn').addEventListener('click', showSuccessPanel);
//
// // Hiện success panel sau khi nhấn "Yes" trong confirm-regis
// function showSuccessPanel() {
//     const confirmPanel = document.querySelector('.confirm-regis');
//     const successPanel = document.querySelector('.success-panel');
//     const overlay2 = document.querySelector('.overlay2');
//
//     if (confirmPanel && successPanel && overlay2) {
//         confirmPanel.classList.remove('active');
//         successPanel.classList.add('active');
//         overlay2.classList.add('active'); // Ensure overlay2 remains active
//     }
// }
//
// // Đóng tất cả các panel và overlay khi nhấn "Continue" hoặc overlay
// function closeAllPanels() {
//     const confirmPanel = document.querySelector('.confirm-regis');
//     const successPanel = document.querySelector('.success-panel');
//     const overlay2 = document.querySelector('.overlay2');
//
//     if (confirmPanel && successPanel && overlay2) {
//         confirmPanel.classList.remove('active');
//         successPanel.classList.remove('active');
//         overlay2.classList.remove('active');
//     }
// }
//
// // Sự kiện khi nhấn vào nút "Yes" (để hiển thị success panel)
// document.querySelector('.confirm-regis .yes-btn').addEventListener('click', showSuccessPanel);
//
// // Sự kiện khi nhấn vào overlay hoặc nút "Continue" (để đóng tất cả các panel)
// document.querySelector('.overlay2').addEventListener('click', closeAllPanels);
// document.querySelector('.success-panel .continue-btn').addEventListener('click', closeAllPanels);

// Hiển thị confirm-info-container khi nhấn "Yes" trong confirm-regis
function showConfirmInfoContainer() {
    const confirmPanel = document.querySelector(".confirm-regis");
    const confirmInfoContainer = document.querySelector(
        ".confirm-info-container"
    );
    const overlay2 = document.querySelector(".overlay2");

    if (confirmPanel && confirmInfoContainer && overlay2) {
        confirmPanel.classList.remove("active"); // Ẩn confirm-regis
        confirmInfoContainer.classList.add("active"); // Hiển thị popup confirm-info-container
        overlay2.classList.add("active"); // Hiển thị overlay
    }
}

// Hiển thị success-panel khi nhấn "Confirm" trong confirm-info-container
function showSuccessPanel() {
    const confirmInfoContainer = document.querySelector(
        ".confirm-info-container"
    );
    const successPanel = document.querySelector(".success-panel");
    const overlay2 = document.querySelector(".overlay2");

    if (confirmInfoContainer && successPanel && overlay2) {
        confirmInfoContainer.classList.remove("active"); // Ẩn confirm-info-container
        successPanel.classList.add("active"); // Hiển thị success-panel
        overlay2.classList.add("active"); // Overlay vẫn hiển thị
    }
}

// Hiển thị success-panel khi nhấn "Confirm" trong confirm-info-container
function showSuccessPanel() {
    // Lưu trạng thái form đã được gửi vào sessionStorage
    sessionStorage.setItem("formSubmitted", "true");

    const confirmInfoContainer = document.querySelector(
        ".confirm-info-container"
    );
    const successPanel = document.querySelector(".success-panel");
    const overlay2 = document.querySelector(".overlay2");

    if (confirmInfoContainer && successPanel && overlay2) {
        confirmInfoContainer.classList.remove("active"); // Ẩn confirm-info-container
        successPanel.classList.add("active"); // Hiển thị success-panel
        overlay2.classList.add("active"); // Overlay vẫn hiển thị
    }

    // Gửi form sau khi xác nhận thành công
    document.querySelector(".confirm-info-form").submit();
}

// Ẩn tất cả popup và overlay khi nhấn vào "Continue" hoặc overlay
function closeAllPanels() {
    const confirmPanel = document.querySelector(".confirm-regis");
    const confirmInfoContainer = document.querySelector(
        ".confirm-info-container"
    );
    const successPanel = document.querySelector(".success-panel");
    const overlay2 = document.querySelector(".overlay2");

    if (confirmPanel && confirmInfoContainer && successPanel && overlay2) {
        confirmPanel.classList.remove("active"); // Ẩn confirm-regis
        confirmInfoContainer.classList.remove("active"); // Ẩn confirm-info-container
        successPanel.classList.remove("active"); // Ẩn success-panel
        overlay2.classList.remove("active"); // Ẩn overlay
    }
}

// Sự kiện khi nhấn vào nút "Yes"
document
    .querySelector(".confirm-regis .yes-btn")
    .addEventListener("click", showConfirmInfoContainer);

// Sự kiện khi nhấn vào nút "Confirm"
document
    .querySelector('.confirm-info-container button[type="submit"]')
    .addEventListener("click", function (event) {
        event.preventDefault();
        console.log("Submit prevented");
        showSuccessPanel();
    });

// Sự kiện khi nhấn vào overlay hoặc "Continue"
document.querySelector(".overlay2").addEventListener("click", closeAllPanels);
document
    .querySelector(".success-panel .continue-btn")
    .addEventListener("click", closeAllPanels);

// Hàm để điền dữ liệu vào form ROOM APPLICATION
document.addEventListener("DOMContentLoaded", function () {
    const inforData = {
        dormId: "A01333",
        id: "A101",
        studentId: "22520000",
        fullName: "Lê Minh Hoàng",
        buildingId: "A",
        floor: "1",
        price: "1.000.000 VND/month",
        capacity: "0/2",
        // startDate: "2024-10-01",
        gender: "Male",
        roomType: "Male",
        // duration: "6",
    };
    // Hàm để điền dữ liệu vào form ROOM APPLICATION
    function populateRoomInfo(data) {
        console.log("Populating data..."); // Debug
        document.getElementById("dorm-id").value = data.dormId || "";
        document.getElementById("room-id").value = data.id || "";
        document.getElementById("student-id").value = data.studentId || "";
        document.getElementById("full-name").value = data.fullName || "";
        document.getElementById("building-id").value = data.buildingId || "";
        document.getElementById("floor").value = data.floor || "";
        document.getElementById("price").value = data.price || "";
        document.getElementById("capacity").value = data.capacity || "";
        document.getElementById("start-date").value = data.startDate || "";
        document.getElementById("gender").value = data.gender || "";
        document.getElementById("room-type").value = data.roomType || "";
        document.getElementById("duration").value = data.duration || "";
    }

    // Gọi hàm để điền dữ liệu vào form
    populateRoomInfo(inforData);
});

// Hiển thị danh sách phòng khi tải trang
document.addEventListener("DOMContentLoaded", displayRoom);

document.addEventListener("DOMContentLoaded", function () {
    const roomItems = document.querySelectorAll(".room-item");
    roomItems.forEach((item) => {
        item.addEventListener("click", function () {
            const id = this.dataset.id;
            window.location.href = `/roomInfor/${id}`;
        });
    });
});
