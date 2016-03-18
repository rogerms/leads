<div class="panel-group">
    <form id="{{$job->id}}">
        <div class="row row-extra-pad">
            <h2>Job: {{$job->id}}</h2>
        </div>
        <div class="row">
            <div class="form-grrup col-md-2">
                <label for="jobtype">Job Type </label>
                <select class="form-control" id="jobtype">
                    @foreach($job_types as $type)
                        <option {{ isSelected($type->name, $job->job_type) }}>{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="customertype">Customer Type </label>
                <select class="form-control" id="customertype">
                    @foreach($customer_types as $type)
                        <option {{ isSelected($type->customer_type, $job->customer_type) }}>{{$type->customer_type}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="contractor">Contractor</label>
                <input type="text" class="form-control" id="contractor" value="{{$job->contractor}}" placeholder="Contractor">
            </div>
            <div class="form-group col-md-2">
                <label for="propertytype">Property Type </label>
                <select class="form-control" id="propertytype">
                    @foreach($property_types as $type)
                        <option {{ isSelected($type->property_type, $job->property_type) }}>{{$type->property_type}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3">
                <label for="datesold">Date Sold</label>
                <input type="date" class="form-control" id="datesold" value="{{  toInputDate($job->date_sold) }}">
            </div>
        </div>

        @can('read-job')
        <div class="row">
            <div class="form-group col-md-2">
                <label for="size">Size</label>
                <input type="text" class="form-control" id="size" value="{{$job->size}}" placeholder="Size">
            </div>
            <div class="form-group col-md-2">
                <label for="sqftprice">SQ. FT. Price</label>
                <input type="text" class="form-control" id="sqftprice" value="{{$job->sqft_price}}" placeholder="SQ. FT. Price">
            </div>
            <div class="form-group col-md-3">
                <label for="proposalamount">Proposal Amount</label>
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input type="text" class="form-control"  id="proposalamount" value="{{$job->proposal_amount}}" aria-label="Amount">
                </div>
            </div>

            <div class="form-group col-md-3">
                <label for="invoicedamount">Amount Invoiced</label>
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    <input type="text" class="form-control"  id="invoicedamount" value="{{$job->invoiced_amount}}" aria-label="Amount">
                </div>
            </div>
        </div>
        @endcan

        <?php $count = 0; ?>

        <div class="row">
            <?php $job_features = (count($job->features) > 0)? $job->features: $features; ?>
            @foreach($job_features as $feat)
                @if($count % 6 == 0)
        </div><div class="row">
            @endif
            @if( $count++ ) @endif
            <div class="form-group col-md-2">
                <label class="checkbox-inline">
                    <input type="checkbox" name="feats" value="{{ $feat->id }}"  @if($feat->pivot){{ isChecked($feat->pivot->active) }}  @endif > {{ $feat->name }}
                </label>
            </div>
            @endforeach
        </div> <!-- END FEATURES 2-->

        <div class="stylesgroups">
            @if($count = 1) @endif
            <div class="style-sheets">
            @foreach($job->stylegroups as $stylegroup)
                    @include('partials.stylegr', compact('stylegroup', 'count'))
                @if($count++) @endif
            @endforeach
            </div>
            <div class="row row-extra-pad">
                <button type="button" class="btn btn-primary btn-xs add-style-group" id="add-style-group">New Style Group</button>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-3">
                <label for="crew">Crew</label>
                <input type="text" class="form-control" name="crew"  id="crew" value="{{ $job->crew }}" placeholder="Name">
            </div>
            <div class="form-group col-md-2 center-box">
                <label class="checkbox-inline">
                    <input type="checkbox" id="downpayment" name="downpayment" {{ isChecked($job->downpayment_done) }}>Down payment
                </label>
            </div>

        </div> <!--  -->

        <div class="row">
            <div class="form-group col-md-12 note-form">
                <label>Removals </label>
                <div class="list-group" id="removals" name="removals">
                    @foreach($job->removals as $removal)
                        <input type="text" class="form-control inline-control" name="removal"  data-removalid="{{ $removal->id  }}"
                               value="{{ $removal->name }}" placeholder="removal..."
                        >
                    @endforeach
                    @can('edit-job')<button type="button" class="btn btn-primary " id="addremoval">Add Removal</button>@endcan
                </div>

            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12 note-form">
                <label>Materials </label>
                <div class="list-group" id="materials" name="materials">
                    @foreach($job->materials as $material)
                        <div class="col-lg-3">
                            <div class="input-group material" id="{{ $material->id}}">
                            <span class="input-group-addon material-name">
                                <input type="text" class="form-control" id="name" placeholder="name" value="{{ $material->name }}" >
                            </span>
                            <span class="input-group-addon material-value">
                                <input type="text" class="form-control" id="qty" placeholder="qty" value="{{ $material->qty }}">
                            </span>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                    @endforeach
                    @can('edit-job')<button type="button" class="btn btn-primary " id="add-material">Add Material</button>@endcan
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="form-group">
                        <label>Todo list</label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="checkbox-inline">
                            <input type="checkbox" id="paversordered" {{ isChecked($job->pavers_ordered) }} value="paversOrdered">Pavers Ordered
                        </label>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="checkbox-inline">
                            <input type="checkbox" id="prelien"  {{ isChecked($job->prelien) }} value="prelien">Pre-Lien
                        </label>
                    </div>
                    <div class="form-group col-md-4">
                        <label class="checkbox-inline">
                            <input type="checkbox" id="bluestakes" {{ isChecked($job->bluestakes) }}  value="bluestakes">Bluestakes
                        </label>
                    </div>
                </div>
                @if($job->id > 0)
                <div class="row">
                    <div class="form-group col-md-12 note-form">
                        <label>Notes</label>
                        <div class="list-group" id="notes" name="notes">
                            @foreach($job->notes as $note)
                                <a href="#" class="list-group-item active">
                                    <button type="button" class="delete-note" data-noteid="{{ $note->id }}"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="list-group-item-heading">{{ $note->note }}</h4>
                                    <p class="list-group-item-text">Created on: {{ toFormatted($note->created_at) }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row row-extra-bm-pad">
                    <div class="col-md-12">
                        @can('edit-job')
                        <div class="input-group">
                            <span class="input-group-addon" id="jobnotelb">+</span>
                            <input type="text" id="jobnote" class="form-control jobnote" data-job-id="{{ $job->id }}"  placeholder="Add a note" aria-describedby="jobnotelb">
                        </div>
                        @endcan
                    </div>
                </div><!-- /.row -->
                @endif
            </div>
        </div>
        <div class="row row-extra-pad">
            <input type="hidden" id="jobid" value="{{$job->id}}" />
            <input type="hidden" id="leadid" value="{{$lead->id}}" />
            @can('edit-job')
                @if($job->id > 0)
                    <button type="button" class="btn btn-primary updatejob" name="updatejob">Update</button>
                @else
                    <button type="button" class="btn btn-primary createjob" id="createjob">Create</button>
                @endif
            @endcan
        </div>

    </form>
    <div id="pdfviewer"></div>
</div>