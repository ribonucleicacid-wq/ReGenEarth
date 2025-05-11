<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test User Actions</title>
</head>
<body>

    <h2>Test Users Module</h2>

    <!-- Search -->
    <input type="text" id="searchTerm" placeholder="Search users">
    <button onclick="searchUsers()">Search</button>

    <!-- List -->
    <button onclick="listUsers()">List All Users</button>

    <!-- Get User -->
    <input type="number" id="getId" placeholder="User ID">
    <button onclick="getUser()">Get User</button>

    <!-- Update User -->
    <h4>Update User</h4>
    <input type="number" id="updateId" placeholder="User ID">
    <input type="text" id="username" placeholder="Username">
    <input type="email" id="email" placeholder="Email">
    <input type="text" id="bio" placeholder="Bio">
    <button onclick="updateUser()">Update</button>

    <!-- Delete User -->
    <input type="number" id="deleteId" placeholder="User ID">
    <button onclick="deleteUser()">Delete</button>

    <pre id="responseOutput" style="margin-top:20px; background:#f0f0f0; padding:10px;"></pre>

    <script>
        const output = document.getElementById("responseOutput");

        // Function to send POST requests using Fetch API
        function postToUsers(data) {
            return fetch("admin/user_actions.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: new URLSearchParams(data).toString() // Format as URL-encoded data
            })
            .then(response => response.json())
            .then(json => {
                output.textContent = JSON.stringify(json, null, 2);
            })
            .catch(err => {
                output.textContent = "Error: " + err.message;
            });
        }

        // Function to list all users
        function listUsers() {
            postToUsers({ action: "list" });
        }

        // Function to search users
        function searchUsers() {
            const searchTerm = document.getElementById("searchTerm").value;
            postToUsers({ action: "searchUser", userRole: "user", searchTerm });
        }

        // Function to get a single user by ID
        function getUser() {
            const user_id = parseInt(document.getElementById("getId").value, 10);
            if (!isNaN(user_id)) {
                postToUsers({ action: "get", user_id });
            }
        }

        // Function to update user details
        function updateUser() {
            const user_id = parseInt(document.getElementById("updateId").value, 10);
            const username = document.getElementById("username").value;
            const email = document.getElementById("email").value;
            const bio = document.getElementById("bio").value;
            if (!isNaN(user_id)) {
                postToUsers({ action: "update", user_id, username, email, bio });
            }
        }

        // Function to delete a user
        function deleteUser() {
            const user_id = parseInt(document.getElementById("deleteId").value, 10);
            if (!isNaN(user_id) && confirm("Are you sure you want to delete this user?")) {
                postToUsers({ action: "delete", user_id });
            }
        }
    </script>
</body>
</html>
