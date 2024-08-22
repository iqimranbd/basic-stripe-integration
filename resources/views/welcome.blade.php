<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
<h1>Buy a Product</h1>

<form action="{{ route('payment.store') }}" method="POST" id="payment-form">
    @csrf

    <label for="product">Select a Product:</label>
    <select id="price" name="price" required>
        <option value="10" data-price="1000">Product 1 - $10.00</option>
        <option value="20" data-price="2000">Product 2 - $20.00</option>
        <option value="30" data-price="3000">Product 3 - $30.00</option>
    </select>
<br />
    <label for="card-holder-name">Procuct Name:</label>
    <input id="product_name" type="text" name="product_name" required>

    <div id="card-element"></div>

    <button id="card-button" data-secret="" type="submit"> #{{ $intent->client_secret ?? "" }}
        Pay
    </button>
</form>

{{--<script>--}}
{{--    const stripe = Stripe('{{ config('cashier.key') }}');--}}
{{--    const elements = stripe.elements();--}}
{{--    const cardElement = elements.create('card');--}}
{{--    cardElement.mount('#card-element');--}}

{{--    const cardHolderName = document.getElementById('card-holder-name');--}}
{{--    const cardButton = document.getElementById('card-button');--}}
{{--    const clientSecret = cardButton.dataset.secret;--}}

{{--    const form = document.getElementById('payment-form');--}}
{{--    form.addEventListener('submit', async (e) => {--}}
{{--        e.preventDefault();--}}

{{--        const { setupIntent, error } = await stripe.confirmCardSetup(--}}
{{--            clientSecret, {--}}
{{--                payment_method: {--}}
{{--                    card: cardElement,--}}
{{--                    billing_details: { name: cardHolderName.value }--}}
{{--                }--}}
{{--            }--}}
{{--        );--}}

{{--        if (error) {--}}
{{--            // Display error.message in your UI.--}}
{{--            console.log(error.message);--}}
{{--        } else {--}}
{{--            const paymentMethodInput = document.createElement('input');--}}
{{--            paymentMethodInput.setAttribute('type', 'hidden');--}}
{{--            paymentMethodInput.setAttribute('name', 'paymentMethod');--}}
{{--            paymentMethodInput.setAttribute('value', setupIntent.payment_method);--}}

{{--            const selectedProduct = document.getElementById('product');--}}
{{--            const priceInput = document.createElement('input');--}}
{{--            priceInput.setAttribute('type', 'hidden');--}}
{{--            priceInput.setAttribute('name', 'price');--}}
{{--            priceInput.setAttribute('value', selectedProduct.options[selectedProduct.selectedIndex].getAttribute('data-price'));--}}

{{--            form.appendChild(paymentMethodInput);--}}
{{--            form.appendChild(priceInput);--}}
{{--            form.submit();--}}
{{--        }--}}
{{--    });--}}
{{--</script>--}}
</body>
</html>
