@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                    <i data-acorn-icon="chevron-left"></i>
                </a>
            </li>
            @else
            <li>
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i data-acorn-icon="chevron-left"></i></a>
            </li>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page">
                            <a class="page-link">{{ $page }}</a>
                        </li>
                        @else
                        <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
            <li>
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i data-acorn-icon="chevron-right"></i></a>
            </li>
            @else
                <li class="page-link disabled" aria-disabled="true">
                    <span aria-hidden="true"><i data-acorn-icon="chevron-right"></i></span>
                </li>
            @endif
            {{-- <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">
                    <i data-acorn-icon="chevron-right"></i>
                </a>
            </li> --}}
        </ul>
    </nav>
@endif
