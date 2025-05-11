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
    <title>Posts Management - ReGenEarth</title>
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

        * {
            font-family: "Poppins", sans-serif;
        }

        .main {
            padding: 2rem;
            background-color: var(--prussian-blue);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            color: var(--silver);
            font-weight: 700;
        }

        .table {
            background-color: var(--rich-black);
            color: var(--silver);
        }

        .table thead th {
            background-color: var(--rich-black);
            color: var(--silver);
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #bd2130;
        }

        .modal-content {
            background-color: var(--rich-black);
            color: var(--silver);
        }
    </style>
</head>

<body>
    <div class="main">
        <h2 class="mb-4 text-center">Post Management</h2>

        <div class="table-responsive w-100">
            <table class="table table-bordered table-hover" id="tipTable">
                <thead>
                    <tr>
                        <th>Post ID</th>
                        <th>User ID</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Topic</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic content -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Reason Modal -->
    <div class="modal fade" id="deleteReasonModal" tabindex="-1" role="dialog" aria-labelledby="deleteReasonModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="deleteForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Post</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="text-white">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Why are you deleting this post?</p>
                        <select id="deleteReason" class="form-control" required>
                            <option value="" disabled selected>Select a reason</option>
                            <option value="Harmful words">Harmful words</option>
                            <option value="Inappropriate text">Inappropriate text</option>
                            <option value="Spam or misleading">Spam or misleading</option>
                            <option value="Off-topic">Off-topic</option>
                            <option value="Other">Other</option>
                        </select>
                        <input type="hidden" id="deletePostId">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Confirm Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tipTableBody = document.querySelector("#tipTable tbody");

            function postToTips(data) {
                return fetch("post_actions.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(data)
                }).then(res => res.json());
            }

            function loadTips() {
                postToTips({ action: "list" })
                    .then(data => {
                        tipTableBody.innerHTML = "";

                        if (!data.length) {
                            tipTableBody.innerHTML = `<tr><td colspan="8" class="text-center">No posts found.</td></tr>`;
                            return;
                        }

                        data.forEach(post => {
                            tipTableBody.innerHTML += `
                        <tr>
                            <td>${post.id}</td>
                            <td>${post.user_id}</td>
                            <td>${post.title}</td>
                            <td>${post.content}</td>
                            <td>${post.category}</td>
                            <td>${post.created_at}</td>
                            <td>${post.updated_at ?? '-'}</td>
                            <td>
                                <button class="btn btn-sm btn-danger deleteTip" data-id="${post.id}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>`;
                        });
                    });
            }

            // Open modal and save ID
            document.addEventListener("click", function (e) {
                if (e.target.closest(".deleteTip")) {
                    const postId = e.target.closest(".deleteTip").dataset.id;
                    document.getElementById("deletePostId").value = postId;
                    $('#deleteReasonModal').modal('show');
                }
            });

            // Handle delete with reason
            document.getElementById("deleteForm").addEventListener("submit", function (e) {
                e.preventDefault();
                const reason = document.getElementById("deleteReason").value;
                const postId = document.getElementById("deletePostId").value;

                if (!reason || !postId) return;

                postToTips({ action: "delete", id: postId, reason })
                    .then(() => {
                        $('#deleteReasonModal').modal('hide');
                        loadTips();
                    })
                    .catch(console.error);
            });

            // Initial load
            loadTips();
        });
    </script>

</body>

</html>