"use strict";

var processingSearch = false;
var autocompleteLists = [];
var sortby = '';
var sortdirection = 1; // 1=asc -1=desc
var versionbuttons = {};
var showCompletedJobs = false;

$(function () {

    processingSearch = false;
    setupAjaxHeader();
    setAutoComplete();
    datePickerInit();
    populateTable();
    populateJobsTable();
    initPrototype();
    //needs to add listener after a new job is added if using modal form
	$('#leadnote,.jobnote').keypress(addnote);

    $('.pagelinks').on('click', '.pagination a', nextLeadsPage);

    $('.jobs-pagelinks').on('click', '.pagination a', nextJobsPage);

    $('#leadstb th').on('click', sortLeads);

    $('#jobstb th').on('click', sortJobs);

    $('.addremoval').on('click', addremovals);

    $('div[name=notes]').on('click', '.delete-note', deletenote);

	$('.paversgroups').on('click', '.add-paver', addPaver);

    $('.add-paver-group').click(addPaverGroup);

	$("#savebt").on("click", saveLead);

	$("#createjob").on('click', createJob);

	$('#updatelead').click(updateLead);

	$('.updatejob').click(updateJob);

    $("#leadstb tbody").on("click", "tr", tableRowGoto);

    $("#jobstb tbody").on("click", "tr", tableRowGoto);

    $('#addImageModal').on('click', addImage);

    $('.sketch-group').on('click', '.sketch-tbn', viewImage);

    $('.job-labels').on('click', '.job-label-btn', deleteJobLabel);

    $('.lead-labels').on('click', '.job-label-btn', deleteLeadLabel);

    $('.label-menu-apply').on('click', updateJobLabel);

    $('.label-menu-item').on('click', labelMenuClicked);

    $('.lead-label-menu-apply').on('click', updateLeadLabel);

    $('.lead-label-menu-item').on('click', leadLabelMenuClicked);

	var searchbar = $('#searchbar');
    var jobsearchbar = $('#jobs-searchbar');

    searchbar.find('#searchbt').on('click', searchLeads);

    jobsearchbar.find('#searchbt').on('click', sortJobs);

    $('#searchtx').keypress(seachTextfieldChanged);

    addSearchAutoComplete();

    $('[data-toggle="offcanvas"]').click(toggleData);

    $('.tbfilter').on('change', searchLeads);

    $('.jobtbfilter').on('change', sortJobs);

    $('.searchby').on('click', changeSearchBy);

    $('body').on('click', hideContextMenu);

    $('#drawings').on("contextmenu", '.sketch-nail', showContextMenu);

    $('.sketch-group').on('click', '.context-menu-button', showContextMenuOption);

    $("#contextMenu").on("click", "a", runContextMenuAction);

    $('ul.j-pager li').on('click', 'a', updatePagination);

    $('.add-material').on('click', addmaterial);

    $('.toggle-box').on('click', togglePavers);

    $('.add-rep').on('click', addReps);

    $('.update-rep').on('click', updateReps);

    $('.update-lists').on('click', updateLists);

    $('.update-group,#update-all-groups').on('click', updateGroup);

    $('.delete-paver').on('click', deletePaver);

    $('.tags-select').on('change', selectNotes);

    $('.tags-select').trigger('change');

    $("#apptime").blur(validateTime);

    $("#addtocalendar").on('click', addCalendarEvent);

    $(".calendarhash").on('click', addCalendarHash);

    $(".delete-phone").on('click', deletePhone);

    $(".delete-email").on('click', deleteEmail);

    $("#addphone").on('click', addPhone);

    $("#addemail").on('click', addEmail);

    $("#addjobbt").on('click', addJob);

    $('.emailtocustomer').on('click', emailToCustomer);

    $('#create-lead-label').on('click', createLeadLabel);

    $('.delete-label-btn').on('click', deleteLabel);

    $('.changeorder').on('click', showChangeOrderTag);

    $('.checkall_labels').on('click', toggleCheckAll);

    initSortable();

    tinymceInit();

    $('.btn-toggle').on('click', toggleShowCompletedJobs);

});

function initSortable()
{
    $( ".sortable" ).sortable({
        axis:'y',
        placeholder: 'sortable-placeholder',
        opacity: 0.8,
        update: sortLabelLists,
        cursor: "move"
    });
    $( ".sortable" ).disableSelection();
}

function toggleData()
{
    $('.row-offcanvas').toggleClass('active');
}

function initPrototype()
{
    Date.prototype.getWeek = function () {
        return $.datepicker.iso8601Week(this);
    };

    Number.prototype.pad = function(size) {
        var s = String(this);
        while (s.length < (size || 2)) {s = "0" + s;}
        return s;
    }
}

function tinymceInit () {
    tinymce.init({
        selector: 'textarea.proposal-note',
        //content_css: '/css/style.css?'+new Date().getMilliseconds(),
        //font_formats:"Default='myFontFace', Arial, Helvetica, Tahoma, Verdana, sans-serif;Arial=arial,helvetica,sans-serif",
        width: 835,
        height: 360,
        max_height: 270,
        browser_spellcheck: true,
        contextmenu: false,
        menubar: false,
        resize: false,
        elementpath: false,
        custom_undo_redo_levels: 10,
        statusbar: false,

        setup: customRTEButtons,

        plugins: [
            'advlist lists print preview hr',
            'save table contextmenu template textcolor'
        ],
        toolbar: 'undo redo | newdoc save | fontsizeselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | print viewpdf | forecolor | autosum viewversions',

        save_onsavecallback: saveProposalNote
    });
}

function datePickerInit() {
    $('input.date').datepicker({
        autoclose: true,
        clearBtn: true,
        todayHighlight: true,
        calendarWeeks: true
    });
}

function validateTime(){
    var time = $(this).val();
    var result = false, m;
    var re = /^\s*([01]?\d|2[0-3]):?([0-5]\d)?\s?(am|pm)?$/;
    if ((m = time.match(re))) {
        var ampm = (m[1] > 12)? '': (m[3] == undefined)? 'am':  m[3];
        var min = (m[2] == undefined)? '00': m[2];
        result = (m[1].length === 2 ? "" : "0") + m[1] + ":" + min+ampm;
    }
    if(result !== false)
    {
        $(this).removeClass('alert-danger');
        $(this).val(result);
    }
    else{
        $(this).addClass('alert-danger');
    }
}

function customRTEButtons (editor) {
    // editor.on('init', function(args) {
    //
    // });

    editor.addButton('autosum', {
        icon: 'sigma',
        title: 'Add numbers',
        image: '/images/icons/360-sigma.png',
        onclick: function (event) {
            var jobid = $(event.target).parents('form').attr('id');
            var amount = $(event.target).parents('form').find('#proposalamount');

            var re = /(-)?\$(\d+[\d\.,]*)/ig;
            var str = editor.getContent();
            var matches;
            var sum = 0;
            while ((matches = re.exec(str)) !== null) {
                var res = matches[2].replace(/,/g, '');
                sum += parseFloat(res)*(matches[1]? -1: 1);
            }
            // console.log(sum);
            if(sum % 1 != 0)
            {
                sum = sum.toFixed(2);
            }
            alert('Total $'+sum);
            amount.val(sum);
        }
    });

    editor.addButton('viewpdf', {
        icon: 'filepdf',
        title: 'View PDF',
        image: '/images/icons/480-file-pdf.png',
        onclick: function (event) {
            var jobid = $(event.target).parents('form').attr('id');
            // console.log('job'+ jobid);
            window.location.href = '/print/job/'+jobid;
        }
    });

    editor.addButton('viewversions', {
        icon: 'viewversions',
        title: 'View Versions',
        image: '/images/icons/stopwatch.png',
        onclick: function (event) {
            var jobid = $(event.target).parents('form').attr('id');
            window.location.href = '/proposal/index/'+jobid;
        },

        onpostrender: function(event){
            var id =  $(this).attr('_id');
            var form = $('#'+id).parents('form');
            var jobid = form.attr('id');
            var count = parseInt(form.find('.proposals-count').data('count'));
            this.disabled(!(count > 1));
            versionbuttons[jobid] = this;

        }
    });

    editor.addButton('newdoc', {
        icon: 'newdoc',
        title: 'New',
        image: '/images/icons/file-empty.png',
        onclick: function (event) {
            var form = $(event.target).parents('form');
            // console.log('job'+ jobid);
            newProposalNote(editor, form)
        }
    });

}

