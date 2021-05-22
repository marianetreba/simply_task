<?
/** @var array $paging */

?>
<? if ($paging['total_pages'] > 1): ?>
<nav>
    <ul class="pagination justify-content-center">
        <li class="page-item <?= $paging['page_number'] === 1 ? 'disabled' : '' ?>">
            <a href="<?= LinkGenerate::pageLink($paging['page_number']-1) ?>" class="page-link">&lt;</a>
        </li>
        <? if ($paging['page_number'] > 10): ?>
        <li class="page-item" <?= $paging['page_number'] == 1 ? ' disabled' : '' ?>>
            <a href="<?= LinkGenerate::pageLink(1) ?>" class="page-link">1</a>
            <span class="pages">...</span>
        </li>
        <? endif; ?>
        <? for ($i = max(1, $paging['page_number'] - 10); $i <= min(
            $paging['total_pages'],
            $paging['page_number'] + 10
        ) ; $i++): ?>
        <li class="page-item <?= $i === $paging['page_number'] ? 'active' : '' ?>">
            <a href="<?= LinkGenerate::pageLink($i) ?>" class="page-link" ><?= $i ?></a>
        </li>
        <? endfor; ?>
        <? if ($paging['total_pages'] > $paging['page_number'] + 10): ?>
        <li class="page-item" <?= $paging['total_pages'] === $paging['page_number'] ? 'disabled' : '' ?>>
            <span class="pages">...</span>
            <a href="<?= LinkGenerate::pageLink($paging['total_pages']) ?>" class="page-link">
                <?= $paging['total_pages'] ?>
            </a>
        </li>
        <? endif; ?>
        <li class="page-item <?= $paging['page_number'] >= $paging['total_pages']  ? 'disabled' : '' ?>">
        <a href="<?= LinkGenerate::pageLink($paging['page_number']+1) ?>" class="page-link">&gt;</a>
        </li>
    </ul>
</nav>
<? endif; ?>
<div class="total">Всего записей: <?= $paging["total_entries"] ?></div>

