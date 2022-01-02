<?php
/**
 * [ADMIN] SimpleRedirection
 *
 * @link http://www.materializing.net/
 * @author arata
 * @package SimpleRedirection
 * @license MIT
 */
$this->BcListTable->setColumnNumber(3);
?>
<?php echo $this->BcForm->create('SimpleRedirection', ['url' => ['action' => 'index']]); ?>

<section class="bca-section">
	<table cellpadding="0" cellspacing="0" class="list-table bca-table-listup" id="SimpleRedirectionListTable">
		<thead class="bca-table-listup__thead">
			<tr>
				<th class="bca-table-listup__thead-th">
					遷移元URL（上段）、遷移先URL（下段）
					<br>
					HTTPステータスコード&nbsp;/&nbsp;利用状態
				</th>
				<th class="bca-table-listup__thead-th">
					説明文
					<br>
					削除指定
				</th>
				<th class="bca-table-listup__thead-th">
					確認
				</th>
			</tr>
		</thead>
		<tbody class="bca-table-listup__tbody">
		<?php if (count($this->request->data)): ?>
			<?php foreach ($this->request->data as $i => $data): ?>
			<tr id="Row<?php echo $i; ?>">
				<td class="col-head bca-table-listup__tbody-td">
					<?php
						$inputTextOption = [
							'type' => 'text', 'size' => 80,
							'class' => implode(' ', ['bca-textbox__input', 'full-counter']),
							'placeholder' => '必須入力',
						];
						if (Hash::check($data, 'SimpleRedirection.error')) {
							$inputTextOption = Hash::merge($inputTextOption, ['class' => implode(' ', ['bca-textbox__input', 'full-counter', 'form-error'])]);
						}
					?>
					<?php echo $this->BcForm->input($i .'.SimpleRedirection.source', $inputTextOption) ?>
					<?php echo $this->BcForm->error($i .'.SimpleRedirection.source') ?>
					<br>

					<?php
						$inputTextOption = [
							'type' => 'text', 'size' => 80,
							'class' => implode(' ', ['bca-textbox__input', 'full-counter']),
							'placeholder' => '必須入力',
						];
						if (Hash::check($data, 'SimpleRedirection.error')) {
							$inputTextOption = Hash::merge($inputTextOption, ['class' => implode(' ', ['bca-textbox__input', 'full-counter', 'form-error'])]);
						}
					?>
					<?php echo $this->BcForm->input($i .'.SimpleRedirection.target', $inputTextOption) ?>
					<?php echo $this->BcForm->error($i .'.SimpleRedirection.target') ?>

					<? // エラーメッセージの表示 ?>
					<?php if (Hash::check($data, 'SimpleRedirection.error')): ?>
						<div class="error-message"><?php echo implode(' ', Hash::get($data, 'SimpleRedirection.error')); ?></div>
					<?php else: ?>
						<br>
					<?php endif; ?>

					<small>[HTTPステータスコード]</small>
					<?php echo $this->BcForm->input($i .'.SimpleRedirection.status_code', [
						'type' => 'select', 'options' => ['302' => '302 - Found（Temporary Redirect）', '301' => '301 - Moved Permanently'], 'default' => '302',
					]); ?>
					<?php echo $this->BcForm->error($i .'.SimpleRedirection.status_code'); ?>
					<?php echo $this->BcForm->input($i .'.SimpleRedirection.status', ['type' => 'checkbox', 'label' => '利用する']); ?>
					<?php echo $this->BcForm->error($i .'.SimpleRedirection.status'); ?>
				</td>
				<td class="col-head bca-table-listup__tbody-td">
					<?php echo $this->BcForm->input($i .'.SimpleRedirection.description', [
						'type' => 'textarea', 'cols' => 30, 'rows' => 1,
						'style' => 'width: 96%;'
					]) ?>
					<br>
					<small>※設定の理由や目的等を自由入力（省略可）</small>
					<?php echo $this->BcForm->error($i .'.SimpleRedirection.description'); ?>
					<br>

					<?php echo $this->BcForm->input($i .'.SimpleRedirection.delete', ['type' => 'checkbox', 'label' => 'この設定を削除する']); ?>
					<?php echo $this->BcForm->error($i .'.SimpleRedirection.delete'); ?>
				</td>
				<td class="row-tools bca-table-listup__tbody-td bca-table-listup__tbody-td--actions">
					<?php if ($this->BcForm->value($i .'.SimpleRedirection.source') && $this->BcForm->value($i .'.SimpleRedirection.target')): ?>
						<?php if ($this->BcForm->value($i .'.SimpleRedirection.status')): ?>
							<?php $this->BcBaser->link($this->BcBaser->getImg('admin/icn_tool_check.png', ['alt' => __d('baser', '確認'), 'class' => 'btn']),
								$this->BcForm->value($i .'.SimpleRedirection.source'),
								['title' => __d('baser', '確認'), 'class' => 'btn-check', 'target' => '_blank']
							); ?>
						<?php endif; ?>
					<?php endif; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="<?php echo $this->BcListTable->getColumnNumber() ?>" class="bca-table-listup__tbody-td">
					<p class="no-data"><?php echo __d('baser', 'リダイレクト設定がありません。') ?></p>
				</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
