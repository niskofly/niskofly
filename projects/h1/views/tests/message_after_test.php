<table style="width: 50%" border="1">
    <tr>
        <td style="width: 30%">Имя</td>
        <td><?=$user->username?></td>
    </tr>
    <tr>
        <td>e-mail</td>
        <td><?=$user->email?></td>
    </tr>
    <tr>
        <td>телефон</td>
        <td><?=$user->phone?></td>
    </tr>
    <tr>
        <td>course</td>
        <td>English</td>
    </tr>
    <tr>
        <td>уровень</td>
        <td><?=$level?></td>
    </tr>
    <tr>
        <td>сообщение</td>
        <td>Assessment test was done on web-site</td>
    </tr>

    <!-- Begin roistat -->
    <tr>
        <td>Идентификатор ройстат</td>
        <td><?= $roistatID?></td>
    </tr>
    <!-- End roistat -->

</table>