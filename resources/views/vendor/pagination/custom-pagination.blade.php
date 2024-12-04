<div class="custom-pagination">
    @if ($paginator->hasPages())
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled"><span>&laquo;</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            {{-- First Page Link --}}
            @if ($paginator->lastPage() > 5)
                @if ($paginator->currentPage() > 3)
                    <li><a href="{{ $paginator->url(1) }}" class="first-page">First</a></li>
                @endif

                @if ($paginator->currentPage() > 4)
                    <li class="disabled"><span>...</span></li>
                @endif
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            @if ($page >= $paginator->currentPage() - 1 && $page <= $paginator->currentPage() + 1)
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Last Page Link --}}
            @if ($paginator->lastPage() > 5)
                @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                    <li class="disabled"><span>...</span></li>
                @endif

                @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                    <li><a href="{{ $paginator->url($paginator->lastPage()) }}" class="last-page">Last</a></li>
                @endif
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="disabled"><span>&raquo;</span></li>
            @endif
        </ul>
    @endif
</div>