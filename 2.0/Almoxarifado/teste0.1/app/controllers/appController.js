export function switchTab(tabId) {
  document.querySelectorAll('.tab-content').forEach((tab) => tab.classList.add('hidden'));
  document.getElementById(`tab-${tabId}`)?.classList.remove('hidden');

  document.querySelectorAll('.tab-btn').forEach((button) => {
    button.classList.remove('bg-blue-600', 'text-white', 'font-medium');
    button.classList.add('text-slate-400', 'hover:text-slate-200', 'hover:bg-slate-900');
  });

  const activeButton = document.getElementById(`btn-${tabId}`);
  if (activeButton) {
    activeButton.classList.remove('text-slate-400', 'hover:text-slate-200', 'hover:bg-slate-900');
    activeButton.classList.add('bg-blue-600', 'text-white', 'font-medium');
  }
}

export function openModal(modalId) {
  document.getElementById(modalId)?.classList.remove('hidden');
}

export function closeModal(modalId) {
  document.getElementById(modalId)?.classList.add('hidden');
}

export function showNotification(message, type = 'success') {
  const toast = document.getElementById('toast');
  const toastMessage = document.getElementById('toast-message');
  if (!toast || !toastMessage) return;

  toastMessage.textContent = message;

  if (type === 'error') {
    toast.classList.remove('bg-emerald-600', 'border-emerald-500');
    toast.classList.add('bg-rose-600', 'border-rose-500');
  } else {
    toast.classList.remove('bg-rose-600', 'border-rose-500');
    toast.classList.add('bg-emerald-600', 'border-emerald-500');
  }

  toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');
  setTimeout(() => {
    toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
  }, 3000);
}
