$(function() {
	// ★ページ離脱イベント
	$(window).on('beforeunload', function() {
		$(".op").show();
		return ('ページ移動を確認します');
	});
	// Submitの場合のみ　ページ離脱イベント解除
	$('form').on('submit', function() {
		$(window).off('beforeunload');
	});
	$('.close').live('click', function() {
		$(".op").hide();
	});

	$('#mask').live('click', function() {
		$(".op").hide();
	});
}); 