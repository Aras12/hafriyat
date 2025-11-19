    </div><!-- End Main Content -->

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        // DataTable
        $(document).ready(function() {
            if ($('.datatable').length) {
                $('.datatable').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json'
                    },
                    order: [[0, 'desc']]
                });
            }

            // CKEditor
            if ($('.ckeditor').length) {
                $('.ckeditor').each(function() {
                    CKEDITOR.replace(this.id);
                });
            }

            // Silme onayı
            $('.btn-delete').on('click', function(e) {
                if (!confirm('Bu kaydı silmek istediğinizden emin misiniz?')) {
                    e.preventDefault();
                }
            });

            // Slug otomatik oluşturma
            $('#title').on('blur', function() {
                const title = $(this).val();
                if (title && !$('#slug').val()) {
                    $.ajax({
                        url: 'ajax_slug.php',
                        method: 'POST',
                        data: { title: title },
                        success: function(slug) {
                            $('#slug').val(slug);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
