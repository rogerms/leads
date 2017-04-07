<div id="templates" class="hidden">
<div class="paver-sheet" id="0" >
    <div class="row paver-group-title">
        <h5>Paver Group <span class="group-count">*</span></h5>
    </div>
    <div class="paver-rows">
            <div class="paver-row" id="0">
                <div class="row" >
                    <div class="form-group col-md-3">
                        <label for="paver">Paver </label>
                        <input type="text" class="form-control" name="paver" id="paver" value="" placeholder="Paver">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="pavercolor">Paver Color</label>
                        <input type="text" class="form-control" name="pavercolor"  id="pavercolor" value="" placeholder="Paver Color">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="paversize">Paver Size</label>
                        <input type="text" class="form-control" name="paversize"  id="paversize" value="" placeholder="Paver Size">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="sqft">SQ/FT</label>
                        <input type="text" class="form-control" name="sqft"  id="sqft" value="" placeholder="0">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="weight">Weight</label>
                        <input type="text" class="form-control" name="weight"  id="weight" value="" placeholder="0">
                    </div>
                </div>  <!-- /row -->
                @can('read-job')
                <div class="row inner-row">
                    <div class="form-group col-md-2">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" name="price"  id="price" value="" placeholder="0.00">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="palets">Quantity</label>
                        <div class="input-group" id="">
                        <span class="input-group-addon qty-value">
                            <input type="text" class="form-control" id="qty" placeholder="how many" value="">
                        </span>
                        <span class="input-group-addon qty-unit">
                            <input type="text" class="form-control" id="qty_unit" placeholder="unit" value="">
                        </span>
                        </div>
                    </div>
                    <div class="form-group col-md-2 center-box">
                        <label class="checkbox-inline">
                            <input type="checkbox" id="tumbled" name="tumbled" >Tumbled
                        </label>
                    </div>
                </div>
                @endcan
            </div>
    </div><!-- / pavers -->
    @can('edit-job')
    <div class="row row-extra-pad">
        <button type="button" class="btn btn-primary btn-xs add-paver" name="add-paver">Add Paver</button>
    </div>
    @endcan
    <div class="row">
        <div class="form-group col-md-2">
            <label for="delivered">Manufacturer</label>
            <input type="text" class="form-control" name="manu"  id="manu" value="" placeholder="name">
        </div>
        <div class="form-group col-md-2">
            <label for="portland">Number of Portlands</label>
            <input type="text" class="form-control" name="portland" id="portland" value="" placeholder="0">
        </div>
        <div class="form-group col-md-3">
            <label for="orderedby">Ordered by</label>
            <input type="text" class="form-control" name="orderedby"  id="orderedby" value="" placeholder="Name">
        </div>
        <div class="form-group col-md-3">
            <label for="handledby">Delivery Handled by</label>
            <input type="text" class="form-control" name="handledby"  id="handledby" value="" placeholder="Name">
        </div>
        <div class="form-group col-md-2">
            <label for="delivery">Date to Deliver</label>
            <input type="text" class="form-control date" name="delivery"  id="delivery" value="" placeholder="mm/dd/yyyy">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label for="placementnote">Notes for placing pavers</label>
            <input type="text" class="form-control" id="note" value="" >
        </div>
        <div class="form-group col-md-4">
            <label for="deliveryaddr">Delivery Address</label>
            <input type="text" class="form-control" id="deliveryaddr" value="" >
        </div>
        <div class="form-group col-md-2">
            <label for="orderdate">Order Date</label>
            <input type="text" class="form-control date" id="orderdate" value="" >
        </div>
        <div class="form-group col-md-2">
            <label for="delivered">Delivered</label>
            <input type="text" class="form-control date" id="delivered" placeholder="mm/dd/yyyy" >
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label for="invoice">Invoice Number</label>
            <input type="text" class="form-control" id="invoice" value="" >
        </div>
    </div>
    <div class="print-btns">
        <div >
            <a href="" class="btn btn-primary update-group">Update Group</a>
        </div>
    </div>
</div>

<div id="material" class="col-sm-5">
        <div class="input-group material" id="0">
            <span class="input-group-addon material-name">
                <input type="text" class="form-control" id="name" placeholder="name" >
            </span>
            <span class="input-group-addon material-value-sm">
                <input type="text" class="form-control" id="qty" placeholder="qty" >
            </span>
            <span class="input-group-addon material-value-sm">
                <input type="text" class="form-control" id="unit" placeholder="unit">
            </span>
            <span class="input-group-addon material-value">
                <input type="text" class="form-control" id="vendor" placeholder="from">
            </span>
            <span class="input-group-addon material-value-sm">
                 <label class="material-checkbox">
                     <input id="delivered" type="checkbox"  value="delivered">
                 </label>
            </span>
        </div>
</div><!-- /.col-lg-6 -->

    <div id="phone" class="input-group extra-phone">
        <input type="tel" class="form-control extra-phone-num" aria-label="phone-number" value="" placeholder="Phone #">
        <div class="input-group-btn">
            <button type="button" class="btn btn-default disabled badge-btn"></button>
            <a class="btn btn-default" role="button" href=""><span class="glyphicon glyphicon-earphone"></span></a>
            <button type="button" data-id="" class="btn btn-default delete-phone" ><span class="glyphicon glyphicon-trash"></span></button>
        </div><!-- /btn-group -->
    </div><!-- /input-group -->

    <div id="email" class="input-group extra-email-group">
        <input type="email" class="form-control extra-email" aria-label="email" value="" >
        <div class="input-group-btn">
            <button type="button" class="btn btn-default disabled badge-btn"></button>
            <a class="btn btn-default" role="button" href=""><span class="glyphicon glyphicon-envelope"></span></a>
            <button type="button" data-id="" class="btn btn-default delete-email" ><span class="glyphicon glyphicon-trash"></span></button>
        </div><!-- /btn-group -->
    </div><!-- /input-group -->
</div>