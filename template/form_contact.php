        <?php
            if (isset($_GET['edit']) && $_GET['edit']*1 > 0) {

                require_once "function/connect.php";
                require_once "class/ClassCrud.php";

                $people = new CrudDb();
                $dataPeople = $people->selectRegistry($pdo,$_GET['edit'],'people');

                $infoPhone = $people->selectPhone($pdo,$_GET['edit']);

                if (!$dataPeople) {

                    $_SESSION['alert'] = "O resgistro que você está tentando editar não foi encontrado no sistema.";
                    header("Location:".BASEURL);
                
                }

                $title = "Editar Contato";

            } else {

                $title = "Novo Contato";

            }
        ?>
        <script>
            var idenRegistro = 0;
            function insertPhone()
            {
                var clone = $("#boxModel tbody").html();
                clone= clone.replace(/\[X\]/g, "["+idenRegistro+"]");
                clone= clone.replace(/__X/g, "__"+idenRegistro);

                $("#boxView tbody").append(clone);
                
                idenRegistro++;
            };

            function removePhone(o)
            {
                $(o.parentNode.parentNode).remove();
            };
        </script>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?=$title?></h1>                    
                </div>
            </div>

            <div class="row">
                <form class="form-contact" action="function/send_form.php" method="POST" id="form-contact">
                    <input type="hidden" name="idPeople" value="<?=isset($dataPeople) ? $dataPeople->id_people : '' ?>">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>Nome:</label>
                            <input type="text" class="form-control" name="name" value="<?=isset($dataPeople) ? $dataPeople->name : ''?>"/>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>E-mail:</label>
                            <input type="email" class="form-control" name="email" value="<?=isset($dataPeople) ? $dataPeople->email : ''?>" />
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>CEP:</label>
                            <input type="text" class="form-control" name="zip" value="<?=isset($dataPeople) ? $dataPeople->zip : ''?>" />
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>Endereço:</label>
                            <input type="text" class="form-control" name="address" value="<?=isset($dataPeople) ? $dataPeople->address : ''?>" />
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Número:</label>
                            <input type="text" class="form-control" name="number" value="<?=isset($dataPeople) ? $dataPeople->num : ''?>" />
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Complemento:</label>
                            <input type="text" class="form-control" name="complement" value="<?=isset($dataPeople) ? $dataPeople->complement : ''?>" />
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Bairro:</label>
                            <input type="text" class="form-control" name="neighborhood" value="<?=isset($dataPeople) ? $dataPeople->neighborhood : ''?>" />
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Cidade:</label>
                            <input type="text" class="form-control" name="county" value="<?=isset($dataPeople) ? $dataPeople->county : ''?>"/>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Estado:</label>
                            <input type="text" class="form-control" name="state" value="<?=isset($dataPeople) ? $dataPeople->state : '' ?>"/>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <a class="btn btn-success btn-phone" onclick="insertPhone()">Inserir Telefone</a>
                            <table class="table table-striped table-bordered" id="boxModel" style="display: none">
                                <thead>    
                                    <tr>
                                        <th>Tipo Contato</th>
                                        <th>Número Contato</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <input type="hidden" name="insertPhonePeople_idComponent[X]" value="<??>">
                                        <td>
                                            <select name="insertPhonePeople_typePhone[X]" class="form-control">
                                                <option value='casa'>Casa</option>
                                                <option value='celular'>Celular</option>
                                                <option value='recado'>Recado</option>
                                                <option value='servico'>Serviço</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="tel" name="insertPhonePeople_numberPhone[X]" placeholder="(99) 9999-9999" class="form-control phone_number">
                                        </td>
                                        <td>
                                            <a class="btn btn-danger btn-remove" onclick="removePhone(this)">(x) Remover</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-striped table-bordered" id="boxView">
                                <thead>    
                                    <tr>
                                        <th>Tipo Contato</th>
                                        <th>Número Contato</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 0;
                                    if(isset($infoPhone)) : foreach ($infoPhone as $infoPhone):?>
                                        <tr>
                                            <input type="hidden" name="insertPhonePeople_idComponent[<?=$count?>]" value="<?=$infoPhone->id_phone?>">
                                            <td>
                                                <select name="insertPhonePeople_typePhone[<?=$count?>]" class="form-control">
                                                    <option value='casa' <?=($infoPhone->type_phone == 'casa') ? 'selected' : ''?> >Casa</option>
                                                    <option value='celular' <?=($infoPhone->type_phone == 'celular') ? 'selected' : ''?>>Celular</option>
                                                    <option value='recado' <?=($infoPhone->type_phone == 'recado') ? 'selected' : ''?> >Recado</option>
                                                    <option value='servico' <?=$infoPhone->type_phone == 'servico' ? 'selected' : ''?>>Serviço</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="tel" name="insertPhonePeople_numberPhone[<?=$count?>]" placeholder="(99) 9999-9999" class="form-control phone_number" value="<?=$infoPhone->phone?>">
                                            </td>
                                            <td>
                                                <a class="btn btn-danger btn-remove" onclick="removePhone(this)">(x) Remover</a>
                                            </td>
                                        </tr>
                                    <?php
                                    $count++;
                                    endforeach; endif;?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                
                    <div class="col-lg-6 col-xs-6">
                        <a href="<?=BASEURL?>" name="back" class="btn btn-warning"><i class="fa fa-chevron-left fa-fw"></i> Voltar</a>
                    </div>

                    <div class="col-lg-6 text-right col-xs-6">
                        <button type="submit" name="send-contact" value="0" class="btn btn-success"><i class="fa fa-save fa-fw"></i> Cadastrar</button>
                    </div>

                    <div class="clearfix"></div>

                </form>
            </div>
        </div>

        <!--MODAL VALIDATE EMAIL -->
        <div class="modal fade validateEmail" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i style="color: red" class="fa fa-exclamation-circle fa-2x" aria-hidden="true"></i> E-mail já existente!</h4>
                    </div>
                    <div class="modal-body">
                        Este e-mail já está cadastrado em nosso sistema.<br />
                        <a id="linkEdit">Clique Aqui</a> para poder <u>editar</u> o cadastro do e-mail informado.<br />
                        Ou clique em <i>Fechar</i> para continuar o cadastro com outro e-mail.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <script>
            $(document).ready(function(){
                $("input[name=zip]").mask("99999-999");
                $(function(){
                    var phone, element;  
                    
                    element = $('.phone_number');  
                    element.unmask();  
                    phone = element.val().replace(/\D/g, '');

                    if(phone.length > 10) {  
                        element.mask("(99) 99999-9999");  
                    } else {  
                        element.mask("(99) 9999-99999");  
                    }
                }).trigger('focusout');


                $("#form-contact").validate({
                    //DEFINING THE FORM VALIDATION RULES
                    rules:{
                        name:{required: true, minlength: 2},
                        email:{required:true, email: true},
                        address:{required: true}
                    }
                });

                $("input[name=email]").blur(function(){
                    var email = $(this).val();
                    
                    $.ajax({
                        url:"function/validate.php",
                        type:"POST",
                        data: "email=" + email,
                        dataType: "json",
                        success: function(a){
                            if (a.validate == 1) {

                                $("#linkEdit").attr("href","?edit="+a.idPeople);  
                                $(".validateEmail").modal("show");
                            } else {
                                $("input[name=zip]").focus();
                            }
                        }
                    });
                });

                $("input[name=zip]").blur(function(){
                    var zip = $(this).val();

                    $.ajax({
                        url: "function/validate.php",
                        type: "POST",
                        data: "zip=" + zip,
                        dataType: 'json',
                        success: function(b){
                            if (b.success == 1) {

                                $("input[name=address]").val(b.address);
                                $("input[name=neighborhood]").val(b.neighborhood);
                                $("input[name=county]").val(b.county);
                                $("input[name=state]").val(b.state);
                                
                                $("input[name=number]").focus();
                            
                            } else {
                            
                                $("input[name=address]").focus();
                            
                            }
                        }
                    });
                });
            });
        </script>