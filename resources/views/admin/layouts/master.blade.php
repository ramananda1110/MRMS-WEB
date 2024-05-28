@include('admin.layouts.navbar')
@include('admin.layouts.sidebar')
<div id="layoutSidenav_content">
    <div class="container-fluid" style="background-color: #f0f0f0; " >
        <main style=" min-height: calc(100vh - 64px - 56px);"> <!-- Adjust the min-height value -->
            @yield('content')
        </main>

        @include('admin.layouts.fotter')
        </div>
</div>

<!-- Include JavaScript libraries here -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Add other necessary JS libraries here -->

<!-- Yield for custom scripts -->
@yield('scripts')