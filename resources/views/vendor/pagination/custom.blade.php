

<div class="eskimo-pager">
    <ul class='pagination flex-wrap'>
        @foreach ($elements as $element)
            @if ($paginator->onFirstPage())
                
            @else 
            <li class='page-item'><a class='page-link' href="{{ $paginator->previousPageUrl() }}"><i class="fa fa-chevron-left"></i></a></li>
            @endif 

                @if (is_string($element)) 
                <li class='page-item active'><a class='page-link' href='#'>1</a></li>
                @endif
                
                @if (is_array($element)) 
                @foreach ($element as $page => $url) 
                @if ($page == $paginator->currentPage()) 

                <li class='page-item active'><a class='page-link'>{{ $page }}</a></li>

                @else 

                <li class="page-item">
                    <a href="{{ $url }}" class="page-link"> {{ $page }} </a>
                </li>

                @endif 
                @endforeach 
                @endif 

            @if ($paginator->hasMorePages()) 
            <li class='page-item'><a class='page-link' href="{{ $paginator->nextPageUrl() }}"><i class="fa fa-chevron-right"></i></a></li>
            @else
                
            @endif
        @endforeach 
    </ul>
</div>
<div class="clearfix"></div>