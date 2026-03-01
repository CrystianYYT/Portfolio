<?php
// Configurazione database per le recensioni
$db_host = 'localhost';
$db_name = 'crystian_website';
$db_user = 'root';
$db_pass = '';

// Funzione per connessione database
function getConnection() {
    global $db_host, $db_name, $db_user, $db_pass;
    try {
        $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        return null;
    }
}

// Gestione invio recensione
$message = '';
if ($_POST['action'] ?? '' === 'add_review') {
    $name = trim($_POST['name'] ?? '');
    $rating = intval($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');
    
    if (!empty($name) && $rating >= 1 && $rating <= 5 && !empty($comment)) {
        $pdo = getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("INSERT INTO reviews (name, rating, comment, date_added) VALUES (?, ?, ?, NOW())");
                $stmt->execute([$name, $rating, $comment]);
                $message = 'Recensione aggiunta con successo!';
            } catch(PDOException $e) {
                $message = 'Errore nell\'aggiungere la recensione.';
            }
        }
    } else {
        $message = 'Per favore compila tutti i campi correttamente.';
    }
}

// Recupera recensioni
function getReviews() {
    $pdo = getConnection();
    if (!$pdo) return [];
    
    try {
        $stmt = $pdo->query("SELECT * FROM reviews WHERE approved = 1 ORDER BY date_added DESC LIMIT 10");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return [];
    }
}

