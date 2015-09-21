<style>
    .flowers
    {
        display: none;
    }
</style>
<h1>Букет</h1>

<div class="container">
    <form method="post" enctype="multipart/form-data">
    <input type="hidden" name='uniq' value="<?php echo PassGen();?>">
    <input type="hidden" name='action' value="ProductSave">



        <div class="form-group">
            <label for="title">Название</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Название">
        </div>

        <div class="form-group">
            <label for="description_short">Краткое описание</label>
            <input type="text" class="form-control" id="description_short" name="description_short" placeholder="">
        </div>


        <div class="form-group">
            <label for="description_full">Полное описание</label>
            <input type="text" class="form-control" id="description_full" name="description_full" placeholder="">
        </div>

        <div class="form-group">
            <label for="p_type">Тип</label>
            <select class="form-control" id="p_type" name="p_type">
                <?php
                $sql="select * from s_types";
                $query = $modx->query($sql);
                while ($row = $query->fetch(PDO::FETCH_ASSOC))
                {
                    ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                    <?php
                }
                ?>
            </select>
        </div>

    <div class="form-group">
        <label for="seasons">Сезон</label>
        <select class="form-control" id="seasons" name="seasons">
            <?php
            $sql="select * from s_seazons";
            $query = $modx->query($sql);
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="gammas">Гаммы</label>
        <select class="form-control" id="gammas" name="gammas">
            <?php
            $sql="select * from s_gammas";
            $query = $modx->query($sql);
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Варианты букета</div>
        <div class="panel-body">
            <div role="tabpanel">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#home" aria-controls="home" role="tab" data-toggle="tab">Вариант 1</a></li>
                    <li role="presentation">
                        <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Вариант 2</a>
                    </li>
                    <li role="presentation">
                        <a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Вариант 3</a>
                    </li>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="form-group">
                            <label for="art1">Артикул</label>
                            <input type="text" class="form-control" id="art1" name="art1" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="notes1">Примечания</label>
                            <input type="text" class="form-control" id="notes1" name="notes1" placeholder="">
                        </div>

                        <div class="form-group">
                            <label>
                                <input id="hit_flag1" name="hit_flag1" type="checkbox"> флаг "Хит"
                            </label>
                        </div>

                        <script>
                            $(document).ready(function(){
                                var count1T=1;
                                $(".flower1add").click(function(){
                                    var AppStr="";
                                    AppStr=AppStr+'<tr id="TableRow_'+count1T+'"><td><select name="Fflower_v1_'+count1T+'" class="form-control">';
                                <?php
                                $sql="select * from s_flowers";
                                $query = $modx->query($sql);
                                while ($row = $query->fetch(PDO::FETCH_ASSOC))
                                {
                                    ?>
                                    AppStr=AppStr+'<option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>';
                                    <?php
                                }
                                ?>
                                    AppStr=AppStr+'</select></td><td><input value="0" type="text" name="flower_F_count_'+count1T+'"  class="form-control"></td>';
                                    AppStr=AppStr+'<td><button deleted="'+count1T+'"  type="button" class="OrdersListDeleteAdmin btn btn-danger"';
                                    AppStr=AppStr+"onclick='";
                                    AppStr=AppStr+'$("#TableRow_"+$(this).attr("deleted")).remove();';
                                    AppStr=AppStr+"'"	 ;
                                    AppStr=AppStr+'>Удалить</button></td>';

                                    AppStr=AppStr+'</tr>';
                                    $('.flower1grid').append(AppStr);
                                    count1T=count1T+1;

                                });

                                var countImg1T=1;
                                $(".flowerimg1add").click(function(){
                                    var AppStr="";
                                    AppStr=AppStr+'<tr id="TableRowI1_'+countImg1T+'"><td><input type="file" name="f_'+countImg1T+'"></td>';

                                    AppStr=AppStr+'<td><button deleted="'+countImg1T+'"  type="button" class="OrdersListDeleteAdmin btn btn-danger"';
                                    AppStr=AppStr+"onclick='";
                                    AppStr=AppStr+'$("#TableRowI1_"+$(this).attr("deleted")).remove();';
                                    AppStr=AppStr+"'"	 ;
                                    AppStr=AppStr+'>Удалить</button></td>';

                                    AppStr=AppStr+'</tr>';
                                    $('.flImg1').append(AppStr);
                                    countImg1T=countImg1T+1;

                                });

                            });
                        </script>


                        <div class="panel panel-primary ">
                            <div class="panel-heading">Изображения</div>
                            <div class="panel-body">
                                <table class="table flImg1 table-striped">
                                    <tr>
                                        <th>Изображение</th>
                                        <th><button type="button" class="btn btn-primary flowerimg1add">Добавить</button></th>
                                    </tr>
                                </table>
                            </div>
                        </div>



                        <table class="table flower1grid table-striped">
                            <tr>
                                <th>Название</th>
                                <th>количество, штук</th>
                                <th>
                                    <button type="button" class="btn btn-primary flower1add">Добавить</button>
                                </th>
                            </tr>
                        </table>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">

                        <div class="form-group">
                            <label for="art2">Артикул</label>
                            <input type="text" class="form-control" id="art2" name="art2" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="notes2">примечания</label>
                            <input type="text" class="form-control" id="notes2" name="notes2" placeholder="">
                        </div>

                        <div class="form-group">
                            <label>
                                <input id="hit_fla21" name="hit_flag2" type="checkbox"> флаг "Хит"
                            </label>
                        </div>

                        <script>
                            $(document).ready(function(){
                                var count2T=1;
                                $(".flower2add").click(function(){
                                    var AppStr="";
                                    AppStr=AppStr+'<tr id="TableRow2_'+count2T+'"><td><select name="Sflower_v2_'+count2T+'" class="form-control">';
                                <?php
                                $sql="select * from s_flowers";
                                $query = $modx->query($sql);
                                while ($row = $query->fetch(PDO::FETCH_ASSOC))
                                {
                                    ?>
                                    AppStr=AppStr+'<option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>';
                                    <?php
                                }
                                ?>
                                    AppStr=AppStr+'</select></td><td><input value="0"  type="text" name="flower_S_count_'+count2T+'"  class="form-control"></td>';
                                    AppStr=AppStr+'<td><button deleted="'+count2T+'"  type="button" class="OrdersListDeleteAdmin btn btn-danger"';
                                    AppStr=AppStr+"onclick='";
                                    AppStr=AppStr+'$("#TableRow2_"+$(this).attr("deleted")).remove();';
                                    AppStr=AppStr+"'"	 ;
                                    AppStr=AppStr+'>Удалить</button></td>';

                                    AppStr=AppStr+'</tr>';
                                    $('.flower2grid').append(AppStr);
                                    count2T=count2T+1;
                                });

                                var countImg2T=1;
                                $(".flowerimg2add").click(function(){
                                    var AppStr="";
                                    AppStr=AppStr+'<tr id="TableRowI2_'+countImg2T+'"><td><input type="file" name="f_'+countImg2T+'"></td>';

                                    AppStr=AppStr+'<td><button deleted="'+countImg2T+'"  type="button" class="OrdersListDeleteAdmin btn btn-danger"';
                                    AppStr=AppStr+"onclick='";
                                    AppStr=AppStr+'$("#TableRowI2_"+$(this).attr("deleted")).remove();';
                                    AppStr=AppStr+"'"	 ;
                                    AppStr=AppStr+'>Удалить</button></td>';

                                    AppStr=AppStr+'</tr>';
                                    $('.flImg2').append(AppStr);
                                    countImg2T=countImg2T+1;

                                });

                            });
                        </script>


                        <div class="panel panel-primary ">
                            <div class="panel-heading">Изображения</div>
                            <div class="panel-body">
                                <table class="table flImg2 table-striped">
                                    <tr>
                                        <th>Изображение</th>
                                        <th><button type="button" class="btn btn-primary flowerimg2add">Добавить</button></th>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <table class="table flower2grid table-striped">
                            <tr>
                                <th>Название</th>
                                <th>количество, штук</th>
                                <th>
                                    <button type="button" class="btn btn-primary flower2add">Добавить</button>
                                </th>
                            </tr>
                        </table>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="messages">
                        <div class="form-group">
                            <label for="art3">Артикул</label>
                            <input type="text" class="form-control" id="art3" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="notes3">примечания</label>
                            <input type="text" class="form-control" id="notes3" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>
                                <input id="hit_flag3" name="hit_flag3" type="checkbox"> флаг "Хит"
                            </label>
                        </div>


                        <script>
                            $(document).ready(function(){
                   

                                var countImg3T=1;
                                $(".flowerimg3add").click(function(){
                                    var AppStr="";
                                    AppStr=AppStr+'<tr id="TableRowI3_'+countImg3T+'"><td><input type="file" name="f_'+countImg3T+'"></td>';

                                    AppStr=AppStr+'<td><button deleted="'+countImg3T+'"  type="button" class="OrdersListDeleteAdmin btn btn-danger"';
                                    AppStr=AppStr+"onclick='";
                                    AppStr=AppStr+'$("#TableRowI3_"+$(this).attr("deleted")).remove();';
                                    AppStr=AppStr+"'"	 ;
                                    AppStr=AppStr+'>Удалить</button></td>';

                                    AppStr=AppStr+'</tr>';
                                    $('.flImg3').append(AppStr);
                                    countImg3T=countImg3T+1;

                                });
                            });
                        </script>

                        <div class="panel panel-primary ">
                            <div class="panel-heading">Изображения</div>
                            <div class="panel-body">
                                <table class="table flImg3 table-striped">
                                    <tr>
                                        <th>Изображение</th>
                                        <th><button type="button" class="btn btn-primary flowerimg3add">Добавить</button></th>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <table class="table flower3grid table-striped">
                            <tr>
                                <th>Название</th>
                                <th>количество, штук</th>
                                <th>
                                    <button type="button" class="btn btn-primary flower3add">Добавить</button>
                                </th>
                            </tr>
                        </table>



                    </div>

                </div>

            </div>
        </div>
    </div>




        <h4>Сопутствующие товары</h4>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>
                        <input id="sp1" name="sp1" type="checkbox"> Сопутствующий товар 1
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>
                        <input id="sp2" name="sp1" type="checkbox"> Сопутствующий товар 2
                    </label>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>
                        <input id="sp3" name="sp3" type="checkbox"> Сопутствующий товар 3
                    </label>
                </div>
            </div>

        </div>


        <button type="submit" class="btn btn-default">Submit</button>
    </form>

</div>
