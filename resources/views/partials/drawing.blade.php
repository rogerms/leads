@if ($count = 0) @endif
<div class="row">
    @foreach($drawings as $drawing)
        <div class="col-md-3 sketch-nail" id="{{ $drawing->id }}" data-drawingid="{{ $drawing->id }}" data-label="{{ $drawing->label }}">
            <div class="thumbnail tbn-item visibility-{{ $drawing->selected }}"  id="dw-{{ $drawing->id }}">
                <div class="caption ">
                    <p id="label">{{ $drawing->label }}</p>
                    <a href="/drawings/{{$drawing->path}}" class="sketch-tbn"><i class="glyphicon glyphicon-picture"></i></a>
                    <a href="/drawings/{{$drawing->path}}"><i class="glyphicon glyphicon-resize-full"></i></a>
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



