'use strict';

var line = 6;
var margin = 10;
var _newLine = margin;
var _xgap = 4;
var _SUBLINEOFF = 7;
var _LEFTMARGIN = 7;
function process()
{
	
	var doc = new jsPDF({format: 'legal', unit: 'mm'});
	
	doc.setFontSize(14); 
	doc.text(100, newLine(), 'Strong Rock Pavers');
	
	doc.setFontSize(11); 
	doc.text(74, newLine(), 'Northern Utah: (801) 815-5704   Southern Utah: (435) 703-8937');
	doc.text(74, newLine(), '125 East 300 South Suite 203 Provo, Utah 84606');
	doc.text(74, newLine(), 'Fax: (801) 437-1765 email: office.strongrockpavers@gmail.com');
	
	//doc.setFillColor(150, 235, 185); 
	doc.setFontSize(9); 
	var prevy = newLine();
	doc.rect(7, prevy, 201, 51); //x, y, width, height
	var y = newLine(_xgap);
	var subline = getsubline(y);
	doc.text(8, subline, 'Proposal Submitted to:');
	doc.text(90, subline, 'Job Name:               Occupation:');
	doc.text(165, subline, 'Date:');
	doc.line(89, prevy, 89, y)//vertical lines
	doc.line(163, prevy, 163, y);//vertical lines
	doc.line(7, y, 208, y); 
	//input data 
	doc.setFontSize(11);
	doc.setFontStyle('bold');
	var inpos = y -2;
	doc.text(9, inpos, val('customer'));//sumitted to
	doc.text(91, inpos, val('customer')); //job_name
	doc.text(126, inpos, val('customer')); //ocupation
	doc.text(166, inpos, val('datesold')); //date
	inpos += 10;
	doc.text(9, inpos, val('street')+' '+val('city')+' UT '+val('zipcode')); //job_address
	doc.text(166, inpos, '2/23/2016'); //start_date
	inpos += 10;
	doc.text(9, inpos, '123 Univerty Pwy, Provo'); //billing_address
	doc.text(91, inpos, val('street')); //subdivision
	doc.text(166, inpos, val('street')); //lot#
	inpos += 10;
	doc.text(9, inpos, val('phone'));//office-home
	doc.text(51, inpos, val('email'));//email
	doc.text(136, inpos, val('email'));//cross_street
	inpos += 11;
	doc.text(9, inpos, val('city'));//contact
	doc.text(47, inpos, val('city'));//cell
	doc.text(118, inpos, val('salesrep'));//rep
	doc.text(157, inpos, val('city'));//rep_cell


	doc.text(9, 170, getVal($('#jobtype')));
	doc.text(9, 200, getVal($('#paverstyle')));
	doc.text(9, 220, getVal($('#manufacturer')));


	doc.setFontSize(9);
	doc.setFontStyle('normal');


 
	
	//row 2
	prevy = y;
	y = newLine(_xgap);
	doc.line(7, y, 208, y); 
	subline = getsubline(y);
	doc.text(8, subline, 'Job Address:');
	doc.text(165, subline, 'Est. Start Date:');
	doc.line(163, prevy, 163, y);//vertical lines
	
	//row 3
	prevy = y;
	y = newLine(_xgap);
	doc.line(89, prevy, 89, y);
	doc.line(163, prevy, 163, y)//vertical lines
	doc.text(8, getsubline(y), 'Billing Address:');
	doc.text(90, getsubline(y), 'Subdivision:');
	doc.text(165, getsubline(y), 'Lot #:');
	doc.line(7, y, 208, y); 
	
	//row 4
	prevy = y;
	y = newLine(_xgap);
	doc.line(49, prevy, 49, y)//vertical lines
	doc.line(134, prevy, 134, y)//vertical lines
	doc.text(8, getsubline(y), 'Office/Home:');
	doc.text(50, getsubline(y), 'Fax/Email:');
	doc.text(135, getsubline(y), 'Cross Streets:');
	doc.line(7, y, 208, y); 
	//doc.setLineWidth(3); 
	
	//row 5
	prevy = y;
	y = newLine(_xgap);
	doc.text(8, getsubline(y), 'Contact:');
	doc.text(46, getsubline(y), 'Cell:');
	doc.text(117, getsubline(y), 'Rep:');
	doc.text(156, getsubline(y), 'Rep Cell:');
	doc.line(45, prevy, 45, y+1)//vertical lines
	doc.line(116, prevy, 116, y+1)//
	doc.line(155, prevy, 155, y+1)
	//doc.line(7, y, 208, y);

	//doc.setFontSize(11); 
	//add logo
	//doc.addImage(getBase64Image('images/logo_srp.jpg'), 7, 10, 50, 25);
	
	
	doc.text(_LEFTMARGIN, newLine(), "New/Remodel             DW            BP             POOL             FIREPIT              FIREPLACE             SEATING            WW                   Prch");
	doc.text(_LEFTMARGIN, newLine(), "Stone      Rad.Heat     Pergola      Lnd      Scap/Spklr     Pavilion     BBQ      Pizza Oven     Water Ftr.   Boulder  Rwall");
	doc.text(_LEFTMARGIN, newLine(), "Tumbled UD   Over Existing Concrete   Conc./Grass/Dirt/Asp.Removal  Poly Sand  G  B  Sealer  W  N");
	doc.text(_LEFTMARGIN, newLine(), "Approx.Sq.Ft. ____________________RB_______________Face/CRV/THRSHD___________ Step LF/CRV_________");
	doc.text(_LEFTMARGIN, newLine(), "Pavers____________________________________________________________________________________________");
	doc.text(_LEFTMARGIN, newLine(), "Job description: ");
	doc.setFontSize(6); 
	doc.text(_LEFTMARGIN+27, newLine(-6), "All material and work listed to be performed in accordance with applicable drawings and specifications, completed in substantial and workman like manner.");

	//grid section *************************************************************
	y = newLine(-10);
	var top = 0;
	for(var i = 0; i < 30; i++)
	{
		if(i == 1) top = y;
		y = newLine(-1);
		doc.line(7, y, 208, y); //horizontal line
	}
	
	var col = _LEFTMARGIN;
	for(var i = 0; i < 34; i++)
	{
		doc.line(col, top, col, y);//vertical line
		col += 6;
	}
	doc.line(208, top, 208, y);
	
	//payment section  *********************************************************
	doc.setFontSize(9); 
	var paying = getPaySection();
	for(var i in paying)
	{
		var vpos = newLine(-2);
		doc.text(_LEFTMARGIN, vpos, paying[i]);
	}
	newLine();
	doc.text(_LEFTMARGIN, newLine(), "Authorized Signature: _______________________________________________  Date: _________________________");
	
	
	
	//disclaimer page **********************************************************
	doc.addPage();
	resetLine();
	doc.setFontSize(14); 
	doc.setFontStyle('bold');
	doc.text(81, newLine(), "Strong Rock Pavers");
	doc.text(_LEFTMARGIN+81, newLine(), "Warranty");
	//doc.setFontStyle('underline');
	y = newLine();
	doc.text(76, y, "Installation Disclaimer");
	doc.line(76, y+1, 128, y+1);
	newLine();
	newLine();
	doc.setFontStyle('normal');
	doc.setFontSize(9); 
	
	var disclaimer = getDisclaimer();
	for(var i in disclaimer)
	{
		var vpos = newLine(-2);
		var hpos = 0;
		var pos = disclaimer[i].indexOf(':');
		if (pos > 0) //find ':'
		{
			var txt = disclaimer[i].substr(0, pos+1);
			
			hpos = doc.getTextDimensions(txt).w;
			doc.setFontStyle('bold');
			doc.text(_LEFTMARGIN, vpos, txt);
			doc.setFontStyle('normal');
			doc.text(Math.ceil(hpos/2)+2, vpos, disclaimer[i].substr(pos+1, disclaimer[i].length));
		}
		else
		{
			doc.text(_LEFTMARGIN, vpos, disclaimer[i]);
		}
	}
	
	newLine();
	doc.text(_LEFTMARGIN, newLine(), "Customer Signature: _________________________________________________                            Date: ________________________");
	doc.setFontStyle('bold');
	doc.text(_LEFTMARGIN+81, newLine(), "WARRANTY");
	newLine();
	doc.setFontStyle('normal');
	doc.text(_LEFTMARGIN, newLine(-2), "The manufacturer provides their own warranty for all paver and wall products. Pavestone and Belgard provide a Lifetime Limited Warranty. ");
	doc.text(_LEFTMARGIN, newLine(-2), "Strong Rock Pavers provides a 2-year Warranty for all paver products we manufacture. Strong Rock Pavers also guarantees all labor and ");
	doc.text(_LEFTMARGIN, newLine(-2), "workmanship for two years. This warranty is for residential construction only and does not imply warranty for commercial applications.");
	newLine();
	doc.text(_LEFTMARGIN, newLine(), "Customer Signature: _________________________________________________                            Date: ________________________");
	//doc.save('Test.pdf');
	var ppf = doc.output('dataurlnewwindow'); //'dataurlnewwindow' datauristring
	//$('#pdfviewer').append('<object id="pdfview" data='+ ppf +' type="application/pdf" width="600" height="800"></object>');
	//document.getElementById("image").src = ppf;
	resetLine();

}

