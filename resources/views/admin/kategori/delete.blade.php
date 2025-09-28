
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteKategoriModal" tabindex="-1" aria-labelledby="deleteKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteKategoriModalLabel">
                    <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus Kategori
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="bi bi-trash text-danger" style="font-size: 4rem;"></i>
                </div>
                <h5 class="text-center mb-3">Apakah Anda yakin ingin menghapus kategori ini?</h5>
                <div id="kategori-info" class="alert alert-warning">
                    <strong>Kategori:</strong> <span id="kategori-name"></span><br>
                    <strong>Jumlah Buku:</strong> <span id="kategori-books-count"></span> buku
                </div>
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. Semua buku yang menggunakan kategori ini akan kehilangan referensi kategorinya.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </button>
                <form id="delete-form" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Ya, Hapus Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(kategoriId, kategoriName, booksCount, deleteUrl) {
    document.getElementById('kategori-name').textContent = kategoriName;
    document.getElementById('kategori-books-count').textContent = booksCount;
    document.getElementById('delete-form').action = deleteUrl;
    
    var modal = new bootstrap.Modal(document.getElementById('deleteKategoriModal'));
    modal.show();
}
</script>
