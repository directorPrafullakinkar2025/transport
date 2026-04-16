<?php
require_once 'db.php';   // make sure this has $conn connection

// $editData = null;

/* EDIT LOAD */
// if (isset($_GET['edit_id'])) {
//     $id = (int)$_GET['edit_id'];

//     $editQuery = mysqli_query(
//         $conn,
//         "SELECT * FROM group_master WHERE group_id = $id"
//     );

//     $editData = mysqli_fetch_assoc($editQuery);
// }

// /* INSERT / UPDATE */
// if(isset($_POST['save_group'])) {

//     $group = mysqli_real_escape_string($conn, $_POST['group_name']);

//     if(isset($_POST['group_id']) && $_POST['group_id'] != ''){

//         // UPDATE
//         $group_id = (int)$_POST['group_id'];

//         mysqli_query($conn, "
//             UPDATE group_master 
//             SET group_name='$group'
//             WHERE group_id=$group_id
//         ");

//         echo "<script>alert('Group Updated Successfully');</script>";

//     } else {

//         // INSERT
//         mysqli_query($conn, "
//             INSERT INTO group_master (group_name)
//             VALUES ('$group')
//         ");

//         echo "<script>alert('Group Saved Successfully');</script>";
//     }
// }
?>

<title>Group Creation</title>

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
    z-index:9999;
}

.modal.show{
    display:flex;
}

/* Modal Box */
.modal-box{
    background:#fff;
    width:450px;
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

.form-group input{
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


<div id="frmgroupmodal" class="modal">
    <div class="modal-box">

        <div class="modal-header">
            <span class="modal-title">Group Creation</span>
            <button class="close-btn" onclick="closeGroupModal()">×</button>
        </div>

        <form method="POST">

            <input type="hidden" name="group_id"
                   value="<?= isset($editData['group_id']) ? $editData['group_id'] : '' ?>">

            <div class="form-group">
                <label>Group Name *</label>
                        <input type="text" name="group_name"
                value="<?= isset($editData['group_name']) ? $editData['group_name'] : '' ?>"
                placeholder="Enter Group Name" required>
            </div>

            <div style="text-align:center; margin-top:15px;">
                <button type="submit" name="save_group" class="btn-save">
                    Save
                </button>

                <button type="button" class="btn-cancel" onclick="closeGroupModal()">
                    Cancel
                </button>
            </div>

        </form>

    </div>
</div>


<script>
function openGroupModal(){
    document.getElementById("frmgroupmodal").classList.add("show");
}

function closeGroupModal(){
    document.getElementById("frmgroupmodal").classList.remove("show");
}

document.getElementById("frmgroupmodal").addEventListener("click", function(event){
    if(event.target === this){
        closeGroupModal();
    }
});
</script>