  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="<?= base_url("recursos")?>/img/AdminLTELogo.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">CPPD</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url("recursos")?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-plus-circle"></i>
              <p>
                Cadastros
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             
              <!-- menu servidor -->
              <li class="nav-item">
                <a href="<?= site_url("restrito/servidor") ?>" class="nav-link">         
                  <i class="fas fa-user-cog nav-icon"></i>
                  <p>Servidor</p>
                </a>
              </li>

               <!-- menu Situação -->
               <li class="nav-item">
                <a href="<?= site_url("restrito/situacao") ?>" class="nav-link">
                  <i class="fas fa-chalkboard-teacher nav-icon"></i>
                  <p>Situação</p>
                </a>
              </li>

               <!-- menu Avaliação -->
               <li class="nav-item">
                <a href="<?= site_url("restrito/avaliacao") ?>" class="nav-link">
                  <i class="far fa-edit nav-icon"></i>
                  <p>Avaliação</p>
                </a>
              </li>

               <!-- menu Titulacao -->
               <li class="nav-item">
                <a href="<?= site_url("restrito/titulacao") ?>" class="nav-link">
                  <i class="fa fa-graduation-cap nav-icon"></i>
                  <p>Titulação</p>
                </a>
              </li>

               <!-- menu Carreira -->
               <li class="nav-item">
                <a href="<?= site_url("restrito/carreira") ?>" class="nav-link">
                  <i class="far fa-address-card nav-icon"></i>
                  <p>Carreira</p>
                </a>
              </li>
              <!-- menu Chefe Imediato -->
              <li class="nav-item">
                <a href="<?= site_url("restrito/chefe") ?>" class="nav-link">
                  <i class="fas fa-briefcase nav-icon"></i>
                  <p>Chefe Imediato</p>
                </a>
              </li>
              <!-- menu Nível -->
              <li class="nav-item">
                <a href="<?= site_url("restrito/nivel") ?>" class="nav-link">
                  <i class="fas fa-layer-group nav-icon"></i>
                  <p>Nível</p>
                </a>
              </li>
              <!-- menu Classe -->
              <li class="nav-item">
                <a href="<?= site_url("restrito/classe") ?>" class="nav-link">
                  <i class="fas fa-circle-notch nav-icon"></i>
                  <p>Classe</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="../widgets.html" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Widgets
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>