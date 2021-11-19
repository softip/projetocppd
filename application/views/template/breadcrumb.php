<div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo isset($titulo) ? $titulo : "";  ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><?php echo isset($breadcrumb1) ? $breadcrumb1 : "";  ?></a></li>
              <li class="breadcrumb-item active"><?php echo isset($breadcrumb2) ? $breadcrumb2 : "";  ?></li>
            </ol>
          </div>
        </div>
</div><!-- /.container-fluid -->