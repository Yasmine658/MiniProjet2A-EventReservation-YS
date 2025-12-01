<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Eventify - Online Event Booking'; ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <a href="/">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Eventify</span>
                    </a>
                </div>
                <ul class="nav-links">
                    <li><a href="/">Events</a></li>
                    <?php if (isset($_SESSION['admin_id'])): ?>
                        <li><a href="/admin/dashboard">Dashboard</a></li>
                        <li><a href="/admin/logout" class="btn-logout">Logout</a></li>
                    <?php else: ?>
                        <li><a href="/admin/login" class="btn-admin">Admin Login</a></li>
                    <?php endif; ?>
                </ul>
                <div class="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>
    <main class="main-content">
