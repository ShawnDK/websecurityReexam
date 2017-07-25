<div class="container">

  <section class="panel-default">
    <div class="txt-align-center">
      <h3 class="panel-title">Add Product</h3>
    </div>
    <hr>
    <div class="panel-body">

      <form action="/websecurity/actions/action_add-product.php" enctype="multipart/form-data" class="form-horizontal" id="formAddProduct">

        <div class="form-group">
          <label for="name" class="col-sm-3 control-label">Product Name</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="name" id="addProductName" placeholder="Cheap Laptop ASUS">
          </div>
        </div>
        <!-- form-group // -->
        <div class="form-group">
          <label for="name" class="col-sm-3 control-label">Price</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="price" id="addProductPrice" placeholder="300$">
          </div>
        </div>
        <!-- form-group // -->
        <div class="form-group">
          <label for="name" class="col-sm-3 control-label">Period (days)</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" name="period" id="addProductPeriod" placeholder="1">
          </div>
        </div>
        <!-- form-group // -->
        <div class="form-group">
          <label for="about" class="col-sm-3 control-label">Description</label>
          <div class="col-sm-9">
            <textarea class="form-control" name="description" id="addProductDescription"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="name" class="col-sm-3 control-label">Picture</label>
          <div class="col-sm-3">
            <label class="control-label small" for="file_img">Types (png):</label> <input type="file" name="file_img" id="addProductImage">
          </div>
        </div>
        <div class="form-group">
          <label for="tech" class="col-sm-3 control-label">Categories</label>
          <div class="col-sm-3">
            <select id="addProductCategory" class="form-control">
            <option value="tv">Television</option>
              <option value="pc">Computer </option>
              <option value="drill">Driller </option>
            </select>
          </div>
        </div>
        <hr>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
            <button type="submit" class="btn btn-primary">ADD</button>
          </div>
        </div>
      </form>

    </div>
  </section>
</div>
<script>

$('#formAddProduct').on('submit',(function(e) {
    e.preventDefault();
    console.log(this);
    var formData = new FormData(this);
    console.log(formData);
    $.ajax({
        type:'POST',
        url: $(this).attr('action'),
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(data){
            console.log("success ");
            console.log(data);
            window.location.assign("/websecurity/profile");
        },
        error: function(data){
            console.log("error ");
            console.log(data);
            window.location.assign("/websecurity/profile");
        }
    });
}));
// function btnAddProduct(){
//   var sName = $("#addProductName").val();
//   var sPrice = $("#addProductPrice").val();
//   var sDescription = $("#addProductDescription").val();
//   var sCategory = $("#addProductCategory").val();
//   var sPicture = $("#addProductImage").val();
//   var sLink = "http://188.226.140.143/actions/action_add-product.php?name="+sName+"&price="+sPrice+"&description="+sDescription+"&category="+sCategory+"&picture="+sPicture;
//   console.log(sLink);
//   $.ajax({
//     "url":sLink,
//     "method":"post",
//     "dataType":"text",
//     "cache":false
//   }).done(function(Data){
//     swal("Product added", "!", "success");
//   })
// }

</script>