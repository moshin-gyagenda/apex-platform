{{-- Reusable confirmation modal (backend-style). Use via window.showConfirmModal() and window.showAlertModal() --}}
<div id="frontend-confirm-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-[100]">
    <div class="bg-white rounded-lg border border-gray-300 shadow-xl p-6 max-w-md w-full mx-4" onclick="event.stopPropagation()">
        <div class="flex items-start gap-4">
            <div id="frontend-confirm-modal-icon" class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
            </div>
            <div class="flex-1">
                <h3 id="frontend-confirm-modal-title" class="text-lg font-semibold text-gray-800">Confirm</h3>
                <p id="frontend-confirm-modal-message" class="mt-2 text-sm text-gray-600"></p>
                <div id="frontend-confirm-modal-actions" class="mt-4 flex gap-3">
                    <button type="button" id="frontend-confirm-modal-confirm" class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition-colors">
                        Confirm
                    </button>
                    <button type="button" id="frontend-confirm-modal-cancel" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                </div>
                <div id="frontend-confirm-modal-alert-only" class="mt-4 hidden">
                    <button type="button" id="frontend-confirm-modal-ok" class="w-full px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-lg hover:bg-primary-600 transition-colors">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    const modal = document.getElementById('frontend-confirm-modal');
    const titleEl = document.getElementById('frontend-confirm-modal-title');
    const messageEl = document.getElementById('frontend-confirm-modal-message');
    const iconWrap = document.getElementById('frontend-confirm-modal-icon');
    const actionsWrap = document.getElementById('frontend-confirm-modal-actions');
    const alertOnlyWrap = document.getElementById('frontend-confirm-modal-alert-only');
    const confirmBtn = document.getElementById('frontend-confirm-modal-confirm');
    const cancelBtn = document.getElementById('frontend-confirm-modal-cancel');
    const okBtn = document.getElementById('frontend-confirm-modal-ok');

    function closeModal() {
        if (modal) modal.classList.add('hidden');
    }

    function openModal() {
        if (modal) modal.classList.remove('hidden');
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    window.showConfirmModal = function(options) {
        var title = options.title || 'Confirm';
        var message = options.message || 'Are you sure?';
        var confirmText = options.confirmText || 'Yes, continue';
        var cancelText = options.cancelText || 'Cancel';
        var onConfirm = options.onConfirm || function() {};
        var danger = options.danger !== false;

        titleEl.textContent = title;
        messageEl.textContent = message;
        confirmBtn.textContent = confirmText;
        cancelBtn.textContent = cancelText;
        iconWrap.className = 'flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center ' + (danger ? 'bg-red-100' : 'bg-primary-100');
        confirmBtn.className = 'flex-1 px-4 py-2 text-sm font-medium text-white rounded-lg transition-colors ' + (danger ? 'bg-red-500 hover:bg-red-600' : 'bg-primary-500 hover:bg-primary-600');
        iconWrap.innerHTML = danger ? '<i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>' : '<i data-lucide="help-circle" class="w-6 h-6 text-primary-600"></i>';

        actionsWrap.classList.remove('hidden');
        alertOnlyWrap.classList.add('hidden');

        cancelBtn.onclick = function() { closeModal(); };
        confirmBtn.onclick = function() { closeModal(); onConfirm(); };

        modal.onclick = function(e) { if (e.target === modal) closeModal(); };
        openModal();
    };

    window.showAlertModal = function(options) {
        var title = options.title || 'Notice';
        var message = options.message || '';
        var isError = options.type === 'error';

        titleEl.textContent = title;
        messageEl.textContent = message;
        iconWrap.className = 'flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center ' + (isError ? 'bg-red-100' : 'bg-amber-100');
        iconWrap.innerHTML = isError ? '<i data-lucide="alert-circle" class="w-6 h-6 text-red-600"></i>' : '<i data-lucide="info" class="w-6 h-6 text-amber-600"></i>';

        actionsWrap.classList.add('hidden');
        alertOnlyWrap.classList.remove('hidden');

        okBtn.onclick = function() { closeModal(); };
        modal.onclick = function(e) { if (e.target === modal) closeModal(); };
        openModal();
    };

    if (okBtn) okBtn.onclick = closeModal;
})();
</script>
