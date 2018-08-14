<form
        method="post"
        action="/Insync/send"
        class="page-block"
>
    <input type="hidden" name="transferLinkId" value="<?= $data["transferLinkId"] ?>">
    <input type="submit" name="submitForm" value="bank" style="display: none">
    <div class="container">
        <div class="page-icon flc">
            <span class="logo">
                <img src="/images/logo_insync.svg" alt="InSync by Alfa-Bank">
            </span>
        </div>
        <div class="page-form flc">
            <div class="form">
                <div class="form-grid">
                    <div class="form-row flc">
                        <div class="rich-text-input js-rich-text-input rich-text-input--inverted">
                            <div class="rich-text-input__cell-label">
                                <label class="rich-text-input__label">Получатель</label>
                            </div>
                            <div class="rich-text-input__cell-input">
                                <input type="text" class="rich-text-input__input js-rich-text-input__input"
                                       value="<?= $data["user"] ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-row flc">
                        <div class="rich-text-input js-rich-text-input rich-text-input--inverted">
                            <div class="rich-text-input__cell-label">
                                <label class="rich-text-input__label">IBAN</label>
                            </div>
                            <div class="rich-text-input__cell-input">
                                <input type="text" class="rich-text-input__input js-rich-text-input__input"
                                       value="<?= $data["accountIBAN"] ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-row flc">
                        <div class="rich-text-input js-rich-text-input rich-text-input--inverted">
                            <div class="rich-text-input__cell-label">
                                <label class="rich-text-input__label">Дата формирования</label>
                            </div>
                            <div class="rich-text-input__cell-input">
                                <?

                                $dateUpdate = new DateTime();
                                $dateUpdate->setTimestamp($data["lastUpdate"]/1000);
                                ?>
                                <input type="text" class="rich-text-input__input js-rich-text-input__input"
                                       value="<?= $dateUpdate->format("d.m.Y") ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <?
                    $isErrorSum = isset($data["errors"]["sum"]);
                    ?>
                    <div class="form-row form-row--offset flc <?= $isErrorSum ? "form-error" : "" ?>">
                        <div class="rich-text-input js-rich-text-input">
                            <div class="rich-text-input__cell-label">
                                <label class="rich-text-input__label">Сумма в BYN</label>
                            </div>
                            <div class="rich-text-input__cell-input">
                                <input type="text" name="sum"
                                       class="rich-text-input__input js-rich-text-input__input js-mask-input--price"
                                       value="<?= Tools::formatNumber($data["sum"]) ?> BYN">
                            </div>
                        </div>
                        <? if ($isErrorSum): ?>
                            <div class="form-row__note form-row__note--error flc">Минимум 1 BYN!!!</div>
                        <? else: ?>
                            <div class="form-row__note flc"><?= $data["errors"]["sum"] ?></div>
                        <? endif; ?>
                    </div>
                </div>
            </div>
        </div>


        <h2 class="page-subtitle flc">Выберите способ перевода</h2>


        <div class="page-action flc">
            <div class="page-action__buttons flc">
                <a class="btn btn--block disabled hidden-touch hidden-loading">Перевод через InSync</a>
                <button type="submit" name="submitForm" value="insync"
                        class="btn btn--block hidden-no-touch hidden-loading">Перевод через InSync
                </button>
            </div>
            <div class="page-action__note flc">
                Для перевода откройте эту страницу со смартфона с установленым приложением
                <a href="#" target="_blank">InSync</a>
            </div>
        </div>


        <div class="page-action flc">
            <div class="page-action__buttons flc">
                <button type="submit" name="submitForm" value="bank" class="btn btn--block">Перевод с банковской карты
                </button>
            </div>
            <div class="page-action__icons flc">
                <div class="pay-icons">
                    <div class="pay-icons__grid">
                        <div class="pay-icons__item">
                            <img src="/images/logo_mastercard.svg" alt="MasterCard" title="MasterCard">
                        </div>
                        <div class="pay-icons__item">
                            <img src="/images/logo_visa.svg" alt="VISA" title="VISA">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

