<!-- partial:/_adminsidebar.php -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="../dashboard.php">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span> <!-- Dashboard -->
            </a>
        </li>
    
        <!-- List of links to other pages -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">Manage Projects</span> <!-- Manage Projects Page-->
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../projects/viewProjects.php"> <!-- View Projects Page-->
                            View Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../projects/createProjects.php"> <!-- Create a Project Page -->
                            Create a Project
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">System Users</span> <!-- System Users Page -->
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../system_users/ViewSystemUsers.php"> <!-- View System Users Page -->
                            View System Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../system_users/CreateSystemUser.php"> <!-- Add System User Page -->
                            Add System User
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="icon-briefcase menu-icon"></i>
                <span class="menu-title">My Teams</span> <!-- My Teams Page -->
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../teams/viewTeam.php"> <!-- View Teams Page -->
                            View Teams</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../teams/createTeam.php"> <!-- Create a Team Page -->
                            Create a Team</a>
                    </li>
                </ul>
            </div>
        </li>

        

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="icon-bar-graph-2 menu-icon"></i>
                <span class="menu-title">Reports</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../reports/user_reports.php"> <!-- User Reports Page -->
                            System Reports
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>