<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 pointer-events-none flex flex-col gap-3"></div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
        /**
         * Unified Toast Notification System
         */
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            const types = {
                success: { bg: 'bg-white', text: 'text-gray-900', icon: 'fa-check-circle', iconColor: 'text-emerald-500', border: 'border-emerald-100' },
                error: { bg: 'bg-white', text: 'text-gray-900', icon: 'fa-times-circle', iconColor: 'text-red-500', border: 'border-red-100' },
                warning: { bg: 'bg-white', text: 'text-gray-900', icon: 'fa-exclamation-triangle', iconColor: 'text-amber-500', border: 'border-amber-100' },
                info: { bg: 'bg-white', text: 'text-gray-900', icon: 'fa-info-circle', iconColor: 'text-blue-500', border: 'border-blue-100' }
            };

            const config = types[type] || types.info;

            toast.className = `${config.bg} ${config.text} border ${config.border} pointer-events-auto min-w-[320px] max-w-md p-4 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.08)] flex items-start gap-4 transform transition-all duration-500 translate-x-[120%] opacity-0 backdrop-blur-md`;
            
            toast.innerHTML = `
                <div class="${config.iconColor} mt-0.5">
                    <i class="fas ${config.icon} text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-0.5">${type}</p>
                    <p class="text-sm font-medium leading-relaxed">${message}</p>
                </div>
                <button onclick="this.closest('div.pointer-events-auto').classList.add('translate-x-[120%]', 'opacity-0'); setTimeout(() => this.closest('div.pointer-events-auto').remove(), 500);" 
                        class="text-gray-300 hover:text-gray-900 transition-colors">
                    <i class="fas fa-times text-xs"></i>
                </button>
            `;

            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('translate-x-[120%]', 'opacity-0');
            });

            setTimeout(() => {
                if (toast.parentElement) {
                    toast.classList.add('translate-x-[120%]', 'opacity-0');
                    setTimeout(() => toast.remove(), 500);
                }
            }, 5000);
        };

        // Listen for Livewire notifications (single listener to prevent duplicates)
        if (window.Livewire) {
            Livewire.on('notify', (data) => {
                console.log('Livewire notify received:', data);
                // Handle both array and object formats
                const notifyData = Array.isArray(data) ? data[0] : data;
                if (notifyData && notifyData.message) {
                    console.log('Showing toast:', notifyData.message, notifyData.type);
                    window.showToast(notifyData.message, notifyData.type || 'success');
                } else {
                    console.error('Invalid notify data:', data);
                }
            });
        } else {
            // Fallback for when Livewire isn't ready yet
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('notify', (data) => {
                    const notifyData = Array.isArray(data) ? data[0] : data;
                    if (notifyData && notifyData.message) {
                        console.log('Showing toast (fallback):', notifyData.message, notifyData.type);
                        window.showToast(notifyData.message, notifyData.type || 'success');
                    }
                });
            });
        }

        // Listen for custom toaster events
        window.addEventListener('toaster:success', (e) => {
            window.showToast(e.detail.message || e.detail, 'success');
        });

        window.addEventListener('toaster:error', (e) => {
            window.showToast(e.detail.message || e.detail, 'error');
        });

        window.addEventListener('toaster:warning', (e) => {
            window.showToast(e.detail.message || e.detail, 'warning');
        });

        window.addEventListener('toaster:info', (e) => {
            window.showToast(e.detail.message || e.detail, 'info');
        });

        // Bridge Session Flashes to Toasts
        @if(session()->has('message'))
            window.addEventListener('DOMContentLoaded', () => {
                window.showToast("{{ session('message') }}", 'success');
            });
        @endif

        @if(session()->has('success'))
            window.addEventListener('DOMContentLoaded', () => {
                window.showToast("{{ session('success') }}", 'success');
            });
        @endif

        @if(session()->has('error'))
            window.addEventListener('DOMContentLoaded', () => {
                window.showToast("{{ session('error') }}", 'error');
            });
        @endif

        @if(session()->has('toaster'))
            @php
                $toaster = session('toaster');
            @endphp
            window.addEventListener('DOMContentLoaded', () => {
                window.showToast("{{ $toaster['message'] }}", '{{ $toaster['type'] }}');
            });
        @endif
    </script>
