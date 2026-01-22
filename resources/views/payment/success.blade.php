<!doctype html>
<html class="no-js" lang="en">
@include("include/head")
<meta name="csrf-token" content="{{ csrf_token() }}">

<body>
    @include("include/header")


    <div class="d-flex justify-content-center align-items-center mt-50 mb-50">
        <div class="col-md-6">
            <div class="border border-3 border-success"></div>
            <div class="card  bg-white shadow p-5">
                <div class="mb-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                    </svg>
                </div>
                <div class="text-center">
                    <h1>Thank You !</h1>
                    <p>Your Payment is Succesfull (Go to Dashboard to Check Details)</p>
                    <a href="/dashboard" class="btn btn-outline-danger">Dashboard</a>
                </div>
            </div>
        </div>
    </div>
    @include("include/footer")

    <script>
        @if(!empty($purchaseData))
        const purchaseData = @json($purchaseData);

        // Check if the transaction ID has already been processed
        fetch(`/check-transaction/${purchaseData.transaction_id}`)
            .then(response => response.json())
            .then(data => {
                if (!data.processed) {
                    // Trigger the purchase event in Google Analytics
                    gtag("event", "purchase", {
                        transaction_id: purchaseData.transaction_id,
                        value: parseFloat(purchaseData.value),
                        tax: parseFloat(purchaseData.tax),
                        shipping: parseFloat(purchaseData.shipping),
                        currency: purchaseData.currency,
                        items: purchaseData.items.map(item => ({
                            item_id: item.item_id.toString(),
                            item_name: item.item_name,
                            price: parseFloat(item.price),
                            quantity: item.quantity,
                            item_variant: item.item_variant ? item.item_variant.toString() : null,
                            discount: item.discount
                        }))
                    });

                    // Mark the transaction as processed
                    fetch('/mark-transaction-processed', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for Laravel
                        },
                        body: JSON.stringify({
                            transaction_id: purchaseData.transaction_id
                        })
                    });
                } else {
                    console.log("Transaction already processed:", purchaseData.transaction_id);
                }
            })
            .catch(error => console.error("Error checking transaction:", error));
        @endif
    </script>


</body>

</html>