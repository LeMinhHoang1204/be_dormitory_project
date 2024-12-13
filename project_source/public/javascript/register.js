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
}


// Button register
function handleSearch(event) {
    console.log("Searching:", event.target.value);
}
function redirectToRoomInfo(roomId) {
    window.location.href = `/roomInfor?roomId=${roomId}`;
}




function handleRegisterClick(event, roomId) {
    // Ngăn click lan truyền lên phần tử cha
    event.stopPropagation();

    // Hiển thị register-popup
    const registerPopup = document.getElementById("register-popup");
    if (registerPopup) {
        registerPopup.style.display = "block";
    }

    // Lưu roomId để sử dụng khi submit form
    document.getElementById("selected-room-id").value = roomId;
}


