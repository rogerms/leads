<div id="templates" class="hidden">
<div class="style-sheet" id="0" >
    <div class="row style-group-title">
        <h5>Paver Style Group <span class="group-count">*</span></h5>
    </div>
    <div class="style-rows">
            <div class="style-row" id="0">
                <div class="row" >
                    <div class="form-group col-md-3">
                        <label for="paverstyle">Paver Style</label>
                        <input type="text" class="form-control" name="paverstyle" id="paverstyle" value="" placeholder="Paver Style">
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
                    <div class="form-group col-md-1">
                        <label for="palets">Palets</label>
                        <input type="text" class="form-control" name="palets"  id="palets" value="" placeholder="0">
                    </div>
                    <div class="form-group col-md-2 center-box">
                        <label class="checkbox-inline">
                            <input type="checkbox" id="tumbled" name="tumbled" >Tumbled
                        </label>
                    </div>
                </div>
                @endcan
            </div>
    </div><!-- / styles -->
    @can('edit-job')
    <div class="row row-extra-pad">
        <button type="button" class="btn btn-primary btn-xs add-style" name="add-style">Add Style</button>
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
            <label for="delivery">Delivery Date</label>
            <input type="date" class="form-control" name="delivery"  id="delivery" value="" placeholder="mm/dd/yyyy">
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
            <input type="date" class="form-control" id="orderdate" value="" >
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
        </div>
</div><!-- /.col-lg-6 -->
</div>