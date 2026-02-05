<section id="section-login">
  <div class="auth-container">
    <h2>Connexion</h2>

    <?php if (!empty($errors)): ?>
    <div class="alert-error">
      <?php foreach($errors as $error): ?>
      <p><?= $error ?></p>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <form method="post" action="index.php?route=login">
      <label for="email">Email</label>
      <input
        type="email"
        name="email"
        id="email"
        placeholder="votre@email.com"
        required
      />

      <label for="password">Mot de passe</label>
      <input
        type="password"
        name="password"
        id="password"
        placeholder="••••••••"
        required
      />

      <button type="submit">Se connecter</button>
    </form>

    <a href="?route=register" class="auth-links"
      >Pas encore de compte ? S'inscrire</a
    >
  </div>
</section>
