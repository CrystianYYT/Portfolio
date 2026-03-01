-- Database: crystian_website
-- Struttura per la gestione delle recensioni e altri contenuti dinamici

-- Creazione del database
CREATE DATABASE IF NOT EXISTS crystian_website 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE crystian_website;

-- Tabella per le recensioni dei clienti
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) DEFAULT NULL,
    rating TINYINT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    comment TEXT NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved TINYINT DEFAULT 0,
    ip_address VARCHAR(45) DEFAULT NULL,
    INDEX idx_status (status),
    INDEX idx_date_added (date_added),
    INDEX idx_email (email)
);

-- Tabella per le statistiche del sito
CREATE TABLE site_stats (
    id INT PRIMARY KEY AUTO_INCREMENT,
    metric_name VARCHAR(100) NOT NULL,
    metric_value INT DEFAULT 0,
    date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_metric (metric_name)
);

-- Tabella per i log delle visite
CREATE TABLE visit_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    page_visited VARCHAR(255),
    referrer VARCHAR(500),
    visit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    session_id VARCHAR(100),
    INDEX idx_ip_address (ip_address),
    INDEX idx_visit_date (visit_date),
    INDEX idx_session_id (session_id)
);

-- Tabella per gli articoli del blog (opzionale per futuro)
CREATE TABLE blog_posts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content LONGTEXT,
    excerpt TEXT,
    featured_image VARCHAR(500),
    author VARCHAR(100) DEFAULT 'CrystianYYT',
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    tags JSON,
    meta_description VARCHAR(160),
    date_published TIMESTAMP NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    views_count INT DEFAULT 0,
    INDEX idx_slug (slug),
    INDEX idx_status (status),
    INDEX idx_date_published (date_published)
);

-- Tabella per i testimonial clienti
CREATE TABLE testimonials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    client_name VARCHAR(100) NOT NULL,
    client_company VARCHAR(150),
    client_position VARCHAR(100),
    testimonial_text TEXT NOT NULL,
    client_photo VARCHAR(500),
    project_type VARCHAR(100),
    rating TINYINT CHECK (rating >= 1 AND rating <= 5),
    featured TINYINT DEFAULT 0,
    approved TINYINT DEFAULT 0,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_featured (featured),
    INDEX idx_approved (approved),
    INDEX idx_rating (rating)
);

-- Inserimento dati di esempio per i servizi
INSERT INTO services (name, description, price_min, price_max, category, icon, features) VALUES
('Sito Web Statico', 'Sito web moderno e responsive con design personalizzato', 2.00, 10.00, 'web-development', 'fas fa-globe', '["Design Responsive", "Ottimizzazione SEO", "Hosting Setup", "SSL Certificate"]'),
('Sito Web Dinamico', 'Sito web con funzionalità avanzate e gestione contenuti', 4.00, 20.00, 'web-development', 'fas fa-code', '["CMS Personalizzato", "Database Integration", "User Authentication", "Admin Panel"]'),
('Bot Discord Semplice', 'Bot Discord con comandi base per moderazione', 3.00, 5.00, 'discord-bots', 'fab fa-discord', '["Comandi Base", "Moderazione Automatica", "Supporto 24/7", "Setup Gratuito"]'),
('Bot Discord Avanzato', 'Bot Discord complesso con funzionalità personalizzate', 5.00, 20.00, 'discord-bots', 'fab fa-discord', '["Sistema di Livelli", "Database MySQL", "Dashboard Web", "API Integration"]'),
('Plugin Minecraft', 'Plugin personalizzati per server Minecraft', 5.00, 25.00, 'java-development', 'fas fa-cube', '["Funzionalità Custom", "Compatibilità Spigot/Paper", "Configurazione Facile", "Supporto Aggiornamenti"]'),
('Applicazione Java', 'Applicazioni desktop sviluppate in Java', 5.00, 25.00, 'java-development', 'fab fa-java', '["GUI Moderna", "Database Integration", "Cross-platform", "Distribuzione Inclusa"]'),
('Video Editing', 'Editing professionale per video YouTube e social', 3.00, 15.00, 'multimedia', 'fas fa-video', '["Montaggio Professionale", "Effetti Speciali", "Color Grading", "Consegna Rapida"]'),
('Setup Domini', 'Configurazione domini e hosting per il tuo sito', 2.00, 10.00, 'technical-support', 'fas fa-server', '["DNS Configuration", "SSL Setup", "Email Setup", "Supporto Tecnico"]'),
('Script Personalizzati', 'Automazione e script su misura per ogni esigenza', 10.00, 50.00, 'automation', 'fas fa-cogs', '["Python/JavaScript", "Web Scraping", "API Integration", "Documentazione Completa"]');

