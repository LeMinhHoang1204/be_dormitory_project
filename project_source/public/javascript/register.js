function toggleFilter() {
    const filterPopup = document.getElementById("filter-popup");
    filterPopup.classList.toggle("show");
}

function toggleFilterPopup() {
    const filterPopup = document.getElementById("filter-popup");
    filterPopup.classList.remove("show");
}

// Close
window.onclick = function (event) {
    const filterPopup = document.getElementById("filter-popup");
    if (event.target == filterPopup) {
        filterPopup.classList.remove("show");
    }
};

// Hàm xử lý tìm kiếm (có thể thêm sau)
function handleSearch(event) {
    console.log("Searching:", event.target.value);
}



function redirectToRoomInfo(roomId) {
    window.location.href = `/roomInfor?roomId=${roomId}`;
}
