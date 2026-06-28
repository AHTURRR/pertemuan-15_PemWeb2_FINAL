import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    if (window.bootstrap) {
        [...tooltipTriggerList].forEach((tooltipTriggerEl) => new window.bootstrap.Tooltip(tooltipTriggerEl));
    }

    const toast = document.querySelector('.toast-message');
    if (toast && window.Swal) {
        window.Swal.fire({
            toast: true,
            position: 'top-end',
            icon: toast.dataset.type || 'success',
            title: toast.dataset.message || 'Aksi berhasil diproses.',
            showConfirmButton: false,
            timer: 2800,
            timerProgressBar: true,
        });
    }

    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (form.dataset.confirmed === 'true') {
                return;
            }

            event.preventDefault();

            window.Swal.fire({
                title: form.dataset.confirmTitle || 'Konfirmasi aksi',
                text: form.dataset.confirmText || 'Apakah Anda yakin ingin melanjutkan?',
                icon: form.dataset.confirmIcon || 'warning',
                showCancelButton: true,
                confirmButtonText: form.dataset.confirmButton || 'Ya, lanjutkan',
                cancelButtonText: form.dataset.cancelButton || 'Batalkan',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.dataset.confirmed = 'true';
                    form.requestSubmit();
                }
            });
        });
    });

    document.querySelectorAll('form[data-loading="true"], form:not([data-no-loading])').forEach((form) => {
        form.addEventListener('submit', () => {
            if (form.dataset.confirm !== undefined && form.dataset.confirmed !== 'true') {
                return;
            }

            if (form.dataset.waiting === 'true') {
                return;
            }

            form.dataset.waiting = 'true';
            const submitter = form.querySelector('button[type="submit"]');

            if (submitter) {
                submitter.disabled = true;
                submitter.dataset.originalHtml = submitter.innerHTML;
                submitter.innerHTML = '<span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span>Memproses...</span>';
            }
        });
    });

    document.querySelectorAll('input[required], select[required], textarea[required]').forEach((field) => {
        field.addEventListener('input', () => {
            field.classList.toggle('is-valid', field.checkValidity() && field.value.trim() !== '');
            field.classList.toggle('is-invalid', !field.checkValidity() && field.value.trim() !== '');
        });
    });

    document.querySelectorAll('[data-table-search]').forEach((input) => {
        const target = document.querySelector(input.dataset.tableSearch);
        if (!target) return;

        input.addEventListener('input', () => {
            const keyword = input.value.toLowerCase();
            const items = target.querySelectorAll('tbody tr, [class*="col-"]');
            items.forEach((item) => {
                item.hidden = !item.textContent.toLowerCase().includes(keyword);
            });
        });
    });

    document.querySelectorAll('[data-loading-link]').forEach((link) => {
        link.addEventListener('click', () => {
            link.classList.add('disabled');
            link.dataset.originalHtml = link.innerHTML;
            link.innerHTML = '<span class="spinner-border spinner-border-sm" aria-hidden="true"></span><span>Memproses...</span>';
        });
    });
});
