<?php
session_start();
include 'inc/header.php';
include '../auth/user_only.php';
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
                <!-- Page 1 Notifications -->
                <!-- Like Notification -->
                <tr class="unread" data-type="like">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="unread-indicator"></div>
                            <div class="notification-icon like mx-3">
                                <i class="fas fa-thumbs-up"></i>
                            </div>
                            <img src="../uploads/members/sample profile.png" class="rounded-circle me-2" width="32" height="32">
                            <div class="notification-content">
                                <div><strong>Maria Santos</strong> liked your eco-action post: <strong>Tree Planting</strong></div>
                                <small class="text-muted">2 hours ago</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-end" style="width: 100px;">
                        <button class="btn btn-sm btn-outline-secondary view-action" data-type="like" data-id="123">View Post</button>
                    </td>
                </tr>

                <!-- Comment Notification -->
                <tr class="unread" data-type="comment">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="unread-indicator"></div>
                            <div class="notification-icon comment mx-3">
                                <i class="fas fa-comment"></i>
                            </div>
                            <img src="../uploads/members/sample profile.png" class="rounded-circle me-2" width="32" height="32">
                            <div class="notification-content">
                                <div><strong>John Doe</strong> commented on your post: <strong>"Great initiative! Let's plant more trees together."</strong></div>
                                <small class="text-muted">5 hours ago</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-end" style="width: 100px;">
                        <button class="btn btn-sm btn-outline-secondary view-action" data-type="comment" data-id="456">View Comment</button>
                    </td>
                </tr>

                <!-- Follow Notification -->
                <tr class="unread" data-type="follow">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="unread-indicator"></div>
                            <div class="notification-icon follow mx-3">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <img src="../uploads/members/sample profile.png" class="rounded-circle me-2" width="32" height="32">
                            <div class="notification-content">
                                <div><strong>Eco Warrior</strong> started following you</div>
                                <small class="text-muted">1 day ago</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-end" style="width: 100px;">
                        <button class="btn btn-sm btn-outline-secondary view-action" data-type="follow" data-id="ecowarrior">View Profile</button>
                    </td>
                </tr>

                <!-- Badge Notification -->
                <tr class="unread" data-type="badge">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="unread-indicator"></div>
                            <div class="notification-icon badge mx-3">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <img src="../uploads/members/sample profile.png" class="rounded-circle me-2" width="32" height="32">
                            <div class="notification-content">
                                <div>You earned the <strong>Gaianova</strong> badge! Congratulations!🎉</div>
                                <small class="text-muted">2 days ago</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-end" style="width: 100px;">
                        <button class="btn btn-sm btn-outline-secondary view-action" data-type="badge">View Badge</button>
                    </td>
                </tr>

                <!-- Mention Notification -->
                <tr class="unread" data-type="mention">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="unread-indicator"></div>
                            <div class="notification-icon mention mx-3">
                                <i class="fas fa-at"></i>
                            </div>
                            <img src="../uploads/members/sample profile.png" class="rounded-circle me-2" width="32" height="32">
                            <div class="notification-content">
                                <div><strong>Green Team</strong> mentioned you in a post: <strong>"@YourName join us for the beach cleanup!"</strong></div>
                                <small class="text-muted">3 days ago</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-end" style="width: 100px;">
                        <button class="btn btn-sm btn-outline-secondary view-action" data-type="mention" data-id="789">View Mention</button>
                    </td>
                </tr>

                <!-- Action Notification -->
                <tr class="unread" data-type="action">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="unread-indicator"></div>
                            <div class="notification-icon action mx-3">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <img src="../uploads/members/sample profile.png" class="rounded-circle me-2" width="32" height="32">
                            <div class="notification-content">
                                <div><strong>New Eco Challenge</strong> available: <strong>Zero Waste Week</strong></div>
                                <small class="text-muted">1 week ago</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-end" style="width: 100px;">
                        <button class="btn btn-sm btn-outline-secondary view-action" data-type="action" data-id="zerowasteweek">Join Challenge</button>
                    </td>
                </tr>

                <!-- Page 2 Notifications (Hidden by default) -->
                <!-- Like Notification -->
                <tr class="unread page-2" data-type="like" style="display: none;">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="unread-indicator"></div>
                            <div class="notification-icon like mx-3">
                                <i class="fas fa-thumbs-up"></i>
                            </div>
                            <img src="../uploads/members/sample profile.png" class="rounded-circle me-2" width="32" height="32">
                            <div class="notification-content">
                                <div><strong>Sarah Green</strong> liked your post: <strong>Recycling Tips</strong></div>
                                <small class="text-muted">1 week ago</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-end" style="width: 100px;">
                        <button class="btn btn-sm btn-outline-secondary view-action" data-type="like" data-id="124">View Post</button>
                    </td>
                </tr>

                <!-- Comment Notification -->
                <tr class="unread page-2" data-type="comment" style="display: none;">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="unread-indicator"></div>
                            <div class="notification-icon comment mx-3">
                                <i class="fas fa-comment"></i>
                            </div>
                            <img src="../uploads/members/sample profile.png" class="rounded-circle me-2" width="32" height="32">
                            <div class="notification-content">
                                <div><strong>Eco Enthusiast</strong> replied to your comment: <strong>"Great tips! I'll try these at home."</strong></div>
                                <small class="text-muted">1 week ago</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-end" style="width: 100px;">
                        <button class="btn btn-sm btn-outline-secondary view-action" data-type="comment" data-id="457">View Reply</button>
                    </td>
                </tr>

                <!-- Follow Notification -->
                <tr class="page-2" data-type="follow" style="display: none;">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="notification-icon follow mx-3">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <img src="../uploads/members/sample profile.png" class="rounded-circle me-2" width="32" height="32">
                            <div class="notification-content">
                                <div><strong>Green Living</strong> started following you</div>
                                <small class="text-muted">2 weeks ago</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-end" style="width: 100px;">
                        <button class="btn btn-sm btn-outline-secondary view-action" data-type="follow" data-id="greenliving">View Profile</button>
                    </td>
                </tr>

                <!-- Badge Notification -->
                <tr class="page-2" data-type="badge" style="display: none;">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="notification-icon badge mx-3">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <img src="../uploads/members/sample profile.png" class="rounded-circle me-2" width="32" height="32">
                            <div class="notification-content">
                                <div>You earned the <strong>Eco Champion</strong> badge! Keep it up!🌟</div>
                                <small class="text-muted">2 weeks ago</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-end" style="width: 100px;">
                        <button class="btn btn-sm btn-outline-secondary view-action" data-type="badge">View Badge</button>
                    </td>
                </tr>

                <!-- Mention Notification -->
                <tr class="page-2" data-type="mention" style="display: none;">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="notification-icon mention mx-3">
                                <i class="fas fa-at"></i>
                            </div>
                            <img src="../uploads/members/sample profile.png" class="rounded-circle me-2" width="32" height="32">
                            <div class="notification-content">
                                <div><strong>Eco Warriors Club</strong> mentioned you in a post: <strong>"@YourName check out our new recycling program!"</strong></div>
                                <small class="text-muted">3 weeks ago</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-end" style="width: 100px;">
                        <button class="btn btn-sm btn-outline-secondary view-action" data-type="mention" data-id="790">View Mention</button>
                    </td>
                </tr>

                <!-- Action Notification -->
                <tr class="page-2" data-type="action" style="display: none;">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="notification-icon action mx-3">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <img src="../uploads/members/sample profile.png" class="rounded-circle me-2" width="32" height="32">
                            <div class="notification-content">
                                <div><strong>New Eco Challenge</strong> available: <strong>Plastic-Free Month</strong></div>
                                <small class="text-muted">1 month ago</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-end" style="width: 100px;">
                        <button class="btn btn-sm btn-outline-secondary view-action" data-type="action" data-id="plasticfree">Join Challenge</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav aria-label="Notifications pagination" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled" id="prevPage">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
            <li class="page-item active"><a class="page-link" href="#" data-page="1">1</a></li>
            <li class="page-item"><a class="page-link" href="#" data-page="2">2</a></li>
            <li class="page-item" id="nextPage">
                <a class="page-link" href="#">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
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

