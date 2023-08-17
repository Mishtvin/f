<div class="main-phone">
    <div class="main-phone-content">
        <?php if (count(PHONES) > 0): ?>
        <a href="tel:+<?= PHONES[0]['link']?>" class="phone"><?= PHONES[0]['tel']?></a>
        <?php endif; ?>

        <?php if (count(PHONES) > 1): ?>
        <a href="tel:+<?= PHONES[1]['link']?>" class="phone"><?= PHONES[1]['tel']?></a>
        <?php endif; ?>

        <span class="time">Телефон в <?= CITY_GENITIVE ?></span>
    </div>
</div>