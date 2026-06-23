<?php require_once __DIR__ . '/../Partials/head.php'; ?>
<?php require_once __DIR__ . '/../Partials/header.php'; ?>

<main id="app-container" class="ride-details-main">
    
    <?php if (isset($ride) && $ride !== null): ?>
        
        <div class="ride-cover">
            <a href="javascript:history.back()" class="btn-back-overlay">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
            <img src="https://picsum.photos/600/300?random=<?= $ride->getId() ?>" alt="Couverture de la balade" class="cover-img">
        </div>

        <div class="tabs-container">
            <div class="tabs-header">
                <button class="tab-btn active" data-tab="tab-avenir">Informations</button>
                <button class="tab-btn" data-tab="tab-passees">Chat</button>
            </div>

            <div class="tabs-content">
                <div id="tab-avenir" class="tab-panel active">
                    <section class="rides-wrapper">
                        <div>
                            <div class="ride-content">
                    
                                <div class="ride-header-top">
                                    <h1><?= htmlspecialchars($ride->getTitle()) ?></h1>
                                    <?php 
                                        $level = $ride->getDifficulty_level();
                                        $badgeClass = $level == 1 ? "badge-easy" : ($level == 2 ? "badge-medium" : "badge-hard");
                                        $badgeText = $level == 1 ? "Facile" : ($level == 2 ? "Moyen" : "Difficile");
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= $badgeText ?></span>
                                </div>
                                
                                <p class="author"><?= htmlspecialchars($ride->getOrganizer_pseudo()) ?></p>

                                    <div class="info-row">
                                        <i class="fa-regular fa-calendar"></i>
                                        <span><?= htmlspecialchars($ride->getStart_date()) ?> à <?= htmlspecialchars($ride->getStart_hour()) ?></span>
                                    </div>
                                    
                                    <div class="info-row">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <span>De <?= htmlspecialchars($ride->getStart_location()) ?> à <?= htmlspecialchars($ride->getEnd_location()) ?></span>
                                    </div>
                                
                                <div class="ride-quick-infos">
                                    <div class="ride-description">
                                        <h3>Description</h3>
                                        <p><?= nl2br(htmlspecialchars($ride->getDescription())) ?></p>
                                    </div>
                                </div>

                                <div class="ride-participants-list">
                                    <h3>Participants inscrits (<?= count($participations) ?>)</h3>
                                    
                                    <?php if (!empty($participations)): ?>
                                        <ul class="participants-list">
                                            <?php foreach ($participations as $participation): ?>
                                                
                                                    <a href="index.php?route=user_profile&id=<?= $participation->getUser_id() ?>">
                                                        <li>
                                                            <img class="participant-avatar" src="<?= htmlspecialchars($participation->getUser_avatar() ?? 'assets/img/default-avatar.jpg') ?>" alt="Avatar de <?= htmlspecialchars($participation->getUser_pseudo() ?? '') ?>">
                                                            <span class="participant-name"><?= htmlspecialchars($participation->getUser_pseudo() ?? '') ?></span>
                                                        </li>
                                                    </a> 
                                                
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <p class="no-participants">Aucun participant pour le moment. Sois le premier à rejoindre la balade !</p>
                                    <?php endif; ?>
                                </div>

                                <?php 
                                $maxParticipants = $ride->getMax_participants();
                                $participants = count($participations);
                                ?>

                                <?php if (isset($_SESSION['id']) && $_SESSION['id'] != $ride->getOrganizer_id()): ?>
                                    <?php if ($participating): ?>
                                        <a class="btn-leave" href="index.php?route=unjoin_ride&id=<?= $ride->getId() ?>">Se désinscrire</a>
                                    <?php elseif ($participants < $maxParticipants): ?>
                                        <a class="btn-join" href="index.php?route=join_ride&id=<?= $ride->getId() ?>">Participer</a>
                                    <?php else: ?>
                                        <span class="info-complete">Complet</span>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </div>

                        <?php else: ?>
                            <div class="ride-content">
                                <div class="error-message">
                                    <h2>Oups !</h2>
                                    <p>Cette balade n'existe pas ou a été supprimée.</p>
                                    <a href="index.php?route=home" class="btn">Retour à l'accueil</a>
                                </div>
                            </div>
                        <?php endif; ?>
                        </div>
                    </section>
                </div>
                <div id="tab-passees" class="tab-panel">
                    <section class="rides-wrapper">
                        <div>
                            <div class="ride-chat-section">
                                <h3>Discussion de la balade</h3>
                                
                                <div id="chat-messages" class="chat-messages-container">
                                    <?php 
                                    $chatManager = new ChatManager();
                                    $messages = $chatManager->getMessagesByRide($ride->getId());
                                    foreach ($messages as $msg): 
                                    ?>
                                        <div class="chat-message">
                                            <img src="<?= htmlspecialchars($msg['avatar'] ?? 'assets/img/default-avatar.jpg') ?>" class="chat-avatar" alt="Avatar">
                                            <div class="message-content">
                                                <span class="message-author"><?= htmlspecialchars($msg['pseudo']) ?></span>
                                                <p class="message-text"><?= nl2br(htmlspecialchars($msg['content'])) ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <?php if (isset($_SESSION['id'])): ?>
                                    <form id="chat-form" class="chat-form">
                                        <input type="hidden" id="chat-ride-id" value="<?= $ride->getId() ?>">
                                        <input type="hidden" id="chat-user-id" value="<?= $_SESSION['id'] ?>">
                                        <input type="hidden" id="chat-user-pseudo" value="<?= htmlspecialchars($_SESSION['pseudo'] ?? 'Anonyme') ?>">
                                        <input type="hidden" id="chat-user-avatar" value="<?= htmlspecialchars($_SESSION['avatar'] ?? 'assets/img/default-avatar.jpg') ?>">
                                        
                                        <input type="text" id="chat-input" placeholder="Écrivez un message ici..." required autocomplete="off">
                                        <button type="submit" class="btn-send-chat"><i class="fa-solid fa-paper-plane"></i></button>
                                    </form>
                                <?php else: ?>
                                    <p class="chat-login-prompt">Vous devez être <a href="index.php?route=login">connecté</a> pour participer à la discussion.</p>
                                <?php endif; ?>
                            </div>

                            <script src="assets/js/chat.js" defer></script>
                        </div>
                    </section>
                </div>
            </div>
        </div>

    

</main>

<link rel="stylesheet" href="assets/css/ride.css">  




