USE mini_event;

INSERT INTO admin (username, password_hash)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.g/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash);


INSERT INTO events (title, description, date, location, seats, image) VALUES
('Concert Jazz Live', 'Soirée exceptionnelle avec les meilleurs artistes de jazz international. Une ambiance unique pour les amateurs de musique.', '2025-12-15 20:00:00', 'Salle Philharmonie, Tunis', 150, 'jazz-concert.jpg'),
('Conférence Tech 2025', 'Découvrez les dernières innovations en intelligence artificielle et blockchain. Conférenciers de renommée mondiale.', '2025-12-20 09:00:00', 'Centre de Congrès, Tunis', 300, 'tech-conference.jpg'),
('Festival Gastronomique', 'Explorez les saveurs du monde avec nos chefs étoilés. Dégustations, ateliers et découvertes culinaires.', '2025-12-25 18:00:00', 'Palais des Congrès, Tunis', 200, 'food-festival.jpg'),
('Marathon Solidaire', 'Course caritative de 10km pour soutenir les associations locales. Tous niveaux bienvenus!', '2026-01-10 07:00:00', 'Lac de Tunis', 500, 'marathon.jpg'),
('Exposition Art Moderne', 'Découvrez les œuvres des artistes contemporains tunisiens et internationaux. Vernissage privé.', '2026-01-15 19:00:00', 'Musée d Art Moderne, Tunis', 100, 'art-expo.jpg'),
('Workshop Photographie', 'Apprenez les techniques professionnelles de photographie avec un expert. Session pratique incluse.', '2026-01-20 14:00:00', 'Studio PhotoArt, Tunis', 25, 'photo-workshop.jpg');

INSERT INTO reservations (event_id, name, email, phone) VALUES
(1, 'Mohamed Ben Ali', 'mohamed.benali@email.com', '+216 20 123 456'),
(1, 'Fatima Mansour', 'fatima.mansour@email.com', '+216 22 654 321'),
(2, 'Ahmed Trabelsi', 'ahmed.trabelsi@email.com', '+216 98 765 432'),
(2, 'Salma Khedher', 'salma.khedher@email.com', '+216 21 234 567'),
(3, 'Karim Bouazizi', 'karim.bouazizi@email.com', '+216 55 876 543'),
(4, 'Nour Jebali', 'nour.jebali@email.com', '+216 26 345 678'),
(5, 'Youssef Hammami', 'youssef.hammami@email.com', '+216 97 456 789');