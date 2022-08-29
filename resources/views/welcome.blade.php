@extends('layouts.app')

@section('content')

<!-- insert modal -->
<div class="modal fade" id="insertmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add new Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="error"></div>
        <div class="form-group">
            <label for="">Product Name</label>
            <input type="text" id="name" class="form-control">
            <label for="">Product brand</label>
            <input type="text" id="brand" class="form-control">
            <label for="">Product price</label>
            <input type="text" id="price" class="form-control">
            <label for="">Product stock</label>
            <input type="text" id="stock" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="add_product" class="btn btn-primary">Add Product</button>
      </div>
    </div>
  </div>
</div>
<!-- end insert modal -->

<!-- edit modal -->
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="error"></div>
        <div class="form-group">
            <input type="hidden" id="product_id">
            <label for="">Product Name</label>
            <input type="text" id="edit_name" class="form-control">
            <label for="">Product brand</label>
            <input type="text" id="edit_brand" class="form-control">
            <label for="">Product price</label>
            <input type="text" id="edit_price" class="form-control">
            <label for="">Product stock</label>
            <input type="text" id="edit_stock" class="form-control">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="update_product" class="btn btn-primary">Confirm edit Product</button>
      </div>
    </div>
  </div>
</div>
<!-- end edit modal -->

<!-- delete modal -->
<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="error"></div>
        <div class="form-group">
            <input type="hidden" id="delete_id">
        <h5 class="modal-title" id="exampleModalLabel">Are sure to Delete this Product?</h5>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="delete_product" class="btn btn-primary">Confirm Delete Product</button>
      </div>
    </div>
  </div>
</div>
<!-- end delete modal -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <div class="card-header py-5">
                    <div class="success"></div>
                    <h2>Product Data
                        <a href="" id="insert" data-bs-toggle="modal" data-bs-target="#insertmodal" class="btn btn-primary float-end btn-sm">Add Product</a>
                    </h2>
                </div>
                <table class="table table-stripe table-dark">
                    <thead>
                        <tr>
                            <th>Product Id</th>
                            <th>Product Name</th>
                            <th>Product Brand</th>
                            <th>Product Price</th>
                            <th>Product Stock</th>
                            <th>Edit Product</th>
                            <th>Delete Product</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>kjsdfj</td>
                            <td>kjsdfj</td>
                            <td>kjsdfj</td>
                            <td>kjsdfj</td>
                            <td>kjsdfj</td>
                            
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

    $(document).ready(function () { 

        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

        //display data
        displayData();
        function displayData() { 

            $.ajax({
            type:'get',
            url:'/display_data',
            dataType:'json',
            success:function(response){
                $('tbody').html('');
                $.each(response.product, function (key, value) { 
                    $('tbody').append('<tr>\
                            <td>'+value.id+'</td>\
                            <td>'+value.Product_name+'</td>\
                            <td>'+value.Product_brand+'</td>\
                            <td>'+value.Product_price+'</td>\
                            <td>'+value.Product_stock+'</td>\
                            <td><button type="button" value="'+value.id+'" class="edit_btn btn btn-primary btn-sm">Edit</button></td>\
                            <td><button type="button" value="'+value.id+'" class="delete_btn btn btn-danger btn-sm">Delete</button></td>\
                        </tr>');
                 });
            }
        }); 
    }

    //set id delete product
    $(document).on('click', '.delete_btn', function (e) { 
        let id = $(this).val();
        $('#delete_id').val(id);
        $('#deletemodal').modal('show');
    });
    //delete product
    $(document).on('click', '#delete_product', function(e){
        e.preventDefault();

        let id = $('#delete_id').val();
        $.ajax({
            type:'delete',
            url:'/delete/'+id,
            dataType:'json',
            success:function(response){

            $('.success').html('');
            $('.success').addClass('alert alert-success');
            $('.success').text(response.success);
            $('#deletemodal').modal('hide');
            displayData();  
    
            }
        });
    });

    //update product data
    $(document).on('click', '#update_product', function(e){
        e.preventDefault();

        let id = $('#product_id').val();
        let data = {
                'name':$('#edit_name').val(),
                'brand':$('#edit_brand').val(),
                'price':$('#edit_price').val(),
                'stock':$('#edit_stock').val()
        }
        
        $.ajax({
            type:'put',
            url:'/update_data/'+id,
            data:data,
            dataType:'json',
            success:function(response){
                console.log(response);
                if(response.status == 400){
                        $('.error').html('');
                        $('.error').addClass('alert alert-danger');
                        $.each(response.error, function (key, err_data) { 
                            $('.error').append('<li>'+err_data+'</li>');
                         });
                    }else if(response.status == 404){
                        $('.success').html('');
                        $('.success').addClass('alert alert-success');
                        $('.success').text(response.succes);
                    }else{
                        $('.success').html('');
                        $('.success').addClass('alert alert-success');
                        $('.success').text(response.success);
                        $('#editmodal').find('input').val('');
                        $('#editmodal').modal('hide');
                        displayData();
                    }
            }
        });

        console.log(data);
    });


        //set edit data
        $(document).on('click', '.edit_btn', function (e) { 
            e.preventDefault();

            let id = $(this).val();
            $('#editmodal').modal('show');
            $.ajax({
                type:'get',
                url:'/getdata/'+id,
                dataType:'json',
                success:function(response){

                    if(response.error == 404){
                        $('#success').html('');
                        $('#success').addClass('alert alert-warning');
                        $('#success').text(response.success);
                    }else{
                        $('#product_id').val(response.product.id);
                        $('#edit_name').val(response.product.Product_name);
                        $('#edit_brand').val(response.product.Product_brand);
                        $('#edit_price').val(response.product.Product_price);
                        $('#edit_stock').val(response.product.Product_stock);
                    }
                }
            });
        });
        

        //insert data
        $('#add_product').on('click', function (e) { 
            e.preventDefault();

            let data = {
                'name':$('#name').val(),
                'brand':$('#brand').val(),
                'price':$('#price').val(),
                'stock':$('#stock').val()
            };

            $.ajax({
                type:'post',
                url:'/insertdata',
                data: data,
                dataType: 'json',
                success:function(response){
                    
                    if(response.status == 400){
                        $('.error').html('');
                        $('.error').addClass('alert alert-danger');
                        $.each(response.error, function (key, err_data) { 
                            $('.error').append('<li>'+err_data+'</li>');
                         });
                    }else{
                        $('.success').html('');
                        $('.success').addClass('alert alert-success');
                        $('.success').text(response.success);
                        $('#insertmodal').find('input').val('');
                        $('#insertmodal').modal('hide');
                        displayData();
                    }
                }
            });
         });
     });
</script>
@endsection