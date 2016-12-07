<div class="panel-group">
    <form id="{{$job->id}}">
        <div class="row row-extra-pad">
            <div class="col-sm-3"><h2 id="job-num"> {{ \app\Helpers\Helper::show_job_num($job) }} </h2></div>
            <div class="col-sm-9" >
                <div class="pull-right job-labels">
                @foreach($job->labels as $label)
                    <!-- id = job_labels.id  data-label=job_labels.label_id  -->
                    <button type="button" class="btn btn-info btn-xs" id="{{ $label->pivot->id }}" data-label="{{ $label->id }}" >{{ $label->name}}
                        <span class="job-label-btn" aria-hidden="true">X</span>
                    </button>
                @endforeach
                </div>
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
            @can('edit-job')
            @if(!empty($job->id))
            <div class="form-group col-md-3">
                <label for="datesold">Date Sold</label>
                <input type="text" class="form-control date" id="datesold" value="{{ format_date($job->date_sold) }}">
            </div>
            @endif
            @endcan
        </div>

        <div class="row">
            @can('edit-job')
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
            @endcan
            <div class="form-group col-md-2">
                <label for="startdate">Start Date</label>
                <input type="text" class="form-control date" id="startdate" value="{{  format_date($job->start_date) }}">
            </div>
        </div>

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
        @can('edit-job', $job)
        <div class="row">
            <div style="padding: 10px;">
                <label>Proposal Notes:<span style="color:grey"> @if(count($job->proposals) > 0 ){{ '#'.count($job->proposals) }} @endif</span></label>
                <div class="proposal-box" >
                    <textarea class="proposal-note" data-id="{{ $job->proposal['id'] }}">{{ $job->proposal['text'] }}</textarea>
                </div>
            </div>
        </div>
        @endcan

        @can('edit-job')
        <div class="row row-extra-pad">
            <a role="button" class="btn btn-primary" href="/job/{{$job->id}}/style">Pavers</a>
        </div>
        @endcan
        <div class="row">
            <div class="form-group col-md-3">
                <label for="crew">Crew</label>
                <input type="text" class="form-control" name="crew"  id="crew" value="{{ $job->crew }}" placeholder="Name">
            </div>
            @can('edit-job')
            <div class="form-group col-md-2">
                <label for="downpayment">Down payment</label>
                <div class="input-group">
                    <input type="number" class="form-control" name="downpayment" id="downpayment" value="{{ number_fmt($job->downpayment) }}"  placeholder="amount" aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2">%</span>
                </div>
            </div>
            <div class="form-group col-md-2 cbox-valign">
                <label class="checkbox-inline">
                    <input type="checkbox" id="noaddfee"  {{ isChecked($job->noadd_fee) }} value="additionalfee">No additional fees
                </label>
            </div>
            @endcan
            <div class="form-group col-md-2 cbox-valign">
                <label class="checkbox-inline">
                    <input type="checkbox" id="skid"  {{ isChecked($job->needs_skid) }} value="skid">Skid
                </label>
            </div>
        </div> <!--  -->

        <div class="row">
            <div class="form-group col-md-12 note-form">
                <label>Removals </label>
                <div class="list-group" id="removals" >
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
                        <div class="col-sm-5 ">
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
                                <span class="input-group-addon material-value-sm">
                                     <label class="material-checkbox">
                                         <input type="checkbox" id="delivered"  {{ isChecked($material->delivered) }} value="delivered">
                                     </label>
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
                @can('edit-job')
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
                @endcan
                @if($job->id > 0)
                <div class="row">
                    <div class="form-group col-md-12 note-form">
                        <label>Notes</label>
                        <div style="display: inline-block; margin: 2px 20px;">
                            <select class="form-control  tags-select" >
                                <?php $job_notes = \Auth::user()->can('edit-job')? $job->notes: $job->personal_notes;  ?>
                                @foreach(all_tags($job_notes) as $key => $tag)
                                <option value="{{ $key }}"> {{ $tag }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="list-group" id="notes" name="notes">
                            @foreach($job_notes as $note)
                                <?php
                                $deleted = !empty($note->deleted_at);
                                $tagall = ($deleted)? ' disabled tag-deleted': ' active tag-all';
                                ?>

                                <a href="#" class="list-group-item {{ $tagall }} {{ get_tag($note) }}">
                                    @if(!$deleted)
                                    <button type="button" class="delete-note" data-noteid="{{ $note->id }}"><span aria-hidden="true">&times;</span></button>
                                    @endif
                                    <h4 class="list-group-item-heading">{{ $note->note }}</h4>
                                    <p class="list-group-item-text">Created on: {{ toFormatted($note->created_at) }}</p>
                                        <p class="list-group-item-text item-text-deletedat"
                                             style="display: @if($deleted) block @else none  @endif">
                                            Deleted on: {{ toFormatted($note->deleted_at) }}
                                        </p>

                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row row-extra-bm-pad">
                    <div class="col-md-12">
                        <div class="input-group">
                            <span class="input-group-addon" id="jobnotelb">+</span>
                            <input type="text" id="jobnote" class="form-control jobnote" data-job-id="{{ $job->id }}"  placeholder="Add a note" aria-describedby="jobnotelb">
                        </div>
                    </div>
                </div><!-- /.row -->
                @endif
            </div>
            @can('edit-job')
            <div class="col-md-6">
                <div class="form-group col-md-3">
                    <label for="signedat">Signature Date</label>
                    <input type="text" class="form-control date" id="signedat" value="{{  format_date( $job->signed_at) }}" placeholder="mm/dd/yyyy">
                </div>
            </div>
            @endcan
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
            <!-- Split button -->
            <div class="btn-group dropup">
                <a role="button" @can('edit-job', $job) href="/print/job/{{$job->id}}" @endcan class="btn btn-default" id="print-job">View PDF</a>
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Button</span>
                </button>
                <ul class="dropdown-menu">
                    {{--<li><a href="/email/job/{{$job->id}}">Email PDF</a></li>--}}
                    @can('edit-job')
                    <li><a id="emailtocustomer" href="/email/customer/{{$job->id}}">Email Customer</a></li>
                    <li><a href="/report/job/{{$job->id}}">Export Excel</a></li>
                    @endcan
                    @can('read')
                    <li><a href="/print/installer/{{$job->id}}">Installer Sheet</a></li>
                    @endcan
                </ul>
            </div>

            {{-- job progress --}}
            @can('read')
                    <!-- Split button -->
                <div class="btn-group dropup">
                    <a role="button" class="btn btn-default" id="job-progress">Job Progress</a>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Button</span>
                    </button>
                    <ul class="dropdown-menu label-menu">
                        <?php $job_labels_ids = labelIds($job->labels) ?>
                        @foreach($labels as $label)
                            <li>
                                <div class="checkbox">
                                      <label><input type="checkbox" class="label-menu-item" id="{{$label->id }}" value="{{ isLabelChecked($label->id, $job_labels_ids) }}" {{ isLabelChecked($label->id, $job_labels_ids) }} >{{ $label->name }}</label>
                                </div>
                            </li>
                        @endforeach
                        <li role="separator" class="divider"></li>
                        <li><a id="{{$job->id}}" class="btn label-menu-apply disabled" >Apply</a></li>
                    </ul>
                </div>
                @endcan
{{--               {{ dd($job->progress[0]->pivot->id ) }}--}}
        </div>
        <div class="last-update" id="{{ $job->id }}">
                <span>Last Updated: </span><span>{{ format_datetime($job->updated_at) }}</span>
        </div>
    </form>
    <div id="pdfviewer"></div>
</div>