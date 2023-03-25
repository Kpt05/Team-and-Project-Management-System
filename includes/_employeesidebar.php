<!-- partial:/_adminsidebar.php -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="../dashboard.php">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="icon-briefcase menu-icon"></i>
                <span class="menu-title">My Team</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="../teams/viewTeam.php">
                            View Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../teams/viewTeamProjects.php">
                            View Team Projects</a>
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
            <a class="nav-link" href="../clockings/clockings.php">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Clockings</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="../reports/personal_report.php">
                <i class="icon-bar-graph-2 menu-icon"></i>
                <span class="menu-title">Personal Report</span>
            </a>
        </li>


    </ul>
</nav>