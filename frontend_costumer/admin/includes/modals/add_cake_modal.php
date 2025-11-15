<div id="addProductModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add Cake</h2>
            <span class="close-btn">&times;</span>
        </div>
        
        <form id="addProductForm" action="add_product_process.php" method="POST" enctype="multipart/form-data">
            <div class="form-body">
                <div class="form-left">
                    <div class="form-group">
                        <label for="productName">Nama Kue</label>
                        <input type="text" id="productName" name="product_name" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="kategori_product" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Custom Cake">Custom Cake 🎂</option>
                            <option value="Mille Crepes">Mille Crepes 🍰</option>
                            <option value="Soft Cookies">Soft Cookies 🍪</option>
                            <option value="Cheesecake">Cheesecake 🧁</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Harga</label>
                        <input type="number" id="price" name="price" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="diameter">Diameter (cm)</label>
                        <input type="number" id="diameter" name="diameter" placeholder="Contoh: 18" min="1" required>
                    </div>
                </div>

                <div class="form-right">
                    <div class="image-upload-area" id="imageUploadArea">
                        <div class="image-preview" id="imagePreview">
                            <i class="fas fa-image fa-3x placeholder-icon"></i>
                        </div>
                        <input type="file" id="productImage" name="product_image" accept="image/*" hidden required>
                        <label for="productImage" class="browse-btn">Browse Files</label>
                        <p class="drag-drop-text">Drag and drop files here</p>
                    </div>
                </div>
            </div>

            <div class="form-actions-custom">
                <button type="button" class="btn-custom-cancel cancel-btn">Cancel</button>
                <button type="submit" class="btn-custom-add">Add</button>
            </div>
        </form>
    </div>
</div>
