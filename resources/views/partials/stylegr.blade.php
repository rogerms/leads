<div class="row style-group-title">
    <h5 class=""><span class="glyphicon glyphicon-minus-sign toggle-box" id="{{ $stylegroup->id }}"></span>Paver Style Group <span class="group-count">{{ $count }}</span></h5>
</div>
<div class="style-sheet" name="ss{{ $stylegroup->id }}" id="{{ $stylegroup->id }}" >
    <div class="style-rows">
    @foreach($stylegroup->styles as $style)
        <div class="style-row" id="{{ $style->id }}">
            <div class="row" >
                <div class="form-group col-md-3">
                    <label for="paverstyle">Paver Style</label>
                    <input type="text" class="form-control" name="paverstyle" id="paverstyle" value="{{ $style->style }}" placeholder="Paver Style">
                </div>
                {{--<div class="form-group col-md-3">--}}
                    {{--<label for="manufacturer">Paver Manufacturer</label>--}}
                    {{--<input type="text" class="form-control" name="manufacturer" id="manufacturer" value="{{ $style->manufacturer }}" placeholder="Paver Manufacturer">--}}
                {{--</div>--}}
                <div class="form-group col-md-3">
                    <label for="pavercolor">Paver Color</label>
                    <input type="text" class="form-control" name="pavercolor"  id="pavercolor" value="{{ $style->color }}" placeholder="Paver Color">
                </div>
                <div class="form-group col-md-3">
                    <label for="paversize">Paver Size</label>
                    <input type="text" class="form-control" name="paversize"  id="paversize" value="{{ $style->size }}" placeholder="Paver Size">
                </div>
                <div class="form-group col-md-2">
                    <label for="sqft">SQ/FT</label>
                    <input type="text" class="form-control" name="sqft"  id="sqft" value="{{ $style->sqft }}" placeholder="0">
                </div>
                <div class="form-group col-md-1">
                    <label for="weight">Weight</label>
                    <input type="text" class="form-control" name="weight"  id="weight" value="{{ $style->weight }}" placeholder="0">
                </div>
            </div>  <!-- /row -->
            @can('read-job')
            <div class="row inner-row">
                <div class="form-group col-md-2">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" name="price"  id="price" value="{{ $style->price }}" placeholder="0.00">
                </div>
                <div class="form-group col-sm-2">
                    <label for="palets">Quantity</label>
                    <div class="input-group" id="">
                        <span class="input-group-addon qty-value">
                            <input type="text" class="form-control" id="qty" placeholder="qty" value="{{ $style->qty }}">
                        </span>
                        <span class="input-group-addon qty-unit">
                            <input type="text" class="form-control" id="qty_unit" placeholder="unit" value="{{ $style->qty_unit }}">
                        </span>
                    </div>
                </div>

                <div class="form-group col-md-2 center-box">
                    <label class="checkbox-inline">
                        <input type="checkbox" id="tumbled" name="tumbled" {{ isChecked($style->tumbled) }}>Tumbled
                    </label>
                </div>
            </div>
            @endcan
        </div>
    @endforeach
    </div><!-- / styles -->
    @can('edit-job')
    <div class="row row-extra-pad">
        <button type="button" class="btn btn-primary btn-xs add-style" name="add-style">Add Style</button>
    </div>
    @endcan
    <div class="row">
        <div class="form-group col-md-2">
            <label for="delivered">Manufacturer</label>
            <input type="text" class="form-control" name="manu"  id="manu" value="{{ $stylegroup->manufacturer }}" placeholder="name">
        </div>
        <div class="form-group col-md-2">
            <label for="portland">Number of Portlands</label>
            <input type="text" class="form-control" name="portland" id="portland" value="{{ $stylegroup->portlands }}" placeholder="0">
        </div>
        <div class="form-group col-md-3">
            <label for="orderedby">Ordered by</label>
            <input type="text" class="form-control" name="orderedby"  id="orderedby" value="{{ $stylegroup->orderedby }}" placeholder="Name">
        </div>
        <div class="form-group col-md-3">
            <label for="handledby">Delivery Handled by</label>
            <input type="text" class="form-control" name="handledby"  id="handledby" value="{{ $stylegroup->handledby }}" placeholder="Name">
        </div>
        <div class="form-group col-md-2">
            <label for="delivery">Delivery Date</label>
            <input type="date" class="form-control" name="delivery"  id="delivery" value="{{ toInputDate($stylegroup->delivery_at) }}" placeholder="mm/dd/yyyy">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label for="placementnote">Notes for placing pavers</label>
            <input type="text" class="form-control" id="note" value="{{ $stylegroup->note }}" >
        </div>
        <div class="form-group col-md-4">
            <label for="deliveryaddr">Delivery Address</label>
            <input type="text" class="form-control" id="deliveryaddr" value="{{ $stylegroup->delivery_addr }}" >
        </div>
        <div class="form-group col-md-2">
            <label for="orderdate">Order Date</label>
            <input type="date" class="form-control" id="orderdate" value="{{ $stylegroup->order_date }}" >
        </div>
    </div>
    <div class="print-btns">
        <a href="" class="btn btn-primary update-group">Update Group</a>
        <a href="/style/pdf/{{ $stylegroup->id  }}" class="btn btn-default">View PDF</a>
    </div>
</div>