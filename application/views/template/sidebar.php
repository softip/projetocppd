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
      <?php $user = $this->session->userdata("user");?>
      <?php $fotoUser = ($user['foto'] == null) ? "sem_foto.jpg" : $user['foto'] ?>
      
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url($fotoUser); ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= isset($user["nome"])? $user["nome"] : "" ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">MENU</li>
          <?php echo $this->menus->create_menu(); ?>
          
          <li class="nav-header">GERAL</li>
          
         <li class="nav-item pt-1">
            <a href="<?= site_url('')?>" class="nav-link">
            <i class="nav-icon fa fa-globe"></i>
              <p>Acesso Público</p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="<?= site_url('restrito/login/logoff') ?>" class="nav-link">
            <i class="nav-icon fas fa-door-closed"></i>
              <p>Sair</p>
            </a>
          </li>
          
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>