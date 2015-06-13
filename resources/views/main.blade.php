<html>
<head>
<title>Todos</title>
<link rel="stylesheet" href="/css/todos.css" />
</head>
<body>
<div class="container">
    @yield('content')
</div>
<script src="/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
var CSRF_TOKEN = '{{ csrf_token() }}'
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': CSRF_TOKEN
    }
})
</script>
<script src="/js/todos.js"></script>
</body>
</html>
