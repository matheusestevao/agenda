        <?php
            if (isset($_GET['view']) && $_GET['view']*1 > 0) {

                require_once "function/connect.php";
                require_once "class/ClassCrud.php";

                $people = new CrudDb();
                $dataPeople = $people->selectRegistry($pdo,$_GET['view'],'people');

                $infoPhone = $people->selectPhone($pdo,$_GET['view']);

                if (!$dataPeople) {

                    $_SESSION['alert'] = "O resgistro que você está tentando vizualizar não foi encontrado no sistema.";
                    header("Location:".BASEURL);
                
                }

            } else {

                header("Location:".BASEURL);

            } 
        ?>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Visualizar Contato</h1>                    
                </div>
            </div>

            <div class="row">
                <form class="form-contact" action="function/send_form.php" method="POST" id="form-contact">
                    <input type="hidden" name="idPeople" value="<?=isset($dataPeople) ? $dataPeople->id_people : '' ?>">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>Nome:</label>
                            <span><?=$dataPeople->name?></span>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>E-mail:</label>
                            <span><?=$dataPeople->email?></span>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>CEP:</label>
                            <span><?=$dataPeople->zip?></span>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>Endereço:</label>
                            <span><?=$dataPeople->address?></span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Número:</label>
                            <span><?=$dataPeople->num?></span>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Complemento:</label>
                            <span><?=$dataPeople->complement?></span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Bairro:</label>
                            <span><?=$dataPeople->neighborhood?></span>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Cidade:</label>
                            <span><?=$dataPeople->county?></span>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Estado:</label>
                            <span><?=$dataPeople->state?></span>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <table class="table table-striped table-bordered" id="boxView">
                                <thead>    
                                    <tr>
                                        <th>Tipo Contato</th>
                                        <th>Número Contato</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(isset($infoPhone)) : foreach ($infoPhone as $infoPhone):?>
                                        <tr>
                                            <td>
                                                <span><?=ucfirst($infoPhone->type_phone)?></span>
                                            </td>
                                            <td>
                                                <span><?=$infoPhone->phone?></span>
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                    <?php
                                    endforeach; endif;?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                
                    <div class="col-lg-6 col-xs-6">
                        <a href="<?=BASEURL?>" name="back" class="btn btn-warning"><i class="fa fa-chevron-left fa-fw"></i> Voltar</a>
                    </div>
                    <div class="clearfix"></div>

                </form>
            </div>
        </div>