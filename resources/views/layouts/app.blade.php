<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- ... (head section with meta tags, title, and CSS links) ... -->
    @yield('styles') <!-- Additional stylesheets for specific pages -->
</head>

<body>
    <div class="container">
        @yield('content') <!-- Page-specific content goes here -->
    </div>
    <!-- ... (JavaScript includes and other common elements) ... -->
    @yield('scripts') <!-- Additional scripts for specific pages -->
</body>

</html>
