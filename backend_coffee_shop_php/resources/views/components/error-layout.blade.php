@props(['message'])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>error</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
    @vite("resources/css/errors.scss")
</head>

<body>

    <div class="bsod container app-error">
        <h1 class="neg title"><span class="bg">Error - {{ $slot }}</span></h1>
        <p>An error has occurred. To continue:</p>
        <p>
            * Return to our homepage.<br />
            * Send us an email about this error and try again later.
        </p>
        <nav class="nav">
            <a href="{{ route('home') }}" class="link">Back</a>&nbsp;|&nbsp;
            <a href="{{ route('home') }}" class="link">Home Page</a>
        </nav>
    </div>


</body>

</html>
