<?php
include 'config/db.php';
include 'includes/header.php'; 
?>

<div class="container text-center mt-5">
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="jumbotron p-5 bg-white shadow-sm rounded-4">
            <h1 class="display-4 fw-bold text-primary">Smart NBI Control Center</h1>
            <p class="lead text-muted">You are securely connected. Monitoring is active across your network.</p>
            <hr class="my-4">
            <div class="row g-4 mt-2">
                <div class="col-md-4">
                    <a href="dashboard.php" class="text-decoration-none">
                        <div class="p-4 border rounded-3 bg-light hover-shadow">
                            <i class="fas fa-chart-line fa-3x mb-3 text-info"></i>
                            <h5>Go to Dashboard</h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="manage_devices.php" class="text-decoration-none">
                        <div class="p-4 border rounded-3 bg-light hover-shadow">
                            <i class="fas fa-desktop fa-3x mb-3 text-success"></i>
                            <h5>Manage Devices</h5>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="alerts.php" class="text-decoration-none">
                        <div class="p-4 border rounded-3 bg-light hover-shadow">
                            <i class="fas fa-shield-alt fa-3x mb-3 text-warning"></i>
                            <h5>View AI Alerts</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="hero-section py-5">
            <h1 class="display-3 fw-bold">Welcome to Smart Monitoring AI</h1>
            <p class="fs-4 text-secondary mb-5">Your advanced dashboard for Network Behavior Intelligence (NBI) and automated monitoring.</p>
            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                <a href="register.php" class="btn btn-primary btn-lg px-5 gap-3 rounded-pill shadow">Get Started</a>
                <a href="#about-section" class="btn btn-outline-secondary btn-lg px-5 rounded-pill">Learn More</a>
            </div>
        </div>
        
        <div id="about-section" class="mt-5 pt-5 border-top">
            <h2 class="fw-bold mb-4">How it works?</h2>
            <div class="row text-start g-4">
                <div class="col-md-6">
                    <div class="p-4 bg-white shadow-sm rounded-3 h-100">
                        <h4><i class="fas fa-brain text-info me-2"></i> Machine Learning Analysis</h4>
                        <p>Our system uses NBI to detect anomalies in network traffic, identifying potential threats before they happen.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 bg-white shadow-sm rounded-3 h-100">
                        <h4><i class="fas fa-robot text-primary me-2"></i> Real-time Automation</h4>
                        <p>Instant monitoring of CPU and RAM usage with automated alerts sent directly to your dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .hover-shadow:hover { 
        box-shadow: 0 10px 20px rgba(0,0,0,0.1); 
        transform: translateY(-5px);
        transition: 0.3s;
    }
</style>