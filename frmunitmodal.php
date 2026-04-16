<?php
if(isset($_POST['save_unit'])){
    $unit_name  = $_POST['unit_name'];
    $unit_value = $_POST['unit_value'];

    if(!empty($unit_name) && !empty($unit_value)){
        echo "<script>alert('Unit Saved Successfully');</script>";
    }
}
?>

<div id="unitModal" class="modal">
    <div class="modal-box">

        <div class="modal-header">
            <span>Unit Creation</span>
            <button type="button" class="close-btn" onclick="closeUnitModal()">×</button>
        </div>

        <form method="POST">

            <div class="form-group">
                <label>Unit Name *</label>
                <input type="text" id="unit_name" name="unit_name" placeholder="Enter Unit Name" required>
            </div>

            <div class="form-group">
                <label>Unit Value *</label>
                <input type="text" id="unit_value" name="unit_value" placeholder="Enter Unit Value" required>
            </div>

            <div style="text-align:center; margin-top:15px;">
                <button type="button" class="btn-save" onclick="saveUnit()">Save</button>
                <button type="button" class="btn-save" style="background:#6c757d;" onclick="closeUnitModal()">Cancel</button>
            </div>

        </form>

    </div>
</div>

<script>

function openUnitModal(){
    document.getElementById("unitModal").classList.add("show");
}

function closeUnitModal(){
    document.getElementById("unitModal").classList.remove("show");
}

function saveUnit()
{
    var unit_name  = document.getElementById("unit_name").value;
    var unit_value = document.getElementById("unit_value").value;

    if(unit_name=="" || unit_value=="")
    {
        alert("Please fill all fields");
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST","insert_unit.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    xhr.onload = function()
    {
        if(this.responseText.trim() == "success")
        {
            // alert("Unit Saved Successfully");

            loadUnitDropdown(); 
            closeUnitModal();

            document.getElementById("unit_name").value="";
            document.getElementById("unit_value").value="";
        }
    }

    xhr.send("unit_name="+unit_name+"&unit_value="+unit_value);
}

</script>