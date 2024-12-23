function togglePanel() {
    const panel = document.getElementById("filterPanel");
    panel.classList.toggle("active");
}

function closePanel(event) {
    const panel = document.getElementById("filterPanel");
    if (event.target === panel) {
        panel.classList.remove("active");
    }
}

function applyFilters() {
    // Thực hiện lọc dữ liệu
    const panel = document.getElementById("filterPanel");
    panel.classList.remove("active"); // Đóng panel sau khi áp dụng bộ lọc
}

// SweetAlert2 Delete Confirmation
function deleteNotification(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#F72C5B",
        cancelButtonColor: "#6B7280",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Deleted!",
                text: "The notification has been deleted.",
                icon: "success",
                timer: 1000,
                showConfirmButton: false,
            }).then(() => {
                document.getElementById("delete-form-" + id).submit();
            });
        }
    });
}

function showNotificationModal(id, title, content, sender, date) {
    const modalElement = document.getElementById("notificationModal");
    document.getElementById("modalTitle").textContent = title;
    document.getElementById("modalContent").textContent = content;
    document.getElementById("modalSender").textContent = sender;
    document.getElementById("modalDate").textContent = date;

    const modal = new bootstrap.Modal(modalElement);
    const closeButton = modalElement.querySelector(
        ".modal-footer .btn-secondary"
    );

    const closeHandler = () => {
        modal.hide();
        closeButton.removeEventListener("click", closeHandler);
    };

    closeButton.addEventListener("click", closeHandler);
    modal.show();
}
