<div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="{{url('/')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>

                            <a class="nav-link" href="{{url('import-employee')}}">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>
                                Employee
                            </a>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Department
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>

                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    @if(isset(Auth()->user()->role->permission['name']['department']['can-add']))
                                           
                                    <a class="nav-link" href="{{Route('departments.create')}}">Create</a>
                                    @endif
                                    @if(isset(Auth()->user()->role->permission['name']['department']['can-list']))
                                    <a class="nav-link" href="{{Route('departments.index')}}">View</a>
                                    @endif

                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                User
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Role
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            @if(isset(Auth()->user()->role->permission['name']['role']['can-add']))
                                           
                                            <a class="nav-link" href="{{Route('roles.create')}}">Create Role</a>
                                            @endif

                                            @if(isset(Auth()->user()->role->permission['name']['role']['can-list']))
                                           
                                            <a class="nav-link" href="{{Route('roles.index')}}">View Role</a>
                                            @endif
                                           
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        User
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            @if(isset(Auth()->user()->role->permission['name']['user']['can-add']))
                                           
                                            <a class="nav-link" href="{{Route('users.create')}}">Create</a>
                                            @endif
                                           
                                            @if(isset(Auth()->user()->role->permission['name']['user']['can-list']))
                                           
                                            <a class="nav-link" href="{{Route('users.index')}}">View</a>
                                            @endif
                                           
                                        </nav>
                                    </div>

                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapsePermission" aria-expanded="false" aria-controls="pagesCollapsePermission">
                                        Permission
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapsePermission" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            @if(isset(Auth()->user()->role->permission['name']['permission']['can-add']))
                                                <a class="nav-link" href="{{Route('permissions.create')}}">Create</a>
                                            @endif    
                                            @if(isset(Auth()->user()->role->permission['name']['permission']['can-list']))
                                            <a class="nav-link" href="{{Route('permissions.index')}}">View</a>
                                            @endif
                                        </nav>
                                    </div>

                                </nav>
                            </div>


                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsRoom" aria-expanded="false" aria-controls="collapseLayoutsRoom">
                                <div class="sb-nav-link-icon"><i class="fas fa-laptop-house"></i></div>
                                Room
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayoutsRoom" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{Route('rooms.create')}}">Create</a>
                                <!-- @if(isset(Auth()->user()->role->permission['name']['leave']['can-add'])) -->
                                   
                                      
                                <!-- @endif -->
                               
                                    <a class="nav-link" href="{{Route('rooms.index')}}">View</a>
                                  

                                </nav>
                            </div>


                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsLeave" aria-expanded="false" aria-controls="collapseLayoutsLeave">
                                <div class="sb-nav-link-icon"><i class="fas fa-pencil-alt"></i></div>
                                Staf Leaves
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayoutsLeave" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{Route('leaves.create')}}">Create</a>
                                <!-- @if(isset(Auth()->user()->role->permission['name']['leave']['can-add'])) -->
                                   
                                      
                                <!-- @endif -->
                                @if(isset(Auth()->user()->role->permission['name']['leave']['can-list']))
                              
                                    <a class="nav-link" href="{{Route('leaves.index')}}">View</a>
                                    @endif

                                </nav>
                            </div>


                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayoutsNotice" aria-expanded="false" aria-controls="collapseLayoutsNotice">
                                <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                                Staf Notice
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayoutsNotice" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                              
                                @if(isset(Auth()->user()->role->permission['name']['notice']['can-add']))
                                   
                                     <a class="nav-link" href="{{Route('notices.create')}}">Create</a>
                                @endif
                               
                                @if(isset(Auth()->user()->role->permission['name']['notice']['can-list']))
                              
                                    <a class="nav-link" href="{{Route('notices.index')}}">View</a>
                                @endif

                                </nav>
                            </div>
                           
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        {{Auth()->user()->role->name}}
                    </div>
                </nav>
            </div>