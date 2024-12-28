<div class="custom-pagination">
    @if ($paginator->hasPages())
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled"><span>&laquo;</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            {{-- First Page Link and Dots --}}
            @if ($paginator->currentPage() > 3)
                <li><a href="{{ $paginator->url(1) }}">1</a></li>
                @if ($paginator->currentPage() > 4)
                    <li class="disabled"><span>...</span></li>
                @endif
            @endif

            {{-- Pagination Elements --}}
            @foreach (range(1, $paginator->lastPage()) as $page)
                @if ($page == $paginator->currentPage())
                    <li class="active"><span>{{ $page }}</span></li>
                @elseif ($page >= $paginator->currentPage() - 2 && $page <= $paginator->currentPage() + 2)
                    <li><a href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
                @endif
            @endforeach

            {{-- Last Page Link and Dots --}}
            @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                    <li class="disabled"><span>...</span></li>
                @endif
                <li><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
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
