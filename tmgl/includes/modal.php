<?php
if (function_exists('have_rows')) {
	if (have_rows('modal_home')) : 
		while (have_rows('modal_home')) : the_row(); 
			$show_modal = get_sub_field('show_modal');
			$modal_content = get_sub_field('modal_content');
		endwhile;
	endif;
}
?>


<!-- Modal -->
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">The WHO Traditional Medicine Global Library</h5>
      </div>
      <div class="modal-body">
      	<?= $modal_content;?> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="agreeButton">I Agree</button>
      </div>
    </div>
  </div>
</div>

<?php if ($show_modal == "yes"): ?>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		if (!localStorage.getItem("modalShown")) {
			var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
				keyboard: false
			});
			myModal.show();
		}
		document.getElementById('agreeButton').addEventListener('click', function() {
			localStorage.setItem("modalShown", "true");
			var myModalEl = document.getElementById('exampleModal');
			var modalInstance = bootstrap.Modal.getInstance(myModalEl);
			modalInstance.hide();
		});
	});
</script>
<?php endif; ?>
