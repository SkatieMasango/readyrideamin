<!DOCTYPE html>
<html>
<head>
    <title>Razorpay Checkout</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body onload="payNow()">
<script>
function payNow() {
    var options = {
        "key": "{{ $key }}",
        "amount": "{{ $amount }}",
        "currency": "{{ $currency }}",
        "name": "Order Payment",
        "description": "Order #{{ $order_id }}",
        "order_id": "{{ $razorpay_order_id }}",
        "handler": function (response){
            alert("Payment successful!\nPayment ID: " + response.razorpay_payment_id);
        },
        "prefill": {
            "email": "{{ $email }}",
            "name": "{{ $name }}"
        },
        "theme": {
            "color": "#528FF0"
        }
    };
    var rzp = new Razorpay(options);
    rzp.open();
}
</script>
</body>
</html>
