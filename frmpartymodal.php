<?php 
require_once 'state_names.php';
require_once 'city_names.php';

$editData = null;

if (isset($_GET['edit_id'])) {
    $id = (int)$_GET['edit_id'];

    $editQuery = mysqli_query($conn,"SELECT * FROM city_master WHERE city_id = $id");

    $editData = mysqli_fetch_assoc($editQuery);
}

if(isset($_POST['save_party'])) {
    echo "<script>alert('Party Saved Successfully');</script>";
}
?>

<title>Party Creation</title>

<style>
body{
    font-family: Arial, Helvetica, sans-serif;
}

/* Modal Background */
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
    /* z-index:2000; */
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
.form-group select,
.form-group textarea{
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


<!-- Modal -->
<div id="frmpartymodal" class="modal">
    <div class="modal-box">

        <div class="modal-header">
            <span>Party Creation</span>
            <button class="close-btn" onclick="closePartyModal()">×</button>
        </div>

        <!-- SINGLE FORM ONLY -->
       <form id="partyForm">

            <div class="form-group">
                <label>Ledger Group</label>
                <select name="ledger_group">
                    <option>Bank</option>
                    <option>Cash</option>
                    <option>Driver</option>
                    <option>Expense</option>
                    <option>Income</option>
                    <option>Office</option>
                    <option>Owner & Broker</option>
                    <option>Party</option>
                    <option>Staff</option>
                    <option>Supplier</option>
                </select>
            </div>

            <div class="form-group">
                <label>Party Name *</label>
                <input type="text" name="party_name" placeholder="Enter Ledger / Party Name" required>
            </div>

            <div class="form-group">
                <label>Address (1)</label>
                <textarea name="address_one" placeholder="Enter Address"></textarea>
            </div>
            <div class="form-group">
                <label>Address (2)</label>
                <textarea name="address_two" placeholder="Enter Address"></textarea>
            </div>
            <div class="form-group">
                <label>State Name *</label>
                <select name="state_name" id="state" required>
                    <option value="">Select State Name</option>
                    <?php foreach ($stateCities as $state => $cities): ?>
                    <option value="<?= $state ?>"
                    <?= (isset($editData) && $editData['state_name'] == $state) ? 'selected' : '' ?>>
                    <?= $state ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

<div class="form-group">
<label>City Name *</label>

<select name="city_name" id="city_id" required>
<option value="">Select City Name</option>

<?php
$cityList = mysqli_query($conn,"SELECT city_id, city_name FROM city_master ORDER BY city_name ASC");

while($row = mysqli_fetch_assoc($cityList)){
?>

<option value="<?= $row['city_name'] ?>">
<?= $row['city_name'] ?>
</option>

<?php } ?>

</select>
</div>
            <div class="form-group">
                <label>Mobile No.</label>
                <input type="text" name="mobile_number" placeholder="Enter Mobile No.">
            </div>

            <div style="text-align:center; margin-top:15px;">
                <button type="button" class="btn-save" onclick="submitPartyForm()">Save</button>
            </div>

        </form>

    </div>
</div>

<!-- <script>
function openPartyModal(){
    document.getElementById("frmpartymodal").classList.add("show");
}

function closePartyModal(){
    document.getElementById("frmpartymodal").classList.remove("show");
}

// document.getElementById("frmpartymodal").addEventListener("click", function(event){
//     if(event.target === this){
//         closePartyModal();
//     }
// });
</script> -->

<script>
var stateCities = <?= json_encode($stateCities) ?>;
</script>

<script src="city_dropdown.js"></script>
<script>
function submitPartyForm(){

let form = document.getElementById("partyForm");
let formData = new FormData(form);

fetch("save_party.php",{
method:"POST",
body:formData
})
.then(res => res.json())
.then(data => {

if(data.status=="success"){

// alert("Party Saved Successfully");

let consignor = document.getElementById("consignor");
let consignee = document.getElementById("consignee");
let billto    = document.getElementById("bill_to");

let option = new Option(data.party_name,data.party_id,true,true);

if(consignor) consignor.appendChild(option.cloneNode(true));
if(consignee) consignee.appendChild(option.cloneNode(true));
if(billto) billto.appendChild(option.cloneNode(true));

closePartyModal();

}else{
alert(data.message);
}

});
}
</script>