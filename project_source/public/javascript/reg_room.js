function toggleFilter() {
    const filterPopup = document.getElementById("filter-popup");
    filterPopup.classList.toggle("show");

    // Thêm event listener cho nút Apply nếu chưa có
    const applyButton = document.getElementById("apply-filter-btn");
    if (applyButton) {
        applyButton.onclick = applyFilter;
    }
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
    const paymentInfoModal = document.getElementById("payment-info-modal");
    if (paymentInfoModal) {
        paymentInfoModal.style.display = "none";
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

async function handleRegisterClick(event, roomId) {
    // Prevent event bubbling
    event.stopPropagation();

    const response = await fetch(`/students/room-registration/latest-residence`);
    const data = await response.json();
    if (data.residence && (data.residence.status === 'Registered'
                        || data.residence.status === 'Paid'
                        || data.residence.status === 'Checked in')) {
        toastr.warning('You already have a registered room.');
        return;
    }
    // Lấy thông tin phòng từ room-item
    const roomItem = event.target.closest(".room-item");
    const roomName = roomItem.querySelector(".roomname").textContent;
    const roomPrice = roomItem.querySelector(".price").textContent;
    const floorNumber = roomItem.dataset.floor;
    const roomType = roomItem.dataset.type;
    // Cập nhật thông tin trong form
    document.getElementById("room-id-input").value = roomId;
    document.getElementById("display-room-name").textContent = roomName;
    document.getElementById("display-room-price").textContent =
        roomPrice + "/month";
    document.getElementById("display-floor-number").textContent = floorNumber;
    document.getElementById("display-room-type").textContent = roomType;
    // Hiển thị modal đăng ký
    document.getElementById("register-popup").style.display = "block";
}

function closeConfirmModal() {
    const confirmModal = document.getElementById("confirm-register-modal");
    confirmModal.style.display = "none";
    selectedRoomId = null;
}

function proceedToRegistration() {
    if (selectedRoomId) {
        const registerPopup = document.getElementById("register-popup");
        registerPopup.style.display = "flex";
        document.getElementById("room-id-input").value = selectedRoomId;

        updateRegisterPopupDetails(selectedRoomId);
    }
}

// Hiển thị modal thông tin thanh toán
function showPaymentInfo(amount, dueDate) {
    const modal = document.getElementById("payment-info-modal");
    document.getElementById("payment-amount").textContent =
        amount.toLocaleString("vi-VN") + " VND";
    document.getElementById("payment-due-date").textContent = new Date(
        dueDate
    ).toLocaleDateString();
    modal.style.display = "block";
}

function handleFormSubmit(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    // Get CSRF token from meta tag
    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch(form.action, {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": token,
            Accept: "application/json",
        },
        credentials: "same-origin",
    })
        .then((response) => response.json())
        .then((data) => {
            closePopup(); // Close the registration popup

            if (data.success) {
                // Show success message
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: data.message,
                    confirmButtonColor: "#3085d6",
                }).then(() => {
                    // Show payment info modal
                    showPaymentInfo(data.invoice);
                });
            } else {
                // Show error message
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.message || "Registration failed",
                    confirmButtonColor: "#d33",
                });
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "An unexpected error occurred",
                confirmButtonColor: "#d33",
            });
        });

    return false;
}
function showPaymentInfo(invoice) {
    const modal = document.getElementById("payment-info-modal");
    document.getElementById("payment-amount").textContent =
        invoice.total.toLocaleString("vi-VN") + " VND";
    document.getElementById("payment-due-date").textContent = new Date(
        invoice.due_date
    ).toLocaleDateString();
    modal.style.display = "block";
}

function downloadPaymentInfo() {
    // Create a link element
    const link = document.createElement("a");
    link.href = "/images/qrcode.png";
    link.download = "payment_qrcode.png";

    // Append link to body, click it, and remove it
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// filter
function applyFilter() {
    const priceMin = document.getElementById("price-min").value;
    const priceMax = document.getElementById("price-max").value;
    const selectedFloor = document.getElementById("floor-select").value;
    const selectedType = document.getElementById("type-select").value;
    const selectedCapacity = document.getElementById("capacity-select").value;

    const roomItems = document.querySelectorAll(".room-item");

    roomItems.forEach((room) => {
        const price = parseInt(
            room.querySelector(".price").textContent.replace(/[^0-9]/g, "")
        );
        const floor = room.dataset.floor;
        const type = room.dataset.type;
        const capacity = room.dataset.capacity;

        let isVisible = true;

        // Kiểm tra giá
        if (priceMin && price < parseInt(priceMin)) isVisible = false;
        if (priceMax && price > parseInt(priceMax)) isVisible = false;

        // Kiểm tra tầng
        if (selectedFloor && selectedFloor !== "all" && floor !== selectedFloor)
            isVisible = false;

        // Kiểm tra loại phòng
        if (selectedType && selectedType !== "all" && type !== selectedType)
            isVisible = false;

        // Kiểm tra sức chứa
        if (
            selectedCapacity &&
            selectedCapacity !== "all" &&
            capacity !== selectedCapacity
        )
            isVisible = false;

        // Hiển thị hoặc ẩn phòng
        room.style.display = isVisible ? "block" : "none";
    });

    // Đóng popup filter sau khi áp dụng
    closePopup();
}
