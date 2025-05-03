<?php
session_start();
include "inc/navigation.php";
include '../auth/admin_only.php';
require_once '../src/db_connection.php';

$_SESSION['just_logged_in'] = false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Management - ReGenEarth</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="../uploads/logo.png" type="image/png" />
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
            border-color: var(--silver);
        }

        .table thead th {
            background-color: var(----silver);
            color: var(--silver);
            border-color: var(--silver);
        }

        .table td,
        .table th {
            vertical-align: middle !important;
            border-color: var(--silver);
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
            color: var(--silver)
        }

        .search-container {
            margin-bottom: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .search-bar {
            width: 80%;
            max-width: 500px;
            padding: 10px;
            border-radius: 25px;
            border: 1px solid var(--silver);
            background-color: #fff;
        }

        .search-bar:focus {
            outline: none;
            border-color: var(--moonstone);
        }
    </style>
</head>

<body class="dashboard">
    <div class="main">
        <h2 class="mb-4 text-center">User Management</h2>

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="searchInput" class="search-bar"
                placeholder="Search Users by Username, Email, Bio, or Date">
        </div>
        <div class="text-right mb-3 w-100">
            <button class="btn btn-success btn-add" id="addUserBtn">
                <i class="fas fa-user-plus"></i> Add User
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="userTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Bio</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <!-- Pagination placeholder -->
        <nav>
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
    </div>

    <!-- Add/Edit User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="userForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">User Form</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="user_id" />
                        <input type="hidden" name="action" id="formAction" value="add" />
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" id="username" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="email" class="form-control" required />
                        </div>
                        <div class="form-group" id="passwordGroup">
                            <label>Password</label>
                            <input type="password" name="password" id="password" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Bio</label>
                            <textarea name="bio" id="bio" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save User</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            loadUsers();  // Load all users initially

            // Function to load users
            function loadUsers(searchTerm = '') {
                const action = searchTerm ? "searchUser" : "list"; // If search term is provided, call 'searchUser'
                $.post("user_actions.php", { action: action, searchTerm: searchTerm }, function (data) {
                    const users = JSON.parse(data);
                    const tbody = $("#userTable tbody").empty();
                    users.forEach(user => {
                        tbody.append(`
                            <tr>
                                <td>${user.user_id}</td>
                                <td>${user.username}</td>
                                <td>${user.email}</td>
                                <td>${user.bio}</td>
                                <td>${user.created_at}</td>
                                <td>${user.updated_at}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning editUser" data-id="${user.user_id}">Edit</button>
                                    <button class="btn btn-sm btn-danger deleteUser" data-id="${user.user_id}">Delete</button>
                                </td>
                            </tr>
                        `);
                    });
                });
            }
            $("#searchInput").on("input", function () {
                const searchTerm = $(this).val();
                loadUsers(searchTerm); // Reload with the search term
            });

            // Handle form submission
            $("#userForm").submit(function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                $.post("user_actions.php", formData, function (response) {
                    $("#addUserModal").modal("hide");
                    loadUsers();
                });
            });

            // Edit user button click
            $(document).on("click", ".editUser", function () {
                const userId = $(this).data("id");
                $.post("user_actions.php", { action: "get", user_id: userId }, function (data) {
                    const user = JSON.parse(data);
                    $("#user_id").val(user.user_id);
                    $("#username").val(user.username);
                    $("#email").val(user.email);
                    $("#bio").val(user.bio);
                    $("#formAction").val("update");

                    // Clear password for security & allow editing
                    $("#password").val("").prop("readonly", false);
                    $("#passwordGroup").show();

                    $("#addUserModal").modal("show");
                });
            });


            // Delete user
            $(document).on("click", ".deleteUser", function () {
                const userId = $(this).data("id");
                if (confirm("Delete this user?")) {
                    $.post("user_actions.php", { action: "delete", user_id: userId }, function () {
                        loadUsers();
                    });
                }
            });

            $("#addUserBtn").on("click", function () {
                $("#formAction").val("add");
                $("#user_id").val("");
                $("#username, #email, #bio").val("");
                $("#password").val("ReGenEarth2025").prop("readonly", true);
                $("#passwordGroup").show();
                $("#addUserModal").modal("show");
            });

        });
    </script>
</body>

</html>