-- Inserimento statistiche iniziali
INSERT INTO site_stats (metric_name, metric_value) VALUES
('total_projects', 50),
('years_experience', 3),
('client_satisfaction', 100),
('total_visitors', 1250),
('reviews_count', 0);

-- Inserimento progetti portfolio di esempio
INSERT INTO portfolio_projects (title, description, technologies, image_url, project_url, github_url, featured, date_created) VALUES
('SpeedMC.it', 'Sito web completo per server Minecraft con sistema di donazioni integrato e gestione utenti avanzata', '["PHP", "MySQL", "Bootstrap", "JavaScript", "PayPal API"]', '/images/portfolio/speedmc.jpg', 'https://speedmc.it', 'https://github.com/CrystianYYT/speedmc-website', 1, '2024-01-15'),

('Advanced Discord Bot', 'Sistema di moderazione completo con dashboard web, sistema di livelli e integrazione database', '["Python", "Discord.py", "SQLite", "Flask", "HTML/CSS"]', '/images/portfolio/discord-bot.jpg', NULL, 'https://github.com/CrystianYYT/advanced-discord-bot', 1, '2024-03-10'),

('E-commerce Platform', 'Piattaforma e-commerce completa con gestione inventario, pagamenti e amministrazione', '["React", "Node.js", "MongoDB", "Stripe API", "Express.js"]', '/images/portfolio/ecommerce.jpg', NULL, NULL, 1, '2024-02-28'),

('Minecraft Plugin Suite', 'Suite di plugin personalizzati per server Minecraft con economia avanzata', '["Java", "Spigot API", "MySQL", "Redis", "Maven"]', '/images/portfolio/minecraft-plugins.jpg', NULL, 'https://github.com/CrystianYYT/mc-plugin-suite', 0, '2024-04-05'),

('Portfolio Website Template', 'Template responsive per portfolio con animazioni moderne e ottimizzazione SEO', '["HTML5", "CSS3", "JavaScript", "SASS", "Webpack"]', '/images/portfolio/portfolio-template.jpg', NULL, 'https://github.com/CrystianYYT/portfolio-template', 0, '2024-01-20');

-- Inserimento recensioni di esempio (approvate)
INSERT INTO reviews (name, rating, comment, approved) VALUES
('Marco Rossi', 5, 'Servizio eccellente! CrystianYYT ha creato il sito web perfetto per la mia attività. Professionale, veloce e sempre disponibile per modifiche e supporto.', 1),
('Laura Bianchi', 5, 'Il bot Discord che ha sviluppato per la nostra community è fantastico. Tutte le funzionalità richieste sono state implementate alla perfezione. Consigliatissimo!', 1),
('Giuseppe Verde', 4, 'Ottimo lavoro sul plugin Minecraft. Codice pulito, documentazione chiara e supporto post-vendita impeccabile. Tornerò sicuramente per altri progetti.', 1),
('Francesca Neri', 5, 'Video editing di qualità professionale. I miei video YouTube non sono mai stati così belli! Tempi di consegna rispettati e prezzi onesti.', 1),
('Alessandro Blu', 5, 'Script Python personalizzato che ha automatizzato completamente il mio workflow. Risparmio ore di lavoro ogni giorno. Investimento che vale ogni centesimo!', 1);

