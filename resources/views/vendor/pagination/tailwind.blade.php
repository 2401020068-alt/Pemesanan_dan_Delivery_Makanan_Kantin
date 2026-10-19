@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden gap-2">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-xs font-semibold text-gray-400 bg-gray-50 border border-[#E5ECE7] cursor-not-allowed rounded-xl">
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-[#1A241E] bg-white border border-[#E5ECE7] rounded-xl hover:bg-[#F4F6F4] transition">
                    Sebelumnya
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-[#1A241E] bg-white border border-[#E5ECE7] rounded-xl hover:bg-[#F4F6F4] transition">
                    Berikutnya
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-xs font-semibold text-gray-400 bg-gray-50 border border-[#E5ECE7] cursor-not-allowed rounded-xl">
                    Berikutnya
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs text-[#76847B]">
                    Menampilkan
                    @if ($paginator->firstItem())
                        <span class="font-bold text-[#1A241E]">{{ $paginator->firstItem() }}</span>
                        sampai
                        <span class="font-bold text-[#1A241E]">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    dari
                    <span class="font-bold text-[#1A241E]">{{ $paginator->total() }}</span>
                    hasil menu
                </p>
            </div>

            <div>
                <span class="inline-flex items-center gap-1 shadow-xs rounded-xl">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Sebelumnya">
                            <span class="inline-flex items-center px-3 py-2 text-xs font-semibold text-gray-300 bg-white border border-[#E5ECE7] cursor-not-allowed rounded-xl" aria-hidden="true">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-3 py-2 text-xs font-semibold text-[#4A584F] bg-white border border-[#E5ECE7] rounded-xl hover:bg-[#F1F5F2] hover:text-[#1A241E] transition" aria-label="Sebelumnya">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="inline-flex items-center px-3.5 py-2 text-xs font-medium text-[#76847B] bg-white border border-[#E5ECE7] rounded-xl cursor-default">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="inline-flex items-center px-3.5 py-2 text-xs font-bold text-white bg-[#1F3E2C] border border-[#1F3E2C] rounded-xl cursor-default shadow-xs">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center px-3.5 py-2 text-xs font-semibold text-[#4A584F] bg-white border border-[#E5ECE7] rounded-xl hover:bg-[#F1F5F2] hover:text-[#1A241E] transition" aria-label="Halaman {{ $page }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-3 py-2 text-xs font-semibold text-[#4A584F] bg-white border border-[#E5ECE7] rounded-xl hover:bg-[#F1F5F2] hover:text-[#1A241E] transition" aria-label="Berikutnya">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="Berikutnya">
                            <span class="inline-flex items-center px-3 py-2 text-xs font-semibold text-gray-300 bg-white border border-[#E5ECE7] cursor-not-allowed rounded-xl" aria-hidden="true">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