function toggleCheckAll()
{
    var isChecked = $(this).prop("checked");
    var jobtbfilter = $('.jobtbfilter');
    jobtbfilter.prop("checked", isChecked);
    jobtbfilter.trigger('change');
}

function toggleShowCompletedJobs(e) {
    $(this).find('.btn').toggleClass('active');

    if ($(this).find('.btn-primary').size()>0) {
        $(this).find('.btn').toggleClass('btn-primary');
    }
    else if ($(this).find('.btn-danger').size()>0) {
        $(this).find('.btn').toggleClass('btn-danger');
    }
    else if ($(this).find('.btn-success').size()>0) {
        $(this).find('.btn').toggleClass('btn-success');
    }
    else if ($(this).find('.btn-info').size()>0) {
        $(this).find('.btn').toggleClass('btn-info');
    }

    $(this).find('.btn').toggleClass('btn-default');
    showCompletedJobs = $(this).find('.btn-default').text() == 'HIDE';
    sortJobs(e);
}

function sortLabelLists()
{
    var _data = $(this).sortable('serialize');
    $.ajax({
        url: '/labels/sort',
        type: 'POST',
        data: _data
    }).done(function(result){
        if(result == false) {
            console.log('List didn\'t sorted correctly');
            //location.reload();
        }
    })
}

function addCalendarEvent()
{
    var leadid = $(this).parents('form').find('#leadid').val();
    //console.log('add calendar');
    $.ajax({
        url: "/calendar/add/"+leadid,
        type: 'POST'
    }).done(function (result) {
        if(result.success)
        {
            showResult("Event added: "+result.msg);
        }
        if(result.success == false)
        {
            window.location = result.url;
        }
    });
}

function addCalendarHash(e)
{
    e.preventDefault();
    var appointment = $('#appointment').val();
    if(appointment != "")
    {
        var dt = new Date(appointment);
        var tag = $(this).data('tag');
        var msg = tag+dt.getWeek()+""+(dt.getFullYear()-2000);

        if(tag == '#day')
        {
            msg = $(this).data('tag') +""+(dt.getMonth()+1).pad()+""+dt.getDate().pad()+""+(dt.getFullYear()-2000);
        }
        var note = $(this).parents('form').find('#leadnote');
        note.val(msg);
        var evt = jQuery.Event('keypress', { which: 13});
        note.trigger(evt);
    }
}

function showChangeOrderTag()
{
    var form = $(this).parents('form');

    if($(this).prop('checked'))
    {
        form.find('.change-order-tag').removeClass('hidden');
    }
    else
    {
        form.find('.change-order-tag').addClass('hidden');
    }
}

function saveProposalNote(editor){
    event.preventDefault();
    var form = $('#'+editor.id).parents('form');
    var jobid = form.attr('id');
    var id = form.find('.proposal-note').data('id');
    id = (id != "")? id: 0;
    // console.log(jobid);
    //only job owner can upate proposal -- changed
    // var result  = false;
    // if(form.find('#proposal-author').val() == "") {
    //     result = confirm("Only click ok if you are the assigned sales rep. for this job");
    //     if(result !== true) return;
    // }
    // console.log(target.getContent());

    $.ajax({
            url: '/proposal/edit/'+id,
            data: {text: editor.getContent(), jobid: jobid },
            type: 'POST'
        })
        .fail(function (){
            showResult('Error trying to save text', true);
        })
        .done(function(data){
            if(data.result) {
                showResult('text saved');
                //update owner id
                form.find('#proposal-author').val(data.author);
                form.find('.proposal-note').data('id', data.id);
            }
            else{
                showResult(data.msg, true);
            }
        });
}

function newProposalNote(editor, form){
    event.preventDefault();
    var jobid = form.attr('id');
    var id = form.find('.proposal-note').data('id');

    $.ajax({
            url: '/proposal/new/'+jobid,
            data: {text: '', jobid: jobid },
            type: 'POST'
        })
        .fail(function (){
            showResult('Error trying to create doc', true);
        })
        .done(function(data){
            if(data.result) {
                showResult('new doc created');
                form.find('.proposal-note').data('id', data.id);
                editor.setContent("");
                var pc = form.find('.proposals-count');
                var counter = data.counter;
                pc.data('count', counter);
                pc.text('#'+counter);
                versionbuttons[jobid].disabled(!counter > 1);
            }
            else{
                showResult('new doc created');
            }
        });
}

function togglePavers()
{
    var id = $(this).attr('id');
    var name = '[name=ss'+id+']';
    if($(this).hasClass('glyphicon-minus-sign'))
    {
        $(this).removeClass('glyphicon-minus-sign');
        $(this).addClass('glyphicon-plus-sign');
    }
    else
    {
        $(this).removeClass('glyphicon-plus-sign');
        $(this).addClass('glyphicon-minus-sign');
    }
    $(name).toggle();
}

function setupAjaxHeader()
{
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $("input[name='_token']").val()
        }
    });
}

function updatePagination (event)
{
    //todo check if this function is used
    event.preventDefault();
    event.stopPropagation();
    var page = $(this).prop('href').match(/\d+/g)[0];
    console.log(page);

    $.ajax({
        url: "/getpagi",
        data: { page: page },
        type: 'POST'
    }).done(function (msg) {
        $('#leadstb > tbody').html(msg.leads);
        var pager = $(this).parents('ul');
        pager.find('a:nth-child(1)').prop('href', msg.prev);
        pager.find('a:nth-child(2)').prop('href', msg.next);
    });
}

function hideContextMenu ()
{
    $("#contextMenu").hide();
}

function deletenote (event)
{
    event.preventDefault();
    var noteid = $(this).data('noteid');
    var tag = $(this).parent('a');

    var dialog = $('#delete-confirmation');

    //remove any listener leftover from older calls
    dialog.find('#confirmOk').off('click');
    //delete item if OK button is pressed
    dialog.find('#confirmOk').on('click', function () {

        dialog.modal('hide');
        $(this).off( "click");

        $.ajax({
                url: '/note/delete/'+noteid,
                type: 'POST'
            })
            .fail(function (data){
                console.info('delete note ajax fail');
                console.log(data);
                showResult('Error trying to delete note', true);
            })
            .done(function(data){
                // console.log(data);
                if(data.result) {
                    hideDeletedNote(tag);
                    showResult('Note deleted');
                }
            });
    });

    dialog.modal('show');
}
function hideDeletedNote(tag)
{
    var classNames = tag.attr('class').split(' ');
    for(var i = 0, size = classNames.length; i < size; i++)
    {
        if(classNames[i].startsWith('tag-'))
        {
            tag.removeClass(classNames[i]);
        }
    }
    tag.removeClass('active');
    tag.removeClass('tag-all');
    tag.addClass('disabled tag-deleted');
    tag.hide();
    tag.find('.delete-note').remove();//the delete button 'x'
    var dp = tag.find('.item-text-deletedat');
    dp.text("Deleted on: 1 sec ago");
    dp.css('display', 'block');
}

function addPaver()
{
    console.log('call addPaver');
    var slist = $(this).parents('.paver-sheet').find('.paver-rows');
    var tag = $('#templates').find('.paver-row').first().clone();
    slist.append(tag);
    //add autocomplete to new ones
    tag.find('#paver').autocomplete({source: autocompleteLists['pavers']});
    tag.find('#manufacturer').autocomplete({source: autocompleteLists['manus']});
    tag.find('#pavercolor').autocomplete({source: autocompleteLists['colors']});
    tag.find('#paversize').autocomplete({source: autocompleteLists['sizes']});
    $('.delete-paver').on('click', deletePaver);
}

function addPaverGroup()
{
    var slist = $(this).parents('.paversgroups').find('.paver-sheets');
    var tag = $('#templates').find('.paver-sheet').first().clone();
    tag.find('.group-count').text(slist.find('.group-count').length + 1 + '*');
    //tag.attr('id', 0);
    //tag.find('input').val('');
    //tag.find('#tumbled ').prop('checked', false);
    slist.append(tag);
    //add autocomplete to new ones
    //add listener to 'add paver' button
    datePickerInit();
    $('.update-group').on('click', updateGroup);
    tag.find('#paver').autocomplete({source: autocompleteLists['pavers']});
    tag.find('#manu').autocomplete({source: autocompleteLists['manus']});
    tag.find('#pavercolor').autocomplete({source: autocompleteLists['colors']});
    tag.find('#paversize').autocomplete({source: autocompleteLists['sizes']});
    tag.find('#deliveryaddr').val($('#customer_addr').val());
}