.notification-table td {
    padding: 1rem;
    vertical-align: middle;
}

.notification-table tbody tr {
    position: relative;
    transition: all 0.3s ease;
    border-bottom: 1px solid rgba(153, 154, 156, 0.2);
    cursor: pointer;
    padding-left: 40px;
}

.notification-table tbody tr:last-child {
    border-bottom: none;
}

.notification-table tbody tr:hover {
    background-color: rgba(87, 175, 195, 0.1);
}

/* Unread Indicator */
.unread-indicator {
    width: 10px;
    height: 10px;
    background-color: var(--moonstone);
    border-radius: 50%;
    display: inline-block;
    position: absolute;
    top: 50%;
    left: 15px;
    transform: translateY(-50%);
    animation: pulse 2s infinite;
    animation-delay: -1s;
    box-shadow: 0 0 0 0 rgba(87, 175, 195, 0.7);
    z-index: 1;
}

@keyframes pulse {
    0% {
        transform: translateY(-50%) scale(1);
        box-shadow: 0 0 0 0 rgba(87, 175, 195, 0.7);
    }
    70% {
        transform: translateY(-50%) scale(1.3);
        box-shadow: 0 0 0 8px rgba(87, 175, 195, 0);
    }
    100% {
        transform: translateY(-50%) scale(1);
        box-shadow: 0 0 0 0 rgba(87, 175, 195, 0);
    }
}

