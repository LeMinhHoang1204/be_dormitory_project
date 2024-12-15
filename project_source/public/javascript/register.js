function toggleFilter() {
    const filterPopup = document.getElementById("filter-popup");
    filterPopup.classList.toggle("show");
}

// Close Popup
function closePopup() {
    const registerPopup = document.getElementById("register-popup");
    if (registerPopup) {
        registerPopup.style.display = "none";
    }
    const filterPopup = document.getElementById("filter-popup");
    if (filterPopup) {
        filterPopup.classList.remove("show");
    }
    const confirmModal = document.getElementById("confirm-register-modal");
    if (confirmModal) {
        confirmModal.style.display = "none";
    }
}

// Button Register
function handleSearchKeyup(event) {
    // Nếu nhấn Enter
    if (event.key === "Enter") {
        performSearch(event.target.value);
        event.target.blur(); // Thoát khỏi input
        return;
    }

    // Nếu không phải Enter thì tìm kiếm realtime
    performSearch(event.target.value);
}

function performSearch(searchValue) {
    const searchTerm = searchValue.toLowerCase();
    const roomItems = document.querySelectorAll(".room-item");

    // Tim kiem room theo name
    roomItems.forEach((room) => {
        const roomName = room
            .querySelector(".roomname")
            .textContent.toLowerCase();
        if (roomName.includes(searchTerm)) {
            room.style.display = "block";
        } else {
            room.style.display = "none";
        }
    });

    if (searchTerm === "") {
        roomItems.forEach((room) => {
            room.style.display = "block";
        });
    }
}

function redirectToRoomInfo(roomId) {
    window.location.href = `/roomInfor?roomId=${roomId}`;
}

let selectedRoomId = null;

function handleRegisterClick(event, roomId) {
    // Prevent event bubbling
    event.stopPropagation();

    // Lấy thông tin phòng từ room-item
    const roomItem = event.target.closest('.room-item');
    const roomName = roomItem.querySelector('.roomname').textContent;
    const roomPrice = roomItem.querySelector('.price').textContent;
    const floorNumber = roomItem.dataset.floor;
    const roomType = roomItem.dataset.type;
    const capacity = roomItem.dataset.capacity;

    // Cập nhật thông tin trong form
    document.getElementById('room-id-input').value = roomId;
    document.getElementById('display-room-name').textContent = roomName;
    document.getElementById('display-room-price').textContent = roomPrice + '₫/month';
    document.getElementById('display-floor-number').textContent = floorNumber;
    document.getElementById('display-room-type').textContent = roomType;
    document.getElementById('display-room-capacity').textContent = capacity;

    // Hiển thị modal đăng ký
    document.getElementById('register-popup').style.display = 'block';
}

function closeConfirmModal() {
    const confirmModal = document.getElementById("confirm-register-modal");
    confirmModal.style.display = "none";
    selectedRoomId = null;
}

function proceedToRegistration() {
    if (selectedRoomId) {
        // Show register popup
        const registerPopup = document.getElementById("register-popup");
        registerPopup.style.display = "flex";

        // Set the room ID in the hidden input
        document.getElementById("room-id-input").value = selectedRoomId;

        // Get room details and update the popup
        updateRegisterPopupDetails(selectedRoomId);
    }
}

// Thêm event listener cho form submit
document.getElementById('registration-form').addEventListener('submit', function(e) {
    e.preventDefault();

    // Submit form bằng AJAX
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Registration successful!');
            window.location.reload();
        } else {
            alert(data.message || 'Registration failed. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
});
