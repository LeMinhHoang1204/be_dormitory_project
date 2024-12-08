// Hàm bật/tắt filter panel
function toggleFilter() {
    const filterPanel = document.querySelector(".filter-panel");
    const overlay = document.querySelector(".overlay");

    if (filterPanel && overlay) {
        const isActive = filterPanel.classList.toggle("active");
        overlay.classList.toggle("active", isActive);
    }
}

// Đóng filter panel và overlay khi nhấn ra ngoài
document.querySelector(".overlay").addEventListener("click", () => {
    const filterPanel = document.querySelector(".filter-panel");
    const overlay = document.querySelector(".overlay");

    if (filterPanel && overlay) {
        filterPanel.classList.remove("active");
        overlay.classList.remove("active");
    }
});

// Nhấn mở filter panel
document.querySelector(".filter-sgv").addEventListener("click", toggleFilter);

