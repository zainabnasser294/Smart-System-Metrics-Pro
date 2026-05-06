<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartMonitor AI</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background-color: #f8f9fa; margin: 0; }

        
        .navbar { 
            background-color: #1a202c !important; 
            padding: 10px 20px;
        }

        .navbar-brand { font-weight: bold; color: #63b3ed !important; }

        .navbar-nav .nav-link { 
            color: #ffffff !important; 
            font-size: 0.9rem; 
            margin-right: 10px;
            display: flex;
            align-items: center;
        }

        .navbar-nav .nav-link i { margin-right: 5px; }

        .user-pill {
            background: #2d3748;
            color: #63b3ed;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            border: 1px solid #4a5568;
        }

        .logout-btn {
            border: 1px solid #fc8181;
            color: #fc8181 !important;
            border-radius: 8px;
            padding: 5px 15px !important;
        }

        
        .dashboard-container { display: flex; min-height: 100vh; }

        
        .sidebar { 
            width: 260px; 
            background: #1a202c;
            padding-top: 20px;
            min-height: 100vh;
        }

        .sidebar .nav-link { 
            color: #cbd5e0 !important; 
            padding: 12px 25px; 
            border-left: 4px solid transparent; 
            transition: 0.3s; 
        }

        .sidebar .nav-link:hover { 
            background: rgba(255,255,255,0.05); 
            color: #ffffff !important; 
        }

        .sidebar .nav-link.active { 
            background: #2d3748; 
            color: #63b3ed !important; 
            border-left-color: #63b3ed; 
        }

        .content-area { 
            flex: 1; 
            padding: 30px; 
            background: #f8f9fa; 
        }
    </style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-shield-alt"></i> SmartMonitor AI
        </a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="about.php">
                        <i class="fas fa-info-circle"></i> About
                    </a>
                </li>

                <?php if(isset($_SESSION['user_id'])): ?>

                    <li class="nav-item me-2">
                        <span class="user-pill">
                            <i class="fas fa-user-circle"></i> <?php echo $_SESSION['username']; ?>
                        </span>
                    </li>

                    
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo ($_SESSION['role']=='admin') ? 'admin_dashboard.php' : 'dashboard.php'; ?>">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item ms-3">
                        <a class="nav-link logout-btn" href="logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>

                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<div class="dashboard-container">

<?php
$current_page = basename($_SERVER['PHP_SELF']);
$show_sidebar = isset($_SESSION['user_id']);
?>

<?php if($show_sidebar): ?>
<div class="sidebar">

   
    <div class="px-4 mb-4 mt-3">
        <h5 class="fw-bold text-white">
            <i class="fas fa-shield-alt text-info me-2"></i> NBI Control
        </h5>
    </div>

    
    <div class="px-4 mb-2 small fw-bold text-muted">CUSTOMER</div>

    <a href="dashboard.php" class="nav-link <?php echo ($current_page == 'dashboard.php')?'active':''; ?>">
        <i class="fas fa-home me-2"></i> Dashboard
    </a>

    <a href="manage_devices.php" class="nav-link <?php echo ($current_page == 'manage_devices.php')?'active':''; ?>">
        <i class="fas fa-laptop me-2"></i> My Devices
    </a>

    <a href="alerts.php" class="nav-link <?php echo ($current_page == 'alerts.php')?'active':''; ?>">
        <i class="fas fa-bell me-2"></i> Alerts
    </a>

    <a href="contact.php" class="nav-link <?php echo ($current_page == 'contact.php')?'active':''; ?>">
        <i class="fas fa-envelope me-2"></i> Contact
    </a>

  

    <a href="contact.php" class="nav-link <?php echo ($current_page == 'contact.php')?'active':''; ?>">
        <i class="fas fa-envelope me-2"></i> Contact
    </a>

   
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'analyst'): ?>
        <hr class="mx-4 my-3" style="border-top: 1px solid rgba(255,255,255,0.1);">
        <div class="px-4 mb-2 small fw-bold text-muted">ANALYST PANEL</div>

        <a href="view_metrics.php" class="nav-link <?php echo ($current_page == 'view_metrics.php')?'active':''; ?>">
            <i class="fas fa-chart-line me-2"></i> System Metrics
        </a>
        <a href="view_customer_dashboard.php" class="nav-link <?php echo ($current_page == 'view_customer_dashboard.php')?'active':''; ?>">
            <i class="fas fa-desktop me-2"></i> Live Monitoring
        </a>
    <?php endif; ?>


     
    <!-- ADMIN -->
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>

        <hr class="mx-4 my-3" style="border-top: 1px solid rgba(255,255,255,0.1);">

        <div class="px-4 mb-2 small fw-bold text-muted">ADMIN PANEL</div>

        <a href="admin_dashboard.php" class="nav-link <?php echo ($current_page == 'admin_dashboard.php')?'active':''; ?>">
            <i class="fas fa-user-shield me-2"></i> Admin Overview
        </a>

        <a href="admin_manage_users.php" class="nav-link <?php echo ($current_page == 'admin_manage_users.php')?'active':''; ?>">
            <i class="fas fa-users-cog me-2"></i> Manage Customers
        </a>

        <a href="admin_pages_manager.php" class="nav-link <?php echo ($current_page == 'admin_pages_manager.php')?'active':''; ?>">
            <i class="fas fa-file-code me-2"></i> Pages Manager
        </a>

        <a href="admin_db_manager.php" class="nav-link <?php echo ($current_page == 'admin_db_manager.php')?'active':''; ?>">
            <i class="fas fa-database me-2"></i> Database Manager
        </a>

        <a href="admin_messages.php" class="nav-link <?php echo ($current_page == 'admin_messages.php')?'active':''; ?>">
            <i class="fas fa-envelope-open-text me-2"></i> Inquiries
        </a>

        <a href="admin_alerts.php" class="nav-link <?php echo ($current_page == 'admin_alerts.php')?'active':''; ?>">
            <i class="fas fa-exclamation-triangle me-2"></i> Global Alerts
        </a>

        <div class="mt-4 px-4 mb-2 small fw-bold text-muted">MONITORING</div>

        <a href="view_customer_dashboard.php" class="nav-link <?php echo ($current_page == 'view_customer_dashboard.php')?'active':''; ?>">
            <i class="fas fa-desktop me-2"></i> Live Customer View
        </a>

        <a href="view_metrics.php" class="nav-link <?php echo ($current_page == 'view_metrics.php')?'active':''; ?>">
            <i class="fas fa-chart-line me-2"></i> System Metrics
        </a>

    <?php endif; ?>

</div>
<?php endif; ?>


<div class="content-area">