<!-- partial:/_managersidebar.php -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="../dashboard.php">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">Manage Projects</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../projects/viewProjects.php">
                            View Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../projects/createProjects.php">
                            Create a Project
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">System Users</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../system_users/ViewSystemUsers.php">
                            View System Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../system_users/CreateSystemUser.php">
                            Add System User
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="bi bi-calendar-week menu-icon"></i>
                <span class="menu-title">Rosters</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../rosters/team_roster.php">
                            Team Roster</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../rosters/personal_roster.php">
                            Personal Roster</a>
                    </li>
                </ul>
            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="icon-briefcase menu-icon"></i>
                <span class="menu-title">My Teams</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../teams/viewTeam.php">
                            View Teams</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../teams/createTeam.php">
                            Create a Team</a>
                    </li>
                </ul>
            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <i class="icon-check menu-icon"></i>
                <span class="menu-title">Approvals</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/icons/mdi.html">Active Approvals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/icons/mdi.html">Complete Approvals</a>
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
                        <a class="nav-link" href="../reports/project_reports.php">
                            Project Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../reports/user_reports.php">
                            User Reports
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="mailto:forgotpassword.admin@sourcetech.net?subject=Forgot Password ~ Source Tech Login" aria-expanded="false" aria-controls="error">
                <i class="icon-mail menu-icon"></i>
                <span class="menu-title">Contact</span>
            </a>
        </li>
    </ul>
</nav>