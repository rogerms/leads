@extends('layouts.master')

@section('title', 'Update Selection Lists')

@section('content')
<div class="container">
    @include('partials.feedback')

<div class="row">
    <form class="form-inline" action="">

        {{-- job progress --}}
        <div class="col-sm-8 update-div">
            <div class="row">
                <h4>Job Progress</h4>
            </div>
            <?php $max_order=0; ?>
            @foreach($job_labels as $label)
                <div class="row update-row">
                    <div class="form-group">
                        <label class="sr-only" for="name">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $label->name }}">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="order">Display Order</label>
                        <input type="text" class="form-control" id="order" value="{{ $label->display_order }}" placeholder="display order">
                    </div>
                    <button type="button" id="{{ $label->id }}" class="btn btn-default update-lists" data-type="job_label">Update</button>
                    <button type="button" data-labelid="{{ $label->id }}"
                            data-name="{{ $label->name }}" data-number="{{ $label->number }}"
                            class="btn btn-danger delete-label-btn" data-type="job_label">Delete</button>
                </div>
                <?php $max_order=$label->display_order; ?>
            @endforeach
            <div class="row reps-add" style="margin-bottom:15px">
                <div class="form-group">
                    <label class="sr-only" for="name">Name</label>
                    <input type="text" class="form-control" id="name"  placeholder="Alive">
                </div>
                <div class="form-group hidden">
                    <label class="sr-only" for="order">Display Order</label>
                    <input type="text" class="form-control" id="order" value="{{ ++$max_order }}" placeholder="display order">
                </div>
                <button type="button" id="0" class="btn btn-info update-lists" data-type="job_label">Add</button>
            </div>
        </div>

        {{-- lead labels --}}
        <div class="col-sm-8 update-div">
            <div class="row">
                <h4>Lead Labels</h4>
            </div>
            <?php $max_order=0; ?>
            @foreach($lead_labels as $label)
                <div class="row update-row">
                    <div class="form-group">
                        <label class="sr-only" for="name">Name</label>
                        <input type="text" class="form-control" id="name" value="{{ $label->name }}">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="order">Display Order</label>
                        <input type="text" class="form-control" id="order" value="{{ $label->display_order }}" placeholder="display order">
                    </div>
                    <button type="button" id="{{ $label->id }}" class="btn btn-default update-lists" data-type="lead_label">Update</button>
                    <button type="button" data-labelid="{{ $label->id }}"
                            data-name="{{ $label->name }}" data-number="{{ $label->number  }}"
                            class="btn btn-danger delete-label-btn" data-type="lead_label">Delete</button>
                </div>
                <?php $max_order=$label->display_order; ?>
            @endforeach
            <div class="row reps-add" style="margin-bottom:15px">
                <div class="form-group">
                    <label class="sr-only" for="name">Name</label>
                    <input type="text" class="form-control" id="name"  placeholder="Sent Email">
                </div>
                <div class="form-group hidden">
                    <label class="sr-only" for="order">Display Order</label>
                    <input type="text" class="form-control" id="order" value="{{ ++$max_order }}" placeholder="display order">
                </div>
                <button type="button" id="0" data-order="" class="btn btn-info update-lists" data-type="lead_label">Add</button>
            </div>
        </div>
</form>
</div>
</div>
    @include('partials.confirmdlg')
@endsection
