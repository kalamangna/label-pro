<?php
use CodeIgniter\Pager\PagerRenderer;
/**
 * @var PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>
<nav aria-label="Page navigation" class="flex justify-center">
    <ul class="inline-flex items-center gap-1.5 text-sm">
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getFirst() ?>" class="flex items-center justify-center w-10 h-10 text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-emerald-600 transition-all active:scale-95 shadow-sm" aria-label="First">
                    <i class="fa-solid fa-angles-left text-xs"></i>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getPrevious() ?>" class="flex items-center justify-center w-10 h-10 text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-emerald-600 transition-all active:scale-95 shadow-sm" aria-label="Previous">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li>
                <a href="<?= $link['uri'] ?>" class="flex items-center justify-center w-10 h-10 border rounded-xl transition-all shadow-sm <?= $link['active'] ? 'text-white border-emerald-600 bg-emerald-600 font-bold' : 'text-gray-600 bg-white border-gray-200 hover:bg-gray-50 hover:text-emerald-600 active:scale-95' ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" class="flex items-center justify-center w-10 h-10 text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-emerald-600 transition-all active:scale-95 shadow-sm" aria-label="Next">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getLast() ?>" class="flex items-center justify-center w-10 h-10 text-gray-500 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-emerald-600 transition-all active:scale-95 shadow-sm" aria-label="Last">
                    <i class="fa-solid fa-angles-right text-xs"></i>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>
