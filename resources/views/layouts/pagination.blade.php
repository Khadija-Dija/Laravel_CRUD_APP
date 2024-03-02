@if($paginator->hasPages())
    <div class="pagination">
        @if($paginator->onFirstPage())
            <a href="#" disabled>&laquo;</a>
        @else
            <a class="active-page" href="{{$paginator->previousPageUrl()}}">&laquo;</a>
        @endif
        @foreach( $elements as $elem )
            @if(is_string($elem))
                <a href="">{{$elem}}</a>
            @endif
            @if(is_array($elem))
                @foreach($elem as $page => $url)
                   @if($page == $paginator->currentPage())
                        <a class="active-page" href="#">{{$page}}</a>
                    @else
                        <a href="{{$url}}">{{$page}}</a>
                   @endif

                @endforeach
            @endif
        @endforeach
        @if($paginator->hasMorePages())
            <a href="{{$paginator->nextPageUrl()}}">&raquo;</a>
        @else
            <a href="#" disabled>&raquo;</a>
        @endif

    </div>
@endif
