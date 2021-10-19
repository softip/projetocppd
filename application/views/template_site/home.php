<!doctype html>
<html lang="en">
  <head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="<?= base_url() ?>recursos/css/governo.css" rel="stylesheet" >
    <link href="<?= base_url() ?>recursos/css/main.css" rel="stylesheet" >

    <title>CPPD</title>
  </head>
  <body>
    
    <!-- Barra Brasil -->
    <div id="barra-brasil" style="background:#7F7F7F; height: 20px; padding:0 0 0 10px;display:block;"> 
            <ul id="menu-barra-temp" style="list-style:none;">
                <li style="display:inline; float:left;padding-right:10px; margin-right:10px; border-right:1px solid #EDEDED"><a href="http://brasil.gov.br" style="font-family:sans,sans-serif; text-decoration:none; color:white;">Portal do Governo Brasileiro</a></li> 
                <li><a style="font-family:sans,sans-serif; text-decoration:none; color:white;" href="http://epwg.governoeletronico.gov.br/barra/atualize.html">Atualize sua Barra de Governo</a></li>
            </ul>
        </div>

        <header class="governo">
            <div class="container">
                <div class="row">
                        
                    <div id="logo" class="col-lg-9 small">
                        <a href="<?= site_url()?>" title="Campus Inconfidentes">
                            <span class="portal-title-1"> INSTITUTO FEDERAL DO SUL DE MINAS GERAIS</span>
                            <h1 class="portal-title corto">CPPD</h1>
                            <span class="portal-description">Ministério da Educação</span>
                        </a>
                    </div>

                    <div class="col-lg-3 mt-3">                    
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="/index.php" method="post">                                                                            
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="search" class="form-control" placeholder="Pesquisar no Portal" aria-label="Pesquisar no Portal" aria-describedby="basic-addon2">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-default border-left-0" >
                                                    <span class="fa fa-search"></span>
                                                </button>
                                            </span>
                                        </div>
                                    </div>                                                                                           
                                </form>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="list-inline pull-right">
                                    <li class="list-inline-item">
                                        <a href="https://www.facebook.com/institutofederalcampusinconfidentes/" title="Facebook" target="_blank" rel="noopener noreferrer" class="sem-decoration">
                                            <i class="fa fa-facebook-square fa-2x"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="https://www.instagram.com/ifsuldeminasinconfidentes/" title="Instagram" target="_blank" rel="noopener noreferrer" class="sem-decoration">
                                            <i class="fa fa-instagram fa-2x"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="https://twitter.com/IFInconfidentes" title="Twitter" target="_blank" rel="noopener noreferrer" class="sem-decoration">
                                            <i class="fa fa-twitter-square fa-2x"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="https://www.youtube.com/channel/UCpgeZdVGTOMm7NyV9MvFALw" target="_blank" rel="noopener noreferrer" class="sem-decoration">
                                            <i class="fa fa-youtube-square fa-2x"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </header>
     
        <!-- Menu Horizontal -->
        <div class="bg-verde-menu">
        <nav class="navbar navbar-expand-lg navbar-dark ">
        <div class="container">
            <a class="navbar-brand d-block d-lg-none" href="#">Menu</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= site_url("home") ?>">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url("home/documentos") ?>">Documentos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url("home/tabelas") ?>">Tabelas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url("home/progressao") ?>">Progressão e Aceleração</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url("home/afastamento") ?>">Afastamento para capacitação</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url("home/rsc") ?>">RSC</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url("home/normativa") ?>">Normativa Docente</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url("home/login") ?>">Login</a>
                </li>
                
            </ul>
            </div>
        </div>
        </nav>
        </div>
            

        <!-- Conteúdo da Página -->
        <div class="container">
            <?= $contents ?>        
        </div>

        <!-- Rodapé -->
        <footer class="bg-footer">               
            <div class="container ">           
                <a href="http://portal.ifs.ifsuldeminas.edu.br">IFSULDEMINAS - Campus Inconfidentes</a> <br />
                Praça Tiradentes, 416 - Centro - Inconfidentes - MG - CEP 37576-000 - Fone: (35) 3464-1200 <br />
                © 2021. Todos os direitos reservados<br />
                SISTEMA DE GERENCIAMENTO PARA CPPD - IFSULDEMINAS<br />
            </div>                
        </footer>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!-- Barra do Governo -->
    <script defer="defer" src="//barra.brasil.gov.br/barra.js" type="text/javascript"></script> 

  </body>
</html>