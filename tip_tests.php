<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Test Tips Actions</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <h2>Test Tips Module</h2>

    <!-- Search -->
    <input type="text" id="searchTerm" placeholder="Search tips">
    <button onclick="searchTips()">Search</button>

    <!-- List -->
    <button onclick="listTips()">List All Tips</button>

    <!-- Get Tip -->
    <input type="number" id="getId" placeholder="Tip ID">
    <button onclick="getTip()">Get Tip</button>

    <!-- Add Tip -->
    <h4>Add Tip</h4>
    <input type="text" id="addCategory" placeholder="Category">
    <input type="text" id="addTip" placeholder="Tip">
    <button onclick="addTip()">Add</button>

    <!-- Update Tip -->
    <h4>Update Tip</h4>
    <input type="number" id="updateId" placeholder="Tip ID">
    <input type="text" id="updateCategory" placeholder="New Category">
    <input type="text" id="updateTip" placeholder="New Tip">
    <button onclick="updateTip()">Update</button>

    <!-- Delete Tip -->
    <input type="number" id="deleteId" placeholder="Tip ID">
    <button onclick="deleteTip()">Delete</button>

    <pre id="responseOutput" style="margin-top:20px; background:#f0f0f0; padding:10px;"></pre>

    <script>
        const output = $("#responseOutput");

        function postToTips(data) {
            $.post("admin/tips_actions.php", data, function (res) {
                output.text(JSON.stringify(res, null, 2));
            }, "json").fail((xhr) => {
                output.text(`Error: ${xhr.responseText}`);
            });
        }

        function listTips() {
            postToTips({ action: "list" });
        }

        function searchTips() {
            const search = $("#searchTerm").val();
            postToTips({ action: "search", search });
        }

        function getTip() {
            const id = $("#getId").val();
            postToTips({ action: "get", id });
        }

        function addTip() {
            const category = $("#addCategory").val();
            const tip = $("#addTip").val();
            postToTips({ action: "add", category, tip });
        }

        function updateTip() {
            const id = $("#updateId").val();
            const category = $("#updateCategory").val();
            const tip = $("#updateTip").val();
            postToTips({ action: "update", id, category, tip });
        }

        function deleteTip() {
            const id = $("#deleteId").val();
            if (confirm("Are you sure you want to delete this tip?")) {
                postToTips({ action: "delete", id });
            }
        }
    </script>
    

</body>

</html>