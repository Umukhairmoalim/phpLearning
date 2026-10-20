<?php
session_start();

$errors = [];
$data = [];
$success = false;

$fields = [
    'name' => 'Student Name',
    'pob' => 'Place of Birth',
    'dob' => 'Date of Birth',
    'address' => 'Address',
    'gender' => 'Gender',
    'telephone' => 'Telephone',
    'email' => 'Email',
    'parent_name' => 'Parent Name',
    'parent_telephone' => 'Parent Telephone',
    'relationship' => 'Relationship',
    'student_id' => 'Student ID',
    'faculty' => 'Faculty',
    'department' => 'Department',
    'class' => 'Class',
    'registration_date' => 'Registration Date'
];

if (isset($_POST['register'])) {
    foreach ($fields as $key => $label) {
        $data[$key] = trim($_POST[$key] ?? '');

        if ($data[$key] === '') {
            $errors[$key] = "$label is required.";
        }
    }

    if (!empty($data['name']) &&
        !preg_match('/^[\p{L}\s]+$/u', $data['name'])) {
        $errors['name'] = 'Name must contain letters and spaces only.';
    }

    if (!empty($data['parent_name']) &&
        !preg_match('/^[\p{L}\s]+$/u', $data['parent_name'])) {
        $errors['parent_name'] = 'Parent name must contain letters and spaces only.';
    }

    if (!empty($data['email']) &&
        !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Enter a valid email address.';
    }

    if (
        !isset($_FILES['student_image']) ||
        $_FILES['student_image']['error'] !== UPLOAD_ERR_OK
    ) {
        $errors['student_image'] = 'Please upload a student image.';
    } else {
        $allowed = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif'
        ];

        $ext = strtolower(
            pathinfo($_FILES['student_image']['name'], PATHINFO_EXTENSION)
        );

        $mime = (new finfo(FILEINFO_MIME_TYPE))
            ->file($_FILES['student_image']['tmp_name']);

        if (!isset($allowed[$ext]) || $allowed[$ext] !== $mime) {
            $errors['student_image'] =
                'Only JPG, JPEG, PNG and GIF images are allowed.';
        } elseif ($_FILES['student_image']['size'] > 3 * 1024 * 1024) {
            $errors['student_image'] = 'Image must be 3 MB or less.';
        }
    }

    if (empty($errors)) {
        $folder = __DIR__ . '/uploads/';

        if (!is_dir($folder)) {
            mkdir($folder, 0775, true);
        }

        $ext = strtolower(
            pathinfo($_FILES['student_image']['name'], PATHINFO_EXTENSION)
        );

        $filename = 'student_' . bin2hex(random_bytes(8)) . '.' . $ext;

        if (move_uploaded_file(
            $_FILES['student_image']['tmp_name'],
            $folder . $filename
        )) {
            $data['image'] = 'uploads/' . $filename;
            $_SESSION['student'] = $data;
            $success = true;
        } else {
            $errors['student_image'] = 'Unable to save the uploaded image.';
        }
    }
}

