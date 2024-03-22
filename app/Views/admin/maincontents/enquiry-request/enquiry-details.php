<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<style type="text/css">
.progress-bar-wrapper ul.progress-bar {
	width: 100%;
	margin: 0;
	padding: 0;
	font-size: 0;
	list-style: none;
	background-color: #FFF;
	display: inline-block !important;
}
.progress-bar-wrapper li.section {
	display: inline-block !important;
	padding-top: 45px;
	font-size: 10px;
	font-weight: bold;
	line-height: 16px;
	color: gray;
	vertical-align: top;
	position: relative;
	text-align: center;
	overflow: hidden;
	text-overflow: ellipsis;
	word-wrap: break-word;
}
.progress-bar-wrapper li.section:before {
	content: 'x';
	position: absolute;
	top: 3px;
	left: calc(50% - 15px);
	z-index: 1;
	width: 30px;
	height: 30px;
	color: white;
	border: 2px solid white;
	border-radius: 17px;
	line-height: 26px;
	background: gray;
}
.progress-bar-wrapper .status-bar {
	height: 2px;
	background: gray;
	position: relative;
	top: 20px;
	margin: 0 auto;
}
.progress-bar-wrapper .current-status {
	height: 3px;
	width: 0;
	border-radius: 1px;
	background: #26a541;
}
 @keyframes changeBackground {
 from {
background: gray
}
 to {
background: #26a541
}
}
.progress-bar-wrapper li.section.visited:before {
	content: '\2714';
	animation: changeBackground 3s linear;
	animation-fill-mode: forwards;
}
.progress-bar-wrapper li.section.visited.current:before {
	box-shadow: 0 0 0 2px #26a541;
}
.home-successstories .owl-nav {
	position: absolute;
	top: 50%;
	transform: translate(0, -50%);
	width: 100%;
	display: block;
}
.home-successstories .owl-nav button {
	width: 50px;
	height: 50px;
	border: 2px solid #fff !important;
	color: #fff !important;
	font-size: 22px !important;
	border-radius: 50px;
}
.home-successstories .owl-nav button.owl-next {
	right: 0;
	position: absolute;
}
.sucess_boximg {
	height: 500px;
	object-fit: cover;
	overflow: hidden;
}
.sucess_boximg img {
	object-fit: cover;
	height: 100%;
	width: 100%;
}
.material_accordion_section button.accordion-button {
	color: #fff;
	font-size: 18px;
}
.material_accordion_section .accordion-button::after {
	font-family: "Font Awesome 5 Free";
	font-weight: 900;
	content: "\f078";
";
	position: absolute;
	right: 5px;
	color: #fff;
	background-image: none;
}
.material_accordion_section .tab-content {
    padding: 30px;
    background: #fff;
    border: 1px solid #ddd;
    border-top: none;
}
.material_accordion_section .nav-tabs .nav-item .nav-link {
    background: #f2f2f2;
    margin-right: 8px;
    color: #000;
}
.material_accordion_section .nav-tabs .nav-item .nav-link.active {
    background: #198754;
    color: #fff;
}
</style>

