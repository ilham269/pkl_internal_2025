<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>@yield('title', 'Dashboard Admin')</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


<nav class="navbar navbar-dark bg-dark">
<div class="container-fluid">
<span class="navbar-brand">Admin Panel</span>
<span class="text-white">{{ auth()->user()->name ?? 'Admin' }}</span>
</div>
</nav>


<div class="container-fluid">
<div class="row">


<!-- Sidebar -->
<aside class="col-md-2 bg-light min-vh-100 p-3">
<ul class="nav flex-column">
<li class="nav-item">
<a class="nav-link active" href="#">Dashboard</a>
</li>
<li class="nav-item">
<a class="nav-link" href="#">Users</a>
</li>
<li class="nav-item">
<a class="nav-link" href="#">Produk</a>
</li>
<li class="nav-item">
<a class="nav-link text-danger" href="{{ route('logout') }}"
onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
Logout
</a>
</li>
</ul>


<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
@csrf
</form>
</aside>


<!-- Content -->
<main class="col-md-10 p-4">
@yield('content')
</main>


</div>
</div>


</body>
</html>
