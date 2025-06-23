@props(['class_form'])
<script>
    function confirmDelete(els) {
        document.querySelectorAll(els).forEach((form) => {
            form.addEventListener("submit", function (e) {
                e.preventDefault();

                Swal.fire({
                    title: "{{ __('t.are_you_sure') ?? 'Are you sure' }}",
                    text: "{{ __('t.this_action_cannot_be_undone') ?? 'This action cannot be undone' }}",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    cancelButtonColor: "#005f73",
                    confirmButtonText: "{{ __('t.yes_delete_it') ?? 'Yes, delete it' }}",
                    cancelButtonText: "{{ __('t.cancel') ?? 'cancel' }}",
                    customClass: {
                        popup: 'swal-dark'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        confirmDelete("{{ $class_form }}");
    });
</script>
