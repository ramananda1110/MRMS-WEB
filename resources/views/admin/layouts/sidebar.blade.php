<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light shadow-lg" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="{{ url('/') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <div class="ms-2"> Dashboard</div>
                    </a>
                    <div class="sb-sidenav-menu-heading">Interface</div>

                    <!-- <a class="nav-link" href="{{ url('import-employee') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>
                                Employee
                            </a> -->

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayoutsMeeting" aria-expanded="false" aria-controls="collapseLayouts">
                        <i class="fa-solid fa-couch"></i>
                        <div class="ms-2"> Meeting</div>
                        <div class="sb-sidenav-collapse-arrow"><i style="color: black" class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse" id="collapseLayoutsMeeting" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            @if (isset(Auth()->user()->role->permission['name']['meeting']['can-list']))

                            <a class="nav-link" href="{{ Route('meeting.index') }}">View</a>
                            @endif

                            @if (isset(Auth()->user()->role->permission['name']['meeting']['can-add']))

                            <a class="nav-link" href="{{ Route('meeting.create') }}">Create</a>
                            @endif

                        </nav>
                    </div>


                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayoutsEmp" aria-expanded="false" aria-controls="collapseLayouts">
                        <i class="fa-solid fa-users"></i>
                        <div class="ms-2">Emplopyee</div>
                        <div class="sb-sidenav-collapse-arrow"><i style="color: black" class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse" id="collapseLayoutsEmp" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            @if (isset(Auth()->user()->role->permission['name']['role']['can-list']))
                                <a class="nav-link" href="{{ Route('employee.index') }}">View</a>
                            @endif

                            @if (isset(Auth()->user()->role->permission['name']['role']['can-add']))
                                <a class="nav-link" href="{{ Route('employee.create') }}">Create</a>
                            @endif

                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                        <i class="fas fa-user"></i>
                        <div class="ms-2">User</div>
                        <div class="sb-sidenav-collapse-arrow"><i style="color: black" class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#pagesCollapseAuth" aria-expanded="false"
                                aria-controls="pagesCollapseAuth">
                                Role
                                <div class="sb-sidenav-collapse-arrow"><i style="color: black" class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    @if (isset(Auth()->user()->role->permission['name']['role']['can-add']))
                                        <a class="nav-link" href="{{ Route('roles.create') }}">Create Role</a>
                                    @endif

                                    @if (isset(Auth()->user()->role->permission['name']['role']['can-list']))
                                        <a class="nav-link" href="{{ Route('roles.index') }}">View Role</a>
                                    @endif

                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#pagesCollapseError" aria-expanded="false"
                                aria-controls="pagesCollapseError">
                                User
                                <div class="sb-sidenav-collapse-arrow"><i style="color: black" class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    @if (isset(Auth()->user()->role->permission['name']['user']['can-add']))
                                        <a class="nav-link" href="{{ Route('users.create') }}">Create</a>
                                    @endif

                                    @if (isset(Auth()->user()->role->permission['name']['user']['can-list']))
                                        <a class="nav-link" href="{{ Route('users.index') }}">View</a>
                                    @endif

                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                data-bs-target="#pagesCollapsePermission" aria-expanded="false"
                                aria-controls="pagesCollapsePermission">
                                Permission
                                <div class="sb-sidenav-collapse-arrow"><i style="color: black" class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapsePermission" aria-labelledby="headingOne"
                                data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    @if (auth()->user()->isAdmin())
                                        <a class="nav-link" href="{{ Route('permissions.create') }}">Create</a>
                                    @endif
                                    @if (isset(Auth()->user()->role->permission['name']['permission']['can-list']))
                                        <a class="nav-link" href="{{ Route('permissions.index') }}">View</a>
                                    @endif
                                </nav>
                            </div>

                        </nav>
                    </div>



                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <i class="fa-solid fa-building"></i>
                        <div class="ms-2"> Department</div>
                        <div class="sb-sidenav-collapse-arrow"><i style="color: black" class="fas fa-angle-down"></i></div>
                    </a>

                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            @if (isset(Auth()->user()->role->permission['name']['department']['can-add']))
                                <a class="nav-link" href="{{ Route('departments.create') }}">Create</a>
                            @endif
                            @if (isset(Auth()->user()->role->permission['name']['department']['can-list']))
                                <a class="nav-link" href="{{ Route('departments.index') }}">View</a>
                            @endif

                        </nav>
                    </div>


                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayoutsRoom" aria-expanded="false"
                        aria-controls="collapseLayoutsRoom">
                        <i class="fa-solid fa-door-open"></i>
                        <div class="ms-2"> Room</div>
                        <div class="sb-sidenav-collapse-arrow"><i style="color: black" class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayoutsRoom" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            @if (isset(Auth()->user()->role->permission['name']['room']['can-add']))

                            <a class="nav-link" href="{{ Route('rooms.create') }}">Create</a>
                            @endif
                            <!-- @if (isset(Auth()->user()->role->permission['name']['leave']['can-add']))
-->


                            <!--
@endif -->
                            @if (isset(Auth()->user()->role->permission['name']['room']['can-list']))

                            <a class="nav-link" href="{{ Route('rooms.index') }}">View</a>
                            @endif


                        </nav>
                    </div>


                    {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsLeave" aria-expanded="false" aria-controls="collapseLayoutsLeave">
                                <div class="sb-nav-link-icon"></div>
                                <i class="fas fa-pencil-alt"></i>
                                 <div class="ms-2"> Staf Leaves </div>
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a> --}}
                    {{-- <div class="collapse" id="collapseLayoutsLeave" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{Route('leaves.create')}}">Create</a>
                                <!-- @if (isset(Auth()->user()->role->permission['name']['leave']['can-add'])) -->
                                   
                                      
                                <!-- @endif -->
                                @if (isset(Auth()->user()->role->permission['name']['leave']['can-list']))
                              
                                    <a class="nav-link" href="{{Route('leaves.index')}}">View</a>
                                    @endif

                                </nav>
                            </div> --}}


                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayoutsNotice" aria-expanded="false"
                        aria-controls="collapseLayoutsNotice">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div class="ms-2"> Staf Notice</div>
                        <div class="sb-sidenav-collapse-arrow"><i style="color: black" class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayoutsNotice" aria-labelledby="headingOne"
                        data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">

                            @if (isset(Auth()->user()->role->permission['name']['notice']['can-add']))
                                <a class="nav-link" href="{{ Route('notices.create') }}">Create</a>
                            @endif

                            @if (isset(Auth()->user()->role->permission['name']['notice']['can-list']))
                                <a class="nav-link" href="{{ Route('notices.index') }}">View</a>
                            @endif

                        </nav>
                    </div>

                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                {{ Auth()->user()->role->name }}
            </div>
        </nav>
    </div>
    <script>
        // JavaScript to handle sidebar item click
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarItems = document.querySelectorAll('.nav-link');
            
            sidebarItems.forEach(item => {
                item.addEventListener('click', function () {
                    // Remove 'show' class from all other items
                    sidebarItems.forEach(item => {
                        item.classList.remove('show');
                    });
                    
                    // Add 'show' class to the clicked item
                    this.classList.add('show');
                });
            });
        });
    </script>
    
   