$reviews = getReviews();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CrystianYYT - Sviluppatore Web Professionale</title>
    <meta name="description" content="Servizi di sviluppo web, bot Discord, applicazioni Java e molto altro. Soluzioni digitali professionali per ogni esigenza.">
    <link rel="icon" href="./src/images/favicon.ico" type="image/x-icon">
    
    <!-- CSS e Fonts -->
    <link rel="stylesheet" href="./src/css/modern-style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=AUIfq-gEPWP89c4VAz7J8Md6OnoPVqZMDTA0qXy_YkyhHrAGUtF0Sel8hQzPOAerxb2_We9hGd4dbm88&currency=EUR"></script>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <img src="./src/images/profile.jpeg" alt="CrystianYYT" class="nav-avatar">
                <span>CrystianYYT</span>
            </div>
            <ul class="nav-menu" id="nav-menu">
                <li><a href="#home" class="nav-link">Home</a></li>
                <li><a href="#about" class="nav-link">Chi Sono</a></li>
                <li><a href="#services" class="nav-link">Servizi</a></li>
                <li><a href="#portfolio" class="nav-link">Portfolio</a></li>
                <li><a href="#reviews" class="nav-link">Recensioni</a></li>
                <li><a href="#pricing" class="nav-link">Prezzi</a></li>
                <li><a href="#contact" class="nav-link">Contatti</a></li>
            </ul>
            <div class="nav-toggle" id="nav-toggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-background">
            <div class="hero-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>
        </div>
        <div class="hero-content">
            <div class="hero-text animate__animated animate__fadeInUp">
                <h1>Benvenuto nel Futuro Digitale</h1>
                <p class="hero-subtitle">Sviluppatore Web • Designer • Creatore di Soluzioni Innovative</p>
                <p class="hero-description">
                    Trasformo le tue idee in realtà digitali con soluzioni moderne, sicure e family-friendly. 
                    Dal web development ai bot Discord, fino alle applicazioni personalizzate.
                </p>
                <div class="hero-buttons">
                    <a href="#services" class="btn btn-primary">
                        <i class="fas fa-rocket"></i>
                        I Miei Servizi
                    </a>
                    <a href="#contact" class="btn btn-secondary">
                        <i class="fas fa-comments"></i>
                        Collaboriamo
                    </a>
                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="scroll-arrow"></div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Chi Sono</span>
                <h2>Passione, Esperienza e Innovazione</h2>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <h3>Il Mio Approccio</h3>
                        <p>
                            Sono uno sviluppatore web appassionato con una forte attenzione alla qualità e all'esperienza utente. 
                            Mi specializzo in soluzioni digitali complete, dal design alla implementazione, sempre con un occhio 
                            alla sicurezza e all'usabilità per tutta la famiglia.
                        </p>
                    </div>
                    
                    <div class="about-card">
                        <div class="about-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3>La Mia Missione</h3>
                        <p>
                            Creo soluzioni digitali che fanno la differenza. Ogni progetto è un'opportunità per innovare 
                            e offrire valore reale ai miei clienti, dalle piccole imprese alle community online.
                        </p>
                    </div>

                    <div class="stats">
                        <div class="stat-item">
                            <div class="stat-number">50+</div>
                            <div class="stat-label">Progetti Completati</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">3+</div>
                            <div class="stat-label">Anni di Esperienza</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">100%</div>
                            <div class="stat-label">Clienti Soddisfatti</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Servizi</span>
                <h2>Soluzioni Complete per Ogni Esigenza</h2>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>Sviluppo Web</h3>
                    <p>Siti web moderni, responsive e ottimizzati SEO. Dal design alla messa online, creo la tua presenza digitale perfetta.</p>
                    <ul class="service-features">
                        <li>Design Responsive</li>
                        <li>Ottimizzazione SEO</li>
                        <li>CMS Personalizzati</li>
                        <li>E-commerce Solutions</li>
                    </ul>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fab fa-discord"></i>
                    </div>
                    <h3>Bot Discord</h3>
                    <p>Bot Discord avanzati con funzionalità personalizzate per migliorare la gestione e l'engagement della tua community.</p>
                    <ul class="service-features">
                        <li>Moderazione Automatica</li>
                        <li>Sistemi di Livelli</li>
                        <li>Comandi Personalizzati</li>
                        <li>Integrazione Database</li>
                    </ul>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fab fa-java"></i>
                    </div>
                    <h3>Applicazioni Java</h3>
                    <p>Applicazioni desktop robuste e plugin Minecraft personalizzati per esperienze gaming uniche.</p>
                    <ul class="service-features">
                        <li>Plugin Minecraft</li>
                        <li>Desktop Applications</li>
                        <li>Server Management</li>
                        <li>API Integration</li>
                    </ul>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fab fa-python"></i>
                    </div>
                    <h3>Automazione Python</h3>
                    <p>Script di automazione e applicazioni Python per ottimizzare i tuoi processi di lavoro quotidiani.</p>
                    <ul class="service-features">
                        <li>Web Scraping</li>
                        <li>Data Analysis</li>
                        <li>Task Automation</li>
                        <li>API Development</li>
                    </ul>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <h3>Video Editing</h3>
                    <p>Editing professionale per contenuti YouTube, social media e presentazioni aziendali.</p>
                    <ul class="service-features">
                        <li>Montaggio Professionale</li>
                        <li>Effetti Speciali</li>
                        <li>Color Grading</li>
                        <li>Motion Graphics</li>
                    </ul>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h3>Consulenza Tecnica</h3>
                    <p>Supporto nella scelta delle tecnologie, setup di domini e consulenza per progetti digitali complessi.</p>
                    <ul class="service-features">
                        <li>Setup Domini</li>
                        <li>Server Configuration</li>
                        <li>Tech Consulting</li>
                        <li>Performance Optimization</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Portfolio</span>
                <h2>I Miei Progetti</h2>
            </div>
            <div class="portfolio-grid">
                <div class="portfolio-item">
                    <div class="portfolio-image">
                        <div class="portfolio-overlay">
                            <div class="portfolio-info">
                                <h3>SpeedMC.it</h3>
                                <p>Sito web completo per server Minecraft con sistema di donazioni integrato</p>
                                <div class="portfolio-tags">
                                    <span>PHP</span>
                                    <span>MySQL</span>
                                    <span>Bootstrap</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item">
                    <div class="portfolio-image">
                        <div class="portfolio-overlay">
                            <div class="portfolio-info">
                                <h3>Bot Discord Avanzato</h3>
                                <p>Sistema di moderazione completo con dashboard web integrata</p>
                                <div class="portfolio-tags">
                                    <span>Python</span>
                                    <span>Discord.py</span>
                                    <span>SQLite</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portfolio-item">
                    <div class="portfolio-image">
                        <div class="portfolio-overlay">
                            <div class="portfolio-info">
                                <h3>E-commerce Solution</h3>
                                <p>Piattaforma e-commerce completa con gestione inventario e pagamenti</p>
                                <div class="portfolio-tags">
                                    <span>React</span>
                                    <span>Node.js</span>
                                    <span>MongoDB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section id="reviews" class="reviews">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Recensioni</span>
                <h2>Cosa Dicono i Miei Clienti</h2>
            </div>
            
            <?php if (!empty($message)): ?>
                <div class="message <?= strpos($message, 'successo') !== false ? 'success' : 'error' ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <div class="reviews-container">
                <div class="reviews-list">
                    <?php if (empty($reviews)): ?>
                        <div class="no-reviews">
                            <i class="fas fa-star"></i>
                            <p>Sii il primo a lasciare una recensione!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($reviews as $review): ?>
                            <div class="review-card">
                                <div class="review-header">
                                    <div class="review-avatar">
                                        <?= strtoupper(substr($review['name'], 0, 1)) ?>
                                    </div>
                                    <div class="review-info">
                                        <h4><?= htmlspecialchars($review['name']) ?></h4>
                                        <div class="review-rating">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <i class="fas fa-star <?= $i <= $review['rating'] ? 'active' : '' ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <span class="review-date"><?= date('d/m/Y', strtotime($review['date_added'])) ?></span>
                                    </div>
                                </div>
                                <p class="review-text"><?= htmlspecialchars($review['comment']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="review-form-container">
                    <h3>Lascia una Recensione</h3>
                    <form class="review-form" method="POST">
                        <input type="hidden" name="action" value="add_review">
                        
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Il tuo nome" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Valutazione:</label>
                            <div class="rating-input">
                                <input type="radio" name="rating" value="5" id="star5" required>
                                <label for="star5"><i class="fas fa-star"></i></label>
                                <input type="radio" name="rating" value="4" id="star4">
                                <label for="star4"><i class="fas fa-star"></i></label>
                                <input type="radio" name="rating" value="3" id="star3">
                                <label for="star3"><i class="fas fa-star"></i></label>
                                <input type="radio" name="rating" value="2" id="star2">
                                <label for="star2"><i class="fas fa-star"></i></label>
                                <input type="radio" name="rating" value="1" id="star1">
                                <label for="star1"><i class="fas fa-star"></i></label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <textarea name="comment" placeholder="Scrivi la tua recensione..." rows="4" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            Invia Recensione
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="pricing">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Prezzi</span>
                <h2>Soluzioni per Ogni Budget</h2>
                <p>Tariffe trasparenti e competitive per servizi di qualità professionale</p>
            </div>
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-header">
                        <i class="fas fa-globe"></i>
                        <h3>Sviluppo Web</h3>
                    </div>
                    <div class="pricing-content">
                        <div class="pricing-item">
                            <span class="service-name">Sito Statico</span>
                            <span class="price">€2-10</span>
                        </div>
                        <div class="pricing-item">
                            <span class="service-name">Sito Dinamico</span>
                            <span class="price">€4-20</span>
                        </div>
                        <div class="pricing-item">
                            <span class="service-name">E-commerce</span>
                            <span class="price">€15-50</span>
                        </div>
                    </div>
                </div>

                <div class="pricing-card featured">
                    <div class="featured-badge">Più Richiesto</div>
                    <div class="pricing-header">
                        <i class="fab fa-discord"></i>
                        <h3>Bot Discord</h3>
                    </div>
                    <div class="pricing-content">
                        <div class="pricing-item">
                            <span class="service-name">Bot Semplice</span>
                            <span class="price">€3-5</span>
                        </div>
                        <div class="pricing-item">
                            <span class="service-name">Bot Avanzato</span>
                            <span class="price">€5-20</span>
                        </div>
                        <div class="pricing-item">
                            <span class="service-name">Sistema Completo</span>
                            <span class="price">€20-50</span>
                        </div>
                    </div>
                </div>

                <div class="pricing-card">
                    <div class="pricing-header">
                        <i class="fab fa-java"></i>
                        <h3>Sviluppo Java</h3>
                    </div>
                    <div class="pricing-content">
                        <div class="pricing-item">
                            <span class="service-name">Plugin Minecraft</span>
                            <span class="price">€5-25</span>
                        </div>
                        <div class="pricing-item">
                            <span class="service-name">Applicazione Desktop</span>
                            <span class="price">€10-40</span>
                        </div>
                        <div class="pricing-item">
                            <span class="service-name">Sistema Enterprise</span>
                            <span class="price">€30-100</span>
                        </div>
                    </div>
                </div>

                <div class="pricing-card">
                    <div class="pricing-header">
                        <i class="fas fa-cogs"></i>
                        <h3>Altri Servizi</h3>
                    </div>
                    <div class="pricing-content">
                        <div class="pricing-item">
                            <span class="service-name">Video Editing</span>
                            <span class="price">€3+/video</span>
                        </div>
                        <div class="pricing-item">
                            <span class="service-name">Setup Domini</span>
                            <span class="price">€2+</span>
                        </div>
                        <div class="pricing-item">
                            <span class="service-name">Script Personalizzati</span>
                            <span class="price">€10+</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="pricing-note">
                <i class="fas fa-info-circle"></i>
                <p>I prezzi possono variare in base alla complessità del progetto. Contattami per un preventivo personalizzato gratuito!</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Contatti</span>
                <h2>Iniziamo a Collaborare</h2>
                <p>Hai un progetto in mente? Parliamone insieme!</p>
            </div>
            
            <div class="contact-content">
                <div class="contact-info">
                    <h3>Scrivimi Ora</h3>
                    <p>Rispondo sempre entro 24 ore e offro consulenze gratuite per ogni progetto.</p>
                    
                    <div class="contact-methods">
                        <a href="https://mail.google.com/mail/u/0/?fs=1&to=crystianyyt@gmail.com&su=Proposta%20di%20lavoro%20/%20collaborazione&tf=cm" 
                           class="contact-method" target="_blank">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Email</h4>
                                <p>crystianyyt@gmail.com</p>
                            </div>
                        </a>

                        <a href="https://api.whatsapp.com/send/?phone=3896188446&text=Buongiorno%2C%20sarei%20interessato%20ad%20un%20eventuale%20collaborazione." 
                           class="contact-method" target="_blank">
                            <div class="contact-icon">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div class="contact-details">
                                <h4>WhatsApp</h4>
                                <p>+39 389 618 8446</p>
                            </div>
                        </a>

                        <a href="https://t.me/CrystianYYT" class="contact-method" target="_blank">
                            <div class="contact-icon">
                                <i class="fab fa-telegram"></i>
                            </div>
                            <div class="contact-details">
                                <h4>Telegram</h4>
                                <p>@CrystianYYT</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="social-links">
                    <h3>Seguimi Sui Social</h3>
                    <div class="social-grid">
                        <a href="https://github.com/CrystianYYT" target="_blank" class="social-link">
                            <i class="fab fa-github"></i>
                            <span>GitHub</span>
                        </a>
                        <a href="https://discord.com/channels/@me/1089974561648414770" target="_blank" class="social-link">
                            <i class="fab fa-discord"></i>
                            <span>Discord</span>
                        </a>
                        <a href="https://paypal.me/CrystaianYYT?country.x=IT&locale.x=it_IT" target="_blank" class="social-link">
                            <i class="fab fa-paypal"></i>
                            <span>PayPal</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Support Section -->
            <div class="support-section">
                <div class="support-card">
                    <i class="fas fa-heart"></i>
                    <h3>Supporta il Mio Lavoro</h3>
                    <p>Se apprezzi il mio lavoro, considera di supportarmi. Ogni contributo mi aiuta a migliorare i miei servizi!</p>
                    <a href="https://www.paypal.com/paypalme/CrystaianYYT" target="_blank" class="btn btn-support">
                        <i class="fas fa-donate"></i>
                        Supportami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="./src/images/profile.jpeg" alt="CrystianYYT">
                        <span>CrystianYYT</span>
                    </div>
                    <p>Sviluppatore Web Professionale specializzato in soluzioni digitali innovative e family-friendly.</p>
                </div>
                
                <div class="footer-section">
                    <h4>Servizi</h4>
                    <ul>
                        <li><a href="#services">Sviluppo Web</a></li>
                        <li><a href="#services">Bot Discord</a></li>
                        <li><a href="#services">Applicazioni Java</a></li>
                        <li><a href="#services">Video Editing</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Link Utili</h4>
                    <ul>
                        <li><a href="#about">Chi Sono</a></li>
                        <li><a href="#portfolio">Portfolio</a></li>
                        <li><a href="#pricing">Prezzi</a></li>
                        <li><a href="#reviews">Recensioni</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Contatti</h4>
                    <ul>
                        <li><a href="mailto:crystianyyt@gmail.com">crystianyyt@gmail.com</a></li>
                        <li><a href="https://t.me/CrystianYYT">@CrystianYYT</a></li>
                        <li><a href="https://github.com/CrystianYYT">GitHub</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 - 2025 CrystianYYT. Tutti i diritti riservati.</p>
                <div class="footer-links">
                    <a href="#privacy">Privacy Policy</a>
                    <a href="#terms">Termini di Servizio</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="./src/js/main.js"></script>
</body>
</html>