<?php 
$pageTitle = 'Upcoming Events - Eventify';
require_once __DIR__ . '/../partials/header.php'; 
?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Unleash the Best Experiences</h1>
            <p>Discover and reserve your spot at the most exciting events across Tunisia</p>
            <a href="#upcoming-events" class="btn btn-primary">Explore Events</a>
        </div>
    </div>
</section>

<section id="upcoming-events" class="events-section">
    <div class="container">
        <h2 class="section-title">Upcoming Events</h2>
        
        <?php if (empty($events)): ?>
            <div class="no-events">
                <i class="fas fa-calendar-times"></i>
                <p>Stay tuned! New events are coming soon.</p>
            </div>
        <?php else: ?>
            <div class="events-grid">
                <?php foreach ($events as $event): ?>
                    <div class="event-card">
                        <div class="event-image">
                            <img src="/uploads/<?php echo htmlspecialchars($event['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($event['title']); ?>"
                                 onerror="this.src='/uploads/default-event.jpg'">
                            <?php if ($event['is_full']): ?>
                                <span class="badge badge-full">Sold Out</span>
                            <?php else: ?>
                                <span class="badge badge-available"><?php echo $event['available_seats']; ?> spots left</span>
                            <?php endif; ?>
                        </div>
                        <div class="event-content">
                            <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                            <div class="event-meta">
                                <span><i class="fas fa-calendar"></i> <?php echo date('M d, Y', strtotime($event['date'])); ?></span>
                                <span><i class="fas fa-clock"></i> <?php echo date('h:i A', strtotime($event['date'])); ?></span>
                            </div>
                            <div class="event-location">
                                <i class="fas fa-map-marker-alt"></i>
                                <?php echo htmlspecialchars($event['location']); ?>
                            </div>
                            <p class="event-description">
                                <?php echo substr(htmlspecialchars($event['description']), 0, 150); ?>...
                            </p>
                            <a href="/event/<?php echo $event['id']; ?>" class="btn btn-primary">
                                View Details
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
