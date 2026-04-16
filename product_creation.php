<?php 
require_once "db.php";
$groups = $conn->query("SELECT * FROM product_master ORDER BY id ASC");
?>


<title>Product Creation</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
body{
    font-family: Arial;
    background:#dcdde1;
}

.container{
    width:700px;
    margin:50px auto;
    background:#eeeeee;
    padding:30px;
    border-radius:5px;
}

.title{
    text-align:center;
    margin-bottom:20px;
}

.title span{
    background:red;
    color:#fff;
    padding:5px 15px;
    border-radius:20px;
    font-size:14px;
}

label{
    font-weight:bold;
    display:block;
    margin-top:20px;
}

.label-blue{
    background:#0d6efd;
    color:white;
    padding:3px 10px;
    border-radius:15px;
    font-size:13px;
    display:inline-block;
}

.plus-btn{
    background:#00c2ff;
    border:none;
    color:white;
    font-weight:bold;
    padding:3px 8px;
    border-radius:3px;
    cursor:pointer;
}

input, select{
    width:100%;
    padding:8px;
    margin-top:8px;
    border:1px solid #ccc;
}

.save-btn{
    margin-top:30px;
    background:#1e9e59;
    color:white;
    border:none;
    padding:8px 25px;
    cursor:pointer;
    display:block;
    margin-left:auto;
    margin-right:auto;
}
</style>

<body>

<div class="container">

    <div class="title">
        <span>Product Creation</span>
    </div>

    <form id="productForm">

<!-- Group Name -->
<label>
<span class="label-blue">Group Name</span>
<button type="button" class="plus-btn">+</button>
</label>

<select name="group_id" required>
<option value="">---------Select----------</option>

<?php while($row = $groups->fetch_assoc()) { ?>

<option value="<?= $row['id']; ?>">
<?= $row['product_name']; ?>
</option>

<?php } ?>

</select>

 <!-- Product Name -->
<label>
<span class="label-blue">Product Name</span>
</label>

<input type="text" name="product_name" required>

<button type="submit" class="save-btn">
Save
</button>

</form>

<div id="msg"></div>

</div>


</div>
<script>

$("#productForm").submit(function(e){

e.preventDefault();

$.ajax({
    url:"insert_product.php",
    type:"POST",
    data:$(this).serialize(),
    success:function(response){

        $("#msg").html(response);
        $("#productForm")[0].reset();

    }
});

});

</script>
</body>
