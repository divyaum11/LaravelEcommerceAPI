@include('layouts.default')

<div class="container">
    <div class="row">
        @if ($products->isEmpty())
        <a href="{{ route('add-products-view') }}"><button type="button" class="btn btn-primary float-end mt-2 add-pro border-0">Add Products</button></a>
        <p class="text-center">No products available. Please add products.</p>
        @else
        <a href="{{ route('add-products-view') }}"><button type="button" class="btn btn-primary float-end mt-2 add-pro border-0">Add Products</button></a>
        <div class="gallery">
        </div>
        @endif
    </div>
</div>
<script>
    base_url = '<?php echo config("app.url") ?>';
    $(document).ready(function() {

        function viewProduct(productId) {
            window.location.href = "{{ url('/view-product') }}/" + productId;
        }

        $.ajax({
            url: "{{ url('/get-products') }}",
            type: 'get',
            success: function(response) {
                $(".gallery").empty();

                response.data.forEach(function(product) {
                    var productDiv = $("<div>").addClass("content");

                    var imgSrc = base_url + 'storage/' + product?.images?.[0]?.image_url;
                    var img = $("<img>").attr("src", imgSrc);
                    productDiv.append(img);
                    productDiv.append($("<h3>").text(product.name));
                    productDiv.append($("<h6>").text("$" + product.price));

                    var link = $("<button>").addClass("buy-" + product.id).text("View Product");
                    link.attr("href", "javascript:void(0);");
                    link.on('click', function() {
                        viewProduct(product.id);
                    });
                    productDiv.append(link);
                    $(".gallery").append(productDiv);
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
</script>