-- Inserimento testimonial
INSERT INTO testimonials (client_name, client_company, client_position, testimonial_text, project_type, rating, featured, approved) VALUES
('Maria Rossi', 'Digital Solutions SRL', 'CEO', 'CrystianYYT ha trasformato la nostra visione in una realtà digitale straordinaria. Il nuovo sito web ha aumentato le nostre conversioni del 300%.', 'Website Development', 5, 1, 1),
('Paolo Verdi', 'Gaming Community Italia', 'Community Manager', 'Il bot Discord sviluppato ha rivoluzionato la gestione della nostra community di 10.000+ membri. Automazione perfetta e supporto eccezionale.', 'Discord Bot', 5, 1, 1),
('Anna Blu', 'YouTube Channel', 'Content Creator', 'I video editati da CrystianYYT hanno una qualità cinematografica. I miei subscriber sono aumentati del 500% in soli 3 mesi!', 'Video Editing', 5, 0, 1);

-- Creazione utente admin per la gestione (opzionale)
CREATE TABLE admin_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'moderator') DEFAULT 'moderator',
    last_login TIMESTAMP NULL,
    active TINYINT DEFAULT 1,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Trigger per aggiornare automaticamente il conteggio recensioni
DELIMITER //
CREATE TRIGGER update_reviews_count 
    AFTER INSERT ON reviews 
    FOR EACH ROW 
BEGIN
    IF NEW.approved = 1 THEN
        UPDATE site_stats 
        SET metric_value = (SELECT COUNT(*) FROM reviews WHERE approved = 1)
        WHERE metric_name = 'reviews_count';
    END IF;
END//

CREATE TRIGGER update_reviews_count_on_approve 
    AFTER UPDATE ON reviews 
    FOR EACH ROW 
BEGIN
    IF OLD.approved != NEW.approved THEN
        UPDATE site_stats 
        SET metric_value = (SELECT COUNT(*) FROM reviews WHERE approved = 1)
        WHERE metric_name = 'reviews_count';
    END IF;
END//
DELIMITER ;

-- Procedura per ottenere statistiche del sito
DELIMITER //
CREATE PROCEDURE GetSiteStatistics()
BEGIN
    SELECT 
        (SELECT metric_value FROM site_stats WHERE metric_name = 'total_projects') as total_projects,
        (SELECT metric_value FROM site_stats WHERE metric_name = 'years_experience') as years_experience,
        (SELECT metric_value FROM site_stats WHERE metric_name = 'client_satisfaction') as client_satisfaction,
        (SELECT COUNT(*) FROM reviews WHERE approved = 1) as total_reviews,
        (SELECT AVG(rating) FROM reviews WHERE approved = 1) as average_rating,
        (SELECT COUNT(*) FROM portfolio_projects WHERE active = 1) as active_projects,
        (SELECT COUNT(*) FROM contact_requests WHERE status = 'completed') as completed_projects;
END//
DELIMITER ;

-- Procedura per approvazione batch delle recensioni
DELIMITER //
CREATE PROCEDURE ApproveReviews(IN review_ids TEXT)
BEGIN
    SET @sql = CONCAT('UPDATE reviews SET approved = 1 WHERE id IN (', review_ids, ')');
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END//
DELIMITER ;

-- Creazione indici per performance ottimali
CREATE INDEX idx_reviews_name_rating ON reviews(name, rating);
CREATE INDEX idx_portfolio_featured_active ON portfolio_projects(featured, active);
CREATE INDEX idx_services_category_active ON services(category, active);

-- View per le recensioni pubbliche
CREATE VIEW public_reviews AS
SELECT 
    id,
    name,
    rating,
    comment,
    date_added
