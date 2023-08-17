<div class="article-mc contact-wrapper bm">
    <?php if (count(PHONES) > 0): ?>
    <a href="tel:+<?php echo PHONES[0]['link']; ?>" class="contacts-item icon-phone bold-icon large"><?php echo PHONES[0]['tel']; ?></a>
    <?php endif; ?>
    <?php if (count(PHONES) > 1): ?>
    <a href="tel:+<?php echo PHONES[1]['link']; ?>" class="contacts-item icon-phone bold-icon large"><?php echo PHONES[1]['tel']; ?></a>
    <?php endif; ?>
    <div class="label">Телефон в <?php echo CITY_GENITIVE; ?></div>
    <!-- <div class="label">Круглостуончная бесплатная доставка</div> -->
</div>