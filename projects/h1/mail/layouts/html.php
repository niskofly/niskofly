<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

    <meta name="viewport" content="width=3Ddevice-width, initial-scale=1, maximum-scale=1">

    <title>Student Payment</title>

    <style type="text/css">

        body {

          margin: 0;

          padding: 0;

          -ms-text-size-adjust: 100%;

          -webkit-text-size-adjust: 100%;

        }



        table {

          border-spacing: 0;

        }



        table td {

          border-collapse: collapse;

        }



        @media screen and (max-width: 559px) {

            .force-row, .container{

                width: 100% !important;

                max-width: 100% !important;

            }

            table[class="force-row"], table[class="container"]{

                width: 100% !important;

                max-width: 100% !important;  =20

            }

        }

        @media screen and (max-device-width: 414px) and (max-device-height:=
 776px) {

            .force-row, .container{

                width: 100% !important;

                max-width: 100% !important;

            }

            table[class="force-row"], table[class="container"]{

                width: 100% !important;

                max-width: 100% !important;  =20

            }

        }

    </style>

</head>
<body bgcolor="#F2F2F2" style="margin:0">
    <?php $this->beginBody() ?>
    <?= $content ?>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>