jQuery(document).ready(function($) {
	$('.select2').select2();
	var mos_product_cat_visibility = $("input[name='mos_product_cat_visibility']:checked").val();
	console.log(mos_product_cat_visibility);
	mos_show_protection_type(mos_product_cat_visibility);

	$("input[name='mos_product_cat_visibility']").on('change', function(){
		console.log($(this).val());
		mos_show_protection_type($(this).val());
	});
	function mos_show_protection_type(value){

		if(value == 'pass_protected') {
			$('.mos-cat-protection-type').hide();
			$('.mos-cat-protection-type-password').show();
		}
		else if(value == 'user_role_protected') {
			$('.mos-cat-protection-type').hide();
			$('.mos-cat-protection-type-user-roles').show();
		}
		else if(value == 'user_protected') {
			$('.mos-cat-protection-type').hide();
			$('.mos-cat-protection-type-user').show();
		} else {			
			$('.mos-cat-protection-type').hide();
		}
	}
});