function resetLine()
{
	_newLine = margin;
}
function newLine(extra)
{
	var xtra = (extra !== undefined)? extra: 0;
	_newLine += line + xtra;
	return _newLine;
}
function getsubline(ypos)
{
	return ypos - _SUBLINEOFF;
}

function getBase64Image(imgsrc) {
	var img = new Image();
	img.src = imgsrc;
    // Create an empty canvas element
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;

    // Copy the image contents to the canvas
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);

    // Get the data-URL formatted image
    // Firefox supports PNG and JPEG. You could check img.src to
    // guess the original format, but be aware the using "image/jpg"
    // will re-encode the image.
    var dataURL = canvas.toDataURL("image/jpeg"); 

    return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
}

function val(id)
{
	return $('#'+id).val()||'';
}

function getVal(tag)
{
	if(tag != undefined)
		return tag.val();
	return "";
}

function getDisclaimer()
{
	var disclaimer = [];
	disclaimer.push("Material Delivery: Deliveries of pavers and sand may be made 1 to 3 days prior to the start date of the job. The customer is to have the ");
	disclaimer.push("specified area clear to allow for the storage of these materials. These materials, as well as any excavated material and/or concrete will be ");
	disclaimer.push("stored in the specific area until the completion of the project. Additional clean-up and removal fees will be charged if the customer requests ");
	disclaimer.push("removal of these materials prior to completion.");
	disclaimer.push("");
	disclaimer.push("Start and Completion Dates: The customer understands that scheduled start dates are an approximation and can be delayed by weather, ");
	disclaimer.push("manufacturer delivery schedules, delays at existing projects, employee absenteeism, acts of God or any other causes beyond its control.");
	disclaimer.push("");
	disclaimer.push("Excavation: The customer understands that the area in which the pavers are to be installed may be excavated 8\" to 12\" below finish grade, ");
	disclaimer.push("depending upon the thickness of the pavers and the amount of Type II required. This can vary between Driveway's and Patio's.");
	disclaimer.push("");
	disclaimer.push("Concrete Removal: It is very difficult to remove concrete without some damage to surrounding areas. Although care will be taken to ");
	disclaimer.push("minimize this damage, adjacent stucco, underground irrigation pipes, sprinklers, lawn and landscaping may incur some damage. The customer ");
	disclaimer.push("acknowledges that should there be unintentional damage to surrounding areas; Strong Rock Pavers is not financially responsible for the repair ");
	disclaimer.push("of this damage. Furthermore, if the existing concrete is in excess of six (6) inches in thickness or contains rebar or other steel reinforcement, ");
	disclaimer.push("customer will incur an additional charge of a minimum of $0.75 per square foot.");
	disclaimer.push("");
	disclaimer.push("Drainage: Excess water from rainfall, sprinklers, swimming pools, cleaning, etc. needs to drain off the pavement to prevent \"ponding\" and ");
	disclaimer.push("water from flowing toward structures and pools. In most cases, Strong Rock Pavers can avoid the use of drainpipes and \"deco-drains\" by ");
	disclaimer.push("creating the proper slopes and swales to direct excess water in the proper direction. If however, site conditions dictate that drains must be ");
	disclaimer.push("used; there will be an additional charge for the installation of the required drains.");
	disclaimer.push("");
	disclaimer.push("Landscaping: The installation of paving stone hardscapes requires excavation of the specified area to allow for proper installation and ");
	disclaimer.push("grading. The customer acknowledges that some damage to the landscaping adjacent to this area may incur some damage. In addition, the ");
	disclaimer.push("transportation of materials and debris in and around the job site with heavy equipment and/or repeated trips with wheelbarrows may cause ");
	disclaimer.push("damage to the yard as well. Should any additional labor be required for excavation beyond what is normal, such as caliche, boulders, tree ");
	disclaimer.push("roots, etc., the customer understands that they will be charged for the extra labor.");
	disclaimer.push("");
	disclaimer.push("Swimming Pool Remodels: It is common when demolishing concrete and/or coping around an existing swimming pool for there to be ");
	disclaimer.push("incidental damage to pool tile, skimmer, plumbing or electrical conduit when these objects are just below the surface of the concrete. Strong");
	disclaimer.push("Rock Pavers will make every attempt to minimize this damage; however, we cannot be responsible for the repair or replacement of these ");
	disclaimer.push("items. If there is water in the pool during demolition and installation the customer understands the concrete debris, mortar, grout and paved ");
	disclaimer.push("dust from cutting will end up in the pool and clean up will be the responsibility of the customer. Additionally, if the pool will not contain ");
	disclaimer.push("water during installation, there may be some staining of the plaster from mortar and grout.");
	disclaimer.push("");
	disclaimer.push("Snow Removal: Pavers is an upgraded hardscape. In low temperatures (32F or below) Radiant heat underneath your driveway, or walkway, ");
	disclaimer.push("or pool deck area is a comfort and good option to remove snow off pavers (Not obligatory). In the case that you do not have radiant heat the ");
	disclaimer.push("use of a blower is suggested to remove snow or you must require* that your snow removal company have their blade covered with industrial ");
	disclaimer.push("hard plastic/rubber. *This is a must. Strong Rock Pavers is not responsible for damage on the pavers' surface done by snow removal ");
	disclaimer.push("companies that used a regular steel blade on your driveway. DO NOT APPLY SALT. Application of salt voids paver warranty.");
	disclaimer.push("");
	disclaimer.push("Color Blends: Two and three color-blended pavers can vary in appearance from pallet to pallet depending on those delivered by the ");
	disclaimer.push("manufacturer. Installation crews will draw pavers from several pallets in order to distribute these pavers in as uniform manner as possible. ");
	disclaimer.push("However, if additional square footage beyond that specified in the original purchase agreement is ordered, the customer understands that the ");
	disclaimer.push("additional area may differ in appearance from the original scope of work. Color matching cannot be guaranteed.");
	disclaimer.push("");
	disclaimer.push("Sample Pavers: Should Strong Rock Pavers provide paver samples, the customer understands that it is difficult to represent accurately, color ");
	disclaimer.push("blends with a small amount of pavers (see Color Blends). In addition, slight color variations in production runs by the manufacturer can affect ");
	disclaimer.push("the color of the product delivered to the job site. The customer is responsible for their color selection and will be charged for re-stocking and ");
	disclaimer.push("delivery if they reject the product once it has been delivered.");
	disclaimer.push("");
	disclaimer.push("Property Damage: Deliveries of paver and wall products, as well as sand and aggregate base materials by heavy equipment such as semi-");
	disclaimer.push("trucks, dump trucks and forklifts. Although care is taken to minimize any damage, tire tracks, scratches or discoloration may occur. The ");
	disclaimer.push("customer hereby releases Strong Rock Pavers and its employees from responsibility for any and all damages to curbs, sidewalks, driveways, ");
	disclaimer.push("buildings, grounds or otherwise as a result of their making deliveries. The guarantee does not apply to splitting, chipping or there breakage ");
	disclaimer.push("that could be caused by impact, abrasion or overload. Strong Rock Pavers will not warranty any damage caused by loads or trucks of over ");
	disclaimer.push("26,000 pounds.");
	disclaimer.push("");
	disclaimer.push("Efflorescence: Efflorescence is a whitish powder-like deposit common on concrete and masonry products that normally will disappear over ");
	disclaimer.push("time due to different temperatures, moisture levels and weather. Efflorescence is a natural occurrence for which Strong Rock Pavers accepts ");
	disclaimer.push("no responsibility or liability.");
	disclaimer.push("");
	disclaimer.push("SRP Pavers: Our pavers are not for public sale, and are not engineered tested, and are made only when the customer wants to use them. I ");
	disclaimer.push("understand that the pavers are not engineered tested.");
	return disclaimer;
}

