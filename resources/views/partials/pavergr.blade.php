<div class="row paver-group-title">
    <h5 class=""><span class="glyphicon glyphicon-minus-sign toggle-box" id="{{ $pavergroup->id }}"></span>Paver Group <span class="group-count">{{ $count }}</span></h5>
</div>
<div class="paver-sheet" name="ss{{ $pavergroup->id }}" id="{{ $pavergroup->id }}" >
    <div class="paver-rows">
    @foreach($pavergroup->pavers as $paver)
        <div class="paver-row" id="{{ $paver->id }}">
            <div class="row" >
                <div class="form-group col-md-3">
                    <label for="paver">Paver</label>
                    <input type="text" class="form-control" name="paver" id="paver" value="{{ $paver->paver }}" placeholder="Paver">
                </div>
                {{--<div class="form-group col-md-3">--}}
                    {{--<label for="manufacturer">Paver Manufacturer</label>--}}
                    {{--<input type="text" class="form-control" name="manufacturer" id="manufacturer" value="{{ $paver->manufacturer }}" placeholder="Paver Manufacturer">--}}
                {{--</div>--}}
                <div class="form-group col-md-3">
                    <label for="pavercolor">Paver Color</label>
                    <input type="text" class="form-control" name="pavercolor"  id="pavercolor" value="{{ $paver->color }}" placeholder="Paver Color">
                </div>
                <div class="form-group col-md-3">
                    <label for="paversize">Paver Size</label>
                    <input type="text" class="form-control" name="paversize"  id="paversize" value="{{ $paver->size }}" placeholder="Paver Size">
                </div>
                <div class="form-group col-md-2">
                    <label for="sqft">SQ/FT</label>
                    <input type="text" class="form-control" name="sqft"  id="sqft" value="{{ $paver->sqft }}" placeholder="0">
                </div>
                <div class="form-group col-md-1">
                    <label for="weight">Weight</label>
                    <input type="text" class="form-control" name="weight"  id="weight" value="{{ $paver->weight }}" placeholder="0">
                </div>
            </div>  <!-- /row -->
            @can('read-job')
            <div class="row inner-row">
                <div class="form-group col-md-2">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" name="price"  id="price" value="{{ $paver->price }}" placeholder="0.00">
                </div>
                <div class="form-group col-sm-2">
                    <label for="palets">Quantity</label>
                    <div class="input-group" id="">
                        <span class="input-group-addon qty-value">
                            <input type="text" class="form-control" id="qty" placeholder="qty" value="{{ $paver->qty }}">
                        </span>
                        <span class="input-group-addon qty-unit">
                            <input type="text" class="form-control" id="qty_unit" placeholder="unit" value="{{ $paver->qty_unit }}">
                        </span>
                    </div>
                </div>

                <div class="form-group col-md-2 center-box">
                    <label class="checkbox-inline">
                        <input type="checkbox" id="tumbled" name="tumbled" {{ isChecked($paver->tumbled) }}>Tumbled
                    </label>
                </div>
                <div class="form-group col-md-5 pull-right center-box">
                    <button class="btn btn-danger delete-paver">X</button>
                </div>
            </div>
            @endcan
        </div>
    @endforeach
    </div><!-- / pavers -->
    @can('edit-job')
    <div class="row row-extra-pad">
        <button type="button" class="btn btn-primary btn-xs add-paver" name="add-paver">Add Paver</button>
    </div>
    @endcan
    <div class="row">
        <div class="form-group col-md-2">
            <label for="delivered">Manufacturer</label>
            <input type="text" class="form-control" name="manu"  id="manu" value="{{ $pavergroup->manufacturer }}" placeholder="name">
        </div>
        <div class="form-group col-md-2">
            <label for="portland">Number of Portlands</label>
            <input type="text" class="form-control" name="portland" id="portland" value="{{ $pavergroup->portlands }}" placeholder="0">
        </div>
        <div class="form-group col-md-3">
            <label for="orderedby">Ordered by</label>
            <input type="text" class="form-control" name="orderedby"  id="orderedby" value="{{ $pavergroup->orderedby }}" placeholder="Name">
        </div>
        <div class="form-group col-md-3">
            <label for="handledby">Delivery Handled by</label>
            <input type="text" class="form-control" name="handledby"  id="handledby" value="{{ $pavergroup->handledby }}" placeholder="Name">
        </div>
        <div class="form-group col-md-2">
            <label for="delivery">Date to Deliver</label>
            <input type="text" class="form-control date" name="delivery"  id="delivery" value="{{ format_date($pavergroup->delivery_at) }}" placeholder="mm/dd/yyyy">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label for="placementnote">Notes for placing pavers</label>
            <input type="text" class="form-control" id="note" value="{{ $pavergroup->note }}" >
        </div>
        <div class="form-group col-md-4">
            <label for="deliveryaddr">Delivery Address</label>
            <input type="text" class="form-control" id="deliveryaddr" value="{{ $pavergroup->delivery_addr }}" >
        </div>
        <div class="form-group col-md-2">
            <label for="orderdate">Order Date</label>
            <input type="text" class="form-control date" id="orderdate" value="{{ format_date($pavergroup->order_date) }}" placeholder="mm/dd/yyyy" >
        </div>
        <div class="form-group col-md-2">
            <label for="delivered">Delivered</label>
            <input type="text" class="form-control date" id="delivered" value="{{ format_date($pavergroup->delivered) }}" placeholder="mm/dd/yyyy" >
        </div>
    </div>
    <div class="print-btns">
        <a href="" class="btn btn-primary update-group">Update Group</a>
        <a href="/paver/pdf/{{ $pavergroup->id  }}" class="btn btn-default">View PDF</a>
    </div>
</div>