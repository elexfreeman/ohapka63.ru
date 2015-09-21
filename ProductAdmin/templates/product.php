<h1>Букет</h1>

<div class="container">
    <form>
        <div class="form-group">
            <label for="sezon">Сезон</label>
            <select class="form-control" id="sezon">
                <option value="1">Лето</option>
                <option value="2">Зима</option>
                <option value="3">Осень</option>
            </select>
        </div>

        <div class="form-group">
            <label for="title">Название</label>
            <input type="text" class="form-control" id="title" placeholder="Название">
        </div>

        <div class="form-group">
            <label for="description_short">Краткое описание</label>
            <input type="text" class="form-control" id="description_short" placeholder="">
        </div>


        <div class="form-group">
            <label for="description_full">Полное описание</label>
            <input type="text" class="form-control" id="description_full" placeholder="">
        </div>

        <div class="form-group">
            <label for="p_type">Тип</label>
            <select class="form-control" id="p_type">
                <option value="1">Ти 1</option>
                <option value="2">Тип 2</option>
                <option value="3">Тип 3</option>
            </select>
        </div>

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
                        <input type="text" class="form-control" id="art1" placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="notes1">Примечания</label>
                        <input type="text" class="form-control" id="notes1" placeholder="">
                    </div>

                    <div class="form-group">
                        <label>
                            <input id="hit_flag1" name="hit_flag1" type="checkbox"> флаг "Хит"
                        </label>
                    </div>

                    <table class="table">
                        <tr>

                            <th>Название</th>
                            <th>цвет</th>
                            <th>количество, штук</th>
                            <th>
                                <button type="button" class="btn btn-primary">Добавить</button>
                            </th>
                        </tr>
                        <tr>
                            <td>Роза</td>
                            <td>Красный</td>
                            <td>3</td>
                            <td><button flower_id="1" type="button" class="btn btn-danger">Удалить</button></td>
                        </tr>
                        <tr>

                            <td>Хризантема</td>
                            <td>Желтый</td>
                            <td>2</td>
                            <td><button flower_id="2" type="button" class="btn btn-danger">Удалить</button></td>
                        </tr>
                    </table>

                </div>
                <div role="tabpanel" class="tab-pane" id="profile">

                    <div class="form-group">
                        <label for="art2">Артикул</label>
                        <input type="text" class="form-control" id="art2" placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="notes2">примечания</label>
                        <input type="text" class="form-control" id="notes2" placeholder="">
                    </div>

                    <div class="form-group">
                        <label>
                            <input id="hit_fla21" name="hit_flag2" type="checkbox"> флаг "Хит"
                        </label>
                    </div>

                    <table class="table">
                        <tr>

                            <th>Название</th>
                            <th>цвет</th>
                            <th>количество, штук</th>
                            <th>
                                <button type="button" class="btn btn-primary">Добавить</button>
                            </th>
                        </tr>
                        <tr>
                            <td>Гвоздика</td>
                            <td>Красный</td>
                            <td>3</td>
                            <td><button flower_id="1" type="button" class="btn btn-danger">Удалить</button></td>
                        </tr>
                        <tr>

                            <td>Хризантема</td>
                            <td>Желтый</td>
                            <td>2</td>
                            <td><button flower_id="2" type="button" class="btn btn-danger">Удалить</button></td>
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

                    <table class="table">
                        <tr>

                            <th>Название</th>
                            <th>цвет</th>
                            <th>количество, штук</th>
                            <th>
                                <button type="button" class="btn btn-primary">Добавить</button>
                            </th>
                        </tr>
                        <tr>
                            <td>Тюльпан</td>
                            <td>Красный</td>
                            <td>3</td>
                            <td><button flower_id="1" type="button" class="btn btn-danger">Удалить</button></td>
                        </tr>
                        <tr>

                            <td>Хризантема</td>
                            <td>Желтый</td>
                            <td>2</td>
                            <td><button flower_id="2" type="button" class="btn btn-danger">Удалить</button></td>
                        </tr>
                    </table>

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