/* Notification Icon Container */
.notification-icon {
    position: relative;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(87, 175, 195, 0.1);
    border-radius: 50%;
    flex-shrink: 0;
    margin-right: 10px;
    margin-left: 20px;
}

.notification-content {
    flex: 1;
    min-width: 200px;
    max-width: 100%;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.notification-content div {
    margin-bottom: 0.25rem;
}

.notification-content small {
    color: var(--taupe-gray);
}

/* Notification Icon Colors */
.notification-icon.like { color: #4CAF50; }
.notification-icon.comment { color: #2196F3; }
.notification-icon.follow { color: #9C27B0; }
.notification-icon.badge { color: #FFC107; }
.notification-icon.mention { color: #E91E63; }
.notification-icon.action { color: #00BCD4; }

.btn-outline-secondary {
    border-color: var(--moonstone);
    color: var(--silver);
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background-color: var(--moonstone);
    color: white;
}

/* Filter Buttons Styling */
.filter-group {
    background-color: var(--prussian-blue);
    padding: 0.5rem;
    border-radius: 50px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.filter-btn {
    background: transparent;
    color: var(--silver);
    border: none;
    padding: 0.5rem 1.2rem;
    margin: 0 0.2rem;
    border-radius: 25px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-btn i {
    font-size: 0.9rem;
}

.filter-btn:hover {
    background-color: rgba(87, 175, 195, 0.2);
    color: var(--moonstone);
    transform: translateY(-1px);
}

.filter-btn.active {
    background-color: var(--moonstone);
    color: white;
    box-shadow: 0 2px 8px rgba(87, 175, 195, 0.3);
}

/* Mark All Read Button */
.mark-all-btn {
    background-color: var(--moonstone);
    color: white;
    border: none;
    padding: 0.5rem 1.2rem;
    border-radius: 25px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 2px 8px rgba(87, 175, 195, 0.3);
}

.mark-all-btn:hover {
    background-color: #489fb5;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(87, 175, 195, 0.4);
}

/* Pagination Styling */
.pagination {
    margin-top: 0;
    margin-bottom: 0;
}

.page-link {
    background-color: var(--prussian-blue);
    color: var(--silver);
    border: none;
    padding: 0.5rem 1rem;
    margin: 0 0.2rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.page-link:hover {
    background-color: rgba(87, 175, 195, 0.2);
    color: var(--moonstone);
    transform: translateY(-1px);
}

.page-item.active .page-link {
    background-color: var(--moonstone);
    color: white;
    box-shadow: 0 2px 8px rgba(87, 175, 195, 0.3);
}

.page-item.disabled .page-link {
    background-color: rgba(153, 154, 156, 0.1);
    color: var(--taupe-gray);
}

/* Mobile adjustments */
@media (max-width: 576px) {
    .container.mt-4 {
        margin-top: 0.75rem !important;
    }
    
    .notification-table {
        margin-bottom: 0.05rem;
    }
    
    .page-link {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
    }
    
    .notification-table tbody tr {
        padding-left: 35px;
    }
    
    .unread-indicator {
        width: 8px;
        height: 8px;
        left: 12px;
    }
    
    .notification-icon {
        margin-left: 15px;
    }
}

@media (max-width: 768px) {
    .notification-table {
        font-size: 0.9rem;
    }
    
    .notification-table td {
        padding: 0.75rem;
    }
    
    .notification-icon {
        width: 30px;
        height: 30px;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    
    .filter-group {
        flex-wrap: wrap;
        justify-content: center;
        padding: 0.3rem;
    }
    
    .filter-btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
    }
    
    .mark-all-btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
    }
    
    .page-link {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .unread-indicator {
        width: 8px;
        height: 8px;
        left: -1px;
    }
    
    .notification-table tbody tr {
        padding-left: 15px;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to update notification states in both table and dropdown
    function updateNotificationStates() {
        // Update table states
        const unreadRows = document.querySelectorAll('.notification-table tbody tr.unread');
        const unreadCount = unreadRows.length;
        
        // Update badge count
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            badge.textContent = unreadCount;
            badge.style.display = unreadCount > 0 ? 'block' : 'none';
        }

        // Update dropdown states (if it exists)
        const dropdownItems = document.querySelectorAll('.notification-item-preview');
        if (dropdownItems.length > 0) {
            dropdownItems.forEach((item, index) => {
                const tableRow = document.querySelector(`.notification-table tbody tr:nth-child(${index + 1})`);
                if (tableRow) {
                    if (tableRow.classList.contains('unread')) {
                        item.classList.add('unread');
                    } else {
                        item.classList.remove('unread');
                    }
                }
            });
        }

        // Store the unread state in localStorage for cross-page synchronization
        localStorage.setItem('unreadNotifications', unreadCount);
    }

    // Initial state update
    updateNotificationStates();

    // Listen for storage events to sync across tabs/pages
    window.addEventListener('storage', function(e) {
        if (e.key === 'unreadNotifications') {
            updateNotificationStates();
        }
    });

    // Handle action button clicks
    document.querySelectorAll('.view-action').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const type = this.getAttribute('data-type');
            const id = this.getAttribute('data-id');
            
            let url = '';
            let title = '';
            let text = '';
            
            switch(type) {
                case 'like':
                    title = 'Viewing Post';
                    text = 'Redirecting to the liked post...';
                    url = `post.php?id=${id}`;
                    break;
                case 'comment':
                    title = 'Viewing Comment';
                    text = 'Redirecting to the comment...';
                    url = `post.php?id=${id.split('-')[0]}#comment-${id.split('-')[1]}`;
                    break;
                case 'follow':
                    title = 'Viewing Profile';
                    text = 'Redirecting to the user profile...';
                    url = `profile.php?user=${id}`;
                    break;
                case 'badge':
                    title = 'Viewing Badge';
                    text = 'Redirecting to your badges...';
                    url = 'profile.php?tab=badges';
                    break;
                case 'mention':
                    title = 'Viewing Mention';
                    text = 'Redirecting to the post where you were mentioned...';
                    url = `post.php?id=${id}`;
                    break;
                case 'action':
                    title = 'Joining Challenge';
                    text = 'You are joining the Zero Waste Week challenge!';
                    url = `challenges.php?id=${id}`;
                    break;
            }
            
            Swal.fire({
                title: title,
                text: text,
                icon: 'info',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = url;
            });
        });
    });

    const itemsPerPage = 6;
    let currentPage = 1;
    let currentFilter = 'all';
    const totalPages = 2; // Since we have 12 notifications total

    function showPage(page, filter) {
        // Hide all notifications
        document.querySelectorAll('.notification-table tbody tr').forEach(tr => {
            tr.style.display = 'none';
        });

        // Get all notifications that match the current filter
        let filteredNotifications = Array.from(document.querySelectorAll('.notification-table tbody tr'));
        
        switch(filter) {
            case 'unread':
                filteredNotifications = filteredNotifications.filter(tr => tr.classList.contains('unread'));
                break;
            case 'mentions':
                filteredNotifications = filteredNotifications.filter(tr => tr.getAttribute('data-type') === 'mention');
                break;
            case 'follows':
                filteredNotifications = filteredNotifications.filter(tr => tr.getAttribute('data-type') === 'follow');
                break;
            case 'badges':
                filteredNotifications = filteredNotifications.filter(tr => tr.getAttribute('data-type') === 'badge');
                break;
        }

        // Calculate total pages based on filtered notifications
        const totalFilteredPages = Math.ceil(filteredNotifications.length / itemsPerPage);
        
        // Show notifications for current page
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        
        filteredNotifications.slice(startIndex, endIndex).forEach(tr => {
            tr.style.display = '';
        });

        // Update pagination buttons
        document.querySelectorAll('.page-link[data-page]').forEach(link => {
            const pageNum = parseInt(link.getAttribute('data-page'));
            link.parentElement.classList.remove('active');
            if (pageNum === page) {
                link.parentElement.classList.add('active');
            }
            // Hide page numbers that exceed total filtered pages
            link.parentElement.style.display = pageNum <= totalFilteredPages ? '' : 'none';
        });

        // Update prev/next buttons
        document.getElementById('prevPage').classList.toggle('disabled', page === 1);
        document.getElementById('nextPage').classList.toggle('disabled', page === totalFilteredPages);
    }

    // Filter functionality
    const filterButtons = document.querySelectorAll('[data-filter]');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            currentFilter = filter;
            currentPage = 1; // Reset to first page when changing filter
            showPage(currentPage, filter);
        });
    });

    // Handle page clicks
    document.querySelectorAll('.page-link[data-page]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const page = parseInt(this.getAttribute('data-page'));
            if (page !== currentPage) {
                currentPage = page;
                showPage(currentPage, currentFilter);
            }
        });
    });

    // Handle prev/next clicks
    document.getElementById('prevPage').addEventListener('click', function(e) {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage, currentFilter);
        }
    });

    document.getElementById('nextPage').addEventListener('click', function(e) {
        e.preventDefault();
        const filteredNotifications = Array.from(document.querySelectorAll('.notification-table tbody tr')).filter(tr => {
            switch(currentFilter) {
                case 'unread': return tr.classList.contains('unread');
                case 'mentions': return tr.getAttribute('data-type') === 'mention';
                case 'follows': return tr.getAttribute('data-type') === 'follow';
                case 'badges': return tr.getAttribute('data-type') === 'badge';
                default: return true;
            }
        });
        const totalFilteredPages = Math.ceil(filteredNotifications.length / itemsPerPage);
        
        if (currentPage < totalFilteredPages) {
            currentPage++;
            showPage(currentPage, currentFilter);
        }
    });

    // Show first page initially
    showPage(1, 'all');

    // Mark all as read functionality
    document.getElementById('markAllRead').addEventListener('click', function() {
        Swal.fire({
            title: 'Mark all as read?',
            text: "This will mark all notifications as read.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#57AFC3',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, mark all as read'
        }).then((result) => {
            if (result.isConfirmed) {
                const unreadRows = document.querySelectorAll('.notification-table tbody tr.unread');
                unreadRows.forEach(row => {
                    row.classList.remove('unread');
                    const indicator = row.querySelector('.unread-indicator');
                    if (indicator) {
                        indicator.style.display = 'none';
                    }

                    // If on unread filter, hide the row
                    const activeFilter = document.querySelector('[data-filter].active');
                    if (activeFilter && activeFilter.getAttribute('data-filter') === 'unread') {
                        row.style.display = 'none';
                    }
                });

                // Update states in both table and dropdown
                updateNotificationStates();

                Swal.fire(
                    'Success!',
                    'All notifications have been marked as read.',
                    'success'
                );
            }
        });
    });

    // Individual row click to mark as read
    document.querySelectorAll('.notification-table tbody tr').forEach(row => {
        row.addEventListener('click', function(e) {
            if (!e.target.closest('button') && this.classList.contains('unread')) {
                this.classList.remove('unread');
                const indicator = this.querySelector('.unread-indicator');
                if (indicator) {
                    indicator.style.display = 'none';
                }

                // If on unread filter, hide the row
                const activeFilter = document.querySelector('[data-filter].active');
                if (activeFilter && activeFilter.getAttribute('data-filter') === 'unread') {
                    this.style.display = 'none';
                }

                // Update states in both table and dropdown
                updateNotificationStates();
            }
        });
    });
});
</script>