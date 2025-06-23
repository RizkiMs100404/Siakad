<?php if (count($pager->links()) > 1): ?>
<nav class="flex justify-center mt-6">
    <ul class="inline-flex items-center -space-x-px">
        <?php if ($pager->hasPrevious()): ?>
            <li>
                <a href="<?= $pager->getPrevious() ?>"
                   class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                   &laquo;
                </a>
            </li>
        <?php endif ?>
        <?php foreach ($pager->links() as $link): ?>
            <li>
                <a href="<?= $link['uri'] ?>"
                   class="px-3 py-2 leading-tight <?= $link['active'] ? 'text-white bg-[#6C7CF6] border-[#6C7CF6]' : 'text-gray-500 bg-white border-gray-300' ?> border hover:bg-gray-100 hover:text-gray-700">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>
        <?php if ($pager->hasNext()): ?>
            <li>
                <a href="<?= $pager->getNext() ?>"
                   class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                   &raquo;
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>
<?php endif ?>
 