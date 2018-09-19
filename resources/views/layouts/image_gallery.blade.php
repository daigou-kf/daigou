<div id="{{$gallery_id}}" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        @foreach(range(0,count($data_array)-1) as $index)
            <li data-target="#{{$gallery_id}}" data-slide-to="{{$index}}"
                @if($index == 0) class="active" @endif></li>
        @endforeach
    </ol>
    <div class="carousel-inner">
        @foreach($data_array as $data)
            <div class="carousel-item @if($loop->index == 0) active @endif">
                @if($data['href'] != null) <a href="{{$data['href']}}"> @endif
                    <img class="d-block mx-auto" src="{{asset('storage/app/'.$data['src'])}}"
                         alt="{{$loop->index}} slide"
                         style="width:{{$width}}">
                    @if($data['href'] != null) </a> @endif
            </div>
        @endforeach
    </div>
    @if($has_button == true)
        <a class="carousel-control-prev" href="#{{$gallery_id}}" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon bg-info" aria-hidden="true" style="height:50px;width:50px"></span>
            <span class="sr-only">上一张</span>
        </a>
        <a class="carousel-control-next" href="#{{$gallery_id}}" role="button" data-slide="next">
            <span class="carousel-control-next-icon bg-info" aria-hidden="true" style="height:50px;width:50px"></span>
            <span class="sr-only">下一张</span>
        </a>
    @endif
</div>
