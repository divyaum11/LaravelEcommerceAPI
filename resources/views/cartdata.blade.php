@include('layouts.default')
<section class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="display-5 mb-4 text-center">Shopping Cart</h3>
                @if($cartData->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 40%">Product</th>
                                    <th scope="col" style="width: 20%">Price</th>
                                    <th scope="col" style="width: 20%">Quantity</th>
                                    <th scope="col" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartData as $item)
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    @if(isset($productImages[$item->product_id]) && $productImages[$item->product_id]->isNotEmpty())
                                                        @php
                                                            $firstImage = $productImages[$item->product_id]->first();
                                                        @endphp
                                                        <img src="{{ config('app.url') }}storage/{{ $firstImage->image_url }}" alt="Product Image" class="img-fluid">
                                                    @else
                                                        <img src="https://via.placeholder.com/250x250" alt="Product Image" class="img-fluid">
                                                    @endif
                                                </div>
                                                <div class="col-md-8">
                                                    <p>{{ $productData[$item->product_id]->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ $productData[$item->product_id]->price }}</td>
                                        <td>
                                            <input type="number" class="form-control" value="{{ $item->quantity }}">
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-secondary">Update</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-cart-message">Your cart is empty.</div>
                    <a href="{{ route('home') }}" class="add-product-link">Add Products</a>
                @endif
                <div class="float-end">
                    <h4>Total Price: ${{ $totalAmount }}</h4>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary btn-lg w-100 checkout">Checkout</a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('home') }}" class="btn btn-secondary btn-lg w-100">Continue Shopping</a>
            </div>
        </div>
    </div>
</section>
