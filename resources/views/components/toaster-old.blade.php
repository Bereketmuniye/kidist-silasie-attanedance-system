<div x-data="toaster()" x-init="init()" class="fixed top-4 right-4 z-50 space-y-2" style="max-width: 400px;">
    <template x-for="notification in notifications" :key="notification.id">
        <div x-data="notificationItem(notification)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 translate-x-full"
             :class="getNotificationClasses(notification.type)"
             class="flex items-center gap-3 p-4 rounded-lg shadow-lg border">
            
            <!-- Icon -->
            <div class="flex-shrink-0">
                <svg x-show="notification.type === 'success'" class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <svg x-show="notification.type === 'error'" class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <svg x-show="notification.type === 'warning'" class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <svg x-show="notification.type === 'info'" class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
            </div>
            
            <!-- Content -->
            <div class="flex-1 min-w-0">
                <p x-text="notification.message" class="text-sm font-medium"></p>
                <p x-show="notification.description" x-text="notification.description" class="text-xs opacity-75 mt-1"></p>
            </div>
            
            <!-- Close button -->
            <button @click="close()" class="flex-shrink-0 p-1 rounded-md hover:bg-black/10 transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
</div>

<script>
function toaster() {
    return {
        notifications: [],
        
        init() {
            // Store reference for global access
            window.toasterInstance = this;
            
            // Listen for custom events to add notifications
            window.addEventListener('toaster:add', (event) => {
                this.add(event.detail);
            });
            
            // Listen for Livewire dispatched events
            window.addEventListener('toaster:success', (event) => {
                this.add({
                    type: 'success',
                    message: event.detail.message || event.detail,
                    description: event.detail.description
                });
            });
            
            window.addEventListener('toaster:error', (event) => {
                this.add({
                    type: 'error',
                    message: event.detail.message || event.detail,
                    description: event.detail.description
                });
            });
            
            window.addEventListener('toaster:warning', (event) => {
                this.add({
                    type: 'warning',
                    message: event.detail.message || event.detail,
                    description: event.detail.description
                });
            });
            
            window.addEventListener('toaster:info', (event) => {
                this.add({
                    type: 'info',
                    message: event.detail.message || event.detail,
                    description: event.detail.description
                });
            });
        },
        
        add(notification) {
            const id = Date.now() + Math.random();
            const newNotification = {
                id,
                type: notification.type || 'info',
                message: notification.message || 'Notification',
                description: notification.description || null,
                duration: notification.duration || 5000
            };
            
            this.notifications.push(newNotification);
            
            // Auto-remove after duration
            if (newNotification.duration > 0) {
                setTimeout(() => {
                    this.remove(id);
                }, newNotification.duration);
            }
        },
        
        remove(id) {
            const index = this.notifications.findIndex(n => n.id === id);
            if (index > -1) {
                this.notifications.splice(index, 1);
            }
        },
        
        success(message, description = null, duration = 5000) {
            this.add({ type: 'success', message, description, duration });
        },
        
        error(message, description = null, duration = 5000) {
            this.add({ type: 'error', message, description, duration });
        },
        
        warning(message, description = null, duration = 5000) {
            this.add({ type: 'warning', message, description, duration });
        },
        
        info(message, description = null, duration = 5000) {
            this.add({ type: 'info', message, description, duration });
        },
        
        clear() {
            this.notifications = [];
        }
    };
}

function notificationItem(notification) {
    return {
        show: true,
        
        close() {
            this.show = false;
            setTimeout(() => {
                window.toasterInstance.remove(notification.id);
            }, 200);
        },
        
        getNotificationClasses(type) {
            const baseClasses = 'flex items-center gap-3 p-4 rounded-lg shadow-lg border';
            
            const typeClasses = {
                success: 'bg-green-50 border-green-200 text-green-800',
                error: 'bg-red-50 border-red-200 text-red-800',
                warning: 'bg-yellow-50 border-yellow-200 text-yellow-800',
                info: 'bg-blue-50 border-blue-200 text-blue-800'
            };
            
            return baseClasses + ' ' + (typeClasses[type] || typeClasses.info);
        }
    };
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Find the toaster element and store its Alpine.js instance
    setTimeout(() => {
        const toasterElement = document.querySelector('[x-data*="toaster"]');
        if (toasterElement && toasterElement._x_dataStack) {
            window.toasterInstance = toasterElement._x_dataStack[0];
        }
    }, 100);
});
</script>
