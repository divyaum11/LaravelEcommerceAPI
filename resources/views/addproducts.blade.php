@include('layouts.default')
<form action="/" method="POST" enctype="multipart/form-data" class="mt-4" id="add-product">
@csrf
    <div>
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" min="0" step="0.01" required>
    </div>
    <div>
        <label for="images">Images:</label>
        <input type="file" id="images" name="images[]" accept="image/*" multiple required>
    </div>
    <button type="button" class="btn btn-primary m-0" id="addProduct-btn">Add Product</button>
</form>

<script>
    $(document).ready(function() {
        $('#addProduct-btn').click(function() {
            var fileInput = document.getElementById('images');
            
            if (fileInput.files.length === 0) {
                alert('Please select at least one image.');
                return;
            }
            var formData = new FormData($('#add-product')[0]);
            $.ajax({
                url: "{{ url('/add-products') }}",
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    window.location.href = "{{ url('/') }}";
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>