function getPaySection()
{
	var list = [];
	list.push("Payments to be made as follows: 50% down payment/deposit 5 days prior to projected project start date and final payment ");
	list.push("due upon project completion. Invoices past due 30 days or more are subject to a 5% per month service charge and 1.5% per month ");
	list.push("interest charge. Owner is responsible for all attorney fees in the case that the contractor is forced to go to court in order to obtain ");
	list.push("payment for services performed. Due to high demand of job materials and market conditions, projects started 30 days or more after ");
	list.push("the date of this proposal may be subject to price increases. INITIALS_____________.");
	list.push("Exclusion: SPRINKLERS, Underground unknown, rough grading/excavation, state and city sales tax.");
	list.push("Additional fees: $600.00 dumpster fee if one is not provide on jobsite. Any alteration or deviation to the Scope of the Work or ");
	list.push("Material Specifications listed above will require a bid revision or change order which could result in extra costs over and above the ");
	list.push("original contract value. Pavers, steps, retaining walls, different types of sands, sealers and concrete removal including landfill costs ");
	list.push("are priced differently and separately.");
	list.push("Owner/General Contractor warrants that ______________________________ is the titled owner of the real property and ");
	list.push("understands that Strong Rock Pavers is relying on this representation to enter into this contract. You are authorized to do the work ");
	list.push("as outlined above. Payment will be made by the undersigned as set forth in this document. (Material will be ordered once a signed ");
	list.push("contract is received). The above prices, scope of work, and conditions are satisfactory and hereby accepted.");
	return list;
}