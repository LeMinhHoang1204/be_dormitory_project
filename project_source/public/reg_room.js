const roomsData = [
    {
        name: "A101",
        price: 800000.0,
        img: "room.png",
    },
    {
        name: "A102",
        price: 800000.0,
        img: "room.png",
    },
    {
        name: "A103",
        price: 800000.0,
        img: "room.png",
    },
    {
        name: "A104",
        price: 800000.0,
        img: "room.png",
    },
    {
        name: "A105",
        price: 800000.0,
        img: "room.png",
    },
    {
        name: "A106",
        price: 800000.0,
        img: "room.png",
    },
];

function createRoom(room1) {
    return `
        <div class="room">
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

// Hàm hiển thị phòng
function displayRoom() {
    const roomList = document.getElementById("room-list");
    roomList.innerHTML = roomsData.map(createRoom).join("");
}

document.addEventListener("DOMContentLoaded", function () {
    displayRoom();
});

// Hàm bật/tắt filter panel
function toggleFilter() {
    const filterPanel = document.querySelector('.filter-panel');
    const overlay = document.querySelector('.overlay');

    if (filterPanel && overlay) {
        const isActive = filterPanel.classList.toggle('active');
        overlay.classList.toggle('active', isActive);
    }
}

// Đóng filter panel và overlay khi nhấn ra ngoài
document.querySelector('.overlay').addEventListener('click', () => {
    const filterPanel = document.querySelector('.filter-panel');
    const overlay = document.querySelector('.overlay');

    if (filterPanel && overlay) {
        filterPanel.classList.remove('active');
        overlay.classList.remove('active');
    }
});

// Nhấn mở filter panel
document.querySelector('.filter-sgv').addEventListener('click', toggleFilter);

// Bắt sự kiện khi nhấn nút Apply
document.getElementById('apply-filter').addEventListener('click', () => {
    const filterPanel = document.querySelector('.filter-panel');
    const overlay = document.querySelector('.overlay');

    // Thực hiện hành động khi áp dụng bộ lọc
    console.log('Filter applied!');
    // TODO: Viết logic để áp dụng bộ lọc tại đây

    // Đóng filter-panel và overlay sau khi nhấn Apply
    filterPanel.classList.remove('active');
    overlay.classList.remove('active');
});


// Hàm bật/tắt Confirm regis panel
function toggleConfirm() {
    const confirmPanel = document.querySelector('.confirm-regis');
    const overlay2 = document.querySelector('.overlay2');

    if (confirmPanel && overlay2) {
        const isActive = confirmPanel.classList.toggle('active');
        overlay2.classList.toggle('active', isActive); // Sync the state
    }
}

// Đóng confirm panel và overlay khi nhấn ra ngoài overlay2 hoặc nhấn vào nút "No"
function closeConfirm() {
    const confirmPanel = document.querySelector('.confirm-regis');
    const overlay2 = document.querySelector('.overlay2');

    if (confirmPanel && overlay2) {
        confirmPanel.classList.remove('active');
        overlay2.classList.remove('active');
    }
}

// Đóng confirm panel và overlay khi nhấn ra ngoài
document.querySelector('.overlay2').addEventListener('click', closeConfirm);

// Sự kiện khi nhấn vào nút "No" (để đóng cả overlay và confirm panel)
document.querySelector('.confirm-regis .no-btn').addEventListener('click', closeConfirm);

// Nhấn mở confirm panel
document.querySelector('.change-button').addEventListener('click', toggleConfirm);

// Hiện success panel sau khi nhấn "Yes" trong confirm-regis
function showSuccessPanel() {
    // Ẩn confirm-regis panel
    const confirmPanel = document.querySelector('.confirm-regis');
    const successPanel = document.querySelector('.success-panel');
    const overlay2 = document.querySelector('.overlay2');

    if (confirmPanel && successPanel && overlay2) {
        confirmPanel.classList.remove('active');
        successPanel.classList.add('active');
        overlay2.classList.add('active'); // Ensure overlay2 remains active
    }
}

// Đóng success panel khi nhấn "Continue"
function closePanel() {
    const successPanel = document.querySelector('.success-panel');
    const overlay2 = document.querySelector('.overlay2');

    if (successPanel && overlay2) {
        successPanel.classList.remove('active');
        overlay2.classList.remove('active');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const inforData = {
        dormId: "A01333",
        roomId: "A101",
        studentId: "22520000",
        fullName: "Lê Minh Hoàng",
        buildingId: "A",
        floor: "1",
        price: "1.000.000 VND/month",
        capacity: "0/2",
        gender: "Male",
        roomType: "Male",
    };

    // Hàm để điền dữ liệu vào form ROOM APPLICATION
    function populateRoomInfo(data) {
        document.getElementById("dorm-id").value = data.dormId;
        document.getElementById("room-id").value = data.roomId;
        document.getElementById("student-id").value = data.studentId;
        document.getElementById("full-name").value = data.fullName;
        document.getElementById("building-id").value = data.buildingId;
        document.getElementById("floor").value = data.floor;
        document.getElementById("price").value = data.price;
        document.getElementById("capacity").value = data.capacity;
        document.getElementById("start-date").value = data.startDate; // Đảm bảo định dạng ngày tháng là YYYY-MM-DD
        document.getElementById("gender").value = data.gender;
        document.getElementById("room-type").value = data.roomType;
        document.getElementById("duration").value = data.duration; // Đảm bảo rằng combobox duration có ID 'duration'
    }

    // Gọi hàm để điền dữ liệu vào form
    populateRoomInfo(inforData);
});




// Hiển thị danh sách phòng khi tải trang
document.addEventListener("DOMContentLoaded", displayRoom);
