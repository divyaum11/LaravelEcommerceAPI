<div class="align-items-center d-flex justify-content-between p-2">
    <a href="{{ route('home') }}">
        <h3>Ecommerce</h3>
    </a>
    <a href="{{ route('cart') }}">
        <i class="bi bi-bell fs-5"></i>
        <span class="badge bg-danger rounded-circle position-absolute translate-middle">
            0
        </span>
    </a>
</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ url('/get-cart') }}",
            type: 'get',
            success: function(response) {
                $(".badge").text(response.data.cart_item_count);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
</script>