<?php
use CodeIgniter\Pager\PagerRenderer;
/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(1);
?>
<nav aria-label="Page navigation" class="flex justify-center">
    <ul class="inline-flex items-center -space-x-px text-sm">
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getPrevious() ?>" class="flex items-center justify-center px-3 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-200 rounded-s-xl hover:bg-gray-50 hover:text-emerald-600 transition-colors">
                    <i class="fa-solid fa-chevron-left"></i>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li>
                <a href="<?= $link['uri'] ?>" class="flex items-center justify-center px-4 h-10 leading-tight border transition-colors <?= $link['active'] ? 'z-10 text-emerald-600 border-emerald-200 bg-emerald-50 font-bold' : 'text-gray-500 bg-white border-gray-200 hover:bg-gray-50 hover:text-emerald-600' ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" class="flex items-center justify-center px-3 h-10 leading-tight text-gray-500 bg-white border border-gray-200 rounded-e-xl hover:bg-gray-50 hover:text-emerald-600 transition-colors">
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>
