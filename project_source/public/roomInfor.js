


document.addEventListener("DOMContentLoaded", function () {
    const roomData = JSON.parse(localStorage.getItem("selectedRoom"));

    if (roomData) {
        document.querySelector(".room-image img").src = `/img/${roomData.roomImg}`;
    }
});

