<?php
session_start();
include "inc/navigation.php";
include '../auth/admin_only.php';

$_SESSION['just_logged_in'] = false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Management - ReGenEarth</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="uploads/logo.png" type="image/png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />

    <style>
        :root {
            --moonstone: #57AFC3;
            /* Table header background */
            --prussian-blue: #132F43;
            /* Page background */
            --silver: #E2E6EA;
            /* Light text color */
            --taupe-gray: #999A9C;
            --rich-black: #0B1A26;
            /* Table body background */
        }

        .light-mode {
            --moonstone: #489fb5;
            --prussian-blue: #f8f9fa;
            /* Light background */
            --silver: #212529;
            /* Dark text */
            --taupe-gray: #6c757d;
            --rich-black: #ffffff;
            /* Table background */
        }

        * {
            font-family: "Poppins", sans-serif;
        }

        body {}

        .main {
            padding: 2rem;
        }

        h2 {
            color: var(--silver);
            font-weight: 700;
        }

        .table {
            background-color: var(--rich-black);
            color: var(--silver);
            border-color: var(--moonstone);
        }

        .table thead th {
            background-color: var(--moonstone);
            color: white;
            border-color: var(--moonstone);
        }

        .table td,
        .table th {
            vertical-align: middle !important;
            border-color: var(--moonstone);
        }

        .btn-custom {
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 0.9rem;
            border: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-edit:hover {
            background-color: #e0a800;
            color: #fff;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #bd2130;
        }

        .btn-add {
            background-color: #28a745;
            color: white;
        }

        .btn-add:hover {
            background-color: #218838;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .main {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: var(--prussian-blue);
        }

        td {
            font-size: 12px;
            color: var(--moonstone)
        }
    </style>
</head>

<body class="dashboard">
    <div class="main">
        <h2 class="mb-4 mt-5">Admins Management</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Privileges</th>
                        <th style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>10</td>
                        <td>superadmin</td>
                        <td>superadmin@example.com</td>
                        <td>Full Access</td>
                        <td>
                            <button class="btn btn-edit btn-custom" onclick="editAdmin(this)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-delete btn-custom" onclick="deleteAdmin(this)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            <button class="btn btn-add btn-custom" onclick="addAdmin()">
                <i class="fas fa-user-shield"></i> Add Admin
            </button>
        </div>
    </div>

    <script>
        function deleteUser(button) {
            const row = button.closest("tr");
            const username = row.children[1].textContent;
            if (confirm(`Are you sure you want to delete user "${username}"?`)) {
                row.remove();
                // TODO: Connect to backend to delete
            }
        }

        function editUser(button) {
            const row = button.closest("tr");
            const username = row.children[1].textContent;
            alert(`Edit user "${username}" - feature not implemented yet.`);
            // TODO: Add modal or redirect for editing
        }

        function addUser() {
            alert("Add user feature not implemented yet.");
            // TODO: Show form or redirect to user_create.php
        }
    </script>
</body>

</html>