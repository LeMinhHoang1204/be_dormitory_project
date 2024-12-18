document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.dataset.action;
            const invoiceId = this.closest('tr').querySelector('td:first-child').textContent;

            switch(action) {
                case 'confirm':
                    showConfirmDialog(invoiceId);
                    break;
                case 'refuse':
                    showRefuseDialog(invoiceId);
                    break;
                case 'report':
                    showReportDialog(invoiceId);
                    break;
                case 'delete':
                    showDeleteDialog(invoiceId);
                    break;
                case 'update':
                    showUpdateDialog(invoiceId);
                    break;
            }
        });
    });
});

//  config dialog
const commonConfig = {
    width: '32em',
    padding: '2em',
    showCancelButton: true,
    cancelButtonText: 'Cancel',
    cancelButtonColor: '#6c757d',
    confirmButtonColor: '#3085d6',
    customClass: {
        popup: 'custom-popup-class',
        title: 'custom-title-class',
        content: 'custom-content-class',
        confirmButton: 'custom-confirm-btn',
        cancelButton: 'custom-cancel-btn'
    }
};

function showConfirmDialog(invoiceId) {
    Swal.fire({
        ...commonConfig,
        title: 'Confirm Payment',
        text: `Are you sure you want to confirm payment for invoice #${invoiceId}?`,
        icon: 'question',
        confirmButtonText: 'Confirm',
        confirmButtonColor: '#007bff'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/accountant/payment/confirm/${invoiceId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessAlert('Payment has been confirmed successfully.');
                } else {
                    showErrorAlert('An error occurred while confirming payment.');
                }
            });
        }
    });
}

function showRefuseDialog(invoiceId) {
    Swal.fire({
        ...commonConfig,
        title: 'Refuse Payment',
        text: `Are you sure you want to refuse payment for invoice #${invoiceId}?`,
        input: 'textarea',
        inputLabel: 'Reason for refusal',
        inputPlaceholder: 'Enter reason for refusal...',
        icon: 'warning',
        confirmButtonText: 'Refuse',
        confirmButtonColor: '#dc3545',
        inputClass: 'custom-input-class'
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            // Handle refuse logic here
            showSuccessAlert('Payment has been refused.');
        }
    });
}

function showReportDialog(invoiceId) {
    Swal.fire({
        ...commonConfig,
        title: 'Report Issue',
        input: 'textarea',
        inputLabel: 'Report Content',
        inputPlaceholder: 'Enter report content...',
        icon: 'info',
        confirmButtonText: 'Submit Report',
        confirmButtonColor: '#007bff',
        inputClass: 'custom-input-class'
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            // Handle report logic here
            showSuccessAlert('Report has been submitted.');
        }
    });
}

function showDeleteDialog(invoiceId) {
    Swal.fire({
        ...commonConfig,
        title: 'Delete Invoice',
        text: `Are you sure you want to delete invoice #${invoiceId}?`,
        icon: 'warning',
        confirmButtonText: 'Delete',
        confirmButtonColor: '#dc3545'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/accountant/payment/delete/${invoiceId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessAlert('Invoice has been deleted successfully.')
                    .then(() => {
                        window.location.reload();
                    });
                } else {
                    showErrorAlert('An error occurred while deleting the invoice.');
                }
            })
            .catch(error => {
                showErrorAlert('An error occurred while deleting the invoice.');
                console.error('Error:', error);
            });
        }
    });
}

function showUpdateDialog(invoiceId) {
    Swal.fire({
        ...commonConfig,
        title: 'Update Invoice',
        html: `
            <form id="updateForm" class="custom-form">
                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="number" class="form-control custom-input" id="amount">
                </div>
                <div class="mb-3">
                    <label class="form-label">Due Date</label>
                    <input type="date" class="form-control custom-input" id="dueDate">
                </div>
                <div class="mb-3">
                    <label class="form-label">Note</label>
                    <textarea class="form-control custom-input" id="note"></textarea>
                </div>
            </form>
        `,
        confirmButtonText: 'Update',
        confirmButtonColor: '#ffc107'
    }).then((result) => {
        if (result.isConfirmed) {
            // Handle update logic here
            showSuccessAlert('Invoice has been updated successfully.');
        }
    });
}

// Helper functions for consistent alerts
function showSuccessAlert(message) {
    return Swal.fire({
        ...commonConfig,
        title: 'Success!',
        text: message,
        icon: 'success',
        showCancelButton: false,
        timer: 2000,
        timerProgressBar: true
    });
}

function showErrorAlert(message) {
    return Swal.fire({
        ...commonConfig,
        title: 'Error!',
        text: message,
        icon: 'error',
        showCancelButton: false,
        confirmButtonColor: '#dc3545'
    });
}
        