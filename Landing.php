<?php 
session_start();
include 'includes/header.php'; 
?>

<div class="hero-section" style="background: linear-gradient(135px, #1a202c 0%, #2d3748 100%); color: white; padding: 120px 0; position: relative; overflow: hidden;">
    <div class="container text-center" style="position: relative; z-index: 2;">
        <div class="badge rounded-pill bg-primary mb-3 px-3 py-2" style="font-size: 0.9rem; letter-spacing: 1px;">
            <i class="fas fa-microchip me-2"></i> NEXT-GEN MONITORING
        </div>
        <h1 class="display-3 fw-bold mb-3">SmartMonitor <span style="color: #63b3ed;">AI</span></h1>
        <p class="lead mb-5 mx-auto" style="max-width: 700px; color: #cbd5e0; font-size: 1.25rem;">
            Empower your network with **Network Behavior Intelligence (NBI)**. Detect anomalies, monitor performance, and secure your infrastructure in real-time.
        </p>
        
        <div class="d-flex justify-content-center gap-3">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="<?php echo ($_SESSION['role'] == 'admin') ? 'admin_dashboard.php' : 'dashboard.php'; ?>" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg">
                    <i class="fas fa-th-large me-2"></i> Go to Dashboard
                </a>
            <?php else: ?>
                <a href="login.php" class="btn btn-primary btn-lg px-5 rounded-pill shadow-lg hover-scale">
                    Get Started <i class="fas fa-arrow-right ms-2"></i>
                </a>
                <a href="signup.php" class="btn btn-outline-light btn-lg px-5 rounded-pill">
                    Create Account
                </a>
            <?php endif; ?>
        </div>
    </div>
    
    <div style="position: absolute; top: 0; right: 0; opacity: 0.1; font-size: 10rem;">
        <i class="fas fa-network-wired"></i>
    </div>
</div>

<div class="container" style="margin-top: -50px; position: relative; z-index: 3;">
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-lg rounded-4 p-4 hover-up">
                <div class="icon-box mb-3 mx-auto" style="width: 70px; height: 70px; background: #e3f2fd; border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-user-shield fa-2x text-primary"></i>
                </div>
                <h4 class="fw-bold">NBI Protection</h4>
                <p class="text-muted">Advanced behavioral analysis to detect zero-day threats and network intrusions before they happen.</p>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-lg rounded-4 p-4 hover-up">
                <div class="icon-box mb-3 mx-auto" style="width: 70px; height: 70px; background: #e8f5e9; border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-chart-area fa-2x text-success"></i>
                </div>
                <h4 class="fw-bold">Live Metrics</h4>
                <p class="text-muted">Real-time visualization of CPU, RAM, and bandwidth usage with millisecond precision.</p>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-lg rounded-4 p-4 hover-up">
                <div class="icon-box mb-3 mx-auto" style="width: 70px; height: 70px; background: #fffde7; border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-robot fa-2x text-warning"></i>
                </div>
                <h4 class="fw-bold">AI Chatbot</h4>
                <p class="text-muted">Ask our intelligent assistant about your network status and get instant technical insights.</p>
            </div>
        </div>
    </div>
</div>

<div class="container my-5 py-5">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <h2 class="fw-bold mb-4">Why Choose SmartMonitor <span class="text-primary">AI</span>?</h2>
            <div class="d-flex mb-3">
                <i class="fas fa-check-circle text-primary mt-1 me-3 fa-lg"></i>
                <p><strong>Scalable Architecture:</strong> Monitor one device or ten thousand with the same efficiency.</p>
            </div>
            <div class="d-flex mb-3">
                <i class="fas fa-check-circle text-primary mt-1 me-3 fa-lg"></i>
                <p><strong>Render Cloud Deployment:</strong> Hosted on high-performance cloud infrastructure for 99.9% uptime.</p>
            </div>
            <div class="d-flex mb-3">
                <i class="fas fa-check-circle text-primary mt-1 me-3 fa-lg"></i>
                <p><strong>NBI Dashboard:</strong> A unified view for administrators to manage all connected clients.</p>
            </div>
        </div>
        <div class="col-lg-6">
            <img src="https://img.freepik.com/free-vector/network-mesh-wire-digital-technology-background_1017-27428.jpg" class="img-fluid rounded-4 shadow" alt="Network Monitoring">
        </div>
    </div>
</div>

<style>
    .hover-up { transition: all 0.3s ease; }
    .hover-up:hover { transform: translateY(-10px); }
    .hover-scale:hover { transform: scale(1.05); transition: 0.3s; }
    body { background-color: #f7fafc; }
</style>

<?php include 'includes/footer.php'; ?>