// TODO: remove before prod
// Dev flag: THU{c0mm3nts_4r3_n0t_s3cr3ts}
// Admin panel backup: /admin/index.php

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input, textarea').forEach(function (field) {
        field.addEventListener('focus', function () {
            field.style.borderColor = '#d0f870';
        });
        field.addEventListener('blur', function () {
            field.style.borderColor = '#2c7d49';
        });
    });
});
