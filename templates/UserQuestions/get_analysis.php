<!-- dashboard.ctp -->
<?php

use Cake\ORM\TableRegistry; ?>
<div class="mx-5">
    <div class=" mx-auto p-5 border border-black border-solid">
        <h2 class="text-white">Popular Questions</h2>
    </div>

    <?php $i = 1; ?>
    <?php foreach ($query as $row) : ?>
        <?php if ($row->category == 'general') : ?>
            <?php
            $general = TableRegistry::getTableLocator()->get('Generals');
            $generalContent = $general->find()
                ->where(['id' => $row->answer_id])
                ->first();
            ?>
        <?php endif; ?>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg my-2">
            <ul class="divide-y divide-gray-200">
                <li>
                    <a href="#" class="block hover:bg-gray-50">
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium text-indigo-600 truncate">
                                    Answer <?php echo $i++; ?>
                                </div>
                                <div class="ml-2 flex-shrink-0 flex">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <p class="text-gray-600">Count: <?= $row->count ?></p>
                                    </span>
                                </div>
                            </div>
                            <div class="mt-2 sm:flex sm:justify-between">
                                <div class="sm:flex">
                                    <div class="mr-6 flex items-center text-sm text-gray-500">
                                        <!-- Heroicon name: solid/calendar -->
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5 2a1 1 0 011-1h8a1 1 0 011 1v1h2a2 2 0 012 2v13a2 2 0 01-2 2H5a2 2 0 01-2-2V5c0-1.1.9-2 2-2h2V2zm8 3H7v1h6V5zM5 8h10V7H5v1zm5 1a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                        <?= $generalContent->content; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <!-- More list items here -->
            </ul>
        </div>
    <?php endforeach; ?>

    <hr class="my-[20px] border-t border-gray-300">

    <div class="row ml-1 mt-5">
        <div class="col-6">
            <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-2">Languages Asked by Users Most Frequently:</h2>
                <ul class="list-disc ml-4">
                    <li class="text-gray-800">Japanese</li>
                    <li class="text-gray-800">English</li>
                    <!-- Add more languages as needed -->
                </ul>
            </div>
        </div>
    </div>

    <hr class="my-[20px] border-t border-gray-300">

    <div class=" mx-auto p-5 border border-black border-solid">
        <h2 class="text-white">Answer Ratings based on User</h2>
    </div>

    <?php $i = 1; ?>
    <?php foreach ($query as $row) : ?>
        <?php if ($row->category == 'general') : ?>
            <?php
            $general = TableRegistry::getTableLocator()->get('Generals');
            $generalContent = $general->find()
                ->where(['id' => $row->answer_id])
                ->first();
            ?>
        <?php endif; ?>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg my-2">
            <ul class="divide-y divide-gray-200">
                <li>
                    <a href="#" class="block hover:bg-gray-50">
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium text-indigo-600 truncate">
                                    Answer <?php echo $i++; ?>
                                </div>
                                <div class="ml-2 flex-shrink-0 flex">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <p class="text-gray-600">Count: <?= $row->count ?></p>
                                    </span>
                                </div>
                            </div>
                            <div class="mt-2 sm:flex sm:justify-between">
                                <div class="sm:flex">
                                    <div class="mr-6 flex items-center text-sm text-gray-500">
                                        <!-- Heroicon name: solid/calendar -->
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5 2a1 1 0 011-1h8a1 1 0 011 1v1h2a2 2 0 012 2v13a2 2 0 01-2 2H5a2 2 0 01-2-2V5c0-1.1.9-2 2-2h2V2zm8 3H7v1h6V5zM5 8h10V7H5v1zm5 1a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                        <?= $generalContent->content; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <!-- More list items here -->
            </ul>
        </div>
    <?php endforeach; ?>



</div>


<!-- Additional content for the dashboard -->