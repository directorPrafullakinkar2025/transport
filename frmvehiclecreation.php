<?php
require_once 'db.php';

if(isset($_POST['vehicle_number'])){

$owner_name = mysqli_real_escape_string($conn,$_POST['owner_broker_name']);
$vehicle_no = mysqli_real_escape_string($conn,$_POST['vehicle_number']);

if(!empty($vehicle_no)){

mysqli_query($conn,"
INSERT INTO vehicle_master (owner_broker_name, vehicle_number)
VALUES ('$owner_name','$vehicle_no')
");

echo "success";
exit;
}
}
?>
<style>

.modal{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.6);
justify-content:center;
align-items:center;
}

.modal.show{
display:flex;
}

.modal-box{
background:#fff;
width:500px;
padding:25px;
border-radius:8px;
}

.modal-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:15px;
}

.modal-header span{
font-size:18px;
font-weight:bold;
}

.close-btn{
background:red;
color:#fff;
border:none;
width:30px;
height:30px;
cursor:pointer;
border-radius:50%;
}

.form-group{
margin-bottom:12px;
}

.form-group label{
display:block;
font-weight:bold;
margin-bottom:4px;
}

.form-group input,
.form-group select{
width:100%;
padding:6px;
border:1px solid #ccc;
border-radius:4px;
}

.btn-save{
background:#198754;
color:white;
padding:8px 15px;
border:none;
border-radius:4px;
cursor:pointer;
}

</style>


<div id="frmvehiclemodal" class="modal">

<div class="modal-box">

<div class="modal-header">
<span>Vehicle Creation</span>
<button type="button" class="close-btn" onclick="closeVehicleModal()">×</button>
</div>

<form id="vehicleForm">

<div class="form-group">

<label>Owner / Broker
<button type="button" class="plus-btn" onclick="openPartyModal()">+</button>
</label>

<select name="owner_broker_name">

<option value="">Select Owner / Broker</option>

<?php
$q = mysqli_query($conn,"SELECT party_id,party_name FROM party_master ORDER BY party_name ASC");

while($r = mysqli_fetch_assoc($q)){
?>

<option value="<?= $r['party_name'] ?>">
<?= $r['party_name'] ?>
</option>

<?php } ?>

</select>

</div>


<div class="form-group">

<label>Vehicle Number *</label>

<input type="text" id="vehicle_number" name="vehicle_number" placeholder="Enter Vehicle Number" required>

</div>


<div style="text-align:center; margin-top:15px;">

<button type="button" onclick="saveVehicle()" class="btn-save">Save</button>

<button type="button" class="btn-save" style="background:#6c757d;" onclick="closeVehicleModal()">Cancel</button>

</div>

</form>

</div>

</div>


<script>

// function openVehicleModal(){
// document.getElementById("frmvehiclemodal").classList.add("show");
// }

// function closeVehicleModal(){
// document.getElementById("frmvehiclemodal").classList.remove("show");
// }

function saveVehicle(){

var owner = document.querySelector("[name='owner_broker_name']").value;
var vehicle = document.getElementById("vehicle_number").value;

if(vehicle == ""){
alert("Enter Vehicle Number");
return;
}

$.ajax({

url:"save_vehicle.php",
type:"POST",

data:{
owner_broker_name:owner,
vehicle_number:vehicle
},

success:function(res){

var data = JSON.parse(res);

if(data.status == "success"){

// alert("Vehicle Creation Successful");

$("#vehicle_number").val("");

refreshVehicles();   // refresh dropdown
closeVehicleModal(); // close modal

}else{

alert("Error : " + data.message);

}

}

});

}
</script>