<!-- resources/views/dashboard.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>React Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="app"></div>
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
