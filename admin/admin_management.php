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
    <title>Admins Management - ReGenEarth</title>
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
            background-color: var(--rich-black);
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

        .modal-content {
            background-color: var(--rich-black);
            color: var(--silver);
        }

    </style>
</head>

<body class="dashboard">
    <div class="main">
        <h2 class="mb-4 text-center">Admin & Staff Management</h2>

        <div class="search-container">
            <input type="text" id="searchInput" class="search-bar"
                placeholder="Search by Username, Email, Bio, or Date">
        </div>

        <div class="text-right mb-3 w-100">
            <button class="btn btn-success btn-add" id="addUserBtn">
                <i class="fas fa-user-plus"></i> Add Admin
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="adminTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="adminForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Admin Form</h5>
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
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Bio</label>
                            <textarea name="bio" id="bio" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const loadUsers = (searchTerm = "") => {
                const payload = {
                    action: searchTerm.trim() !== "" ? "searchUser" : "list",
                    searchTerm: searchTerm,
                    userRole: "admin,staff"
                };

                fetch("admin_actions.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(payload)
                })
                    .then(res => res.json())
                    .then(users => {
                        const tbody = document.querySelector("#adminTable tbody");
                        tbody.innerHTML = "";

                        if (!users.length) {
                            tbody.innerHTML = `<tr><td colspan="7" class="text-center">No users found.</td></tr>`;
                        } else {
                            users.forEach(user => {
                                tbody.innerHTML += `
                    <tr>
                        <td>${user.user_id}</td>
                        <td>${user.username}</td>
                        <td>${user.email}</td>
                        <td>${user.role}</td>
                        <td>${user.created_at}</td>
                        <td>${user.updated_at}</td>
                        <td>
                            <button class="btn btn-sm btn-warning editUser" data-id="${user.user_id}"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger deleteUser" data-id="${user.user_id}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`;
                            });
                        }
                    })
                    .catch(err => console.error("Error loading users:", err));
            };

            loadUsers(); // Load users initially

            document.getElementById("searchInput").addEventListener("input", function () {
                loadUsers(this.value); // Trigger user list update based on search
            });

            document.getElementById("adminForm").addEventListener("submit", function (e) {
                e.preventDefault();

                const form = e.target;
                const data = {
                    action: form.formAction.value,
                    user_id: form.user_id.value,
                    username: form.username.value,
                    email: form.email.value,
                    password: form.password.value,
                    bio: form.bio.value,
                    role: form.role.value
                };

                fetch("admin_actions.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                    .then(res => res.json())
                    .then(response => {
                        if (response.status === "success" || response.status === "updated") {
                            $("#addUserModal").modal("hide");
                            loadUsers(); // Reload user list after successful action
                        } else {
                            alert("Failed to save user, please try again.");
                        }
                    })
                    .catch(err => console.error("Error saving user:", err));
            });

            document.addEventListener("click", function (e) {
                // Edit user
                if (e.target.classList.contains("editUser") || e.target.closest(".editUser")) {
                    const userId = e.target.dataset.id || e.target.closest(".editUser").dataset.id;

                    fetch("admin_actions.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ action: "get", user_id: userId })
                    })
                        .then(res => res.json())
                        .then(user => {
                            document.getElementById("user_id").value = user.user_id;
                            document.getElementById("username").value = user.username;
                            document.getElementById("email").value = user.email;
                            document.getElementById("bio").value = user.bio;
                            document.getElementById("role").value = user.role;
                            document.getElementById("password").value = "";
                            document.getElementById("password").readOnly = false;
                            document.getElementById("formAction").value = "update";
                            $("#addUserModal").modal("show");
                        })
                        .catch(err => console.error("Error loading user data:", err));
                }

                // Delete user
                if (e.target.classList.contains("deleteUser") || e.target.closest(".deleteUser")) {
                    const userId = e.target.dataset.id || e.target.closest(".deleteUser").dataset.id;

                    if (confirm("Are you sure you want to delete this user?")) {
                        fetch("admin_actions.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({ action: "delete", user_id: userId })
                        })
                            .then(res => res.json())
                            .then(response => {
                                if (response.status === "deleted") {
                                    loadUsers(); // Reload user list after successful deletion
                                } else {
                                    alert("Failed to delete user, please try again.");
                                }
                            })
                            .catch(err => console.error("Error deleting user:", err));
                    }
                }
            });

            // Open modal to add a new user
            document.getElementById("addUserBtn").addEventListener("click", function () {
                document.getElementById("formAction").value = "add";
                document.getElementById("user_id").value = "";
                document.getElementById("username").value = "";
                document.getElementById("email").value = "";
                document.getElementById("bio").value = "";
                document.getElementById("role").value = "staff";
                document.getElementById("password").value = "ReGenEarth2025";
                document.getElementById("password").readOnly = true;
                $("#addUserModal").modal("show");
            });
        });
    </script>

</body>

</html>