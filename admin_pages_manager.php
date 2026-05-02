<?php
include 'config/db.php';
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


$directory = "./";
$files = array_diff(scandir($directory), array('..', '.', 'assets', 'config', 'includes', 'api', 'vendor'));

?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-file-code text-success"></i> System Pages Manager</h2>
        <button class="btn btn-success rounded-pill shadow-sm" onclick="alert('This feature will allow you to upload new PHP modules!')">
            <i class="fas fa-plus-circle me-2"></i> Register New Page
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white p-4 border-0">
            <h5 class="fw-bold mb-0">Live Application Structure</h5>
            <small class="text-muted">Total Active Files: <?php echo count($files); ?></small>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Page/File Name</th>
                        <th>File Size</th>
                        <th>Permissions</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $count = 1;
                    foreach ($files as $file): 
                        if (is_file($file)):
                            $file_size = round(filesize($file) / 1024, 2);
                    ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td class="text-start ps-4">
                            <i class="fas fa-file-alt me-2 text-muted"></i>
                            <strong><?php echo $file; ?></strong>
                        </td>
                        <td><?php echo $file_size; ?> KB</td>
                        <td><span class="badge bg-light text-dark border">Readable</span></td>
                        <td>
                            <div class="form-check form-switch d-inline-block">
                                <input class="form-check-switch" type="checkbox" checked disabled>
                                <span class="badge bg-success-soft text-success">Online</span>
                            </div>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="<?php echo $file; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-external-link-alt"></i> Preview
                                </a>
                                <button class="btn btn-sm btn-outline-secondary" onclick="alert('Direct edit is disabled for security.')">
                                    <i class="fas fa-code"></i> Edit
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 p-3 bg-light rounded-4 border">
        <p class="small text-muted mb-0">
            <i class="fas fa-info-circle me-2"></i>
            <strong>ملاحظة للأدمن:</strong> هذه الصفحة تقرأ الملفات الحقيقية من المجلد. أي حذف للملف من هنا سيؤدي لتعطل الجزء المقابل في النظام.
        </p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>