function addmaterial()
{
    var list = $(this).parents('form').find('#materials');
    var tag = $('#templates').children('#material').clone();
    list.append(tag);
}

function addremovals()
{
    var tag = '<input type="text" class="form-control inline-control" name="removal" data-removalid="0" value="" placeholder="removal...">';
    $(this).before(tag);

    $('input[name=removal]').each(function(){
        if ($(this).autocomplete( "instance" ) == undefined) //add only if it doesn't have one already
            $(this).autocomplete({source: autocompleteLists['removals']});
    });
}

function changeDrawingVisibility(id, level)
{
    var dcard = $('#dw-'+id);

    $.ajax({
            url: '/drawing/visibility/'+id,
            data: {leadid: $('#leadid').val(), visibility: level },
            type: 'POST'
        })
        .fail(function (){
            showResult('Error trying to change visibility', true);
        })
        .done(function(data){
            if(data.success) {

                removeVClass(dcard);
                dcard.addClass('visibility-'+level);
                showResult('Sketch visibility changed');
            }
        });
}

function removeVClass(elem)
{
    elem.removeClass('visibility-');
    for(var i=0; i < 3; i++)
    {
        elem.removeClass('visibility-'+i);
    }
}

function editDrawing(target)
{
    var id = target.data('drawingid');
    var label = target.data('label');
    var result = prompt("Please enter label", label);
    if (result != null) {
        $.ajax({
            url: "/drawing/edit/"+id,
            data: {label: result},
            type: 'POST'
        }).done(function (msg) {
            console.log(msg);
            if (msg.success) {
                target.find('#label').html(msg.label);
                showResult('Label changed!');
            }
        }).fail(function (){
            showResult('Error trying to change label', true);
        });
    }
}

function changeSearchBy()
{
    $('#searchbt > small').text($(this).text());
}

function saveLead() {
    event.preventDefault();

    var formdata = {
        customer: $('#customer').val(),
        contact: $('#contact').val(),
        street: $('#street').val(),
        city: $('#city').val(),
        zip: $('#zip').val(),
        phone: $('#phone').val(),
        email: $('#email').val(),
        appointment: $('#appointment').val(),
        note: $('#note').val(),
        takenby: $('#takenby').val(),
        source: $('#source').val(),
        salesrep: $('#salesrep').val(),
        status: $('#status').val()

    };

    console.log(formdata);
    $.ajax({
            url: "/store",
            data: formdata,
            type: 'POST'
        })
        .done(function(data){
            showResult('New lead created successfully!')
        })
        .fail(function(){
            showResult('Error trying to create a new lead!', true);
        });
}

function setAutoComplete () {
    $.ajax({
            url: "/getcities",
            type: 'POST'
        })
        .done(function (data)
        {
            // console.log(data);
            // auto complete for cities
            $('#city').autocomplete({
                source: data['cities'],
                minLength: 1
            });

            $('input[name=paver]').autocomplete({
                source: data['pavers'],
                minLength: 1
            });

            $('input[name=manu]').autocomplete({
                source: data['manus'],
                minLength: 1
            });

            $('input[name=pavercolor]').autocomplete({
                source: data['colors'],
                minLength: 1
            });

            $('input[name=paversize]').autocomplete({
                source: data['sizes'],
                minLength: 1
            });

            $('input[name=removal]').autocomplete({
                source: data['removals'],
                minLength: 1
            });
            autocompleteLists = data;
        });
}

function empty (arow) {
    //console.log('empty');
    //console.log(arow);
    for (var i in arow)
    {
        if(arow[i].length > 0 && arow[i] != 0)
            return false;
    }
    return true;
}

function createJob ()
{
    var form = $('form');
    var leadId = $('#leadid').val();
    var formdata = jobFormData(form);

    formdata['leadid'] = leadId;
    console.log(formdata);

    $.ajax({
            url: "/job/store",
            data: formdata,
            type: 'POST'
        })
        .done(function (data) {
            if (data.result == 'success')
            {
                window.location.href = "/lead/" + leadId;
            }
        })
        .fail(function(){
            showResult('Error trying to open page', true);
        });
}

function jobFormData(form)
{
    return {
        size: form.find('#size').val(),
        customertype: form.find('#customertype').val(),
        contractor: form.find('#contractor').val(),
        datesold: form.find('#datesold').val(),
        jobtype: form.find('#jobtype').val(),
        sqftprice: form.find('#sqftprice').val(),
        proposalamount: form.find('#proposalamount').val(),
        invoicedamount: form.find('#invoicedamount').val(),
        propertytype: form.find('#propertytype').val(),
        paversordered: form.find('#paversordered').prop('checked'),
        prelien: form.find('#prelien').prop('checked'),
        bluestakes: form.find('#bluestakes').prop('checked'),
        noaddfee: form.find('#noaddfee').prop('checked'),
        changeorder: form.find('.changeorder').prop('checked'),
        skid: form.find('#skid').prop('checked'),
        crew: form.find('#crew').val(),
        downpayment: form.find('#downpayment').val(),
        materials: getMaterials(form),
        startdate: form.find('#startdate').val(),
        signedat: form.find('#signedat').val(),
        removals: getRemovals(form),
        features: getFeats(form)
    };
}

function getRemovals(form)
{
    var removals = [];
    form.find('#removals').find('input').each(function (){
        var value = $(this).val();
        if (value != '')
        {
            removals.push(
                {
                    id: $(this).data('removalid'),
                    name: value
                }
            );
        }
    });

    return removals;
}

function showContextMenuOption(e) {
    e.preventDefault();
    var $contextMenu = $("#contextMenu");
    var drawing = $(this).parents('.sketch-nail');

    $contextMenu.data('id', drawing.attr('id'));
    $contextMenu.data('target', drawing);

    $contextMenu.css({
        display: "block",
        left: e.pageX,
        top: e.pageY
    });
    return false;
}

function showContextMenu ()
{
    var $contextMenu = $("#contextMenu");
    $('#drawings').on("contextmenu", '.sketch-nail', function(e) {
        $contextMenu.data('id', $(this).data('drawingid'));
        $contextMenu.data('target', $(this));

        $contextMenu.css({
            display: "block",
            left: e.pageX,
            top: e.pageY
        });
        return false;
    });
}

function runContextMenuAction() {
    var $contextMenu = $("#contextMenu");
    var select = $(this).text();
    if(select == 'Delete')
    {
        var drawingid = $contextMenu.data('id');
        //console.log('Delete '+ drawingid);
        deleteDrawing($(this), drawingid);
    }
    if(select == 'Private')
    {
        changeDrawingVisibility($contextMenu.data('id'), 0);
    }
    if(select == 'Protected')
    {
        changeDrawingVisibility($contextMenu.data('id'), 1);
    }
    if(select == 'Public')
    {
        changeDrawingVisibility($contextMenu.data('id'), 2);
    }
    if(select == 'Change Label')
    {
        editDrawing($contextMenu.data('target'));
    }

    $contextMenu.hide();
}

function addImage(event) {
    var leadid = $('#leadid').val();

    bootbox.dialog({
        title: "Image",
        message: $('#add-image-modal').html(),
        buttons: {
            success: {
                label: "Upload image",
                className: "btn-success",
                callback: function(event)
                {
                    var files = $(this).find('#inputfile').prop('files');
                    var label = $(this).find('#label').val();
                    var visibility = $(this).find('#visibility').val();
                    if(files.length > 0) {
                        uploadFile(event, files[0], leadid, label, visibility);
                    }
                }
            },
            danger: {
                label: "Cancel",
                className: "btn-default",
                callback: function () {}
            }
        }
    });

    // modal.find('#uploadImage').click(function(event) {
    //     var files = modal.find('#inputfile').prop('files');
    //     var label = modal.find('#label').val();
    //
    //     console.log('button clicked from job -- '+ leadid +' length '+ files.length);
    //     if(files.length > 0) {
    //         uploadFile(event, files[0], leadid, label);
    //         modal.modal('hide');
    //     }
    // });
}

function addSearchAutoComplete()
{
    $('#searchtx').autocomplete({
        source: 'getdata',
        minLength: 1,
        select: function (event, ui) {
            console.log(ui.item.label);
            $('#searchtx').val(ui.item.label); //set textfield value
            searchLeads();
        }
    });
}

