<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>MadUniv — Academic Management System</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet"/>
<link href="{{ asset('css/style.css') }}" rel="stylesheet"/>
@stack('styles')
</head>
<body>

@auth
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <a href="{{ route('dashboard') }}" class="brand-logo">
      <div class="brand-icon"><i class="bi bi-mortarboard-fill"></i></div>
      <div>
        <div class="brand-name">MadUniv</div>
        <div class="brand-sub">Academic System</div>
      </div>
    </a>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-label">Overview</div>
    <div class="nav-item">
      <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2 nav-icon"></i> Dashboard
      </a>
    </div>

    <div class="nav-label" style="margin-top:12px;">Management</div>
    <div class="nav-item">
      <a href="{{ route('students.index') }}" class="nav-link-custom {{ request()->routeIs('students.*') ? 'active' : '' }}">
        <i class="bi bi-people nav-icon"></i> Students
      </a>
    </div>
    <div class="nav-item">
      <a href="{{ route('departments.index') }}" class="nav-link-custom {{ request()->routeIs('departments.*') ? 'active' : '' }}">
        <i class="bi bi-building nav-icon"></i> Departments
      </a>
    </div>
    <div class="nav-item">
      <a href="{{ route('courses.index') }}" class="nav-link-custom {{ request()->routeIs('courses.*') ? 'active' : '' }}">
        <i class="bi bi-journal-bookmark nav-icon"></i> Courses
      </a>
    </div>
  </nav>

  <div class="sidebar-footer">
    <div class="user-card" data-bs-toggle="dropdown" aria-expanded="false">
      <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
      <div>
        <div class="user-name">{{ Auth::user()->name }}</div>
        <div class="user-role">Administrator</div>
      </div>
      <i class="bi bi-chevron-up ms-auto" style="color:var(--muted)"></i>
    </div>
    <ul class="dropdown-menu dropdown-menu-dark w-100 mt-2">
      <li>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="dropdown-item" type="submit">Logout</button>
        </form>
      </li>
    </ul>
  </div>
</aside>

<main class="main">
  <div class="topbar">
    <button class="btn-icon d-md-none" onclick="document.getElementById('sidebar').classList.toggle('open')">
      <i class="bi bi-list"></i>
    </button>
    <div class="topbar-title">@yield('title')</div>
  </div>

  <div class="content">
    @if ($errors->any())
        <div class="alert alert-danger" style="background: rgba(248,113,113,0.15); border: 1px solid var(--red); color: var(--red);">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success" style="background: rgba(52,211,153,0.15); border: 1px solid var(--green); color: var(--green);">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
  </div>
</main>
@else
  @yield('content')
@endauth

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
