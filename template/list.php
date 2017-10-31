        <?php
            require_once "function/connect.php";
            require_once "class/ClassCrud.php";

            $people = new CrudDb();
            $listPeople = $people->selectList($pdo,'people');

        ?>

        <div class="container">
            <div class="row">
                <?php 
                if (isset($_SESSION['successInsert'])) {?>
                    <div class="alert alert-success alert-dismissable">
                        <strong>Contato Cadastrato com sucesso!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>                        
                    </div>
                <?
                    unset($_SESSION['successInsert']);
                } elseif (isset($_SESSION['successDel'])) {?>
                    <div class="alert alert-success alert-dismissable">
                        <strong>Contato Deletado com sucesso!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>                        
                    </div>
                <?
                    unset($_SESSION['successDel']);
                } elseif (isset($_SESSION['errorValidate'])) {?>
                    <div class="alert alert-danger alert-dismissable">
                        <strong>Não foi possível efetuar o cadastro! O e-mail informado, no cadastro, já consta em nosso sistema.</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>                        
                    </div>
               <?php
                    unset($_SESSION['errorValidate']);

                } elseif (isset($_SESSION['errorDb'])) {?>
                    <div class="alert alert-danger alert-dismissable">
                        <strong>Não foi possível efetuar o cadastro!<?=$_SESSION['errorDb']?></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</butto>  
                    </div>
                <?php
                    unset($_SESSION['errorDb']);
                } elseif (isset($_SESSION['successUp'])) {?>
                    <div class="alert alert-success alert-dismissable">
                        <strong>Informações atualizadas com sucesso!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</butto>  
                    </div>
            <?php
                    unset($_SESSION['successUp']);
                } elseif (isset($_SESSION['alert'])){?>
                    <div class="alert alert-warning alert-dismissable">
                        <strong><?=$_SESSION['alert']?></strong>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</butto>  
                    </div>
            <?php
                    unset($_SESSION['alert']);
                }?>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="?form" class="btn btn-success new-contact">Novo Contato</a>     
                </div>
                <br />
                <div class="col-12">
                    <table class="display table table-striped table-bordered table-hover table-responsive" id="tbl-contact" width="">
                        <thead>
                            <tr>
                                <th>Cód</th>   
                                <th>Nome</th>   
                                <th>E-mail</th>   
                                <th>Ações</th>
                            </tr>   
                        </thead>
                        <tbody>
                            <?php
                                foreach ($listPeople as $listPeople) {?>
                                    <tr>
                                        <td> <?=$listPeople->id_people?> </td>
                                        <td> <?=$listPeople->name?> </td>
                                        <td> <?=$listPeople->email?> </td>
                                        <td>
                                            <a href="?view=<?=$listPeople->id_people?>" class="btn btn-sm btn-primary" title="Visualizar"> 
                                                <i class="fa fa-eye fa-lg"></i>
                                            </a>
                                            <a href="?edit=<?=$listPeople->id_people?>" class="btn btn-sm btn-primary" title="Editar">
                                                <i class="fa fa-pencil fa-fw"></i>
                                            </a>
                                            <a href="?del=<?=$listPeople->id_people?>" class="btn btn-sm btn-danger" title="Excluir">
                                                <i class="fa fa-trash-o fa-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                               <?php
                                } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function(){
                $("#tbl-contact").DataTable({
                    "language": {
                        "url": "lib/datatable/DataTables-1.10.16/js/dataTables.Portuguese-Brasil.json"
                    }
                });
            });
        </script>