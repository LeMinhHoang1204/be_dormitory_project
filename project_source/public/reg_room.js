// Creat room
function createRoom(room) {
    const assets = room.has_room_assets.map(asset => `
        <span class="detail-item">${asset.asset.name}: ${asset.quantity}</span>
    `).join("");

    return `
        <div class="room-item"
            data-room-id="${room.id}" data-room-name="${room.name}" data-room-price="${room.unit_price}"
            data-room-building="${room.building_id}" data-room-type="${room.type}" data-room-floor="${room.floor_number}"
            data-room-capacity="${room.member_number}">
            <img src="/img/room.png" alt="${room.name}">
            <div class="form-group">
                <div class="roomname">Room ${room.name}</div>
                <div id="room-price">
                    <span class="price">${room.unit_price}</span>
                    <span class="per-month">/month</span>
                </div>
                <div class="room-info">Phòng được thiết kế mới mẻ với đầy đủ các vật dụng cần thiết</div>
                <div class="type-group">
                    ${assets}
                </div>
                <div class="type-group">
                <button class="change-button" onclick="toggleConfirm()">Register</button>
                </div>
            </div>
        </div>
    `;
}

async function fetchRooms() {
    try {
        const response = await fetch("/students/rooms"); // Đường dẫn API trả về danh sách phòng
        if (!response.ok) throw new Error("Failed to fetch rooms data");
        const data = await response.json(); // Chuyển đổi dữ liệu JSON
        return data;
    } catch (error) {
        console.error("Error fetching rooms:", error);
        return [];
    }
}

// Display rooms
async function displayRoom() {
    const roomList = document.getElementById("room-list");
    const roomsData = await fetchRooms(); // Lấy dữ liệu từ database thông qua API
    roomList.innerHTML = roomsData.map(createRoom).join("");

    const roomItems = document.querySelectorAll(".room-item");
    roomItems.forEach((item) => {
<<<<<<< HEAD
        const roomData = {
            roomId: item.dataset.roomId,
            roomName: item.dataset.roomName,
            roomPrice: item.dataset.roomPrice,
            roomImg: item.dataset.roomImg
        };

        // Lưu data room vào localStorage khi click vào bất kỳ phần nào của room-item
        localStorage.setItem("selectedRoom", JSON.stringify(roomData));
=======
        item.addEventListener("click", function () {
            const roomId = this.dataset.roomId;
            const roomName = this.dataset.roomName;
            const roomPrice = this.dataset.roomPrice;
            const building = this.dataset.roomBuilding;
            const roomFloor = this.dataset.roomFloor;
            const roomType = this.dataset.roomType;
            const roomCapacity = this.dataset.roomCapacity;


            // Luu data room-item vao localStorage
            localStorage.setItem(
                "selectedRoom",
                JSON.stringify({ roomId, roomName, roomPrice, building, roomFloor, roomType, roomCapacity })
            );

            // window.location.href = `/roomInfor/${roomId}`;
        });
>>>>>>> c2624dc9a06ee3e8fdabd4de7c85c7b6ef12ab7b
    });
}

document.addEventListener("DOMContentLoaded", async function () {
    try {
        const response = await fetch("/students/current-student-user"); // Adjust the endpoint as needed
        if (!response.ok) throw new Error("Failed to fetch user data");
        const userData = await response.json();
        localStorage.setItem("currentUser", JSON.stringify(userData));
    } catch (error) {
        console.error("Error fetching user data:", error);
    }
    displayRoom();
});

// Sự kiện khi nhấn vào nút "Yes"
document.addEventListener("DOMContentLoaded", function () {
    // Sự kiện khi nhấn vào nút "Yes"
    document.querySelector(".confirm-regis .yes-btn").addEventListener("click", function() {
        // Lấy dữ liệu từ phần tử đã chọn (ví dụ: room-item)

        const selectedRoom = JSON.parse(localStorage.getItem("selectedRoom"));
        const currentUser = JSON.parse(localStorage.getItem("currentUser"));

        if (selectedRoom) {
            const roomData = {
                dormId: currentUser.userId,
                roomId: selectedRoom.roomId,
                studentId: currentUser.studentId,
                fullName: currentUser.name,
                buildingId: selectedRoom.building,
                floor: selectedRoom.roomFloor,
                price: selectedRoom.roomPrice,
                capacity: selectedRoom.roomCapacity,
                gender: currentUser.gender,
                roomType: selectedRoom.roomType,
            };


            populateRoomInfo(roomData);
        }
        showConfirmInfoContainer();
    });
});

function populateRoomInfo(data) {
    document.getElementById("dorm-id").value = data.dormId || "";
    document.getElementById("room-id").value = data.roomId || "";
    document.getElementById("student-id").value = data.studentId || "";
    document.getElementById("full-name").value = data.fullName || "";
    document.getElementById("building-id").value = data.buildingId || "";
    document.getElementById("floor").value = data.floor || "";
    document.getElementById("price").value = data.price || "";
    document.getElementById("capacity").value = data.capacity || "";
    document.getElementById("gender").value = data.gender || "";
    document.getElementById("room-type").value = data.roomType || "";
}

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
const overlay = document.querySelector(".overlay");
if (overlay) {
    overlay.addEventListener("click", () => {
        const filterPanel = document.querySelector(".filter-panel");
        if (filterPanel) {
            filterPanel.classList.remove("active");
        }
        overlay.classList.remove("active");
    });
}

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
document.querySelector(".confirm-regis .no-btn").addEventListener("click", closeConfirm);

// Nhấn mở confirm panel
document
    .getElementById("room-list")
    .addEventListener("click", function (event) {
        if (event.target && event.target.classList.contains("change-button")) {
            toggleConfirm();
        }
    });

// Hiển thị success-panel khi nhấn "Confirm" trong confirm-info-container
function showSuccessPanel() {
    // Lưu trạng thái form đã được gửi vào sessionStorage
    sessionStorage.setItem("formSubmitted", "true");

    console.log(2);

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



// Sự kiện khi nhấn vào nút "Confirm"
document.querySelector('.confirm-info-container button[type="submit"]')
    .addEventListener("click", function (event) {
        event.preventDefault();
        console.log("Submit prevented");
        showSuccessPanel();
    });

// Sự kiện khi nhấn vào overlay hoặc "Continue"
document.querySelector(".overlay2").addEventListener("click", closeAllPanels);
document.querySelector(".success-panel .continue-btn")
    .addEventListener("click", closeAllPanels);


document.addEventListener("DOMContentLoaded", function () {
    const roomItems = document.querySelectorAll(".room-item");
    roomItems.forEach((item) => {
        item.addEventListener("click", function () {
            const id = this.dataset.id;
            window.location.href = `/roomInfor/${id}`;
        });
    });
});
