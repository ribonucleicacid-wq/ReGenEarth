<?php
session_start();
include 'inc/header.php';
include '../auth/user_only.php';
require_once '../src/db_connection.php';

$db = new Database();
$conn = $db->getConnection();

// Handle AJAX requests
if (isset($_POST['action'])) {
    $response = ['success' => false];

    switch ($_POST['action']) {
        case 'mark_read':
            if (isset($_POST['notification_id'])) {
                $stmt = $conn->prepare("CALL sp_mark_notification_read(?)");
                $stmt->execute([$_POST['notification_id']]);
                $response['success'] = true;
            }
            break;

        case 'mark_all_read':
            $stmt = $conn->prepare("CALL sp_mark_all_notifications_read(?)");
            $stmt->execute([$_SESSION['user_id']]);
            $response['success'] = true;
            break;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Get notifications for the current page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;

// Get user's profile picture
$stmt = $conn->prepare("SELECT profile_picture FROM users WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
$profile_picture = $user_data['profile_picture'] ?? 'default.jpg';

$stmt = $conn->prepare("CALL sp_get_notifications(?, ?, ?)");
$stmt->execute([$_SESSION['user_id'], $page, $limit]);
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt->closeCursor();

// Get total notifications count for pagination
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM notifications WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$total_count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_count / $limit);
?>

 <!-- Main Content -->
 <div class="container mt-4">
     <!-- Filter Bar -->
     <div class="d-flex justify-content-between align-items-center mb-4">
         <div class="btn-group filter-group" role="group">
             <button type="button" class="btn filter-btn active" data-filter="all">
                 <i class="fas fa-bell"></i> All
             </button>
             <button type="button" class="btn filter-btn" data-filter="unread">
                 <i class="fas fa-circle"></i> Unread
             </button>
             <button type="button" class="btn filter-btn" data-filter="mentions">
                 <i class="fas fa-at"></i> Mentions
             </button>
             <button type="button" class="btn filter-btn" data-filter="follows">
                 <i class="fas fa-user-plus"></i> Follows
             </button>
             <button type="button" class="btn filter-btn" data-filter="badges">
                 <i class="fas fa-trophy"></i> Badges
             </button>
         </div>
         <button class="btn mark-all-btn" id="markAllRead">
             <i class="fas fa-check-double"></i> Mark all as read
         </button>
     </div>
 
     <!-- Notification Table -->
     <div class="table-responsive">
         <table class="table table-hover notification-table">
             <tbody>
                <?php if (empty($notifications)): ?>
                <tr>
                    <td colspan="2" class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-bell-slash fa-4x mb-3"></i>
                            <h4>No notifications yet</h4>
                            <p class="text-muted">When you get notifications, they'll show up here</p>
                         </div>
                     </td>
                 </tr>
                <?php else: ?>
                    <?php foreach ($notifications as $notification): 
                        $data = json_decode($notification['notification_data'], true);
                    ?>
                    <tr class="<?= $notification['is_read'] ? '' : 'unread' ?>" data-type="<?= $notification['type'] ?>">
                     <td>
                         <div class="d-flex align-items-center">
                                <?php if (!$notification['is_read']): ?>
                             <div class="unread-indicator"></div>
                                <?php endif; ?>
                                <div class="notification-icon <?= $notification['type'] ?> mx-3">
                                    <?php
                                    $icon = '';
                                    switch ($notification['type']) {
                                        case 'like': $icon = 'thumbs-up'; break;
                                        case 'comment': $icon = 'comment'; break;
                                        case 'follow': $icon = 'user-plus'; break;
                                        case 'mention': $icon = 'at'; break;
                                        case 'badge': $icon = 'trophy'; break;
                                        case 'action': $icon = 'leaf'; break;
                                    }
                                    ?>
                                    <i class="fas fa-<?= $icon ?>"></i>
                             </div>
                                <img src="../uploads/members/<?= htmlspecialchars($notification['notifier_profile_picture'] ?? 'default.jpg') ?>" 
                                     class="rounded-circle me-2" width="32" height="32" 
                                     alt="<?= htmlspecialchars($notification['notifier_username']) ?>">
                             <div class="notification-content">
                                    <div>
                                        <?php
                                        switch ($notification['type']) {
                                            case 'like':
                                                echo "<strong>" . htmlspecialchars($notification['notifier_username']) . "</strong> liked your post";
                                                if (isset($data['post_title'])) {
                                                    echo ": <strong>" . htmlspecialchars($data['post_title']) . "</strong>";
                                                }
                                                break;
                                            case 'comment':
                                                echo "<strong>" . htmlspecialchars($notification['notifier_username']) . "</strong> commented on your post";
                                                if (isset($data['comment_text'])) {
                                                    echo ": <strong>\"" . htmlspecialchars($data['comment_text']) . "\"</strong>";
                                                }
                                                break;
                                            case 'follow':
                                                echo "<strong>" . htmlspecialchars($notification['notifier_username']) . "</strong> started following you";
                                                break;
                                            case 'mention':
                                                echo "<strong>" . htmlspecialchars($notification['notifier_username']) . "</strong> mentioned you in a post";
                                                break;
                                            case 'badge':
                                                echo "You earned the <strong>" . htmlspecialchars($data['badge_name']) . "</strong> badge! 🎉";
                                                break;
                                        }
                                        ?>
                             </div>
                                    <small class="text-muted" data-timestamp="<?= $notification['created_at'] ?>"></small>
                             </div>
                         </div>
                     </td>
                     <td class="text-end" style="width: 100px;">
                            <?php
                            $buttonText = '';
                            $buttonLink = '#';
                            switch ($notification['type']) {
                                case 'like':
                                case 'comment':
                                case 'mention':
                                    $buttonText = 'View Post';
                                    $buttonLink = isset($data['post_id']) ? "post.php?id=" . $data['post_id'] : '#';
                                    break;
                                case 'follow':
                                    $buttonText = 'View Profile';
                                    $buttonLink = "profile.php?user=" . urlencode($notification['notifier_username']);
                                    break;
                                case 'badge':
                                    $buttonText = 'View Badge';
                                    $buttonLink = "profile.php?tab=badges";
                                    break;
                            }
                            ?>
                            <button class="btn btn-sm btn-outline-secondary view-action" 
                                    data-type="<?= $notification['type'] ?>" 
                                    data-id="<?= $notification['notification_id'] ?>"
                                    onclick="window.location.href='<?= $buttonLink ?>'">
                                <?= $buttonText ?>
                            </button>
                     </td>
                 </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
             </tbody>
         </table>
     </div>
 
    <?php if ($total_pages > 1): ?>
     <!-- Pagination -->
     <nav aria-label="Notifications pagination" class="mt-4">
         <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page - 1 ?>">
                     <i class="fas fa-chevron-left"></i>
                 </a>
             </li>
            <?php endif; ?>

            <?php
            $start = max(1, min($page - 2, $total_pages - 4));
            $end = min($total_pages, $start + 4);
            
            for ($i = $start; $i <= $end; $i++):
            ?>
            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page + 1 ?>">
                     <i class="fas fa-chevron-right"></i>
                 </a>
             </li>
            <?php endif; ?>
         </ul>
     </nav>
    <?php endif; ?>
 </div>
 
 <style>
 /* Main Content Container */
 .container.mt-4 {
     margin-top: 1rem !important;
 }
 
 /* Notification Table */
 .notification-table {
     background-color: var(--prussian-blue);
     color: var(--silver);
     border-radius: 8px;
     overflow: hidden;
     margin-bottom: 0.1rem;
 }
 
.notification-item {
    border-bottom: 1px solid var(--bs-border-color);
    transition: background-color 0.2s ease;
}

.notification-item:last-child {
     border-bottom: none;
 }
 
.notification-item.unread {
    background-color: rgba(13, 110, 253, 0.05);
}

.notification-item:hover {
    background-color: rgba(0,0,0,0.02);
}

.notification-indicator {
    width: 8px;
    height: 8px;
     border-radius: 50%;
    margin-right: 15px;
}

.notification-indicator.unread {
    background-color: #0d6efd;
}

.notification-avatar {
    margin-right: 15px;
}

.notification-avatar img {
    width: 40px;
    height: 40px;
    object-fit: cover;
}

.notification-content {
    margin-right: 15px;
}

.notification-text {
    margin-bottom: 4px;
}

.notification-meta {
    font-size: 0.875rem;
}

.empty-state {
    color: var(--bs-secondary);
    padding: 40px 20px;
}

.empty-state i {
    color: var(--bs-secondary);
    opacity: 0.5;
}

.filter-group .btn {
    border-radius: 20px;
    margin-right: 5px;
    padding: 0.375rem 1rem;
}

.filter-group .btn.active {
    background-color: #0d6efd;
     color: white;
}

#markAllRead {
    border-radius: 20px;
}

.notification-actions {
    white-space: nowrap;
}

.notification-actions .btn {
    border-radius: 20px;
    padding: 0.25rem 1rem;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .notification-item.unread {
        background-color: rgba(13, 110, 253, 0.1);
    }
    
    .notification-item:hover {
        background-color: rgba(255,255,255,0.05);
     }
 }
 </style>
 
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <script>
 document.addEventListener('DOMContentLoaded', function() {
    // Format timestamps
    function formatTimeAgo(date) {
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);

        if (diffInSeconds < 60) return 'Just now';
        if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)}m ago`;
        if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)}h ago`;
        if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)}d ago`;

        return date.toLocaleDateString('default', { month: 'short', day: 'numeric' });
    }

    document.querySelectorAll('[data-timestamp]').forEach(element => {
        const timestamp = new Date(element.dataset.timestamp);
        element.textContent = formatTimeAgo(timestamp);
    });

    // Filter functionality
    document.querySelectorAll('.filter-group .btn').forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            document.querySelectorAll('.filter-group .btn').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');

            // Filter notifications
            const filter = this.dataset.filter;
            document.querySelectorAll('.notification-item').forEach(item => {
                if (filter === 'all' || 
                    (filter === 'unread' && item.classList.contains('unread')) ||
                    item.dataset.type === filter) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
             });
         });
     });
 
    // Mark as read functionality
    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', function(e) {
            if (!e.target.closest('.notification-actions')) {
                const id = this.dataset.id;
                fetch('notifications.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=mark_read&notification_id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.classList.remove('unread');
                        const indicator = this.querySelector('.notification-indicator');
                        if (indicator) indicator.classList.remove('unread');
                        updateUnreadCount();
                    }
                });
             }
         });
     });
 
     // Mark all as read functionality
    const markAllReadBtn = document.getElementById('markAllRead');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function() {
            fetch('notifications.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'action=mark_all_read'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelectorAll('.notification-item.unread').forEach(item => {
                        item.classList.remove('unread');
                        const indicator = item.querySelector('.notification-indicator');
                        if (indicator) indicator.classList.remove('unread');
                    });
                    updateUnreadCount();
             }
         });
     });
    }

    function updateUnreadCount() {
        const unreadCount = document.querySelectorAll('.notification-item.unread').length;
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            badge.textContent = unreadCount;
            badge.style.display = unreadCount > 0 ? '' : 'none';
        }
    }
 });
 </script>
 
 <?php include 'inc/footer.php'; ?>