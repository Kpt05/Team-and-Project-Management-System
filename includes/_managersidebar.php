<!-- partial:/_managersidebar.php -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="../dashboard.php">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span> <!-- This is the dashboard link -->
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">Manage Projects</span> <!-- This is the Manage Projects link -->
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../projects/viewProjects.php"> <!-- This is the View Projects Page -->
                            View Projects
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../projects/createProjects.php"> <!-- This is the Create a Project Page -->
                            Create a Project
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">System Users</span> <!-- This is the System Users link -->
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../system_users/ViewSystemUsers.php"> <!-- This is the View System Users Page -->
                            View System Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../system_users/CreateSystemUser.php"> <!-- This is the Create a System User Page -->
                            Add System User
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="bi bi-calendar-week menu-icon"></i>
                <span class="menu-title">Rosters</span> <!-- This is the Rosters link -->
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../rosters/team_roster.php"> <!-- This is the Team Roster Page -->
                            Team Roster</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../rosters/personal_roster.php"> <!-- This is the Personal Roster Page -->
                            Personal Roster</a>
                    </li>
                </ul>
            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="icon-briefcase menu-icon"></i>
                <span class="menu-title">My Teams</span> <!-- This is the My Teams link -->
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../teams/viewTeam.php"> <!-- This is the View Teams Page -->
                            View Teams</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../teams/createTeam.php"> <!-- This is the Create a Team Page -->
                            Create a Team</a>
                    </li>
                </ul>
            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <i class="icon-check menu-icon"></i>
                <span class="menu-title">Approvals</span> <!-- This is the Approvals link -->
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/icons/mdi.html">Active Approvals</a> <!-- This is the Active Approvals Page -->
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/icons/mdi.html">Complete Approvals</a> <!-- This is the Complete Approvals Page -->
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="icon-bar-graph-2 menu-icon"></i>
                <span class="menu-title">Reports</span> <!-- This is the Reports link -->
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../reports/project_reports.php"> <!-- This is the Project Reports Page -->
                            Project Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../reports/user_reports.php"> <!-- This is the User Reports Page -->
                            User Reports
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="mailto:forgotpassword.admin@sourcetech.net?subject=Forgot Password ~ Source Tech Login" aria-expanded="false" aria-controls="error"> <!-- When clicked, this link will open the user's email client and pre-populate the email address, subject, and body -->
                <i class="icon-mail menu-icon"></i>
                <span class="menu-title">Contact</span>
            </a>
        </li>
    </ul>
</nav>