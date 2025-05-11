<?php

// Helper function to make cURL requests
function makeRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Test List Users
function testListUsers()
{
    $response = makeRequest('http://localhost/admin_actions.php', [
        'action' => 'list'
    ]);
    echo "Test: List Users\n";
    print_r($response);
    echo "\n";
}

// Test Search User
function testSearchUser()
{
    $response = makeRequest('http://localhost/admin_actions.php', [
        'action' => 'searchUser',
        'searchTerm' => 'john'
    ]);
    echo "Test: Search User\n";
    print_r($response);
    echo "\n";
}

// Test Get User by ID
function testGetUser()
{
    $response = makeRequest('http://localhost/admin_actions.php', [
        'action' => 'get',
        'user_id' => 1
    ]);
    echo "Test: Get User\n";
    print_r($response);
    echo "\n";
}

// Test Add User
function testAddUser()
{
    $response = makeRequest('http://localhost/admin_actions.php', [
        'action' => 'add',
        'username' => 'newuser',
        'email' => 'newuser@example.com',
        'role' => 'admin',
        'bio' => 'This is a new user'
    ]);
    echo "Test: Add User\n";
    print_r($response);
    echo "\n";
}

// Test Update User
function testUpdateUser()
{
    $response = makeRequest('http://localhost/admin_actions.php', [
        'action' => 'update',
        'user_id' => 1,
        'username' => 'updateduser',
        'email' => 'updateduser@example.com',
        'role' => 'staff',
        'bio' => 'Updated user bio'
    ]);
    echo "Test: Update User\n";
    print_r($response);
    echo "\n";
}

// Test Delete User
function testDeleteUser()
{
    $response = makeRequest('http://localhost/admin_actions.php', [
        'action' => 'delete',
        'user_id' => 1
    ]);
    echo "Test: Delete User\n";
    print_r($response);
    echo "\n";
}

// Run all tests
testListUsers();
testSearchUser();
testGetUser();
testAddUser();
testUpdateUser();
testDeleteUser();

?>