FROM reviews 
WHERE approved = 1 
ORDER BY date_added DESC;

-- View per le statistiche dashboard
CREATE VIEW dashboard_stats AS
SELECT 
    'Progetti Totali' as stat_name,
    (SELECT COUNT(*) FROM portfolio_projects WHERE active = 1) as stat_value,
    'projects' as stat_type
UNION ALL
SELECT 
    'Recensioni Positive' as stat_name,
    (SELECT COUNT(*) FROM reviews WHERE approved = 1 AND rating >= 4) as stat_value,
    'reviews' as stat_type
UNION ALL
SELECT 
    'Media Valutazioni' as stat_name,
    (SELECT ROUND(AVG(rating), 1) FROM reviews WHERE approved = 1) as stat_value,
    'rating' as stat_type
UNION ALL
SELECT 
    'Richieste Contatti' as stat_name,
    (SELECT COUNT(*) FROM contact_requests WHERE date_added >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as stat_value,
    'contacts' as stat_type;

-- Inserimento log di sistema iniziale
INSERT INTO visit_logs (ip_address, user_agent, page_visited, referrer) VALUES
('127.0.0.1', 'Database Setup Script', 'System Installation', 'Direct');

-- Commenti e documentazione
/*
ISTRUZIONI PER L'INSTALLAZIONE:

1. Creare il database MySQL:
   mysql -u root -p < database.sql

2. Configurare le credenziali nel file PHP:
   - Modificare le variabili $db_host, $db_name, $db_user, $db_pass

3. Impostare i permessi corretti:
   - L'utente PHP deve avere privilegi di SELECT, INSERT, UPDATE

4. Per la gestione admin (opzionale):
   - Creare un utente admin nella tabella admin_users
   - Sviluppare un pannello di amministrazione separato

5. Backup automatico consigliato:
   mysqldump crystian_website > backup_$(date +%Y%m%d).sql

6. Monitoraggio performance:
   - Verificare regolarmente gli indici
   - Pulire i log vecchi periodicamente
   - Monitorare le query lente

SICUREZZA:
- Usare prepared statements sempre
- Validare tutti gli input utente
- Implementare rate limiting per le form
- Usare HTTPS per tutte le comunicazioni
- Configurare firewall appropriato

MANUTENZIONE:
- Backup giornalieri automatici
- Pulizia log più vecchi di 90 giorni
- Ottimizzazione indici mensile
- Aggiornamento statistiche settimanale
*/

-- Fine del file database.sql
    user_agent TEXT DEFAULT NULL,
    INDEX idx_approved (approved),
    INDEX idx_date_added (date_added),
    INDEX idx_rating (rating)
);

-- Tabella per i progetti del portfolio
CREATE TABLE portfolio_projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    technologies JSON,
    image_url VARCHAR(500),
    project_url VARCHAR(500),
    github_url VARCHAR(500),
    featured TINYINT DEFAULT 0,
    date_created DATE,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    active TINYINT DEFAULT 1,
    INDEX idx_featured (featured),
    INDEX idx_active (active),
    INDEX idx_date_created (date_created)
);

-- Tabella per i servizi offerti
CREATE TABLE services (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price_min DECIMAL(10,2),
    price_max DECIMAL(10,2),
    category VARCHAR(100),
    icon VARCHAR(100),
    features JSON,
    active TINYINT DEFAULT 1,
    sort_order INT DEFAULT 0,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_active (active),
    INDEX idx_sort_order (sort_order)
);

-- Tabella per le richieste di contatto
CREATE TABLE contact_requests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(200),
    message TEXT NOT NULL,
    phone VARCHAR(30) DEFAULT NULL,
    budget_range VARCHAR(50) DEFAULT NULL,
    project_type VARCHAR(100) DEFAULT NULL,
    status ENUM('new', 'in_progress', 'completed', 'cancelled') DEFAULT 'new',
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    admin_notes TEXT DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,