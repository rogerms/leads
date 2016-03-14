@if ($count = 0) @endif
<div class="row">
    @foreach($drawings as $drawing)
        <div class="col-md-3 sketch-nail" id="{{ $drawing->id }}" data-drawingid="{{ $drawing->id }}">
            <div class="thumbnail tbn-item {{ $drawing->selected? 'active': '' }}" id="dw-{{ $drawing->id }}">
                <div class="caption ">
                    <p>{{ $drawing->title }}</p>
                    <a href="/drawings/{{$drawing->path}}" class="sketch-tbn"><i class="glyphicon glyphicon-picture"></i></a>
                </div>
            </div>
        </div>
        @if (++$count % 4 == 0)</div> <div class="row"> @endif
    @endforeach
</div>

    {{--<a href="/drawings/{{$drawing->path}}" class="sketch-tbn" >--}}
        {{--<img src="/drawings/placeholder.png"  alt="sketch" id="drawing-{{ $drawing->id }}"--}}
             {{--class="img-rounded sketch-nail {{ ($drawing->selected)? 'active': '' }}"--}}
             {{--data-drawingid="{{ $drawing->id }}">--}}
        {{--<h5>Label Head</h5>--}}
    {{--</a>--}}



