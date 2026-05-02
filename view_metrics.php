<?php
include 'config/db.php';
include 'includes/header.php'; 

$device_id = isset($_GET['id']) ? $_GET['id'] : 0;


$device_stmt = $pdo->prepare("SELECT device_name FROM devices WHERE id = ?");
$device_stmt->execute([$device_id]);
$device = $device_stmt->fetch();
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4 p-4 mb-4 bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-0"><i class="fas fa-microchip text-primary me-2"></i> <?php echo $device['device_name'] ?? 'Device Metrics'; ?></h2>
                        <small class="text-muted">Network Behavior Intelligence (NBI) Live Analysis</small>
                    </div>
                    <span class="badge bg-success p-2 pulse-animation"><i class="fas fa-sync fa-spin me-1"></i> Live Monitoring</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-primary text-white text-center">
                <small class="opacity-75">Bandwidth Usage</small>
                <h3 class="fw-bold mb-0" id="currentBandwidth">0 Mbps</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-info text-white text-center">
                <small class="opacity-75">Packet Count</small>
                <h3 class="fw-bold mb-0" id="currentPackets">0</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-dark text-white text-center">
                <small class="opacity-75">CPU Load</small>
                <h3 class="fw-bold mb-0" id="currentCPU">0%</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-secondary text-white text-center">
                <small class="opacity-75">RAM Usage</small>
                <h3 class="fw-bold mb-0" id="currentRAM">0%</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-4"><i class="fas fa-network-wired text-info me-2"></i> Network Traffic History (NBI Data)</h5>
                <canvas id="networkChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-3">CPU Usage %</h5>
                <canvas id="cpuChart"></canvas>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-3">RAM Usage %</h5>
                <canvas id="ramChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

function createChart(ctxId, label, color, fill = false) {
    const ctx = document.getElementById(ctxId).getContext('2d');
    return new Chart(ctx, {
        type: 'line',
        data: { labels: [], datasets: [{ label: label, data: [], borderColor: color, backgroundColor: color + '22', fill: fill, tension: 0.4, borderWidth: 3 }] },
        options: { responsive: true, scales: { x: { display: false }, y: { beginAtZero: true } }, plugins: { legend: { display: (label.includes('&')) } } }
    });
}


const networkChart = createChart('networkChart', 'Bandwidth (Mbps)', '#0dcaf0', true);
const cpuChart = createChart('cpuChart', 'CPU %', '#0d6efd');
const ramChart = createChart('ramChart', 'RAM %', '#198754');


networkChart.data.datasets.push({
    label: 'Packets Count',
    data: [],
    borderColor: '#ffc107',
    borderDash: [5, 5],
    tension: 0.4,
    borderWidth: 2
});

async function updateAllMetrics() {
    try {
        const response = await fetch(`get_live_data.php?id=<?php echo $device_id; ?>`);
        const data = await response.json();

        if (data.length > 0) {
            const last = data[data.length - 1];
            
          
            document.getElementById('currentBandwidth').innerText = last.bandwidth_usage + ' Mbps';
            document.getElementById('currentPackets').innerText = last.packet_count;
            document.getElementById('currentCPU').innerText = last.cpu_usage + '%';
            document.getElementById('currentRAM').innerText = last.ram_usage + '%';

            
            const labels = data.map(r => r.captured_at);
            
            networkChart.data.labels = labels;
            networkChart.data.datasets[0].data = data.map(r => r.bandwidth_usage);
            networkChart.data.datasets[1].data = data.map(r => r.packet_count);
            
            cpuChart.data.labels = labels;
            cpuChart.data.datasets[0].data = data.map(r => r.cpu_usage);
            
            ramChart.data.labels = labels;
            ramChart.data.datasets[0].data = data.map(r => r.ram_usage);

            networkChart.update('none');
            cpuChart.update('none');
            ramChart.update('none');
        }
    } catch (e) { console.error("Data fetch error", e); }
}

setInterval(updateAllMetrics, 3000);
updateAllMetrics();
</script>

<style>
.pulse-animation { animation: pulse 2s infinite; }
@keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
.card { transition: 0.3s; }
.card:hover { transform: translateY(-5px); }
</style>

<?php include 'includes/footer.php'; ?>