function seachTextfieldChanged (e) {
    if (e.which == 13) { //Enter key
        e.preventDefault();
        $('#searchtx').autocomplete('close');

        if($(this).parents('#jobs-searchbar').length > 0)
        {
            sortJobs(e);
        }
        else
        {
            searchLeads(e);
        }
    }
}

function viewImage(event){
    event.preventDefault();
    var url = $(this).prop('href');
    $('#showImageModal').find('#img-holder').prop('src', url);

    var modal = $('#showImageModal');
    modal.modal('show');
}

function deleteJobLabel(){
    var button =  $(this).parent('button');
    var id = button.attr('id');

    $.ajax({
        url: "/label/delete",
        data: { id: id},
        type: 'POST'
    }).done(function (msg) {
        if (msg.result > 0) {
            //showResult('label removed');
            var label_id = button.data('label');
           // var menu_item = button.parents('form').find('.label-menu-item#'+label_id);

            var menu_item = button.parents('form').find('.label-menu-item#'+label_id);
            //uncheck it on the dropdown list
            menu_item.prop('checked', false);
            menu_item.val('');
            button.remove();
        }
    }).fail(function (){
        console.log('Error trying to delete label');
    });
}

function deleteLeadLabel(){//trail button
    var button =  $(this).parent('button');
    var id = button.attr('id');

    $.ajax({
        url: "/label/delete/lead",
        data: { id: id},
        type: 'POST'
    }).done(function (msg) {
        if (msg.result > 0) {
            //showResult('label removed');
            var label_id = button.data('label');
            var menu_item = button.parents('form').find('.lead-label-menu-item#'+label_id);
            //uncheck it on the dropdown list
            menu_item.prop('checked', false);
            menu_item.val('');
            button.remove();
        }
    }).fail(function (){
        console.log('Error trying to delete label');
    });
}

function deleteLabel(){//manage lead page
    var row =  $(this).parent('.update-row');
    var id = $(this).data('labelid');
    var dialog = $('#delete-confirmation');
    var _type = $(this).data('type').replace("_label", "s");
    //remove any listener leftover from older calls
    dialog.find('#confirmOk').off('click');
    dialog.find('#message')
          .html('Remove the label <b>"'+$(this).data('name')+
              '"</b> from '+$(this).data('number')+' '+
              _type+' and delete the label');
    //delete item if OK button is pressed
    dialog.find('#confirmOk').on('click', function () {
        dialog.modal('hide');
        $(this).off( "click");

        $.ajax({
        url: "/labels/delete/"+id,
        type: 'POST'
        })
        .fail(function (data){
            showResult('Error trying to delete label', true);
        })
        .done(function(data){
            if(data.result) {
                showResult('label deleted ');
                row.remove();
            }
        });
    });

    dialog.modal('show');
}

function updateJobLabel(event) {
    var applybtn = $(this);
    var form = $(this).parents('form');
    var menu = applybtn.parents('.label-menu');

    //only sending changes
    var changed = getChangedLabels(menu);

    $.ajax({
        url: "/label/update",
        data: {add: changed.add, remove: changed.remove, jobid: applybtn.attr('id')},
        type: 'POST'
    }).done(function (msg) {
        //console.log(msg);
        if (msg.result == true) {
            resetLabelTrail(form, msg.labels);
            applybtn.addClass('disabled');
        }
    }).fail(function (){
        console.log('Error trying to update job label!', true);
    });
}

function updateLeadLabel(event) {
    var applybtn = $(this);
    var form = $(this).parents('form');
    var menu = applybtn.parents('.lead-label-menu');

    //only sending changes
    var changed = getChangedLabels(menu, '.lead-label-menu-item');

    $.ajax({
        url: "/label/update/lead",
        data: {add: changed.add, remove: changed.remove, leadid: applybtn.attr('id')},
        type: 'POST'
    }).done(function (msg) {
       // console.log(msg);
        if (msg.result == true) {

            resetLeadLabelTrail(form, msg.labels);
            applybtn.hide();
            form.find('.create-lead-label').show();
            form.find('.edit-lead-label').show();
        }
    }).fail(function (){
        console.log('Error trying to update lead label!', true);
    });
}

function resetLabelTrail(form, labels)
{
    var joblabels = form.find('.job-labels');
    joblabels.find('button').remove();//empty list

    $.each(labels, function (index, label) {
        joblabels.append(jobLabelButton(label.pivot.id, label.id, label.name));
    });
}

function resetLeadLabelTrail(form, labels)
{
    var leadlabels = form.find('.lead-labels');
    leadlabels.find('button').remove();//empty list

    $.each(labels, function (index, label) {
        leadlabels.append(jobLabelButton(label.pivot.id, label.id, label.name));
    });
}

function getChangedLabels(menu, tagname)
{
    var add = [];
    var remove = [];
    var tname = (tagname != undefined)? tagname: '.label-menu-item';
    var items = menu.find(tname);
    items.each(function(){ //loop all menu items
        var checkbox = $(this);
        var checked = checkbox.val() == 'checked';//original value

        if(checked !== checkbox.prop('checked'))//original and now values
        {
            var id = checkbox.attr('id');
            if(checked === true)//it was true before -- remove from db
            {
                remove.push(id);
                checkbox.val(''); //update new value
            }
            else
            {
                add.push(id);//
                checkbox.val('checked'); //update new value
            }
        }
    });
    return {add: add, remove: remove};
}

function jobLabelButton(id, labelid, name)
{
    return '<button type="button" style="margin-left:4px;" class="btn btn-info btn-xs" id="'+id+
        '" data-label="'+labelid+'" >'+name+
        '<span class="job-label-btn" style="margin-left:5px;" aria-hidden="true">X</span></button>';
}

function labelMenuClicked(event) {
    event.stopPropagation();

    var menu = $(this).parents('.label-menu');
    var haschanges = false;

    menu.find('.label-menu-item').each(function(){ //loop all menu items
        var checkbox = $(this);
        var checked = checkbox.val() == 'checked';
        if(checked !== checkbox.prop('checked'))
        {
            haschanges = true;
            return false; //break out of the loop
        }
    });

    var applybtn = menu.find('.label-menu-apply');
    if(haschanges == true)
        applybtn.removeClass('disabled');
    else
        applybtn.addClass('disabled');
}

function leadLabelMenuClicked(event) {
    event.stopPropagation();
    console.log('leadLabelMenuClicked ');
    var menu = $(this).parents('.lead-label-menu');
    var haschanges = false;

    menu.find('.lead-label-menu-item').each(function(){ //loop all menu items
        var checkbox = $(this);
        var checked = checkbox.val() == 'checked';
        if(checked !== checkbox.prop('checked'))
        {
            haschanges = true;
            return false; //break out of the loop
        }
    });

    var applybtn = menu.find('.lead-label-menu-apply');
    var createbtn = menu.find('.create-lead-label');
    var editbtn = menu.find('.edit-lead-label');

    if(haschanges == true)
    {
        applybtn.show();
        createbtn.hide();
        editbtn.hide();
    }
    else
    {
        applybtn.hide();
        createbtn.show();
        editbtn.show();
    }
}

function tableRowGoto () {
    window.location.href = "/lead/" + $(this).data('id');
    //open in a new tab
    // var win = window.open("/lead/"+ $(this).data('id'), '_blank');
    // win.focus();
}

function selectNotes()
{
    var notes = $(this).parents('.note-form');
    notes.find('.tag-all, .tag-deleted').hide();
    var tag = '.'+$(this).val();
    notes.find(tag).show();
}

function updateJob () {
    event.preventDefault();

    var form = $(this).parents('form');
    var id = form.find('#jobid').val();
    var fdata = jobFormData(form);

    fdata['id'] = id;

    // update proposal note if button is enabled
    var proposalsavebt = form.find('.mce-i-save').parent('button');
    if(proposalsavebt.css('cursor') == 'pointer')
    {
        //trigger button click (save button of the tynemce text editor)
        proposalsavebt.trigger('click');
    }

    $.ajax({
        url: "/job/update",
        data: fdata,
        type: 'POST'
    }).done(function (msg) {
        console.log(msg);
        if (msg.result == 'success') {
            form.find('#job-num').html(msg.jobnum);

            form.find('.last-update>span:last-child').text(msg.updated);
            showResult('Job info updated!');
            updateNoteList(msg.note, form);
            if(msg.labels)
            {
                console.log('new label called');
                resetLabelTrail(form, msg.labels);
            }
            if(msg.removals)
            {
                refreshRemovalList(form, msg.removals);
            }
            if(msg.materials)
            {
                refreshMaterialList(form, msg.materials);
            }
        }
    }).fail(function (){
        showResult('Error trying to update job info!', true);
    });
}

