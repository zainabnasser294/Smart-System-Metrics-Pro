<?php
include 'config/db.php';
include 'includes/header.php';
?>

<style>
    .about-header { background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%); color: white; padding: 60px 0; border-radius: 20px; margin-bottom: 50px; }
    .feature-icon { font-size: 3rem; margin-bottom: 20px; color: #3498db; }
    .step-box { border-left: 4px solid #3498db; padding-left: 20px; margin-bottom: 40px; position: relative; }
    .step-number { position: absolute; left: -15px; top: 0; background: #3498db; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
    .concept-card { background: white; border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: 0.3s; }
    .concept-card:hover { transform: translateY(-10px); }
</style>

<div class="container mt-4">
    <div class="about-header text-center shadow-lg">
        <h1 class="display-4 fw-bold">Understanding Smart NBI</h1>
        <p class="lead">How our intelligent system monitors, analyzes, and protects your network.</p>
    </div>

    <div class="row text-center mb-5">
        <div class="col-md-4">
            <div class="card concept-card p-4 h-100">
                <i class="fas fa-microchip feature-icon"></i>
                <h4>Data Collection</h4>
                <p class="text-muted">Python scripts gather real-time metrics (CPU, RAM, Traffic) from every connected device.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card concept-card p-4 h-100">
                <i class="fas fa-brain feature-icon text-success"></i>
                <h4>NBI Analysis</h4>
                <p class="text-muted">Network Behavior Intelligence analyzes patterns to distinguish between normal and suspicious activity.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card concept-card p-4 h-100">
                <i class="fas fa-shield-alt feature-icon text-warning"></i>
                <h4>Instant Protection</h4>
                <p class="text-muted">The system triggers immediate visual alerts and logs every anomaly detected by the AI.</p>
            </div>
        </div>
    </div>

    <div class="row align-items-center mt-5">
        <div class="col-lg-6">
            <h2 class="fw-bold mb-4">How it Works (The Workflow)</h2>
            <div class="step-box">
                <div class="step-number">1</div>
                <h5>Collector Service</h5>
                <p>The <code>collector.py</code> runs on the client machine, capturing system behavior every few seconds.</p>
            </div>
            <div class="step-box">
                <div class="step-number">2</div>
                <h5>Secure Transmission</h5>
                <p>Data is sent via encrypted API requests to our central database (MySQL).</p>
            </div>
            <div class="step-box">
                <div class="step-number">3</div>
                <h5>Intelligence Engine</h5>
                <p>The PHP backend processes the data, comparing current metrics with normal behavior thresholds.</p>
            </div>
            <div class="step-box">
                <div class="step-number">4</div>
                <h5>Visualization</h5>
                <p>Results are displayed on your Smart Dashboard with interactive charts and AI-driven alerts.</p>
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <div class="p-5 bg-light rounded-5 shadow-inner">
                <i class="fas fa-project-diagram fa-10x text-secondary opacity-25"></i>
                <p class="mt-4 fw-bold">Smart NBI System Architecture</p>
                <p class="small text-muted">A closed-loop system for continuous monitoring and threat detection.</p>
            </div>
        </div>
    </div>

    <div class="text-center my-5 py-5 border-top">
        <h3 class="mb-4">Ready to secure your devices?</h3>
        <a href="dashboard.php" class="btn btn-primary btn-lg px-5 rounded-pill">Explore Dashboard</a>
    </div>
</div>