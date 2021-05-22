<div>
  <div>
    <form action="/user/signin" method="post">
      <h3>Пожалуйста, авторизируйтесь</h3>
      <? if ($failure): ?>
        <div class="alert alert-danger">Неверный логин или пароль.</div>
      <? endif ?>
      <div>
        <input name="login" placeholder="Логин" required autofocus>
      </div>
      <div class="form-group">
        <input type="password" name="password" placeholder="Пароль" required>
      </div>
      <button type="submit">Войти</button>
    </form>
  </div>
</div>
