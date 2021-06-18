<?php if($this->session->flashdata("erro_login")): ?>
    <div class="alert alert-danger mt-3" role="alert">
        <?= $this->session->flashdata("erro_login") ?>
    </div>
<?php endif; ?>

<div class="row justify-content-center">
  <div class="col-md-5 col-sm-12">      
      <fieldset class="mt-5 mb-4 shadow-lg p-3 mb-5 rounded">
        <legend><strong>Controle de acesso</strong></legend>
        <form method="post" action="<?= site_url("login/entrar") ?>" class="form">
          <div class="mb-3">
            <label for="user-email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="user-email" placeholder="name@example.com">
          </div>

          <div class="mb-3">
            <label for="user-senha" class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control" id="user-senha" placeholder="senha">
          </div>

          <div class="mb-3 d-flex justify-content-end">
            <button  class="btn btn-success" type="submit">Entrar</button>
          </div>
      </form>
      </fieldset>
  </div>
</div>