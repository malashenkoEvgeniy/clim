<div class="droparea js-init" data-droparea>
    <input type="file" name="file" class="droparea__input" accept=".pdf, .doc, .docx, .txt" data-droparea="input">
    <div class="droparea__icon">
        {!! SiteHelpers\SvgSpritemap::get('icon-clip', [
            'class' => 'svg-icon svg-icon--icon-clip',
        ]) !!}
    </div>
    <div class="droparea__message">Перетащите сюда файл резюме или <span>выберите файл</span></div>
    <div class="droparea__file-info" data-droparea="file-info"></div>
    <div class="droparea__clear" data-droparea="clear">Очистить</div>
</div>
