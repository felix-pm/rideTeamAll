<section id="section-register">
  <div class="auth-container">
    <h1>Inscription</h1>

    <?php if (!empty($errors)): ?>
    <div class="alert-error">
      <?php foreach($errors as $error): ?>
      <p><?= $error ?></p>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <form method="post" action="">
      <label for="firstname">Pseudo</label>
      <input type="text" name="pseudo" id="firstname" required />

      <label for="email">Email</label>
      <input type="email" name="email" id="email" required />

      <label for="password">Mot de passe</label>
      <input type="password" name="password" id="password" required />

      <label for="confirmPassword">Confirmez le mot de passe</label>
      <input
        type="password"
        name="confirmPassword"
        id="confirmPassword"
        required
      />

      <button type="submit" style="width: 100%; margin-top: 20px">
        S'inscrire
      </button>
    </form>

    <a href="?route=login" class="auth-links">Déjà un compte ? Se connecter</a>
  </div>
</section>
