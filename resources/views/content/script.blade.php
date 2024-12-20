<script type="text/javascript">
   $(document).ready(function () {
    var table = $("#table-content").DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('content') }}",
            type: "GET",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        },
        columns: [
            {
                data: null,
                render: (data, type, row, meta) => {
                    return meta.row + 1;
                },
            },
            {
                data: "title",
                render: function (data, type, row) {
                    return data ? data : "N/A";
                }
            },
            {
                data: "content",
                render: function (data, type, row) {
                    return data ? data : "pemilik";
                }
            },
            {
                data: "image_url",
                render: function (data, type, row) {
                    if (data && data.length > 0) {
                        const imageUrl = `${data}`;
                        return `<img class="img-profile rounded-circle"
                                src="${imageUrl}"
                                alt="Content Image"
                                style="width:50px;height:50px;">`;
                    }
                    return 'No image';
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return ` <div class="d-flex gap-2 justify-content-start">
                        <a href="/content/show/${data.id}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-info-circle"></i>
                        </a>
                        <a href="/content/edit/${data.id}" class="btn btn-sm btn-warning">
                            <i class="fas fa-pen"></i>
                        </a>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${data.id}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        </div>`;
                },
            },
        ],
        initComplete: function () {
            // Add custom padding and margin to search and show controls
            $('.dataTables_filter input').addClass('px-3'); // Adds padding to search box
            $('.dataTables_length select').addClass('px-3'); // Adds padding to entries select
            $('.dataTables_info').addClass('px-3'); // Adds padding to info display
        }
    });

    // Delete action (for the delete button functionality)
    $("#table-content").on("click", ".delete-btn", function () {
        const surveyId = $(this).data("id");
        deleteSurvey(surveyId);
    });
});

function deleteSurvey(surveyId) {
    Swal.fire({
        title: "Apakah Anda Yakin?",
        text: `Anda yakin menghapus data ini?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/content/destroy/${surveyId}`,
                type: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function () {
                    Swal.fire({
                        icon: "success",
                        title: "Deleted!",
                        text: `Data survey berhasil dihapus.`,
                        timer: 2000,
                    });
                    $("#table-content").DataTable().ajax.reload();
                },
                error: function () {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Gagal menghapus data. Silakan coba lagi.",
                    });
                },
            });
        }
    });
}

        </script>
