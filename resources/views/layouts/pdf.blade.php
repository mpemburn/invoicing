<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->

    <!-- Styles -->
    <link rel="stylesheet" href="{{ URL::to('/public/css') }}/pdf.css">

</head>
<body id="pdf-layout">
<div class="container ">
    @yield('content')
</div>
</body>
</html>
