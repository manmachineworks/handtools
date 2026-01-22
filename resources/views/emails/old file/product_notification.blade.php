<!DOCTYPE html>
<html>

<head>
    <title>New Product Available</title>
</head>

<body>
    <h1>{{ $productName }}</h1>
    <p>A new product has been added to our store. You can check it out here:</p>
    <a href="{{ $productUrl }}">{{ $productUrl }}</a>
</body>

</html>