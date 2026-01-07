<div class="sidebar-categories bg-white rounded-3xl shadow-sm border-2 border-gray-100 p-6 sticky top-24">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
        <h3 class="font-black text-xl text-toys-text flex items-center gap-2">
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
            Categories
        </h3>
    </div>

    <div class="space-y-2" id="sidebar-accordion">
        <a href="{{ route('shop.index') }}" 
           class="flex items-center p-3 rounded-2xl transition hover:bg-gray-50 group {{ !request('category') ? 'bg-primary/10 text-primary' : 'text-gray-600' }}">
            <span class="w-2 h-2 rounded-full mr-3 {{ !request('category') ? 'bg-primary' : 'bg-gray-300 group-hover:bg-primary' }}"></span>
            <span class="font-bold uppercase text-xs tracking-wider">All Toys</span>
        </a>

        @foreach($categories as $category)
            <div class="category-item">
                @if($category->children->count() > 0)
                    <div class="flex items-center justify-between p-3 rounded-2xl transition hover:bg-gray-50 cursor-pointer group {{ request('category') == $category->id ? 'bg-secondary/10' : '' }}"
                         onclick="toggleSidebarDropdown(this)">
                        <div class="flex items-center">
                            <span class="w-2 h-2 rounded-full mr-3 bg-gray-300 group-hover:bg-secondary {{ request('category') == $category->id ? 'bg-secondary' : '' }}"></span>
                            <span class="font-bold uppercase text-xs tracking-wider {{ request('category') == $category->id ? 'text-secondary' : 'text-gray-700' }}">{{ $category->name }}</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-300 arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                    
                    <div class="overflow-hidden transition-all duration-300 max-h-0 submenu pl-6 mt-1 space-y-1">
                        @foreach($category->children as $child)
                            <a href="{{ route('shop.index', ['category' => $child->id]) }}" 
                               class="block p-2 rounded-xl text-xs font-bold uppercase tracking-widest transition hover:text-secondary {{ request('category') == $child->id ? 'text-secondary bg-secondary/5' : 'text-gray-500' }}">
                                - {{ $child->name }}
                            </a>
                        @endforeach
                    </div>
                @else
                    <a href="{{ route('shop.index', ['category' => $category->id]) }}" 
                       class="flex items-center p-3 rounded-2xl transition hover:bg-gray-50 group {{ request('category') == $category->id ? 'bg-secondary/10 text-secondary' : 'text-gray-600' }}">
                        <span class="w-2 h-2 rounded-full mr-3 {{ request('category') == $category->id ? 'bg-secondary' : 'bg-gray-300 group-hover:bg-secondary' }}"></span>
                        <span class="font-bold uppercase text-xs tracking-wider">{{ $category->name }}</span>
                    </a>
                @endif
            </div>
        @endforeach
    </div>
</div>

<script>
function toggleSidebarDropdown(element) {
    const submenu = element.nextElementSibling;
    const arrow = element.querySelector('.arrow-icon');
    
    if (submenu.style.maxHeight && submenu.style.maxHeight !== '0px') {
        submenu.style.maxHeight = '0px';
        arrow.classList.remove('rotate-180');
    } else {
        // Close other submenus if needed (accordion behavior)
        // document.querySelectorAll('.submenu').forEach(s => s.style.maxHeight = '0px');
        // document.querySelectorAll('.arrow-icon').forEach(a => a.classList.remove('rotate-180'));
        
        submenu.style.maxHeight = submenu.scrollHeight + "px";
        arrow.classList.add('rotate-180');
    }
}

// Keep active category groups open on load
document.addEventListener('DOMContentLoaded', () => {
    const activeSubmenu = document.querySelector('.submenu .text-secondary');
    if (activeSubmenu) {
        const parentSubmenu = activeSubmenu.closest('.submenu');
        if (parentSubmenu) {
            parentSubmenu.style.maxHeight = parentSubmenu.scrollHeight + 'px';
            const arrow = parentSubmenu.previousElementSibling.querySelector('.arrow-icon');
            if (arrow) arrow.classList.add('rotate-180');
        }
    }
});
</script>
