<?php
    $pages = [
        0 => [
            'name' => 'About',
            'route' => './pages/about/',
        ],
        1 => [
            'name' => 'Services',
            'route' => './pages/services/',
        ],
        2 => [
            'name' => 'Contact',
            'route' => './pages/contact/',
        ]
    ];
?>
<header>
    <div class="content">
        <div class="wrapper-header">
            <a href="" id="link-logo">
                <div class="logo" id="btn">
                    <h1>Gerencia<span>aí</span></h1>
                </div>
            </a>
            <div class="right">
                <ul class="navigation-links">
                    <?php foreach($pages as $page): ?>
                        <li>
                            <a href="<?= $page['route'] ?>">
                                <?= $page['name'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="icon-user">
                    <span class="icon">
                        DS

                        <!-- <ul class="dropdown">
                            <li>aoisndasnd</li>
                            <li>aoisndasnd</li>
                            <li>aoisndasnd</li>
                        </ul> -->
                    </span>
                    <div class="text">
                        <h4>David Soares</h4>
                        <p>Sair</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>