<?php
    //số trang hiển thị = nPageShow nếu nPageShow là số lẻ
    //số trang hiển thị = nPageShow + 1 nếu nPageShow là số chẵn
    $nPageShow = 4;

    if ($nPageShow % 2 == 0) {
        $nPageShow = $nPageShow + 1;
    }

    if ($nPageShow < $paginator->lastPage()) {
        if ($paginator->currentPage() == 1) {
            $startPage  = 1;
            $endPage    = $nPageShow;
        } else if ($paginator->currentPage() == $paginator->lastPage()) {
            $startPage      = $paginator->lastPage() - $nPageShow + 1;
            $endPage        = $paginator->lastPage();
        } else {
            $startPage      = $paginator->currentPage() - ($nPageShow - 1) / 2;
            $endPage        = $paginator->currentPage() + ($nPageShow - 1) / 2;
            if ($startPage < 1) {
                $startPage  = 1;
                $endPage    = $endPage + 1;
            }
            if ($endPage > $paginator->lastPage()) {
                $startPage  = $endPage - $nPageShow + 1;
                $endPage    = $paginator->lastPage();
            }
        }
    } else {
        $startPage = 1;
        $endPage   = $paginator->lastPage();
    }
?>

@if ($paginator->lastPage() > 1)
    <ul class="pagination">
        @if ($paginator->currentPage() != 1)
            <li>
                <a href="{{ $paginator->url(1) }}">Đầu</a>
            </li>
            {{-- <li>
                <a href="{{ str_replace('/?', '?', $paginator->url($paginator->currentPage() - 1)) }}">&laquo;</a>
            </li> --}}
        @endif

        @for ($i = $startPage; $i <= $endPage; $i++)
            @if ($startPage <= $i && $i <= $endPage)
                <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endif
        @endfor

        @if ($paginator->currentPage() != $paginator->lastPage())
            {{-- <li>
                <a href="{{ str_replace('/?', '?', $paginator->url($paginator->currentPage() + 1)) }}">&raquo;</a>
            </li> --}}
            <li>
                <a href="{{ $paginator->url($paginator->lastPage()) }}">Cuối</a>
            </li>
        @endif
    </ul>
@endif
