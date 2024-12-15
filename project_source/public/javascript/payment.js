document.getElementById("sendReport").addEventListener("click", function () {
    const description = document.getElementById("reportDescription").value;
    const evidence = document.getElementById("evidenceUpload").files[0];

    if (description.trim() === "") {
        alert("Please provide a description.");
        return;
    }

    const modal = bootstrap.Modal.getInstance(
        document.getElementById("reportModal")
    );
    modal.hide();
});

document.getElementById("confirmButton").addEventListener("click", function () {
    window.location.href = "payment";
});
