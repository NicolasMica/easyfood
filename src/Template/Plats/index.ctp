<?php $this->assign('title', "Découvrez nos plats") ?>

<?php /*$this->Html->scriptStart(['block' => true]) */?><!--
    $('.carousel.carousel-slider').carousel({fullWidth: true});
--><?php /*$this->Html->scriptEnd() */?>

<div class="container">
    <!--    <div class="row">
            <div class="col s12">
                <div class="carousel carousel-slider">
                    <a class="carousel-item" href="#one!"><img src="http://lorempixel.com/800/400/food/1"></a>
                    <a class="carousel-item" href="#two!"><img src="http://lorempixel.com/800/400/food/2"></a>
                    <a class="carousel-item" href="#three!"><img src="http://lorempixel.com/800/400/food/3"></a>
                    <a class="carousel-item" href="#four!"><img src="http://lorempixel.com/800/400/food/4"></a>
                </div>
            </div>
        </div>-->
    <div class="row">
        <div class="col s12 m6">
            <div class="card">
                <div class="card-image">
                    <?= $this->Html->image('http://lorempixel.com/800/400/food/1', ['alt' => "Demo"]) ?>
                    <span class="card-title">Adipisci</span>
                </div>
                <div class="card-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusamus, adipisci assumenda atque deleniti dignissimos ea facere harum laboriosam laudantium maiores molestias neque, numquam, optio quas ratione rem temporibus voluptates.</p>
                </div>
                <div class="card-action right-align">
                    <a href="#">En savoir plus</a>
                </div>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="card">
                <div class="card-image">
                    <?= $this->Html->image('http://lorempixel.com/800/400/food/2', ['alt' => "Demo"]) ?>
                    <span class="card-title">Quam Saepe Veniam</span>
                </div>
                <div class="card-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. At beatae cupiditate enim ex, expedita hic id, illo impedit molestias, obcaecati omnis perferendis placeat repellendus reprehenderit sunt! Amet consectetur exercitationem officiis!</p>
                </div>
                <div class="card-action right-align">
                    <a href="#">En savoir plus</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m4">
            <div class="card">
                <div class="card-image">
                    <?= $this->Html->image('http://lorempixel.com/800/400/food/3', ['alt' => "Demo"]) ?>
                    <span class="card-title">Quidem reprehenderit</span>
                </div>
                <div class="card-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A asperiores at debitis esse ex obcaecati, provident rem similique sit, tenetur unde, vero.</p>
                </div>
                <div class="card-action right-align">
                    <a href="#">En savoir plus</a>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card">
                <div class="card-image">
                    <?= $this->Html->image('http://lorempixel.com/800/400/food/4', ['alt' => "Demo"]) ?>
                    <span class="card-title">Nesciunt</span>
                </div>
                <div class="card-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa enim nesciunt odit officia praesentium quas quis sed sunt suscipit vero!</p>
                </div>
                <div class="card-action right-align">
                    <a href="#">En savoir plus</a>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card">
                <div class="card-image">
                    <?= $this->Html->image('http://lorempixel.com/800/400/food/5', ['alt' => "Demo"]) ?>
                    <span class="card-title">Expedita</span>
                </div>
                <div class="card-content">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A cum cupiditate harum modi, nisi nulla officiis. Architecto eaque eos incidunt!</p>
                </div>
                <div class="card-action right-align">
                    <a href="#">En savoir plus</a>
                </div>
            </div>
        </div>
    </div>
</div>
