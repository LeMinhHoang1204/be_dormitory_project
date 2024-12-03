// const roomsData = [
//     {
//         
//     },
//     {
//         
//     },
//     {
//         
//     },
//     {
//         
//     },
//     {
//         
//     },
//     {
//         
//     },
// ];



document.addEventListener("DOMContentLoaded", function () {
    const roomData = JSON.parse(localStorage.getItem("selectedRoom"));

    if (roomData) {
        document.querySelector(".room-meta h2").textContent = roomData.roomName;
        document.querySelector(".room-meta span").textContent = `${roomData.roomPrice} VND/month`;
        document.querySelector(".room-image img").src = `/img/${roomData.roomImg}`;
    }
});

