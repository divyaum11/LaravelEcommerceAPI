<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Add Product</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    #header {
        background: #303030;
        color: #fff;
    }

    /* all product page css*/
    a {
        text-decoration: none;
        color: #fff;
    }

    .gallery {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        justify-content: center;
        align-items: center;
        margin: 50px 0;
    }

    .gallery .content {
        width: 20%;
        min-width: 250px;
        margin: 15px;
        text-align: center;
        background-color: #f2f2f2;
        padding-top: 10px;
    }

    .gallery .content:hover {
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15), 0 3px 6px rgba(0, 0, 0, 0.24);
        transform: translateY(-3px);
    }

    .gallery img {
        width: 200px;
        height: 200px;
        text-align: center;
        margin: 0 auto;
        display: block;
        border-radius: 16px;
    }

    .gallery h3 {
        text-align: center;
        font-size: 25px;
        margin: 0;
        padding: 12px 0;
    }

    .gallery p {
        text-align: center;
        color: #b2bec3;
        padding: 0 8px;
    }

    .gallery h6 {
        font-size: 18px;
        text-align: center;
        color: #222f25;
        margin: 5px 0;
    }

    .gallery ul {
        list-style: none;
        display: flex;
        justify-content: center;
        align-items: center;
        padding-top: 0;
    }

    .gallery li {
        padding-left: 4px;
    }

    .gallery .fas {
        font-size: 24px;
    }

    .gallery .checked {
        color: gold;
    }

    .gallery button {
        text-align: center;
        width: 100%;
        border: none;
        background-color: #f64749;
        color: #fff;
        padding: 10px;
        cursor: pointer;
        font-size: 20px;
        margin-top: 10px;
        outline: none;
    }

    .add-pro {
        background-color: #f64749;
    }

    .add-pro:hover {
        background-color: #f64749;
    }

    /* view product page css*/

    #view-product .card-wrapper {
        max-width: 1100px;
        margin: 0 auto;
    }

    #view-product img {
        width: 20%;
    }

    #view-product .img-display {
        overflow: hidden;
    }

    #view-product .img-showcase {
        display: flex;
        width: 100%;
        transition: all 0.5s ease;
    }

    #view-product .img-showcase img {
        min-width: 50%;
    }

    #view-product .img-select {
        display: flex;
    }

    #view-product .img-item {
        margin: 0.3rem;
    }

    #view-product .img-item:nth-child(1),
    #view-product .img-item:nth-child(2),
    #view-product .img-item:nth-child(3) {
        margin-right: 0;
    }

    #view-product .img-item:hover {
        opacity: 0.8;
    }

    #view-product .product-content {
        padding: 2rem 1rem;
    }

    #view-product .product-title {
        font-size: 3rem;
        text-transform: capitalize;
        font-weight: 700;
        position: relative;
        color: #12263a;
        margin: 1rem 0;
    }

    #view-product .product-title::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        height: 4px;
        width: 80px;
        background: #12263a;
    }

    #view-product .product-link {
        text-decoration: none;
        text-transform: uppercase;
        font-weight: 400;
        font-size: 0.9rem;
        display: inline-block;
        margin-bottom: 0.5rem;
        background: #256eff;
        color: #fff;
        padding: 0 0.3rem;
        transition: all 0.5s ease;
    }

    #view-product .product-link:hover {
        opacity: 0.9;
    }

    #view-product .product-rating {
        color: #ffc107;
    }

    #view-product .product-rating span {
        font-weight: 600;
        color: #252525;
    }

    #view-product .product-price {
        margin: 1rem 0;
        font-size: 1rem;
        font-weight: 700;
    }

    #view-product .product-price span {
        font-weight: 400;
    }

    #view-product .last-price span {
        color: #f64749;
        text-decoration: line-through;
    }

    #view-product .new-price span {
        color: #256eff;
    }

    #view-product .product-detail h2 {
        text-transform: capitalize;
        color: #12263a;
        padding-bottom: 0.6rem;
    }

    #view-product .product-detail p {
        font-size: 0.9rem;
        padding: 0.3rem;
        opacity: 0.8;
    }

    #view-product .product-detail ul {
        margin: 1rem 0;
        font-size: 0.9rem;
    }

    #view-product .product-detail ul li {
        margin: 0;
        list-style: none;
        background-size: 18px;
        padding-left: 1.7rem;
        margin: 0.4rem 0;
        font-weight: 600;
        opacity: 0.9;
    }

    #view-product .product-detail ul li span {
        font-weight: 400;
    }

    #view-product .purchase-info {
        margin: 1.5rem 0;
    }

    #view-product .purchase-info input,
    #view-product .purchase-info .btn {
        border: 1.5px solid #ddd;
        border-radius: 25px;
        text-align: center;
        padding: 0.45rem 0.8rem;
        outline: 0;
        margin-right: 0.2rem;
        margin-bottom: 1rem;
    }

    #view-product .purchase-info input {
        width: 60px;
    }

    #view-product .purchase-info .btn {
        cursor: pointer;
        color: #fff;
    }

    #view-product .purchase-info .btn:first-of-type {
        background: #256eff;
    }

    #view-product .purchase-info .btn:last-of-type {
        background: #f64749;
    }

    #view-product .purchase-info .btn:hover {
        opacity: 0.9;
    }

    #view-product .social-links {
        display: flex;
        align-items: center;
    }

    #view-product .social-links a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        color: #000;
        border: 1px solid #000;
        margin: 0 0.2rem;
        border-radius: 50%;
        text-decoration: none;
        font-size: 0.8rem;
        transition: all 0.5s ease;
    }

    #view-product .social-links a:hover {
        background: #000;
        border-color: transparent;
        color: #fff;
    }

    @media screen and (min-width: 992px) {
        #view-product .card {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 1.5rem;
        }

        #view-product .card-wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #view-product .product-imgs {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        #view-product .product-content {
            padding-top: 0;
        }
    }

    /* add products page css*/

    form {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    #add-product label {
        display: block;
        margin-bottom: 5px;
    }

    #add-product input[type="text"],
    #add-product input[type="number"],
    #add-product input[type="file"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
        box-sizing: border-box;
    }

    #add-product input[type="file"] {
        margin-bottom: 20px;
    }

    #add-product button[type="button"] {
        width: 100%;
        padding: 10px;
        background-color: #f64749;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    #add-product button[type="button"]:hover {
        background-color: #f64749;
    }

    .badge {
        font-size: 10px;
        width: 18px;
        height: 18px;
        right: 100px;
        top: 20px;
        text-align: center;
    }

    /*Cart page css*/
    .cart-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    .cart-item {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .cart-item img {
        width: 100px;
        height: 100px;
        margin-right: 20px;
    }

    .cart-item-details {
        flex: 1;
    }

    .cart-item-title {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .cart-item-price {
        font-weight: bold;
    }

    .cart-item-quantity {
        margin-top: 5px;
    }

    .cart-item-remove {
        color: red;
        cursor: pointer;
        font-size: 16px;
    }

    .empty-cart-message {
        text-align: center;
        font-size: 18px;
        margin-top: 20px;
    }

    .add-product-link {
        display: block;
        text-align: center;
        margin-top: 10px;
    }

    .checkout {
        background: #f64749;
        border: unset;
    }
</style>