function deletePaver () {
    event.preventDefault();
    var tag = $(this).parents('.paver-row');
    var id = tag.attr('id');
    var result = window.confirm("Are you sure you want to delete this paver?");
    if(result === false) return;

    $.ajax({
        url: "/paver/"+id+"/delete",
        type: 'POST'
    }).done(function (msg) {
        console.log(msg);
        if (msg.result == 'success') {
            tag.remove();
            showResult('Paver deleted');
        }
    }).fail(function (){
        showResult('Error trying to delete paver', true);
    });
}

function updateGroup () {//update paver group
    event.preventDefault();

    var form  = $('form');
    var group = false;
    var _pavergroups = null;

    if ($(this).hasClass('update-group'))
    {
        var group = true;
        _pavergroups = getPaverGroup($(this).parents('.paver-sheet'));
    }
    else{
        _pavergroups = getPaverGroups(form);
    }

    var id = $('#jobid').val();
    var fdata = {
            pavergroups: _pavergroups,
            jobid: id
        };

    $.ajax({
        url: "/paver/update",
        data: fdata,
        type: 'POST'
    }).done(function (msg) {
        // console.log(msg);
        if (msg.result == 'success') {
            form.find('.group-count').each(function(){
                //remove *
                var txt = $(this).text().replace('*', '');
                $(this).text(txt);
            });
            showResult('Pavers info updated!');

            if(group == false) location.reload();
        }
    }).fail(function (){
        showResult('Error trying to update pavers info!', true);
    });
}

function getFeats(form)
{
    var features = {};
    form.find('input[name=feats]').each(function () {
        features[$(this).val()] = $(this).prop('checked');
    });

    return features;
}

function getMaterials(form)
{
    var list = [];
    form.find('.material').each(function()
    {
        var material = $(this);
        var item = {
            id: material.attr('id'),
            name: material.find('#name').val(),
            qty: material.find('#qty').val(),
            unit: material.find('#unit').val(),
            vendor: material.find('#vendor').val(),
            delivered: material.find('#delivered:checked').length
        };
        if(!empty(item)) list.push(item);
    });
    return list;
}

function getPaverGroups(form, selected)
{
    //groups
    var pavergroups = [];

    form.find('.paver-sheet').each(function() {
            var pavers = [];
            var gr = {
                id: $(this).attr('id'),
                manu: $(this).find('#manu').val(),
                portland: $(this).find('#portland').val(),
                orderedby: $(this).find('#orderedby').val(),
                handledby: $(this).find('#handledby').val(),
                delivery: $(this).find('#delivery').val(),
                note: $(this).find('#note').val(),
                orderdate: $(this).find('#orderdate').val(),
                addr: $(this).find('#deliveryaddr').val(),
                delivered: $(this).find('#delivered').val(),
                invoice: $(this).find('#invoice').val()
            };

            $(this).find('.paver-row').each(function () {
                var row = {
                    id: $(this).attr('id'),
                    paver: $(this).find('#paver').val(),
                    //manu: $(this).find('#manufacturer').val(),
                    color: $(this).find('#pavercolor').val(),
                    size: $(this).find('#paversize').val(),
                    sqft: $(this).find('#sqft').val(),
                    weight: $(this).find('#weight').val(),
                    price: $(this).find('#price').val(),
                    qty: $(this).find('#qty').val(),
                    qty_unit: $(this).find('#qty_unit').val(),
                    tumbled: $(this).find('#tumbled:checked').length
                };
                if (!empty(row)) pavers.push(row);
            });
            if (!empty(gr) || !empty(pavers)) {
                gr['pavers'] = pavers;
                pavergroups.push(gr);
            }
    });
    return pavergroups;
}

function getPaverGroup(group)
{
    //groups
    var pavergroups = [];
    var pavers = [];
    var gr = {
        id: group.attr('id'),
        manu: group.find('#manu').val(),
        portland: group.find('#portland').val(),
        orderedby: group.find('#orderedby').val(),
        handledby: group.find('#handledby').val(),
        delivery: group.find('#delivery').val(),
        note: group.find('#note').val(),
        orderdate: group.find('#orderdate').val(),
        addr: group.find('#deliveryaddr').val(),
        delivered: group.find('#delivered').val(),
        invoice: group.find('#invoice').val()
    };

    group.find('.paver-row').each(function () {
        var row = {
            id: $(this).attr('id'),
            paver: $(this).find('#paver').val(),
            //manu: $(this).find('#manufacturer').val(),
            color: $(this).find('#pavercolor').val(),
            size: $(this).find('#paversize').val(),
            sqft: $(this).find('#sqft').val(),
            weight: $(this).find('#weight').val(),
            price: $(this).find('#price').val(),
            qty_unit: $(this).find('#qty_unit').val(),
            qty: $(this).find('#qty').val(),
            tumbled: $(this).find('#tumbled:checked').length
        };
        if (!empty(row)) pavers.push(row);
    });
    if (!empty(gr) || !empty(pavers))
    {
        gr['pavers'] = pavers;
        pavergroups.push(gr);
    }
    return pavergroups;
}

function updateLead () {
    event.preventDefault();
    var id = $('#leadid').val();
    var _form = $(this).parents('form');
    
    var phones = [];
    _form.find('.extra-phone').each(function(){
        var p = {
            number: $(this).find('.extra-phone-num').val(),
            id: $(this).find('.delete-phone').data('id')
        };
        phones.push(p);
    });
    
    var fdata = {
        id: id,
        customer: $('#customer').val(),
        contact: $('#contact').val(),
        street: $('#street').val(),
        city: $('#city').val(),
        state: $('#state').val(),
        zip: $('#zip').val(),
        phone: $('#phone').val(),
        email: $('#email').val(),
        appointment: $('#appointment').val(),
        apptime: $('#apptime').val(),
        takenby: $('#takenby').val(),
        source: $('#source').val(),
        salesrep: $('#salesrep').val(),
        status: $('#status').val(),
        note: $('#leadnote').val(),
        phones: phones
    };

    $.ajax({
        url: "/update",
        data: fdata,
        type: 'POST'
    }).done(function (msg) {
        // console.log(msg);
        if (msg.result == 200) {

            showResult("lead info updated");
            updateNoteList(msg.note, _form);
        }
    }).fail(function(){
        showResult('Error trying to update lead info');
    });

}

function updateNoteList(note, form)
{
    if(note.created == true)
    {
        var tag = '<a href="#" class="list-group-item active">' +
        '<button type="button" class="delete-note" data-noteid="' + note.id + '">' +
        '<span aria-hidden="true">&times;</span></button>' +
        '<h4 class="list-group-item-heading">' + note.note + '</h4>' +
        '<p class="list-group-item-text">Created on: ' + note.created + '</p></a>';

        var list = form.find('#notes');
        form.find('#leadnote').val("");
        form.find('#jobnote').val("");
        list.prepend(tag);
    }
}

function deleteDrawing(target, drawingid)
{
   // var tag = $('#drawing-'+drawingid).parent('a');
    var dialog = $('#delete-confirmation');

    //remove any listener leftover from older calls
    dialog.find('#confirmOk').off('click');
    //delete item if OK button is pressed
    dialog.find('#confirmOk').on('click', function () {

        dialog.modal('hide');
        $(this).off( "click");

        $.ajax({
                url: '/drawing/delete/'+drawingid,
                type: 'POST'
            })
            .fail(function (data){
                console.info('delete sketch ajax fail');
                console.log(data);
                showResult('Error trying to delete sketch', true);
            })
            .done(function(data){
                console.log(data);
                if(data.result) {
                    $('#drawings').html(data.cards);
                    showResult('Sketch deleted');
                }
            });
    });

    dialog.modal('show');
}