</section>
<?php echo $this->BcFormTable->dispatchAfter() ?>

<!-- button -->
<div class="submit bca-actions">

	<?php echo $this->BcForm->button(__d('baser', '保存'),
		[
			'type' => 'submit',
			'id' => 'BtnSave',
			'div' => false,
			'class' => 'button bca-btn bca-actions__item',
			'data-bca-btn-type' => 'save',
			'data-bca-btn-size' => 'lg',
			'data-bca-btn-width' => 'lg',
		]
	) ?>

	<div class="bca-actions__sub">
		<?php echo $this->BcForm->button('設定追加',
			[
				'type' => 'button',
				'id' => 'BtnAddRow',
				'div' => false,
				'class' => 'button bca-btn bca-actions__item',
			]
		) ?>
	</div>
</div>

<?php echo $this->BcForm->end(); ?>

<script>
window.addEventListener('DOMContentLoaded', function() {
	jQuery(function($) {
		$("#BtnAddRow").on("click", function() {
			// 設定ナシから最初の1行目を追加するとき
			if ($('#SimpleRedirectionListTable tbody tr td').find('p.no-data').length){
				$('#SimpleRedirectionListTable tbody tr:first-child').remove();
			}

			// 複製元テーブルの行をクローンしてテーブルの最後に追加する
			let $tableOriginalReplication = $('#TableOriginalReplication').find('tr').parent();
			let tableHtml = $tableOriginalReplication.html();

			let trCount = $('#SimpleRedirectionListTable tbody').children().length;
			$(tableHtml.replaceAll('{{$}}', trCount+1)).appendTo('#SimpleRedirectionListTable tbody');
		});
	});
});
</script>

<table style="display:none;" id="TableOriginalReplication">
<tbody>
	<tr id="Row{{$}}">
		<td class="col-head bca-table-listup__tbody-td">
			<span class="bca-textbox"><input name="data[{{$}}][SimpleRedirection][source]" size="80" class="bca-textbox__input full-counter" type="text" id="{{$}}SimpleRedirectionSource" placeholder="必須入力"></span>
			<br>
			<span class="bca-textbox"><input name="data[{{$}}][SimpleRedirection][target]" size="80" class="bca-textbox__input full-counter" type="text" id="{{$}}SimpleRedirectionTarget" placeholder="必須入力"></span>
			<br>
			<small>[HTTPステータスコード]</small>
			<span class="bca-select"><select name="data[{{$}}][SimpleRedirection][status_code]" class="bca-select__select" id="{{$}}SimpleRedirectionStatusCode">
				<option value="302" selected="selected">302 - Found（Temporary Redirect）</option>
				<option value="301">301 - Moved Permanently</option>
			</select></span>
			<span class="bca-checkbox">
				<input type="hidden" name="data[{{$}}][SimpleRedirection][status]" id="{{$}}SimpleRedirectionStatus_" value="0">
				<input type="checkbox" name="data[{{$}}][SimpleRedirection][status]" class="bca-checkbox__input" value="1" id="{{$}}SimpleRedirectionStatus"><label for="{{$}}SimpleRedirectionStatus" class="bca-checkbox__label">利用する</label>
			</span>
		</td>
		<td class="col-head bca-table-listup__tbody-td">
			<span class="bca-textarea">
				<textarea name="data[{{$}}][SimpleRedirection][description]" cols="30" rows="1" style="width: 96%;" class="bca-textarea__textarea" id="{{$}}SimpleRedirectionDescription"></textarea>
			</span>
			<br>
			<small>※設定の理由や目的等を自由入力（省略可）</small>
			<br>
			<span class="bca-checkbox">
				<input type="hidden" name="data[{{$}}][SimpleRedirection][delete]" id="{{$}}SimpleRedirectionDelete_" value="0">
				<input type="checkbox" name="data[{{$}}][SimpleRedirection][delete]" class="bca-checkbox__input" value="1" id="{{$}}SimpleRedirectionDelete"><label for="{{$}}SimpleRedirectionDelete" class="bca-checkbox__label">この設定を削除する</label>
			</span>
		</td>
		<td class="row-tools bca-table-listup__tbody-td bca-table-listup__tbody-td--actions">
		</td>
	</tr>
</tbody>
</table>
