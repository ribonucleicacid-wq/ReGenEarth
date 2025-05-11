<?php
session_start();
include "inc/navigation.php";
include '../../auth/staff_only.php';
require_once '../../src/db_connection.php';

$_SESSION['just_logged_in'] = false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tips Management - ReGenEarth</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="../uploads/logo.png" type="image/png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

    <style>
        :root {
            --moonstone: #57AFC3;
            --prussian-blue: #132F43;
            --silver: #E2E6EA;
            --taupe-gray: #999A9C;
            --rich-black: #0B1A26;
        }

        .light-mode {
            --moonstone: #489fb5;
            --prussian-blue: #f8f9fa;
            --silver: #212529;
            --taupe-gray: #6c757d;
            --rich-black: #ffffff;
        }

        * {
            font-family: "Poppins", sans-serif;
        }

        .main {
            padding: 2rem;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: var(--prussian-blue);
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

        td {
            font-size: 12px;
            color: var(--silver);
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

        .modal-content {
            background-color: var(--rich-black);
            color: var(--silver);
        }
    </style>
</head>

<body class="dashboard">
    <div class="main">
        <h2 class="mb-4 text-center">Tips Management</h2>

        <!-- Search Bar -->
        <div class="search-container mb-3 w-100 d-flex justify-content-center">
            <input type="text" id="searchInput" class="search-bar form-control"
                placeholder="Search tips by category or content" style="max-width: 500px;">
        </div>

        <div class="text-right mb-3 w-100">
            <button class="btn btn-success btn-add" id="addTipBtn">
                <i class="fas fa-lightbulb"></i> Add Tip
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tipTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tip</th>
                        <th>Category</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic content loaded here -->
                </tbody>
            </table>
        </div>

        <nav>
            <ul class="pagination justify-content-center" id="pagination"></ul>
        </nav>
    </div>

    <!-- Add/Edit Tip Modal -->
    <div class="modal fade" id="addTipModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form id="tipForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tip Form</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="tip_id" id="tip_id" />
                        <input type="hidden" name="action" id="formAction" value="add" />
                        <div class="form-group">
                            <label>Tip</label>
                            <textarea name="tip" id="tip" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" name="category" id="category" class="form-control" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Tip</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const tipTableBody = document.querySelector("#tipTable tbody");
            const searchInput = document.querySelector("#searchInput");

            function postToTips(data) {
                return fetch("tips_actions.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(data)
                }).then(res => {
                    if (!res.ok) throw new Error("Network response was not ok");
                    return res.json();
                });
            }

            function loadTips(searchTerm = "") {
                const action = searchTerm.trim() !== "" ? "search" : "list";
                postToTips({ action, search: searchTerm })
                    .then(renderTips)
                    .catch(console.error);
            }

            function renderTips(data) {
                tipTableBody.innerHTML = "";

                if (!Array.isArray(data) || data.length === 0) {
                    tipTableBody.innerHTML = `<tr><td colspan="6" class="text-center">No tips found.</td></tr>`;
                    return;
                }

                data.forEach(tip => {
                    tipTableBody.innerHTML += `
                <tr>
                    <td>${tip.id}</td>
                    <td>${tip.tip}</td>
                    <td>${tip.category}</td>
                    <td>${tip.created_at}</td>
                    <td>${tip.updated_at ?? '-'}</td>
                    <td>
                        <button class="btn btn-sm btn-warning editTip" data-id="${tip.id}"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger deleteTip" data-id="${tip.id}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>`;
                });
            }

            searchInput.addEventListener("input", () => {
                const searchTerm = searchInput.value.trim();
                loadTips(searchTerm);
            });

            document.getElementById("tipForm").addEventListener("submit", function (e) {
                e.preventDefault();

                const id = document.getElementById("tip_id").value;
                const tip = document.getElementById("tip").value;
                const category = document.getElementById("category").value;
                const action = document.getElementById("formAction").value;

                const payload = {
                    action,
                    tip,
                    category
                };

                if (action === "update") payload.id = parseInt(id, 10);

                postToTips(payload).then(() => {
                    $('#addTipModal').modal('hide');
                    loadTips();
                }).catch(console.error);
            });

            document.addEventListener("click", function (e) {
                if (e.target.closest(".editTip")) {
                    const tipId = parseInt(e.target.closest(".editTip").dataset.id, 10);
                    postToTips({ action: "get", id: tipId })
                        .then(tip => {
                            document.getElementById("tip_id").value = tip.id;
                            document.getElementById("tip").value = tip.tip;
                            document.getElementById("category").value = tip.category;
                            document.getElementById("formAction").value = "update";
                            $('#addTipModal').modal('show');
                        })
                        .catch(console.error);
                }

                if (e.target.closest(".deleteTip")) {
                    const tipId = parseInt(e.target.closest(".deleteTip").dataset.id, 10);
                    if (confirm("Delete this tip?")) {
                        postToTips({ action: "delete", id: tipId })
                            .then(() => loadTips())
                            .catch(console.error);
                    }
                }
            });

            document.getElementById("addTipBtn").addEventListener("click", () => {
                document.getElementById("formAction").value = "add";
                document.getElementById("tip_id").value = "";
                document.getElementById("tip").value = "";
                document.getElementById("category").value = "";
                $('#addTipModal').modal('show');
            });

            // Initial load
            loadTips();
        });
    </script>

</body>

</html>