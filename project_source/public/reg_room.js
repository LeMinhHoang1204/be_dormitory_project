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
                    <button class="change-button">Register</button>
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
