<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<h1>{{ $scheduling->title }}</h1>
<p>{{ $scheduling->description }}</p>
<p>Date: {{ $scheduling->date }}</p>
<p>Start Time: {{ $scheduling->time }}</p>
<p>End Time: {{ $scheduling->end_time }}</p>

</body>
</html>
