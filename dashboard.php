<?php
include_once 'include/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
} else {
    // Correct the session variable to match the login session variable
    $user_email = $_SESSION['user_email'];

    // Properly construct the SQL query
    $sql = "SELECT * FROM user WHERE USER_EMAIL='$user_email'";
    $run = mysqli_query($conn, $sql);

    // Check if the query was successful and if the user data is retrieved
    if ($run && mysqli_num_rows($run) > 0) {
        $user_data = mysqli_fetch_assoc($run);
    } else {
        // Handle the error if the user is not found or the query fails
        echo "Error retrieving user data or user not found.";
        exit();
    }

    // Fetch user appointments
    $user_id = $user_data['USER_ID']; // Assuming the user table has a USER_ID column
    $appointments_sql = "SELECT a.appointment_id, a.patient_name, a.patient_age, a.patient_gender, a.appointment_date, d.doc_name, dept.department_name, a.appointment_status 
                         FROM appointment a 
                         JOIN doctor d ON a.doc_id = d.doc_id 
                         JOIN department dept ON d.department_id = dept.department_id 
                         WHERE a.user_id = '$user_id'";
    $appointments_result = mysqli_query($conn, $appointments_sql);
}
?>

<?php include_once './include/header.php';?>

<div class="mx-3 shadow-lg p-3 m-2"> 
    <div class="row">
        <div class="col-12 col-md-12">
            <h1 class="text-center">User Dashboard</h1>
        </div>
    </div>
</div>
<div class="mx-3 shadow p-3 m-2"> 
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h3><?= htmlspecialchars($user_data['USER_NAME']) ?></h3>
                            <p class="card-text"><?= htmlspecialchars($user_data['USER_EMAIL']) ?></p>
                            <p class="card-text"><?= htmlspecialchars($user_data['USER_MOBILE']) ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Change Password</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
                <div class="mx-5 shadow table-responsive">
                    <table class="table table-bordered table-hover table-primary">
                        <thead>
                            <tr>
                                <th>Appointment Id</th>
                                <th>Patient Name</th>
                                <th>Patient Age</th>
                                <th>Patient Gender</th>
                                <th>Appointment Date</th>
                                <th>Appoint Doctor Name</th>
                                <th>Department</th>
                                <th>Appointment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($appointments_result && mysqli_num_rows($appointments_result) > 0): ?>
                                <?php while ($appointment = mysqli_fetch_assoc($appointments_result)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($appointment['appointment_id']) ?></td>
                                        <td><?= htmlspecialchars($appointment['patient_name']) ?></td>
                                        <td><?= htmlspecialchars($appointment['patient_age']) ?></td>
                                        <td><?= htmlspecialchars($appointment['patient_gender']) ?></td>
                                        <td><?= htmlspecialchars($appointment['appointment_date']) ?></td>
                                        <td><?= htmlspecialchars($appointment['doc_name']) ?></td>
                                        <td><?= htmlspecialchars($appointment['department_name']) ?></td>
                                        <td><?= htmlspecialchars($appointment['appointment_status']) ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">No appointments found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'include/footer.php'; ?>
