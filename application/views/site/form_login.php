<div class="pt-3">
    <?php if ($this->session->flashdata('erro')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="fas fa-ban"></i> Erro!<?= $this->session->flashdata('erro') ?>
        </div>
    <?php endif; ?>
 </div>

<div class="row justify-content-center">
  <div class="col-md-5 col-sm-12">      
      <fieldset class="mt-5 mb-4 shadow-lg p-3 mb-5 rounded">
        <legend><strong>Controle de acesso</strong></legend>
        <form method="post" action="<?= site_url("restrito/login/verificar") ?>" class="form">
          <div class="mb-3">
            <label for="user-email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="user-email" placeholder="name@example.com">
          </div>

          <div class="mb-3">
            <label for="user-senha" class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control" id="user-senha" placeholder="senha">
          </div>
            
            <div class="row row-cols-2">               
                <div class="col">
                    <button type="submit" class="btn btn-success w-100 p-0 pt-2 pb-2"> 
                        <i class="fas fa-lock"></i> &nbsp; 
                        Entrar
                    </button>
                </div>
                <div class="col">
                    <a href="<?= $authUrl ?>" class="btn btn-secondary w-100 p-0 pt-2 pb-2">
                        <i class="fab fa-google"></i> &nbsp;  
                         Entrar com Google
                    </a>
                </div>
            </div>
      </form>
      </fieldset>
  </div>
</div>