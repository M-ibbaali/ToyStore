<div id="alert-container" class="fixed top-24 right-8 z-50 flex flex-col gap-3 pointer-events-none min-w-[320px] max-w-sm">
    <!-- Server-side alerts -->
    @if(session('success'))
        <div class="alert-item animate-slide-in-right pointer-events-auto bg-green-500 text-white shadow-lg rounded-xl p-4 flex items-start gap-3 transform transition-all duration-500 translate-x-0 opacity-100 relative overflow-hidden" role="alert">
             <div class="p-1 bg-white/20 rounded-full shrink-0">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
             </div>
             <div class="flex-1">
                 <p class="font-bold text-sm">Success</p>
                 <p class="text-xs opacity-90 mt-0.5 leading-relaxed">{{ session('success') }}</p>
             </div>
             <button onclick="dismissAlert(this.closest('.alert-item'))" class="text-white/70 hover:text-white focus:outline-none transition-colors shrink-0">
                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
             </button>
             <div class="absolute bottom-0 left-0 h-1 bg-white/30 animate-progress w-full"></div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-item animate-slide-in-right pointer-events-auto bg-red-500 text-white shadow-lg rounded-xl p-4 flex items-start gap-3 transform transition-all duration-500 translate-x-0 opacity-100 relative overflow-hidden" role="alert">
             <div class="p-1 bg-white/20 rounded-full shrink-0">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
             </div>
             <div class="flex-1">
                 <p class="font-bold text-sm">Error</p>
                 <p class="text-xs opacity-90 mt-0.5 leading-relaxed">{{ session('error') }}</p>
             </div>
             <button onclick="dismissAlert(this.closest('.alert-item'))" class="text-white/70 hover:text-white focus:outline-none transition-colors shrink-0">
                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
             </button>
             <div class="absolute bottom-0 left-0 h-1 bg-white/30 animate-progress w-full"></div>
        </div>
    @endif

    @if(session('info'))
        <div class="alert-item animate-slide-in-right pointer-events-auto bg-blue-500 text-white shadow-lg rounded-xl p-4 flex items-start gap-3 transform transition-all duration-500 translate-x-0 opacity-100 relative overflow-hidden" role="alert">
             <div class="p-1 bg-white/20 rounded-full shrink-0">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
             </div>
             <div class="flex-1">
                 <p class="font-bold text-sm">Info</p>
                 <p class="text-xs opacity-90 mt-0.5 leading-relaxed">{{ session('info') }}</p>
             </div>
             <button onclick="dismissAlert(this.closest('.alert-item'))" class="text-white/70 hover:text-white focus:outline-none transition-colors shrink-0">
                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
             </button>
             <div class="absolute bottom-0 left-0 h-1 bg-white/30 animate-progress w-full"></div>
        </div>
    @endif
</div>

<script>
    // Initialize existing alerts
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.alert-item').forEach(alert => {
            scheduleDismiss(alert);
        });
    });

    function dismissAlert(element) {
        element.style.opacity = '0';
        element.style.transform = 'translateX(100%)';
        setTimeout(() => element.remove(), 500);
    }

    function scheduleDismiss(element) {
        setTimeout(() => {
            dismissAlert(element);
        }, 5000); // 5 seconds duration
    }

    // Global function to show alert via JS/AJAX
    window.showAlert = function(type, message) {
        const container = document.getElementById('alert-container');
        
        let bgColor = 'bg-blue-500';
        let iconPath = 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
        let title = 'Info';

        if(type === 'success') {
            bgColor = 'bg-green-500';
            iconPath = 'M5 13l4 4L19 7';
            title = 'Success';
        } else if (type === 'error') {
            bgColor = 'bg-red-500';
            iconPath = 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z';
            title = 'Error';
        }

        const alertHtml = `
            <div class="alert-item animate-slide-in-right pointer-events-auto ${bgColor} text-white shadow-lg rounded-xl p-4 flex items-start gap-3 transform transition-all duration-500 translate-x-full opacity-0 relative overflow-hidden" role="alert">
                 <div class="p-1 bg-white/20 rounded-full shrink-0">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${iconPath}"></path></svg>
                 </div>
                 <div class="flex-1">
                     <p class="font-bold text-sm">${title}</p>
                     <p class="text-xs opacity-90 mt-0.5 leading-relaxed">${message}</p>
                 </div>
                 <button onclick="dismissAlert(this.closest('.alert-item'))" class="text-white/70 hover:text-white focus:outline-none transition-colors shrink-0">
                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                 </button>
                 <div class="absolute bottom-0 left-0 h-1 bg-white/30 animate-progress w-full"></div>
            </div>
        `;

        // Create element from HTML string
        const template = document.createElement('template');
        template.innerHTML = alertHtml.trim();
        const element = template.content.firstElementChild;

        container.appendChild(element);

        // Trigger animation
        requestAnimationFrame(() => {
            element.classList.remove('translate-x-full', 'opacity-0');
            element.classList.add('translate-x-0', 'opacity-100');
        });

        // Auto dismiss
        scheduleDismiss(element);
    }
</script>

<style>
    @keyframes progress {
        from { width: 100%; }
        to { width: 0%; }
    }
    .animate-progress {
        animation: progress 5s linear forwards;
    }
</style>