function createLeadLabel(target)
{
    // var tag = $('#drawing-'+drawingid).parent('a');
    var menu = $(this).parents('.lead-label-menu');
    var order = +menu.find('.lead-label-menu-item').last().data('order');
    order++;

    var dialog = $('#new-label-dialog');
    //remove any listener leftover from older calls
    dialog.find('#confirmOk').off('click');
    //delete item if OK button is pressed
    dialog.find('#confirmOk').on('click', function () {

        dialog.modal('hide');
        $(this).off( "click");
        var name = dialog.find('#label-name').val();
        console.log('label name '+name);
        $.ajax({
            url: '/label/add',
            data: {name: name, order: order, type: 'lead'},
            type: 'POST'
        })
            .fail(function (data){
                console.info('creating lead label failed');
                console.log(data);
                showResult('Error trying to create label', true);
            })
            .done(function(data){
                if(data.result) {
                    menu.find('.label-list-item:last').after(menuItem(data.labels[data.labels.length - 1]));
                    $('.lead-label-menu-item:last').on('click', leadLabelMenuClicked);
                    dialog.find('#label-name').val('');
                    showResult('label created');
                }
            });
    });

    dialog.modal('show');
}

function menuItem(label)
{
  return '<li class="label-list-item" style="margin-left: 7px;"><div class="checkbox">'+
         '<label><input type="checkbox" class="lead-label-menu-item" id="'+label.id+'"'+
         'data-order="'+label.display_order+'" value=""'+
     '>'+label.name+'</label>'+
     '</div></li>';
}

