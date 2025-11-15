// js/add_cake_modal.js
document.addEventListener('DOMContentLoaded', function() {
    const modals = document.querySelectorAll(".modal"); // Bisa ada lebih dari satu
    const addCakeBtns = document.querySelectorAll(".add-cake-btn");

    addCakeBtns.forEach((btn) => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const modalId = btn.dataset.modal; // bisa buat data-modal="addProductModal"
            const modal = document.getElementById(modalId);
            if(modal) modal.style.display = "flex";
        });
    });

    modals.forEach((modal) => {
        const closeBtn = modal.querySelector(".close-btn");
        const cancelBtn = modal.querySelector(".cancel-btn");
        const form = modal.querySelector("form");
        const productImageInput = modal.querySelector('#productImage');
        const imagePreview = modal.querySelector('#imagePreview');
        const imageUploadArea = modal.querySelector('#imageUploadArea');

        function closeModal() {
            modal.style.display = "none";
            if(form) form.reset();
            if(imagePreview) imagePreview.innerHTML = '<i class="fas fa-image fa-3x placeholder-icon"></i>';
            if(imageUploadArea) imageUploadArea.classList.remove('has-image');
        }

        if(closeBtn) closeBtn.addEventListener('click', closeModal);
        if(cancelBtn) cancelBtn.addEventListener('click', closeModal);

        window.addEventListener('click', function(event) {
            if(event.target == modal) closeModal();
        });

        // Preview Image
        if(productImageInput) {
            productImageInput.addEventListener('change', function() {
                if(this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if(imagePreview) {
                            imagePreview.innerHTML = `<img src="${e.target.result}" alt="Product Image Preview">`;
                            imageUploadArea.classList.add('has-image');
                        }
                    }
                    reader.readAsDataURL(this.files[0]);
                } else {
                    if(imagePreview) {
                        imagePreview.innerHTML = '<i class="fas fa-image fa-3x placeholder-icon"></i>';
                        imageUploadArea.classList.remove('has-image');
                    }
                }
            });
        }

        // Drag & Drop
        if(imageUploadArea) {
            imageUploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                imageUploadArea.style.borderColor = '#ccc';
                const files = e.dataTransfer.files;
                if(files.length > 0) {
                    productImageInput.files = files;
                    productImageInput.dispatchEvent(new Event('change'));
                }
            });
            imageUploadArea.addEventListener('dragover', (e) => {e.preventDefault(); imageUploadArea.style.borderColor = '#8B0000';});
            imageUploadArea.addEventListener('dragleave', () => {imageUploadArea.style.borderColor = '#ccc';});
        }
    });
});