if (isset($_POST['new_student'])) {
    unset($_SESSION['student']);
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

if (!$success && isset($_SESSION['student'])) {
    $data = $_SESSION['student'];
    $success = true;
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$sections = [
    'Personal Information' => [
        'Student Name' => 'name',
        'Place of Birth' => 'pob',
        'Date of Birth' => 'dob',
        'Address' => 'address',
        'Gender' => 'gender',
        'Telephone' => 'telephone',
        'Email' => 'email'
    ],
    'Parent Information' => [
        'Parent Name' => 'parent_name',
        'Parent Telephone' => 'parent_telephone',
        'Relationship' => 'relationship'
    ],
    'Academic Information' => [
        'Student ID' => 'student_id',
        'Faculty' => 'faculty',
        'Department' => 'department',
        'Class' => 'class',
        'Registration Date' => 'registration_date'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Registration System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    background: #f2f5fb;
    color: #172b4d;
    font-family: Arial, sans-serif;
}
.header {
    background: #142b4a;
    color: white;
    padding: 22px 0;
}
.header h2 {
    font-size: 22px;
    font-weight: bold;
    margin: 0;
}
.header p {
    color: #cbd6e8;
    margin: 6px 0 0;
    font-size: 13px;
}
.hero {
    background: linear-gradient(120deg, #fff, #e6edff);
    padding: 28px;
    border-radius: 16px;
    margin-bottom: 22px;
    border: 1px solid #dfe6f1;
}
.hero small {
    color: #315ce8;
    font-weight: bold;
    letter-spacing: 2px;
}
.hero h1 {
    font-weight: bold;
    margin: 10px 0;
}
.panel {
    background: white;
    border: 1px solid #e0e6f0;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 20px;
    box-shadow: 0 5px 15px #142b4a08;
}
.panel h4 {
    color: #244575;
    font-weight: bold;
    font-size: 18px;
    border-bottom: 1px solid #e8edf5;
    padding-bottom: 15px;
    margin-bottom: 20px;
}
label {
    display: block;
    font-size: 13px;
    font-weight: bold;
    margin-bottom: 7px;
}
.form-control, .form-select {
    min-height: 44px;
    border-radius: 9px;
    font-size: 13px;
}
.btn-primary {
    background: #315ce8;
    border-color: #315ce8;
    padding: 11px 20px;
    border-radius: 9px;
}
.error {
    color: #c62845;
    font-size: 12px;
    margin-top: 5px;
}
.table th {
    background: #edf2fb;
    width: 40%;
}
footer {
    color: #8591a5;
    text-align: center;
    padding: 20px;
    font-size: 12px;
}
@media print {
    .header, .no-print {
        display: none !important;
    }
    body {
        background: white;
    }
}
</style>
</head>

<body>

<header class="header">
    <div class="container">
        <h2>JU | Jamhuriya University</h2>
        <p>Faculty of Computer &amp; IT — PHP &amp; MySQL</p>
    </div>
</header>

<main class="container py-4">

<?php if (!$success): ?>

<div class="hero">
    <small>CHAPTER 4 ASSIGNMENT</small>
    <h1>Student Registration</h1>
    <p>Complete all sections to register a student.</p>
</div>

<?php if ($errors): ?>
<div class="alert alert-danger">
    <strong>Please correct these errors:</strong>
    <ul class="mb-0">
        <?php foreach ($errors as $message): ?>
            <li><?= e($message) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" id="studentForm">

<section class="panel">
<h4>01. Personal Information</h4>
<div class="row g-3">

<div class="col-md-6">
<label>Full Name *</label>
<input class="form-control" name="name"
value="<?= e($data['name'] ?? '') ?>" required>
<?php if(isset($errors['name'])): ?>
<div class="error"><?= e($errors['name']) ?></div>
<?php endif; ?>
</div>

<div class="col-md-6">
<label>Place of Birth *</label>
<input class="form-control" name="pob"
value="<?= e($data['pob'] ?? '') ?>" required>
</div>

<div class="col-md-6">
<label>Date of Birth *</label>
<input type="date" class="form-control" name="dob"
value="<?= e($data['dob'] ?? '') ?>" required>
</div>

<div class="col-md-6">
<label>Gender *</label>
<select class="form-select" name="gender" required>
<option value="">Select Gender</option>
<option value="Female" <?= ($data['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Female</option>
<option value="Male" <?= ($data['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Male</option>
</select>
</div>

<div class="col-md-6">
<label>Address *</label>
<input class="form-control" name="address"
value="<?= e($data['address'] ?? '') ?>" required>
</div>

<div class="col-md-6">
<label>Telephone *</label>
<input type="tel" class="form-control" name="telephone"
value="<?= e($data['telephone'] ?? '') ?>" required>
</div>

<div class="col-md-6">
<label>Email *</label>
<input type="email" class="form-control" name="email"
value="<?= e($data['email'] ?? '') ?>" required>
<?php if(isset($errors['email'])): ?>
<div class="error"><?= e($errors['email']) ?></div>
<?php endif; ?>
</div>

<div class="col-md-6">
<label>Student Image *</label>
<input type="file" class="form-control" name="student_image"
accept=".jpg,.jpeg,.png,.gif" required>
<small class="text-secondary">JPG, JPEG, PNG or GIF · Max 3 MB</small>
<?php if(isset($errors['student_image'])): ?>
<div class="error"><?= e($errors['student_image']) ?></div>
<?php endif; ?>
</div>

</div>
</section>

<section class="panel">
<h4>02. Parent Information</h4>
<div class="row g-3">

<div class="col-md-4">
<label>Parent Name *</label>
<input class="form-control" name="parent_name"
value="<?= e($data['parent_name'] ?? '') ?>" required>
<?php if(isset($errors['parent_name'])): ?>
<div class="error"><?= e($errors['parent_name']) ?></div>
<?php endif; ?>
</div>

<div class="col-md-4">
<label>Parent Telephone *</label>
<input type="tel" class="form-control" name="parent_telephone"
value="<?= e($data['parent_telephone'] ?? '') ?>" required>
</div>

<div class="col-md-4">
<label>Relationship *</label>
<select class="form-select" name="relationship" required>
<option value="">Select Relationship</option>
<?php foreach(['Father','Mother','Guardian','Other'] as $r): ?>
<option value="<?= e($r) ?>"
<?= ($data['relationship'] ?? '') === $r ? 'selected' : '' ?>>
<?= e($r) ?>
</option>
<?php endforeach; ?>
</select>
</div>

</div>
</section>

<section class="panel">
<h4>03. Academic Information</h4>
<div class="row g-3">

<div class="col-md-6">
<label>Student ID *</label>
<input class="form-control" name="student_id"
value="<?= e($data['student_id'] ?? '') ?>" required>
</div>

<div class="col-md-6">
<label>Faculty *</label>
<input class="form-control" name="faculty"
value="<?= e($data['faculty'] ?? '') ?>" required>
</div>

<div class="col-md-6">
<label>Department *</label>
<input class="form-control" name="department"
value="<?= e($data['department'] ?? '') ?>" required>
</div>

<div class="col-md-6">
<label>Class *</label>
<input class="form-control" name="class"
value="<?= e($data['class'] ?? '') ?>" required>
</div>

<div class="col-md-6">
<label>Registration Date *</label>
<input type="date" class="form-control" name="registration_date"
value="<?= e($data['registration_date'] ?? '') ?>" required>
</div>

</div>
</section>

<div class="text-end mb-4">
<button type="reset" class="btn btn-light border">Clear Form</button>
<button type="submit" name="register" class="btn btn-primary">
Register Student →
</button>
</div>

</form>

<?php else: ?>

<div class="hero">
    <small>REGISTRATION RESULT</small>
    <h1>Registration Successful!</h1>
    <p>The student information is displayed below.</p>
</div>

<section class="panel text-center">
    <img src="<?= e($data['image']) ?>" alt="Student Photo"
         style="width:120px;height:120px;object-fit:cover;border-radius:15px">
    <h3 class="mt-3"><?= e($data['name']) ?></h3>
    <p>Student ID: <?= e($data['student_id']) ?></p>
</section>

<?php foreach ($sections as $title => $items): ?>
<section class="panel">
    <h4><?= e($title) ?></h4>
    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <tbody>
        <?php foreach ($items as $label => $key): ?>
        <tr>
            <th><?= e($label) ?></th>
            <td><?= e($data[$key] ?? '') ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</section>
<?php endforeach; ?>

<div class="d-flex gap-2 justify-content-end no-print mb-4">
    <form method="POST">
        <button type="submit" name="new_student" class="btn btn-light border">
            New Registration
        </button>
    </form>
    <button onclick="window.print()" class="btn btn-primary">
        Print Details
    </button>
</div>

<?php endif; ?>

<footer>PHP &amp; MySQL | Student Registration System</footer>
</main>

<script>
document.getElementById('studentForm')?.addEventListener('submit', function(event) {
    const name = this.elements['name'];
    const parent = this.elements['parent_name'];
    const letters = /^[\p{L}\s]+$/u;

    if (name.value.trim() && !letters.test(name.value.trim())) {
        event.preventDefault();
        name.focus();
        alert('Student name must contain letters and spaces only.');
    } else if (parent.value.trim() && !letters.test(parent.value.trim())) {
        event.preventDefault();
        parent.focus();
        alert('Parent name must contain letters and spaces only.');
    }
});
</script>

</body>
</html>