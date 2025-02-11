document.addEventListener("DOMContentLoaded", function () {
    // Konfirmasi sebelum menghapus pengguna
    let deleteLinks = document.querySelectorAll(".delete");

    deleteLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
            let confirmDelete = confirm("Apakah Anda yakin ingin menghapus pengguna ini?");
            if (!confirmDelete) {
                event.preventDefault();
            }
        });
    });
});