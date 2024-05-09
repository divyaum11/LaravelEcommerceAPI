@include('layouts.default')
<div class="container">
    <div class="row">
        <div class="card-wrapper" id="view-product">
            <div class="card">
                <div class="product-imgs">
                    <div class="img-display">
                        <div class="img-showcase">
                        </div>
                    </div>
                    <div class="img-select">
                        <div class="img-item">
                        </div>
                    </div>
                </div>
                <div class="product-content">
                    <h2 class="product-title"></h2>

                    <div class="product-price">
                        <p class="new-price">Price: <span class="price"></span></p>
                    </div>

                    <div class="purchase-info">
                        <input type="number" class="quantity" min="0" value="1">
                        <button type="button" class="btn add-to-cart">
                            Add to Cart <i class="fas fa-shopping-cart"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input class="product-id" type="hidden" name="product_id" value="">

<script>
    base_url = '<?php echo config("app.url") ?>';

    $(document).ready(function() {
        var productId = window.location.pathname.split('/').pop();
        $.ajax({
            url: "{{ url('/get-products') }}",
            type: 'get',
            data: {
                product_id: productId
            },
            success: function(response) {
                console.log(response);
                $(".product-title").text(response.data.name);
                $(".product-id").val(response.data.id);
                $(".price").text("$" + response.data.price);
                $(".img-showcase").empty();

                // response.data.images.forEach(function(image) {
                //     var imgSrc = base_url + 'storage/' + image.image_url;
                //     var img = $("<img>").attr("src", imgSrc);
                //     $(".img-showcase").append(img);
                // });

                var imgSrc = base_url + 'storage/' + response.data.images[0].image_url;
                var img = $("<img>").attr("src", imgSrc).addClass("gallery-img");
                $(".img-showcase").append(img);

                $(".img-item").empty();
                response.data.images.forEach(function(image) {
                    var a = $("<a>").attr("href", "#").attr("data-id", image.id);
                    var imgSrc = base_url + 'storage/' + image.image_url;
                    var img = $("<img>").attr("src", imgSrc);
                    a.append(img);
                    $(".img-item").append(a);
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
        $('.add-to-cart').click(function() {
            var product_id = $(".product-id").val();
            var quantity = $(".quantity").val();
            var price = parseFloat($(".price").text().replace(/\$/g, ''));
            console.log(price);
            $.ajax({
                url: "{{ url('/add-to-cart') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    product_id: product_id,
                    quantity: quantity,
                    price: price,
                    user_id: 1
                },
                dataType: 'json',
                success: function(response) {
                    // window.location.reload();
                    window.location.href = "{{ url('cart') }}";
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

    });
</script>