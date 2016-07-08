<div class="panel-group">
    <form id="{{$job->id}}">
        <div class="row row-extra-pad">
            <h2 id="job-num"> {{ \app\Helpers\Helper::show_job_num($job) }} </h2>
            <div class="last-update" id="{{ $job->id }}">
                <span>Last Updated: </span><span>{{ format_datetime($job->updated_at) }}</span>
            </div>
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
                        <option {{ isSelected($type->name, $job->customer_type) }}>{{$type->name}}</option>
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
                        <option {{ isSelected($type->name, $job->property_type) }}>{{$type->name}}</option>
                    @endforeach
                </select>
            </div>
            @if(!empty($job->id))
            <div class="form-group col-md-3">
                <label for="datesold">Date Sold</label>
                <input type="text" class="form-control date" id="datesold" value="{{ format_date($job->date_sold) }}">
            </div>
            @endif
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
            <div class="form-group col-md-2">
                <label for="startdate">Start Date</label>
                <input type="text" class="form-control date" id="startdate" value="{{  format_date($job->start_date) }}">
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
                    <input type="checkbox" name="feats" value="{{ $feat->id }}"  @if(isset($feat->pivot)){{ isChecked($feat->pivot->active) }}  @endif > {{ $feat->name }}
                </label>
            </div>
            @endforeach
        </div> <!-- END FEATURES 2-->
        <input type="hidden" id="proposal-author" value="{{ $job->proposal_author }}">
        @can('view-proposal', $job)
        <div class="row">
            <div class="col-xm-12" style="padding: 10px">
                <label>Proposal Notes:</label>
                <textarea class="proposal-note">{{ $job->proposal_note }}</textarea>
            </div>
        </div>
        @endcan
        @can('edit-job')
        <div class="row row-extra-pad">
            <a role="button" class="btn btn-primary" href="/job/{{$job->id}}/style">Paver Styles</a>
        </div>
        @endcan
        <div class="row">
            <div class="form-group col-md-3">
                <label for="crew">Crew</label>
                <input type="text" class="form-control" name="crew"  id="crew" value="{{ $job->crew }}" placeholder="Name">
            </div>
            <div class="form-group col-md-2">
                <label for="downpayment">Down payment</label>
                <div class="input-group">
                    <input type="number" class="form-control" name="downpayment" id="downpayment" value="{{ number_fmt($job->downpayment) }}"  placeholder="amount" aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2">%</span>
                </div>
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
                    @can('edit-job')<button type="button" class="btn btn-primary addremoval" name="addremoval">Add Removal</button>@endcan
                </div>

            </div>
        </div>
        <div class="row materials">
                <label>Materials </label>
                <div class="list-group" id="materials" name="materials">
                    @foreach($job->materials as $material)
                        <div class="col-sm-5">
                            <div class="input-group material" id="{{ $material->id}}">
                                <span class="input-group-addon material-name">
                                    <input type="text" class="form-control" id="name" placeholder="name" value="{{ $material->name }}" >
                                </span>
                                <span class="input-group-addon material-value-sm">
                                    <input type="text" class="form-control" id="qty" placeholder="qty" value="{{ $material->qty }}">
                                </span>
                                <span class="input-group-addon material-value-sm">
                                    <input type="text" class="form-control" id="unit" placeholder="unit" value="{{ $material->qty_unit }}">
                                </span>
                                <span class="input-group-addon material-value">
                                    <input type="text" class="form-control" id="vendor" placeholder="from" value="{{ $material->vendor }}">
                                </span>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                    @endforeach
                        @can('edit-job')
                        <button type="button" class="btn btn-primary add-material" name="add-material">Add Material</button>
                        @endcan
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
                        <div style="display: inline-block; margin: 2px 20px;">
                            <select class="form-control  tags-select" >
                                @foreach(all_tags($job->notes) as $key => $tag)
                                <option value="{{ $key }}"> {{ $tag }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="list-group" id="notes" name="notes">
                            @foreach($job->notes as $note)
                                <a href="#" class="list-group-item active tag-all {{ get_tag($note) }}">
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
            <div class="col-md-6">
                <div class="form-group col-md-3">
                    <label for="signedat">Signature Date</label>
                    <input type="text" class="form-control date" id="signedat" value="{{  format_date( $job->signed_at) }}" placeholder="mm/dd/yyyy">
                </div>
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



            <!-- Split button -->
            <div class="btn-group dropup">
                <a role="button" @can('view-proposal', $job) href="/print/job/{{$job->id}}" @endcan class="btn btn-default" id="print-job">View PDF</a>
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Button</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="/email/job/{{$job->id}}">Email PDF</a></li>
                    <li><a id="emailtocustomer" href="/email/customer/{{$job->id}}">Email Customer</a></li>
                    <li><a href="/report/job/{{$job->id}}">Export Excel</a></li>
                    <li><a href="/print/installer/{{$job->id}}">Installer Sheet</a></li>
                </ul>
            </div>
            @endcan
        </div>

    </form>
    <div id="pdfviewer"></div>
</div>