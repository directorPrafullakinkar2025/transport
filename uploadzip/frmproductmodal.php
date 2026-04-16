

<div id="frmproductmodal" class="modal">
    <div class="modal-box">

        <div class="modal-header">
            <span>Product Creation</span>
            <button type="button" class="close-btn" onclick="closeProductModal()">×</button>
        </div>

        <form id="productForm">

            <div class="form-group">
                <label>
                    Group Name
                    <!-- Plus button kept as you had -->
                    <button type="button" class="plus-btn" onclick="openGroupModal()">+</button>
                </label>

                <select name="group_name" id="group_name" required>
                    <option value="">--------Select--------</option>
                    <option>General Goods</option>
                    <option>Industrial</option>
                </select>
            </div>

            <div class="form-group">
                <label>Product Name *</label>
                <input type="text" id="product_name" name="product_name" placeholder="Enter Product Name" required>
            </div>

<div style="text-align:center; margin-top:20px;">
    <button type="submit" class="btn-save" >Save</button>
</div>

        </form>

    </div>
</div>
<?php include 'groupmodal.php'; ?>
<script>
function openProductModal(){
    document.getElementById("frmproductmodal").classList.add("show");
}

function closeProductModal(){
    document.getElementById("frmproductmodal").classList.remove("show");
}

document.getElementById("frmproductmodal").addEventListener("click", function(event){
    if(event.target === this){
        closeProductModal();
    }
});
</script>
<script>
var productSubmitting = false;

document.getElementById("productForm").addEventListener("submit", function(e){

    e.preventDefault();

    if(productSubmitting) return; // prevents double submit
    productSubmitting = true;

    var group_name = document.getElementById("group_name").value.trim();
    var product_name = document.getElementById("product_name").value.trim();

    var xhr = new XMLHttpRequest();
    xhr.open("POST","insert_product.php",true);
    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    xhr.onload = function(){

        productSubmitting = false;

        if(this.responseText.trim()=="success")
        {
            alert("Product Saved Successfully");

            document.getElementById("product_name").value="";
            document.getElementById("group_name").value="";

            closeProductModal();
            loadProductDropdown();
        }
    };

    xhr.send("group_name="+group_name+"&product_name="+product_name);
});
</script>