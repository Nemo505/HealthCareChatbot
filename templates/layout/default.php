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
 * @var \App\View\AppView $this
 */

$cakeDescription = 'Health Care';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'output', 'chat', 'fontawesome.min']) ?>
    <?= $this->Html->script(['fontawesome.min']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <!-- Add this to your layout file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.min.css'>
  
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.concat.min.js'></script>

</head>
<body>
    
    <?php if (!($this->getRequest()->getParam('controller') === 'Users' && $this->getRequest()->getParam('action') === 'login')) : ?>
        <nav style="background-color: rgba(0, 12, 0, 0.8); padding: 1rem;">
            <div style="color: white; display:flex; justify-content: space-between; align-items: center;">
                <a href="<?= $this->Url->build('/') ?>" style="text-decoration: none; color: white; font-weight: bold; font-size: 2rem;">
                    <span style="color: #f7d418;">⛑️</span> Health <span style="color: #f7d418;"></span> Care ChatBot
                </a>
                <form action="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" method="post">
                    <button type="submit" style="background: linear-gradient(to right, #4E5551, rgba(235, 167, 167, 0.57));
                                                color: #fff; padding: 10px 15px; 
                                                border: none; 
                                                border-radius: 4px; 
                                                cursor: pointer;">
                        Logout
                    </button>
                </form>

            </div>
        </nav>
    <?php endif; ?>

    <main class="main">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>

    <footer>
    </footer>
</body>
</html>
