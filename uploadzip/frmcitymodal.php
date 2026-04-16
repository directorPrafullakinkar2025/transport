<?php
require_once 'db.php';   // make sure this has $conn connection

$editData = null;

/* EDIT LOAD */
if (isset($_GET['edit_id'])) {
    $id = (int)$_GET['edit_id'];

    $editQuery = mysqli_query(
        $conn,
        "SELECT * FROM city_master WHERE city_id = $id"
    );

    $editData = mysqli_fetch_assoc($editQuery);
}

/* INSERT / UPDATE */
if(isset($_POST['save_city'])) {

    $state = mysqli_real_escape_string($conn, $_POST['state_name']);
    $city  = mysqli_real_escape_string($conn, $_POST['city_name']);

    if(isset($_POST['city_id']) && $_POST['city_id'] != ''){

        // UPDATE
        $city_id = (int)$_POST['city_id'];

        mysqli_query($conn, "
            UPDATE city_master 
            SET state_name='$state',
                city_name='$city'
            WHERE city_id=$city_id
        ");

        echo "<script>alert('City Updated Successfully');</script>";

    } else {

        // INSERT
        mysqli_query($conn, "
            INSERT INTO city_master (state_name, city_name)
            VALUES ('$state','$city')
        ");

                        echo "<script>
                    alert('City Saved Successfully');
                    window.location.href=window.location.href;
                    </script>";
    }
}
?>


<title>City Creation</title>

<style>
body{
    font-family: Arial, Helvetica, sans-serif;
}

/* Open Button */
.open-btn{
    margin:40px;
    padding:10px 25px;
    background:#0d6efd;
    color:#fff;
    border:none;
    cursor:pointer;
    border-radius:4px;
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
    z-index:9999;
}

.modal.show{
    display:flex;
}

/* Modal Box */
.modal-box{
    background:#fff;
    width:500px;
    padding:25px;
    border-radius:8px;
}

/* Header */
.modal-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.modal-title{
    background:red;
    color:#fff;
    padding:5px 20px;
    border-radius:15px;
    font-weight:bold;
}

/* Close Button */
.close-btn{
    background:red;
    color:#fff;
    border:none;
    width:30px;
    height:30px;
    cursor:pointer;
    border-radius:50%;
}

/* Form */
.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    background:blue;
    color:#fff;
    padding:3px 12px;
    border-radius:15px;
    font-size:14px;
    margin-bottom:5px;
}

.form-group input,
.form-group select{
    width:100%;
    padding:8px;
    border:1px solid #ccc;
    border-radius:4px;
}

.btn-save{
    background:#198754;
    color:white;
    padding:8px 20px;
    border:none;
    border-radius:4px;
    cursor:pointer;
}

.btn-cancel{
    background:#6c757d;
    color:white;
    padding:8px 20px;
    border:none;
    border-radius:4px;
    cursor:pointer;
}
</style>


<div id="frmcitymodal" class="modal">
    <div class="modal-box">

        <div class="modal-header">
            <span class="modal-title">City Creation</span>
            <button class="close-btn" onclick="closeCityModal()">×</button>
        </div>
<form id="cityForm" method="POST">

            <input type="hidden" name="city_id" 
                   value="<?= isset($editData['city_id']) ? $editData['city_id'] : '' ?>">

            <div class="form-group">
                <label>State Name *</label>
                <input type="text" name="state_name"
                       value="<?= isset($editData['state_name']) ? $editData['state_name'] : '' ?>"
                       placeholder="Enter State Name" required>
            </div>

            <div class="form-group">
                <label>City Name *</label>
                <input type="text" name="city_name"
                       value="<?= isset($editData['city_name']) ? $editData['city_name'] : '' ?>"
                       placeholder="Enter City Name" required>
            </div>

            <div style="text-align:center; margin-top:15px;">
                <button type="submit" name="save_city" class="btn-save">
                    Save
                </button>
                <button type="button" class="btn-cancel" onclick="closeCityModal()">
                    Cancel
                </button>
            </div>

        </form>

    </div>
</div>
<!-- <script>
function openCityModal(){
    document.getElementById("frmcitymodal").classList.add("show");
}

function closeCityModal(){
    document.getElementById("frmcitymodal").classList.remove("show");
}

document.getElementById("frmcitymodal").addEventListener("click", function(event){
    if(event.target === this){
        closeCityModal();
    }
});
</script> -->

<script>

document.getElementById("cityForm").addEventListener("submit", function(e){

e.preventDefault();

let formData = new FormData(this);

fetch("save_city.php",{
method:"POST",
body:formData
})
.then(res => res.json())
.then(data => {

if(data.status == "success"){

success:function(res){
alert("City Added Successfully");
closeCityModal();
refreshCities();   // refresh dropdown
}

// /* Select2 new option */
// let newOption = new Option(data.city_name, data.city_id, true, true);

// $('#from_city').append(newOption).trigger('change');
// $('#to_city').append(newOption).trigger('change');

// closeCityModal();

// }

});

});

</script>