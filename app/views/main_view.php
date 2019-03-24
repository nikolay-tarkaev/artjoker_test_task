<?php
    if(!empty($data['users'])){
        ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ФИО</th>
                <th scope="col">Email</th>
                <th scope="col">Адрес</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($data['users'] as $user){
                ?>
                <tr>
                    <th scope="row"><?= $user['id']; ?></th>
                    <td><?= $user['name']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td><?= $user['territory']; ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
    } else{
        ?>
        <div class="text-center" style="margin-top: 50px;">
            - Пользователей не найдено - <br />
            - Нажмите кнопку "Добавить" что бы зарегистрировать нового пользователя -
        </div>
        <?php
    }
?>
