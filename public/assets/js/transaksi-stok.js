// Transaksi Stok JavaScript

document.addEventListener("DOMContentLoaded", function () {
    // Auto-submit form ketika jenis transaksi dipilih (jika dibutuhkan)
    const jenisTransaksiSelect = document.getElementById("jenisTransaksi");
    if (jenisTransaksiSelect && !jenisTransaksiSelect.disabled) {
        jenisTransaksiSelect.addEventListener("change", function () {
            // Auto submit bisa diaktifkan jika diperlukan
            // this.form.submit();
        });
    }

    // Form validation untuk form transaksi
    const forms = document.querySelectorAll(".needs-validation");
    forms.forEach(function (form) {
        form.addEventListener("submit", function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add("was-validated");
        });
    });

    // Loading indicator pada tombol submit
    const loadingButtons = document.querySelectorAll(".loading-indicator");
    loadingButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            const spinner = this.querySelector(".spinner-loading");
            const icon = this.querySelector(".icon-default");
            const text = this.querySelector(".btn-text");

            if (spinner && icon && text) {
                // Disable button to prevent double submit
                this.disabled = true;

                // Show spinner, hide icon
                spinner.style.display = "inline-block";
                icon.style.display = "none";

                // Change text
                text.textContent = " Memproses...";

                // Re-enable button after 5 seconds (fallback)
                setTimeout(() => {
                    this.disabled = false;
                    spinner.style.display = "none";
                    icon.style.display = "inline-block";
                }, 5000);
            }
        });
    });

    // Confirm delete untuk hapus item dari keranjang
    const deleteButtons = document.querySelectorAll(
        'button[type="submit"][onclick*="confirm"]'
    );
    deleteButtons.forEach(function (button) {
        button.addEventListener("click", function (event) {
            if (
                !confirm(
                    "Apakah Anda yakin ingin menghapus item ini dari keranjang?"
                )
            ) {
                event.preventDefault();
            }
        });
    });
});

// Function untuk reset form setelah berhasil menambah ke keranjang
function resetTransactionForm() {
    const form = document.querySelector('form[action*="add-to-cart"]');
    if (form) {
        // Reset selected options kecuali yang disabled
        const selects = form.querySelectorAll("select:not([disabled])");
        selects.forEach((select) => {
            select.selectedIndex = 0;
        });

        // Reset input numbers
        const numberInputs = form.querySelectorAll('input[type="number"]');
        numberInputs.forEach((input) => {
            input.value = "";
        });

        // Remove validation classes
        form.classList.remove("was-validated");

        // Focus ke select barang
        const barangSelect = document.getElementById("barang");
        if (barangSelect) {
            barangSelect.focus();
        }
    }
}

// Auto-focus ke field yang perlu diisi
window.addEventListener("load", function () {
    const jenisTransaksiSelect = document.getElementById("jenisTransaksi");
    const barangSelect = document.getElementById("barang");

    if (
        jenisTransaksiSelect &&
        !jenisTransaksiSelect.disabled &&
        jenisTransaksiSelect.selectedIndex === 0
    ) {
        jenisTransaksiSelect.focus();
    } else if (barangSelect && barangSelect.selectedIndex === 0) {
        barangSelect.focus();
    }
});
