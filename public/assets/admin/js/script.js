// Password toggle  | data-pw-toggle -> for input, data-pw-toggle-btn -> for toggle button
$(document).on('click', '[data-pw-toggle-btn]', function () {
    const $input = $(this).siblings('[data-pw-toggle]');
    $input.attr('type', $input.attr('type') === 'password' ? 'text' : 'password');
    $(this).children('i').toggleClass('bi-eye bi-eye-slash');
});

const imagePlaceholder = document.currentScript.dataset.imagePlaceholder;

window.setImageFallback = function (image) {
    if (image instanceof HTMLImageElement && image.src !== imagePlaceholder) {
        image.src = imagePlaceholder;
    }
};

document.addEventListener('error', function (event) {
    if (event.target instanceof HTMLImageElement) {
        window.setImageFallback(event.target);
    }
}, true);

document.querySelectorAll('img').forEach(function (image) {
    const source = image.getAttribute('src');

    if (!source || !source.trim() || (image.complete && image.naturalWidth === 0)) {
        window.setImageFallback(image);
    }
});

$(function () {
    $('[data-select-all]').each(function () {
        const $master = $(this);
        const rowSelector = 'tbody ' + $master.data('select-all');
        const $scope = $master.closest('table');
        const $bulkBar = $('#bulkBar');

        function updateState() {
            const $rows = $scope.find(rowSelector);
            const checkedCount = $rows.filter(':checked').length;

            $master.prop('checked', $rows.length > 0 && checkedCount === $rows.length);
            $master.prop('indeterminate', checkedCount > 0 && checkedCount < $rows.length);

            $bulkBar.find('.bulk-count').text(`${checkedCount} selected`);
            $bulkBar.toggleClass('d-none', checkedCount === 0);
        }

        $master.on('change', function () {
            $scope.find(rowSelector).prop('checked', $master.is(':checked'));
            updateState();
        });

        $scope.on('change', rowSelector, updateState);

        $bulkBar.on('click', '#bulkClear', function () {
            $scope.find(rowSelector).prop('checked', false);
            $master.prop('checked', false).prop('indeterminate', false);
            updateState();
        });

        updateState();
    });
});
