<?php 
$pageTitle = htmlspecialchars($event['title']) . ' - MiniEvent';
require_once __DIR__ . '/../partials/header.php'; 
?>

<section class="event-details">
    <div class="container">
        <div class="back-link">
            <a href="/"><i class="fas fa-arrow-left"></i> Retour aux événements</a>
        </div>

        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <strong>Réservation confirmée !</strong> Vous allez recevoir un email de confirmation à l'adresse fournie.
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['reservation_errors'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <ul>
                    <?php foreach ($_SESSION['reservation_errors'] as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['reservation_errors']); ?>
        <?php endif; ?>

        <div class="event-detail-container">
            <div class="event-detail-image">
                <img src="/uploads/<?php echo htmlspecialchars($event['image']); ?>" 
                     alt="<?php echo htmlspecialchars($event['title']); ?>"
                     onerror="this.src='/uploads/default-event.jpg'">
            </div>

            <div class="event-detail-content">
                <h1><?php echo htmlspecialchars($event['title']); ?></h1>
                
                <div class="event-info-grid">
                    <div class="info-item">
                        <i class="fas fa-calendar"></i>
                        <div>
                            <strong>Date</strong>
                            <p><?php echo date('d/m/Y', strtotime($event['date'])); ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <strong>Heure</strong>
                            <p><?php echo date('H:i', strtotime($event['date'])); ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <strong>Lieu</strong>
                            <p><?php echo htmlspecialchars($event['location']); ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-users"></i>
                        <div>
                            <strong>Places disponibles</strong>
                            <p><?php echo $event['available_seats']; ?> / <?php echo $event['seats']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="event-description">
                    <h2>Description</h2>
                    <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                </div>

                <?php if (!$event['is_full']): ?>
                    <div class="reservation-form-container">
                        <h2>Réserver votre place</h2>
                        <form action="/eservation" method="POST" id="reservationForm" class="reservation-form">
                            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                            
                            <div class="form-group">
                                <label for="name"><i class="fas fa-user"></i> Nom complet *</label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="<?php echo isset($_SESSION['reservation_data']['name']) ? htmlspecialchars($_SESSION['reservation_data']['name']) : ''; ?>"
                                       required 
                                       placeholder="Entrez votre nom complet">
                            </div>

                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Email *</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="<?php echo isset($_SESSION['reservation_data']['email']) ? htmlspecialchars($_SESSION['reservation_data']['email']) : ''; ?>"
                                       required 
                                       placeholder="votre.email@exemple.com">
                            </div>

                            <div class="form-group">
                                <label for="phone"><i class="fas fa-phone"></i> Téléphone *</label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="<?php echo isset($_SESSION['reservation_data']['phone']) ? htmlspecialchars($_SESSION['reservation_data']['phone']) : ''; ?>"
                                       required 
                                       placeholder="+216 12 345 678">
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-check-circle"></i> Confirmer la réservation
                            </button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Événement complet</strong> - Il n'y a plus de places disponibles pour cet événement.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php 
unset($_SESSION['reservation_data']);
require_once __DIR__ . '/../partials/footer.php'; 
?>