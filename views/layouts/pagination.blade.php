<div class="row mt-4">
    <div class="col-sm-6">
        <div>
            <p class="mb-sm-0"> Showing {{ ($paginator->currentPage() - 1) * $paginator->perPage() + ($paginator->total() ? 1 : 0) }}  to {{ ($paginator->currentPage() - 1) * $paginator->perPage() + count($paginator) }}  of   {{ $paginator->total() }}  entries</p>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="float-sm-end">
            <ul class="pagination mb-sm-0">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <a href="javascript:void(0);" class="page-link">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                </li>
            @else
                <li class="page-item">
                    <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                </li>
            @endif
               
               
            </ul>
        </div>
    </div>
</div>