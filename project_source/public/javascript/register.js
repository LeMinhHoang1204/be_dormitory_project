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
    if (event.key === 'Enter') {
        performSearch(event.target.value);
        event.target.blur(); // Thoát khỏi input
        return;
    }

    // Nếu không phải Enter thì tìm kiếm realtime
    performSearch(event.target.value);
}

function performSearch(searchValue) {
    const searchTerm = searchValue.toLowerCase();
    const roomItems = document.querySelectorAll('.room-item');

    // Tim kiem room theo name
    roomItems.forEach(room => {
        const roomName = room.querySelector('.roomname').textContent.toLowerCase();
        if (roomName.includes(searchTerm)) {
            room.style.display = 'block';
        } else {
            room.style.display = 'none';
        }
    });

    if (searchTerm === '') {
        roomItems.forEach(room => {
            room.style.display = 'block';
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

    // Store the selected room ID
    selectedRoomId = roomId;

    // Show confirmation modal
    const confirmModal = document.getElementById("confirm-register-modal");
    confirmModal.style.display = "flex";
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