<div class="pagetitle">
  <h1>
    <?=$page_header?>
  </h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
      <li class="breadcrumb-item active">
        <?=$page_header?>
      </li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="row">
    <div class="col-xl-12">
      <?php if(session('success_message')){?>
      <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
        <?=session('success_message')?>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php }?>
      <?php if(session('error_message')){?>
      <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
        <?=session('error_message')?>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php }?>
    </div>
    <div class="col-lg-12 mb-3">
      <div class="card">
        <div class="card-body">
          <div class="progress-bar-wrapper" style="margin-bottom: 10px;">
            <div class="status-bar" style="width: 90%;">
              <div class="current-status" style="width: 33.3333%; transition: width 2100ms linear 0s;"></div>
            </div>
            <ul class="progress-bar">
              <li class="section visited" style="width: 10%;">Vendor Assigned</li>
              <li class="section visited" style="width: 10%;">Pickup Scheduled</li>
              <li class="section visited" style="width: 10%;">Vehicle Placed</li>
              <li class="section visited current" style="width: 10%;">Material Weighed</li>
              <li class="section" style="width: 10%;">Invoice from HO</li>
              <li class="section" style="width: 10%;">Invoice to Vendor</li>
              <li class="section" style="width: 10%;">Payment received from Vendor</li>
              <li class="section" style="width: 10%;">Vehicle Dispatched</li>
              <li class="section" style="width: 10%;">Payment To HO</li>
              <li class="section" style="width: 10%;">Order Complete</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12 mb-3">
      <div class="card">
        <div class="card-body">
          <div class="row mt-3">
            
            <div class="col-md-6">
              <h5 class="fw-bold text-success">Enquiry No.</h5>
              <h6>ECOMM-0000059-B</h6>
            </div>
            <div class="col-md-6">
              <h5 class="fw-bold text-success">Company / Plant</h5>
              <h6> KEYLINE DIGITECH PRIVATE LIMITED <br>
                KEYLINE DIGITECH PRIVATE LIMITED PLANT </h6>
            </div>
            <div class="col-md-6">
              <h5 class="fw-bold text-success">Vendor</h5>
              <h6> S.K.P. ENTERPRISES </h6>
            </div>
            <div class="col-md-6">
              <h5 class="fw-bold text-success">GPS Tracking Image</h5>
              <h6> <a href="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ebff2f6bb14.jpg" target="_blank"><img src="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ebff2f6bb14.jpg" alt="ECOMM-0000059" class="img-thumbnail" style="width: 250px; height: 250px; margin-top: 10px;"></a> </h6>
            </div>
            <div class="col-md-6">
              <h5 class="fw-bold text-success">Tentative Collection Date</h5>
              <h6>Mar 23, 2024</h6>
            </div>
            <div class="col-md-6">
              <h5 class="fw-bold text-success">Latitude</h5>
              <h6>22.5759858</h6>
            </div>
            <div class="col-md-6">
              <h5 class="fw-bold text-success">Device Brand</h5>
              <h6>realme</h6>
            </div>
            <div class="col-md-6">
              <h5 class="fw-bold text-success">Longitude</h5>
              <h6>88.297654</h6>
            </div>
            <div class="col-md-6">
              <h5 class="fw-bold text-success">Device Model</h5>
              <h6>RMX2002</h6>
            </div>
            <div class="col-md-6">
              <h5 class="fw-bold text-success">Assigned Date</h5>
              <h6>Mar 09, 2024 11:54 AM</h6>
            </div>
            <div class="col-md-6">
              <h5 class="fw-bold text-success">Pickup Scheduled Date</h5>
              <h6> Mar 20, 2024 12:00 PM </h6>
            </div>
          </div>
        </div>
      </div>
      <div class="material_accordion_section">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">ECOMM-0000066-1</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">ECOMM-0000066-2</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">ECOMM-0000066-3</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">ECOMM-0000066-3</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">ECOMM-0000066-3</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">ECOMM-0000066-3</button>
            </li>
            
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row">

            <div class="col-md-6">
              <h5 class="fw-bold text-success">Enquiry No.</h5>
              <h6>ECOMM-0000059-B</h6>
            </div>
            <div class="col-md-6">
              <h5 class="fw-bold text-success">Company / Plant</h5>
              <h6> KEYLINE DIGITECH PRIVATE LIMITED <br>
                KEYLINE DIGITECH PRIVATE LIMITED PLANT </h6>
            </div>
            </div>
            
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button bg-success collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"> Enquiry Request Items </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse show collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>HSN</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Digital Marketing</td>
                                    <td>111111</td>
                                    <td>25.00</td>
                                    <td>55.00</td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button bg-success collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> Pickup Scheduled </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            <table class="table">
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>Pickup Date/Time</th>
                                <th>Submitted Date/Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>1</td>
                                <td>Mar 20, 2024 12:00 PM</td>
                                <td>Mar 09, 2024 12:05 PM</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button bg-success collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> Vehicle Placed &nbsp;&nbsp; <span style="float: left; font-size: 14px">(1 vehicles placed)</span> </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            <table class="table">
                            <thead>
                                <tr>
                                <th>#</th>
                                <th>Vehicle Number</th>
                                <th>Vehicle Images</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>1</td>
                                <td>WB02AA2574</td>
                                <td><div class="row">
                                    <div class="col-md-3"> <a href="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec0523dfcd6.jpg" download=""><img src="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec0523dfcd6.jpg" class="img-thumbnail" style="height:100px;width: 100%;"></a> </div>
                                    <div class="col-md-3"> <a href="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec0523e15a9.jpg" download=""><img src="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec0523e15a9.jpg" class="img-thumbnail" style="height:100px;width: 100%;"></a> </div>
                                    </div></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> Material Weighted </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <form method="POST" action="http://localhost/ecoex-commodity-trading/admin/enquiry-requests/modify-approve-material-weight">
                            <input type="hidden" name="sub_enquiry_no" value="ECOMM-0000059-B">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item Name</th>
                                    <th>Weighted Qty</th>
                                    <th>Vendor Submitted Material Weight</th>
                                    <th>Plant Submitted Material Weight</th>
                                    <th>Weight Slips</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Digital Marketing</td>
                                    <td><span class="weight-label">75.00</span>
                                    <input type="text" name="weighted_qty[]" class="form-control weight-value" value="75.00" style="display: none;"></td>
                                    <td>Mar 09, 2024 12:18 PM</td>
                                    <td>Mar 09, 2024 12:32 PM</td>
                                    <td><div class="row">
                                        <div class="col-md-6"> <a href="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec063e972d1.jpg" download=""><img src="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec063e972d1.jpg" class="img-thumbnail" style="height:100px;width: 100px;"></a> </div>
                                        <div class="col-md-6"> <a href="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec098b430ee.jpg" download=""><img src="http://localhost/ecoex-commodity-trading/public/uploads/enquiry/65ec098b430ee.jpg" class="img-thumbnail" style="height:100px;width: 100px;"></a> </div>
                                    </div></td>
                                </tr>
                                <tr>
                                    <td colspan="6" style="text-align:center;"><h6 class="badge bg-success">Material Weight Approved</h6></td>
                                </tr>
                                </tbody>
                            </table>
                            </form>
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed bg-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive"> Invoice From HO </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row mt-3">
                            <div class="col-md-6 text-center"> <a href="http://localhost/ecoex-commodity-trading/admin/enquiry-requests/request-invoice-to-HO-from-ecoex/NTk=/RUNPTU0tMDAwMDA1OS1C" class="btn btn-warning btn-sm" onclick="return confirm('Do you want to sent request for invoice to HO ?');"><i class="fa-solid fa-code-pull-request"></i> Request For Invoice To HO</a> </div>
                            <div class="col-md-6 text-center"> </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
        </div>
        
      </div>
    </div>
  </div>
</section>
