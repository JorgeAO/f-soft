<?php
use app\controllers\PermisoController;
use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use kartik\icons\Icon;

Icon::map($this);

AppAsset::register($this);

$arrMenu = PermisoController::construirMenu();

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100">
        <?php $this->beginBody() ?>
        <header>
            <?php
                if (isset($_SESSION['usuario_sesion']))
                {
                    NavBar::begin([
                        'brandLabel' => Yii::$app->name,
                        'brandUrl' => '#',
                        'options' => [
                            'class' => 'navbar navbar-expand-md bg-white fixed-top',
                        ],
                    ]);

                    echo Nav::widget([
                        'encodeLabels' => false,
                        'options' => ['class' => 'navbar-nav'],
                        'items' => $arrMenu,
                    ]);

                    NavBar::end();
                }
            ?>
        </header>
        <main role="main" class="flex-shrink-0">
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">
                        <i class="fa fa-lightbulb"></i> Ayudas
                    </h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <?= $this->render('ayudas', []) ?>
                </div>
            </div>
            <div class="container">
            <?php if (isset($_SESSION['usuario_sesion'])) { ?>
                <div class="mb-2">
                    <button class="btn btn-personalizado btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" title="Ayudas">
                        <i class="fa fa-lightbulb"></i>
                    </button>
                </div>
                <div class="contenedor-marquesina mb-2">
                    <h5 class="marquesina">
                        1 COP = 0,00024 USD | 0,001414 BRL | 0,00023 EUR
                    </h5>
                </div>
                <?php } ?>
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= $content ?>
            </div>
        </main>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage();?>