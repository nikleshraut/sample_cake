<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->script('jquery.min.js') ?>
    <?= $this->Html->script('bootstrap.bundle.min.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1>
                    <a href="/">Home</a>
                </h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
                <li>
                    <?php
                        echo $this->Html->link(
                            'Tags',
                            ['controller' => 'Tags', 'action' => 'index']
                        );
                    ?>
                </li>
                <li>
                    <?php
                        echo $this->Html->link(
                            'Articles',
                            ['controller' => 'Articles', 'action' => 'index']
                        );
                    ?>
                </li>
                <li>
                    <?php
                        echo $this->Html->link(
                            'Register',
                            ['controller' => 'Users', 'action' => 'add']
                        );
                    ?>
                </li>
                <li>
                    <?php
                        echo $this->Html->link(
                            'Logout',
                            ['controller' => 'Users', 'action' => 'logout'],
                            ['confirm' => 'Are you sure you wish to logout ?']
                        );
                    ?>
                </li>
                <li>
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      User
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                            echo $this->Html->link(
                                'Profile',
                                ['controller' => 'Users', 'action' => 'view',1],
                                ['class' => 'dropdown-item']
                            );
                        ?>
                        <?php
                            echo $this->Html->link(
                                'All Users',
                                ['controller' => 'Users', 'action' => 'index'],
                                ['class' => 'dropdown-item']
                            );
                        ?>
                        
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
