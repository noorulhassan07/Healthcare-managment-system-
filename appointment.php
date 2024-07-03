<?php
// Include database connection file
include_once 'include/config.php';

// Check if the form is submitted for booking
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $department_id = $_POST['department'];
    $doctor_id = $_POST['doctor'];
    $idtype = $_POST['idtype'];
    $idnum = $_POST['idnum'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $date = $_POST['date'];

    // Insert data into the appointment table
    $sql = "INSERT INTO appointment (patient_name, patient_mobile, department_id, doctor_id, patient_idtype, patient_idnum, patient_gender, patient_age, appointment_date) 
            VALUES ('$name', '$mobile', '$department_id', '$doctor_id', '$idtype', '$idnum', '$gender', '$age', '$date')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Appointment booked successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Check if the delete button is clicked
if (isset($_POST['delete'])) {
    $appointment_id = $_POST['appointment_id'];

    // Delete the appointment from the database
    $delete_query = "DELETE FROM appointment WHERE appointment_id = $appointment_id";

    if ($conn->query($delete_query) === TRUE) {
        echo "<script>alert('Appointment deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting appointment: " . $conn->error . "');</script>";
    }
}

?>

<?php include_once 'include/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 py-3 bg-white from-wrapper">
            <div class="container shadow-lg py-3">
                <h3>Appointment Form</h3>
                <hr>
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="name">Patient Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="mobile">Patient Mobile</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="department">Select Department</label>
                            <select name="department" id="department" class="form-control">
                                <option value="">Choose One</option>
                                <?php
                                // Fetch departments from the database and generate options
                                $department_query = "SELECT * FROM department";
                                $department_result = $conn->query($department_query);
                                while ($row = $department_result->fetch_assoc()) {
                                    echo "<option value='" . $row['department_id'] . "'>" . $row['department_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="doctor">Select Doctor</label>
                            <select name="doctor" id="doctor" class="form-control">
                                <option value="">Choose One</option>
                                <?php
                                // Fetch doctors from the database and generate options
                                $doctor_query = "SELECT * FROM doctor";
                                $doctor_result = $conn->query($doctor_query);
                                while ($row = $doctor_result->fetch_assoc()) {
                                    echo "<option value='" . $row['doc_id'] . "'>" . $row['doc_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>   
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="idtype">Select ID Type</label>
                            <select name="idtype" id="idtype" class="form-control">
                                <option value="">Choose One</option>
                                <option value="CNIC">CNIC</option>
                                <option value="Armend Forces Personnel">Armend Forces Personnel</option>
                                <option value="Driver's License">Driver's License</option>
                                <option value="Passport">Passport</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="idnum">ID Number</label>
                            <input type="text" name="idnum" id="idnum" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="gender">Select Patient Gender</label>
                            <select name="gender" id="gender" class="form-control">
                                <<option value="">Choose One</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="age">Patient Age</label>
                            <input type="number" name="age" id="age" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="date">Appointment Date</label>
                            <input type="date" name="date" id="date" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <button type="submit" name="book" class="btn btn-primary">Book Appointment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Display existing appointments -->
    <div class="row mt-5">
        <div class="col-12">
            <h3>Existing Appointments</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Patient Name</th>
                        <th>Mobile</th>
                        <th>Department</th>
                        <th>Doctor</th>
                        <th>ID Type</th>
                        <th>ID Number</th>
                        <th>Gender</th>
                        <th>Age</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch appointments from the database and display them in a table
                    $appointment_query = "SELECT * FROM appointment";
                    $appointment_result = $conn->query($appointment_query);
                    while ($row = $appointment_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['appointment_id'] . "</td>";
                        echo "<td>" . $row['patient_name'] . "</td>";
                        echo "<td>" . $row['patient_mobile'] . "</td>";

                        // Fetch department name based on department_id
                        $department_id = $row['department_id'];
                        $department_name_query = "SELECT department_name FROM department WHERE department_id = $department_id";
                        $department_name_result = $conn->query($department_name_query);
                        $department_name = ($department_name_result->num_rows > 0) ? $department_name_result->fetch_assoc()['department_name'] : "";

                        echo "<td>" . $department_name . "</td>";

                        // Fetch doctor name based on doctor_id
                        $doctor_id = $row['doctor_id'];
                        $doctor_name_query = "SELECT doc_name FROM doctor WHERE doc_id = $doctor_id";
                        $doctor_name_result = $conn->query($doctor_name_query);
                        $doctor_name = ($doctor_name_result->num_rows > 0) ? $doctor_name_result->fetch_assoc()['doc_name'] : "";

                        echo "<td>" . $doctor_name . "</td>";

                        echo "<td>" . $row['patient_idtype'] . "</td>";
                        echo "<td>" . $row['patient_idnum'] . "</td>";
                        echo "<td>" . $row['patient_gender'] . "</td>";
                        echo "<td>" . $row['patient_age'] . "</td>";
                        echo "<td>" . $row['appointment_date'] . "</td>";
                        echo "<td>
                                <form method='POST'>
                                    <input type='hidden' name='appointment_id' value='" . $row['appointment_id'] . "'>
                                    <button type='submit' name='delete' class='btn btn-danger'>Delete</button>
                                </form>
                            </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once 'include/footer.php'; ?>