// Catch the form submit and upload the files
function uploadFile(event, file, leadid, label, visibility)
{
    event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening

    // START A LOADING SPINNER HERE
    // Create a formdata object and add the files
    var data = new FormData();

    data.append("image", file);
    data.append('label', label);
    data.append('visibility', visibility);

    $.ajax({
        url: '/drawing/add/'+leadid,
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request

        success: function(data, textStatus, jqXHR)
        {
            if(typeof data.error === 'undefined')
            {
                // Success so call function to process the form
                console.log('SUCCESS: ' + data.file);
                $('#drawings').html(data.cards);

                showResult('New sketch added')
            }
            else
            {
                // Handle errors here
                console.log('ERRORS!: ' + data);
                showResult('Sketch could NOT be added', true);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
            showResult('Error trying to add new sketch', true);
            // STOP LOADING SPINNER
        }
    });
}

function showResult(message, error)
{
    var tag = $('.alert-dlg');
    tag.text(message);
    if(error === true)
    {
        tag.addClass('alert-dlg-error');
    }
    else
    {
        tag.removeClass('alert-dlg-error');
    }
    //show it for 3 seconds
    tag.show();
    tag.delay(3000).fadeOut();
}

function parseQueryString() {

    var str = window.location.search;
    var objURL = {};

    str.replace(
        new RegExp( "([^?=&]+)(=([^&]*))?", "g" ),
        function( $0, $1, $2, $3 ){
            objURL[ $1 ] = $3;
        }
    );
    return objURL;
}

function addReps(event)
{
    alert('add rep '+$(this).attr('id'));
}

function updateReps()
{
    var row = $(this).parent('.row');
    var id = $(this).attr('id');

    $.ajax({
        url: '/rep/update/'+id,
        type: 'POST',
        data: {
            name: row.find('#name').val(),
            phone: row.find('#phone').val(),
            active: row.find('#active:checked').length
        }
    }).done(function(msg){
        console.log(msg);
        location.reload();
    });
}

function updateLists()
{
    var row = $(this).parent('.row');
    var id = $(this).attr('id');

    $.ajax({
        url: '/list/update/'+id,
        type: 'POST',
        data: {
            type: $(this).data('type'),
            name: row.find('#name').val(),
            order: row.find('#order').val()
        }
    }).done(function(msg){
        console.log(msg);
        location.reload();
    });
}

function sortLeads()
{
    var title = $(this).text();
    if(title == 'Pavers' || title == 'Skid' || title == 'Notes')
        return;
    // if the same heading is click twice change sort direction
    sortdirection = (sortby == title)? sortdirection*-1: 1;
    sortby = title;

    searchLeads();
}

function nextJobsPage(e)
{
    e.preventDefault();
    var url = $(this).attr('href');
    sortJobs(e, url);
}

function sortJobs(event, url)
{
    if (processingSearch == true) return;
    processingSearch = true;
    var hasUrl = (url != undefined);
    var title = $(this).text();
    // if the same heading is click twice change sort direction
    sortdirection = (sortby == title)? sortdirection*-1: 1;
    sortby = title;

    $.ajax({
            url: hasUrl? url: '/jobs?page=1',
            data: {
                labels: getFilters('labels_count'),
                searchtx: $('#searchtx').val(),
                searchby: $('small#searchby').text(),
                sortby: sortby,
                sortdirection: sortdirection,
                showAll: showCompletedJobs
            },
            type: 'GET'
        })
        .done(function (result) {
            var tbody = $('#jobstb > tbody');
            var jobs = result.jobs;
            tbody.html(jobs);
            $('.jobs-pagelinks').html(result.links);

            $('[name="labels_count"]').each(function () {
                var value = $(this).val();
                if(result.labels[value] == undefined)
                {
                    $(this).siblings('.badge').text(0);
                }
                else {
                    $(this).siblings('.badge').text(result.labels[value]);
                }
            });
            $('#labels_count_total').text(result.count);
            processingSearch = false;
        })
        .fail(function (result) {
            if(result.status == 401) {
                window.location = "/jobs";
                return;
            }
            showResult('Error trying to get jobs!', true);
        });
}

function populateTable (event) {
    if(location.pathname == '/' || location.pathname == '/leads')
    {
        showResult('Loading items...');
        searchLeads(event);
    }
}

function populateJobsTable()
{
    if(location.pathname == '/jobs')
    {
        showResult('Loading items...');
        sortJobs();
    }
}

function nextLeadsPage(e)
{
    e.preventDefault();
    var url = $(this).attr('href');
    searchLeads(e, url);
}

function searchLeads(event, url) {
    if (processingSearch == true) return;
    processingSearch = true;
    var hasUrl = (url != undefined);
    $.ajax({
            url: hasUrl? url: '/?page=1',
            data: {
                searchtx: $('#searchtx').val(),
                statuses: getFilters('status_count'),
                reps: getFilters('reps_count'),
                appts: getFilters('appts_count'),
                labels: getFilters('labels_count'),
                today: $('input[name="today"]:checked').length,
                tomorrow: $('input[name="tomorrow"]:checked').length,
                week: $('input[name="week"]:checked').length,
                searchby: $('small#searchby').text(),
                sortby: sortby,
                sortdirection: sortdirection
            },
            type: 'GET'
        })
        .done(function (result) {
            var tbody = $('#leadstb > tbody');
            $('.pagelinks').html(result.links);
            //console.log(result);
            var leads = result.leads;
            tbody.html(leads);
            //filter panel categories count
            $('[name="status_count"]').each(function () {
                var value = $(this).val();
                if(result.status[value] == undefined)
                {
                    $(this).siblings('.badge').text(0);
                }
                else {
                    $(this).siblings('.badge').text(result.status[value]);
                }
            });

            $('[name="reps_count"]').each(function () {
                var value = $(this).val();
                if(result.reps[value] == undefined)
                {
                    $(this).siblings('.badge').text(0);
                }
                else {
                    $(this).siblings('.badge').text(result.reps[value]);
                }
                //console.log(value);
                //console.log(result.status[value]);
            });

            $('[name="labels_count"]').each(function () {
                var value = $(this).val();
                if(result.labels[value] == undefined)
                {
                    $(this).siblings('.badge').text(0);
                }
                else {
                    $(this).siblings('.badge').text(result.labels[value]);
                }
            });

            $('input[name="today"]').siblings('.badge').text(result.today);
            $('input[name="tomorrow"]').siblings('.badge').text(result.tomorrow);
            $('input[name="week"]').siblings('.badge').text(result.week);

            if(!hasUrl)
            showResult('Total: ' + result.count + ' leads found');
            // console.log(result.status);
            // console.log(result.reps);
            processingSearch = false;
        })
        .fail(function () {
            processingSearch = false;
            if(result.status == 401) {
                location.reload();
                return;
            }
            showResult('Error trying to get leads', true);
        });
}

function getFilters(fname)
{
    var result_arr = [];
    $('input[name="'+fname+'"]').each(function (){
        if($(this).prop('checked'))
            result_arr.push("'"+$(this).val()+"'");
    });

    //console.log(result_arr);

    return result_arr;
}

function filterTable(event)
{
    //console.log('alert called '+event.target.checked);
    //var tablerows = document.getElementById("myTable").rows;
    //$.each(tablerows, function(row){
    //    console.log() x[0].cells[0].innerText
    //});

    var status = [];
    var reps =[];

    var isall = $('input[name="status_count"]:checked').length;
    $('input[name="status_count"]').each(function (){
        //if none is checked the user wants all
        if($(this).prop('checked') || isall == 0)
        status.push($(this).val());
    });

    isall = $('input[name="reps_count"]:checked').length;
    $('input[name="reps_count"]').each(function (){
        if($(this).prop('checked') || isall == 0)
        {
            reps.push($(this).val());
        }
    });

    var count = 0;
    $('#leadstb > tbody > tr').each(function() {
        var cells = $(this).children('td');

        if(status.indexOf(cells[6].innerText) != -1 && reps.indexOf(cells[5].innerText) != -1 &&
            inTime(cells[4].innerText))
        {
            $(this).show();
        }
        else
        {
            $(this).hide();
        }
    });
}

function inTime(dateStr)
{
    var isall = $('input[name="appts_count"]:checked').length;
    if (isall == 0) return true;

    var app = {};
    $('input[name="appts_count"]').each(function(){
        app[$(this).val()] = $(this).prop('checked');
    });

    //find the date portion of the datetime string
    var found = dateStr.match(/\w{3,}\s\d{1,2},\s\d{4}/);
    dateStr = found[0];

    if(app['Today'] == true)
    {
        if(isDate(dateStr, 'today')) return true;
    }
    if(app['Tomorrow'] == true)
    {
        if(isDate(dateStr, 'tomorrow')) return true;
    }
    if(app['7 Days'] == true)
    {
        if(is7days(dateStr)) return true;
    }
    return false;
}

function isDate(dateStr, what)
{
    var today = getDate(what);
    var mydate = getDate (dateStr);
   // console.log(dateStr);
   //console.log(mydate.toString() +"\n" + today.toString());
   //
    if(today.getTime() == mydate.getTime())
    {
        //console.log(dateStr);
       // console.log('is today/tomorrow true');
        return true;
    }
   // console.log('is today/tomorrow false');
    return false;
}

function getDate(dateStr)
{
    var dt = null;
    if(dateStr == 'today')
    {
        dt = new Date();
    }
    else if(dateStr == 'tomorrow')
    {
        dt = new Date();
        dt.setTime(dt.getTime() + (60*60*24*1000));
    }
    else if(dateStr == 'week')
    {
        dt = new Date();
        var milisecsWeek = 604800000;
        dt.setTime(dt.getTime() + milisecsWeek);
    }
    else
    {
        dt = new Date(dateStr);
    }

    dt.setHours(0);
    dt.setMinutes(0);
    dt.setSeconds(0);
    dt.setMilliseconds(0);
    return dt;
}

function is7days(dateStr) {

    var mydate = new Date(dateStr);
    var today = getDate('today');
    var week = getDate('week');

    //console.log(today.toString());
    //console.log(week.toString());
    //console.log(mydate.toString());

    if(mydate.getTime() >= today.getTime() && mydate.getTime() <= week.getTime()) {
       // console.log('true');
        return true;
    }
   // console.log('week false');
    return false;
}

function formDate(value)
{
    var res = value.split('-');
    if (res.length < 3)
        return "";

    return res[1]+'/'+res[2]+'/'+res[0];
}

function response()
{
    console.log('Delete Note');
}

function deletePhone()
{
    event.preventDefault();
    var phoneid = $(this).data('id');
    var phone = $(this).parents('.extra-phone');

    var dialog = $('#delete-confirmation');

    //remove any listener leftover from older calls
    dialog.find('#confirmOk').off('click');
    //delete item if OK button is pressed
    dialog.find('#confirmOk').on('click', function () {

        dialog.modal('hide');
        $(this).off( "click");

        $.ajax({
                url: '/phone/delete/'+phoneid,
                type: 'POST'
            })
            .fail(function (data){
                console.info('delete phone ajax fail');
                console.log(data);
                showResult('Error trying to delete phone', true);
            })
            .done(function(data){
                // console.log(data);
                if(data.result) {
                    phone.remove();
                    showResult('Phone deleted');
                }
            });
    });

    dialog.modal('show');
}

function deleteEmail()
{
    event.preventDefault();
    var emailid = $(this).data('id');
    var email = $(this).parents('.extra-email-group');


    bootbox.confirm({
        title: "Delete",
        message: "Are you sure you want to delete this email?",

        callback: function(result){
            if(result === true)
            {
                deleteEmailAjax(email, emailid)
            }
        }
    });
}

function deleteEmailAjax(email, emailid)
{
    $.ajax({
        url: '/email/delete/'+emailid,
        type: 'POST'
    })
    .fail(function (data){
        console.info('delete email ajax failed');
        console.log(data);
        showResult('Error trying to delete email', true);
    })
    .done(function(data){
        // console.log(data);
        if(data.result) {
            email.remove();
            showResult('Email deleted');
        }
    });
}

function addPhone(e)
{
    addPhoneOrEmail(e, 'phone');
}

function addEmail(e)
{
    addPhoneOrEmail(e, 'email');
}

function addPhoneOrEmail(e, type)
{
    e.preventDefault();

    var form = $('#add-phone-modal');
    var title = "Add Phone Number";

    if(type == 'email')
    {
        form.find('.item1-label').text('Email');
        form.find('.item1-input').attr("placeholder", "name@email.com");
        form.find('.item2-input').attr("placeholder", "other");
        title = "Add Email";
    }
    else
    {
        form.find('.item1-label').text('Phone');
        form.find('.item1-input').attr("placeholder", "000-999-0000");
        form.find('.item2-input').attr("placeholder", "home");
    }

    bootbox.dialog({
        title: title,
        message: form.html(),
        buttons: {
            success: {
                label: "Save",
                className: "btn-success",
                callback: function() { addPhoneAjax($(this), type); }
            },
            danger: {
                label: "Cancel",
                className: "btn-danger",
                callback: function () {}
            }
        }
    });
}

function isEmpty(value) {
    return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
}

function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

function isPhone(phone) {
    var regex = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
    return regex.test(phone);
}

function addPhoneAjax(form, type)
{
    var _value = form.find('.item1-input').val();
    var _label = form.find('.item2-input').val();
    var _leadid = $('#leadid').val();

    if(isEmpty(_value) || isEmpty(_label) || isEmpty(_leadid))
    {
        showResult('Please complete all the fields', true);
        return;
    }
    if(type == 'email' && isEmail(_value) == false)
    {
        showResult('The email entered is invalid', true);
        return;
    }
    if(type == 'phone' && isPhone(_value) == false)
    {
        showResult('The phone number entered is invalid', true);
        return;
    }

    var url = (type == 'email')? "/email/add": "/phone/add";

    $.ajax(
        {
            url: url,
            data: {
                value: _value,
                label: _label,
                leadid: _leadid
            },
            type: 'POST'
        }).done(function(data){
            if(data.result) {
                if(type == 'phone')
                {
                    var tag = $('#templates').find('#phone').clone();

                    tag.find('.badge-btn').first().text(data.label);
                    tag.find('.extra-phone-num').first().val(data.number);
                    tag.find('a').attr('href', 'tel:'+data.number);
                    tag.find(".delete-phone").data('id', data.id);
                    tag.find(".delete-phone").on('click', deletePhone);

                    $('.phone-group').append(tag);

                    showResult('Phone added successfully');
                }
                else if(type == 'email')
                {
                    tag = $('#templates').find('#email').clone();

                    tag.find('.badge-btn').first().text(data.label);
                    tag.find('.extra-email').first().val(data.email);
                    tag.find('a').attr('href', 'mailto:'+data.email);
                    tag.find(".delete-email").data('id', data.id);
                    tag.find(".delete-email").on('click', deleteEmail);

                    $('.email-group').append(tag);

                    showResult('Email added successfully');
                }
            }
            else{
                showResult('Error adding item', true);
            }
        });
}

function addJob(e)
{
    e.preventDefault();
    var url = $(this).attr('href');

    bootbox.confirm("Are you sure you want to create a new job?", function(result) {
        if (result === true) {
            window.location = url;
        }
    });
}

function emailToCustomer(e)
{
    e.preventDefault();
    var url = $(this).attr('href');
    var emails = [];
    emails.push($('#email').val());
    $('.extra-email').each(function(index) { emails.push($(this).val()); });

    var _message = $('#email-customer-modal').html();

    _message = _message.replace('=email=', emails.join('; '));

    bootbox.dialog({
        title: "Email:",
        message: _message,
        buttons: {
            success: {
                label: "Send",
                className: "btn-success",
                callback: function ()
                {
                    var subject = $(this).find('#subject').val();
                    var msg = $(this).find('#message').val();
                    var emails = "";
                    var emailArr = $(this).find('#email').val().split(';');

                    $.each(emailArr, function( index, value ) {
                        var email = value.trim();
                        if(email != "")
                        {
                            emails += "&email[]="+email;
                        }
                    });

                    window.location = url+'?subject='+subject+'&message='+encodeURI(msg)+emails;
                }
            },
            danger: {
                label: "Cancel",
                className: "btn-default",
                callback: function () {}
            }
        }
    });
}
function refreshMaterialList(form, materials)
{
    var list = form.find('#materials');
    list.find('.col-sm-5').remove();//empty list
    $.each(materials, function (index, material) {

        var tmp = $('#templates').find('#material').clone();
        tmp.find('#name').val(material.name);
        tmp.find('#qty').val(material.qty);
        tmp.find('#unit').val(material.qty_unit);
        tmp.find('#vendor').val(material.vendor);
        tmp.find('div.material').attr('id', material.id);
        tmp.find('#delivered').prop('checked', (material.delivered == 1));

        list.append(tmp);
    });
}

function refreshRemovalList(form, removals)
{
    var list = form.find('#removals');
    list.find('[name=removal]').remove();//empty list

    $.each(removals, function (index, removal) {
        var elem = '<input type="text" class="form-control inline-control" name="removal"  data-removalid="'+removal.id+'" value="'+removal.name+'">';
        list.find('.addremoval').before(elem);
    });
}

function addnote(event) {
    var target = $(this);
    if (event.which != 13) return;

    var notetx = target.val();
    if(notetx.length == 0) return;

    var data = {
        note: notetx,
        jobid: target.data('job-id'),
        leadid: target.data('lead-id')
    };
    $.ajax(
        {
            url: "/note/add",
            data: data,
            type: 'POST'
        })
        .done(function (data) {
            // console.log("done");
            var form = target.parents('form');
            //check if #tag exists
            var rexp = /#(\w+)/g;
            var m = rexp.exec(data.note);
            var htag = '';
            if(m != null)
            {
                htag = 'tag-'+m[1];
                var found = false;
                var select = form.find('.tags-select');
                select.find('option').each(function(){
                    if($(this).val() == htag)
                    {
                        found = true;
                        return;
                    }
                });
                if(!found)//add new option item
                    select.append('<option value="'+htag+'">'+m[1]+'</option>');
            }

            var tag = '<a href="#" class="list-group-item active tag-all '+htag+'">' +
                '<button type="button" class="delete-note" data-noteid="'+ data.id +'">'+
                '<span aria-hidden="true">&times;</span></button>'+
                '<h4 class="list-group-item-heading">'+ data.note +'</h4>' +
                '<p class="list-group-item-text">Created on: ' + data.created + '</p></a>';

            var list = form.find('#notes');
            target.val("");//clear the input text field
            $('#leadnote').val("");
            list.prepend(tag);

            //add to tag filter list
            
            showResult('New note added');

        }).fail(function (){
        showResult('Error trying to add new note', true);
    });


};

function confirm2(options, action)
{
    var divtag = '<div class="modal fade" id="delete-confirmation" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationLabel">'+
    '<div class="modal-dialog" role="document">'+
    '<div class="modal-content">'+
    '<div class="modal-header">'+
    '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
    '<span aria-hidden="true">&times;</span></button>'+
    '<h4 class="modal-title" id="deleteConfirmationLabel">Delete</h4>'+
    '</div>'+
        '<div class="modal-body">'+
    '<p>'+
    '<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>'+
        'Are you sure you want to delete this item ?'+
        '</p>'+
    '</div>'+
    '<div class="modal-footer">'+
    '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>'+
    '<button type="button" id="confirmOk" class="btn btn-primary">Delete</button>'+
    '</div> </div> </div> </div>';

    $(divtag).find('#confirmOk').bind('click', function(){

        //action.call();
        console.log('click click');
       // $(divtag).modal('hide');

    });

    $(divtag).modal();
    //$(divtag).remove();
}
/***
 * Libaries Docs
 * Datepicker:
 * https://github.com/eternicode/bootstrap-datepicker
 * https://bootstrap-datepicker.readthedocs.io/en/stable/index.html
 * ----------------------------------------------------------------
 *
 * ***/

    /*
     Copyright (c) 2011 Damien Antipa, http://www.nethead.at/, http://damien.antipa.at

     Permission is hereby granted, free of charge, to any person obtaining
     a copy of this software and associated documentation files (the
     "Software"), to deal in the Software without restriction, including
     without limitation the rights to use, copy, modify, merge, publish,
     distribute, sublicense, and/or sell copies of the Software, and to
     permit persons to whom the Software is furnished to do so, subject to
     the following conditions:

     The above copyright notice and this permission notice shall be
     included in all copies or substantial portions of the Software.

     THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
     EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
     MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
     NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
     LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
     OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
     WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
     */
/*
 * jQuery Plugin: Confirmation Dialog
 *
 * Requirements: jQuery 1.6.4, Bootstrap 1.3.0
 * http://jquery.com/
 * http://twitter.github.com/bootstrap/
 *
 * This Plugin can be used for anchors, to show a confirmation popup before redirecting to the link.
 * Original code by Damian Antipa <http://damien.antipa.at/2011/10/jquery-plugin-confirmation/>
 *
 */
(function($){
    $.fn.extend({
        confirmDialog: function(options) {
            var defaults = {
                message: '<strong>Are you sure</strong>',
                dialog: '<div id="confirm-dialog" class="popover">' +
                '<div class="arrow"></div>' +
                '<div class="inner">' +
                '<div class="content">' +
                '<p class="message"></p>' +
                '<p class="button-group"><a href="#" class="btn small danger"></a><a href="#" class="btn small"></a></p>' +
                '</div>' +
                '</div>' +
                '</div>',
                cancelButton: 'Cancel'
            };
            var options =  $.extend(defaults, options);

            return this.each(function() {
                var o = options;
                var $elem = $(this)

                //is there an existing click handler registered
                if ($elem.data('events') && $elem.data('events').click) {
                    //save the handler (TODO: assumes only one)
                    var targetClickFun = $elem.data('events').click[0].handler;
                    //unbind it to prevent it firing
                    $elem.unbind('click');
                }else{
                    //assume there is a href attribute to redirect to
                    var targetClickFun = function() {window.location.href = $elem.attr('href');};
                }

                $elem.bind('click', function(e) {
                    e.preventDefault();
                    if(!$('#confirm-dialog').length) {

                        var offset = $elem.offset();
                        var $dialog = $(o.dialog).appendTo('body');

                        var x;
                        if(offset.left > $dialog.width()) {
                            //dialog can be left
                            x = e.pageX - $dialog.width();
                            $dialog.addClass('left');
                        } else {
                            x = e.pageX;
                            $dialog.addClass('right');
                        }
                        var y = e.pageY - $dialog.height() / 2 - $elem.innerHeight() / 2;

                        $dialog.css({
                            display: 'block',
                            position: 'absolute',
                            top: y,
                            left: x
                        });

                        $dialog.find('p.button-group').css({
                            marginTop: '5px',
                            textAlign: 'right'
                        });

                        $dialog.find('a.btn').css({
                            marginLeft: '3px'
                        });

                        $dialog.find('p.message').html(o.message);

                        $dialog.find('a.btn:eq(0)').text($elem.text()).bind('click', function(e) {
                            $dialog.remove();
                            targetClickFun();
                        });

                        $dialog.find('a.btn:eq(1)').text(o.cancelButton).bind('click', function(e) {
                            $dialog.remove();
                        });

                        $dialog.bind('mouseleave', function() {
                            $dialog.fadeOut('slow', function() {
                                $dialog.remove();
                            });
                        });
                    }
                });
            });
        }
    });
})(jQuery);


