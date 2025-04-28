<?php
session_start();

include 'inc/header.php';
include '../auth/user_only.php';
?>

<!-- Add SweetAlert2 CSS and JS in the head section -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<!-- Add Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    .notif-content {
        --moonstone: #57AFC3;
        --prussian-blue: #132F43;
        --silver: #CACFD3;
        --taupe-gray: #999A9C;
        --rich-black: #0B1A26;
        font-family: 'Inter', 'Arial', sans-serif;
        color: var(--silver);
        background-color: var(--rich-black);
        min-height: 100vh;
        padding-bottom: 40px;
    }
    .notif-content .container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        background: var(--prussian-blue);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .notif-header {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #f0f0f0;
        padding: 30px 0 20px 0;
        font-size: 2em;
        font-weight: 700;
        color: var(--moonstone);
        background: transparent;
        margin-bottom: 20px;
    }
    .notif-count {
        background: var(--moonstone);
        color: #fff;
        border-radius: 12px;
        font-size: 13px;
        padding: 2px 10px;
        margin-left: 10px;
    }
    .mark-as-read {
        margin-left: auto;
        font-size: 0.6em;
        color: var(--silver);
    cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
        padding: 6px 16px;
        border-radius: 6px;
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.6), rgba(35, 79, 56, 0.6));
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .mark-as-read:hover {
        color: white;
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.8), rgba(35, 79, 56, 0.8));
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
    }
    .mark-as-read i {
        font-size: 0.85em;
    }
    .notif-list {
        padding: 0;
    }
    .notif-row {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #f0f0f0;
        padding: 22px 20px;
        position: relative;
        transition: background 0.2s;
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.8), rgba(35, 79, 56, 0.8));
        border-radius: 12px;
        margin-bottom: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .notif-row:last-child {
        border-bottom: none;
    }
    .notif-row.unread {
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.95), rgba(35, 79, 56, 0.95));
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        border: 2px solid var(--moonstone);
        position: relative;
    }
    
    .notif-row.unread::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background-color: var(--moonstone);
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }
    .notif-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #e0e0e0;
    display: flex;
    align-items: center;
    justify-content: center;
        font-weight: 600;
        color: #555;
        margin: 0 25px 0 10px;
        overflow: hidden;
    flex-shrink: 0;
        position: relative;
    }
    .notif-type {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 22px;
        height: 22px;
        border-radius: 50%;
    display: flex;
    align-items: center;
        justify-content: center;
        z-index: 2;
        padding: 0;
    }
    .notif-type.like-badge { 
        background-color: #ff5252; 
        border: 2px solid #ff5252;
    }
    .notif-type.comment-badge { 
        background-color: #2196f3; 
        border: 2px solid #2196f3;
    }
    .notif-type.follow-badge { 
        background-color: #4caf50; 
        border: 2px solid #4caf50;
    }
    .notif-type.award-badge { 
        background-color: #ffc107; 
        border: 2px solid #ffc107;
    }
    .notif-type.mention-badge { 
        background-color: #00bcd4; 
        border: 2px solid #00bcd4;
    }
    .notif-type.system-badge { 
        background-color: #ff9800; 
        border: 2px solid #ff9800;
    }
    
    .notif-type i {
        font-size: 11px;
    color: white;
        line-height: 1;
    display: flex;
    align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        font-weight: bold;
        text-shadow: 0 1px 1px rgba(0,0,0,0.2);
    }
    .text-danger {
        color: #ff6b6b !important;
    }
    .text-primary {
        color: #4dabf7 !important;
    }
    .text-success {
        color: #69db7c !important;
    }
    .text-warning {
        color: #ffd43b !important;
    }
    .text-info {
        color: #22b8cf !important;
    }
    .notif-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .notif-content-main {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .notif-main {
        color: #CACFD3;
        font-size: 15px;
    }
    .notif-actions {
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .notif-action {
        font-size: 14px;
        padding: 4px 12px;
        color: var(--moonstone);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
        display: inline-block;
        text-align: center;
    }
    .notif-action.decline {
        color: #ff6b6b;
    }
    .notif-action:hover {
        text-decoration: none;
        background-color: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }
    .notif-date {
        color: #b0b0b0;
        font-size: 13px;
        min-width: 110px;
        text-align: right;
        margin-left: 20px;
    }
    .notif-loadmore {
        display: block;
        margin: 30px auto 0 auto;
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.7), rgba(35, 79, 56, 0.7));
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--silver);
        border-radius: 8px;
        padding: 10px 36px;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 500;
    }
    .notif-loadmore:hover {
        background: linear-gradient(135deg, rgba(19, 47, 67, 0.9), rgba(35, 79, 56, 0.9));
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        color: white;
    }
    .notif-loadmore:active {
        transform: translateY(0);
    }
    .notif-content h3 {
        color: white;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .notif-content p {
        color: rgba(255, 255, 255, 0.85);
        font-size: 14px;
        margin: 0;
    }
    .notif-time {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.7);
        margin-top: 5px;
    }
    
    /* SweetAlert2 Customization */
    .swal2-popup {
        background: var(--prussian-blue);
        color: var(--silver);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .swal2-title, .swal2-html-container {
        color: var(--silver) !important;
    }
    
    .swal2-confirm {
        background-color: var(--moonstone) !important;
    }
    
    .swal2-deny {
        background-color: #ff6b6b !important;
}
</style>

<div class="notif-content">
    <div class="container">
        <div class="notif-header">
            Notifications
            <span class="mark-as-read" id="mark-as-read">
                <i class="fas fa-check-double"></i>
                Mark as All Read
            </span>
        </div>
        <div class="notif-list" id="notif-list">
            <!-- Like notification -->
            <div class="notif-row unread">
                <div class="notif-avatar">
                    <img src="../assets/images/user.png" alt="User">
                    <div class="notif-type like-badge"><i class="bi bi-heart-fill"></i></div>
                </div>
                <div class="notif-content-main">
                    <span class="notif-main"><b>Alex Johnson</b> liked your post "Creating a Sustainable Garden"</span>
                    <div class="notif-actions">
                        <a href="#" class="notif-action">View Post</a>
                    </div>
                </div>
                <div class="notif-date">2 hours ago</div>
            </div>
            
            <!-- Comment notification -->
            <div class="notif-row unread">
                <div class="notif-avatar">
                    <img src="../assets/images/user.png" alt="User">
                    <div class="notif-type comment-badge"><i class="bi bi-chat-fill"></i></div>
                </div>
                <div class="notif-content-main">
                    <span class="notif-main"><b>Sarah Miller</b> commented on your post "Renewable Energy Tips"</span>
                    <div class="notif-actions">
                        <a href="#" class="notif-action">View Comment</a>
                        <a href="#" class="notif-action">Reply</a>
                    </div>
                </div>
                <div class="notif-date">Yesterday</div>
            </div>
            
            <!-- Follow notification -->
            <div class="notif-row unread">
                <div class="notif-avatar">
                    <img src="../assets/images/user.png" alt="User">
                    <div class="notif-type follow-badge"><i class="bi bi-person-plus-fill"></i></div>
                </div>
                <div class="notif-content-main">
                    <span class="notif-main"><b>Michael Davis</b> started following you</span>
                    <div class="notif-actions">
                        <a href="#" class="notif-action">View Profile</a>
                        <a href="#" class="notif-action">Follow Back</a>
                    </div>
                </div>
                <div class="notif-date">2 days ago</div>
            </div>
            
            <!-- Badge notification -->
            <div class="notif-row">
                <div class="notif-avatar">
                    <img src="../assets/images/user.png" alt="User">
                    <div class="notif-type award-badge"><i class="bi bi-trophy-fill"></i></div>
                </div>
                <div class="notif-content-main">
                    <span class="notif-main">You earned the <b>Eco Warrior</b> badge! Congratulations! 🎉</span>
                    <div class="notif-actions">
                        <a href="#" class="notif-action">View Badges</a>
                        <a href="#" class="notif-action">Share</a>
                    </div>
                </div>
                <div class="notif-date">Last week</div>
            </div>
            
            <!-- Mention notification -->
            <div class="notif-row">
                <div class="notif-avatar">
                    <img src="../assets/images/user.png" alt="User">
                    <div class="notif-type mention-badge"><i class="bi bi-at"></i></div>
                </div>
                <div class="notif-content-main">
                    <span class="notif-main"><b>Green Team</b> mentioned you in a post "Community Clean-up Event"</span>
                    <div class="notif-actions">
                        <a href="#" class="notif-action">View Post</a>
                        <a href="#" class="notif-action">Reply</a>
                    </div>
                </div>
                <div class="notif-date">2 weeks ago</div>
            </div>
        </div>
        <button class="notif-loadmore">
            <i class="fas fa-sync-alt"></i> Load more
        </button>
    </div>
</div>

<script>
    // Immediate initialization to ensure counts are synced
    document.addEventListener('DOMContentLoaded', function() {
        // Get all unread notifications
        const unreadNotifications = document.querySelectorAll('.notif-row.unread');
        const unreadCount = unreadNotifications.length;
        
        // Force update localStorage with the accurate count from this page
        localStorage.setItem('unreadNotifications', unreadCount);
        
        // Directly update any notification badge on this page
        const badges = document.querySelectorAll('.notification-badge');
        badges.forEach(badge => {
            badge.textContent = unreadCount;
            badge.style.display = unreadCount > 0 ? 'inline-block' : 'none';
        });
        
        console.log('Notifications initialized with count:', unreadCount);
        
        // Notify other potential listeners
        broadcastNotificationUpdate(unreadCount);
    });
    
    // Central function to update notification counts everywhere
    function updateUnreadCount() {
        const unreadCount = document.querySelectorAll('.notif-row.unread').length;
        
        // Update localStorage (which header.php reads)
        localStorage.setItem('unreadNotifications', unreadCount);
        
        // Update all badges on this page
        const badges = document.querySelectorAll('.notification-badge');
        badges.forEach(badge => {
            badge.textContent = unreadCount;
            badge.style.display = unreadCount > 0 ? 'inline-block' : 'none';
        });
        
        console.log('Notification count updated:', unreadCount);
        
        // Broadcast the change
        broadcastNotificationUpdate(unreadCount);
        
        return unreadCount;
    }
    
    // Broadcast notification updates to other components
    function broadcastNotificationUpdate(count) {
        // Create and dispatch a custom event that header.php can listen for
        const event = new CustomEvent('unreadNotificationsUpdated', { 
            detail: { count: count },
            bubbles: true
        });
        document.dispatchEvent(event);
        
        // Also trigger a storage event for cross-page communication
        try {
            // This trick forces a storage event on the same page
            const storageEvent = new StorageEvent('storage', {
                key: 'unreadNotifications',
                newValue: count,
                oldValue: localStorage.getItem('unreadNotifications'),
                storageArea: localStorage
            });
            window.dispatchEvent(storageEvent);
        } catch (e) {
            console.log('Storage event simulation not supported');
        }
    }

    // Mark individual notifications as read when clicked
    document.querySelectorAll('.notif-row.unread').forEach(row => {
        row.addEventListener('click', function() {
            this.classList.remove('unread');
            updateUnreadCount();
        });
    });

    // Mark all as read functionality
    document.getElementById('mark-as-read').addEventListener('click', function() {
        const unreadNotifications = document.querySelectorAll('.notif-row.unread');
        
        if (unreadNotifications.length === 0) {
            Swal.fire({
                title: 'No Unread Notifications',
                text: 'You have no unread notifications to mark as read.',
                icon: 'info',
                confirmButtonText: 'OK',
                confirmButtonColor: '#57AFC3'
            });
            return;
        }
        
        Swal.fire({
            title: 'Mark All as Read?',
            text: 'Are you sure you want to mark all notifications as read?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, mark all as read',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#57AFC3'
        }).then((result) => {
            if (result.isConfirmed) {
                // Process with loading indicator
                Swal.fire({
                    title: 'Processing...',
                    text: 'Marking notifications as read',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Small delay to show the processing indicator
                setTimeout(() => {
                    // Mark all notifications as read
                    unreadNotifications.forEach(notification => {
                        notification.classList.remove('unread');
                    });
                    
                    // Update the count everywhere
                    const newCount = updateUnreadCount();
                    
                    // Show success message
                    Swal.fire({
                        title: 'Success!',
                        text: 'All notifications marked as read',
                        icon: 'success',
                        timer: 1500,
                        confirmButtonColor: '#57AFC3'
                    });
                }, 500);
            }
        });
    });
    
    // Load More button (doesn't add notifications, just shows a message)
    document.querySelector('.notif-loadmore').addEventListener('click', function() {
        Swal.fire({
            title: 'No more notifications',
            text: 'There are no more notifications to load at this time.',
            icon: 'info',
            confirmButtonText: 'Ok',
            confirmButtonColor: '#57AFC3'
        });
    });
    
    // Listen for external changes (in case header.php updates something)
    window.addEventListener('storage', function(e) {
        if (e.key === 'unreadNotifications') {
            console.log('Notification count changed externally:', e.newValue);
            
            // If external count doesn't match our actual count, force update
            const actualCount = document.querySelectorAll('.notif-row.unread').length;
            if (parseInt(e.newValue) !== actualCount) {
                console.log('Correcting count discrepancy:', e.newValue, 'vs', actualCount);
                updateUnreadCount();
            }
        }
    });
</script>