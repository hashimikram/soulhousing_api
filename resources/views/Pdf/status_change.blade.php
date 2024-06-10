<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Encounter Details:</p>
    <p>ID: {{ $encounter->id }}</p>
    <p>Patient ID: {{ $encounter->patient_id }}</p>
    <p>Encounter Date: {{ $encounter->encounter_date }}</p>
    <p>Status: {{ $encounter->status }}</p>
    <!-- Add more encounter details as needed -->
</body>
</html>
