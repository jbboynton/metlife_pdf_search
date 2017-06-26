<form action="#" method="POST" class="mps_upload_form" enctype="multipart/form-data">
  <div class="mps-message"></div>
  <p class="description">Upload a PDF file here.</p>
  <div id="mps-file-upload" class="file-upload">
    <input type="file" id="mps_pdf_uploader" name="mps_pdf_uploader" size="25" value="" />
    <?php wp_nonce_field('save_pdf', 'mps_nonce'); ?>
  </div>
</form>
<br><hr><br>
<p class="description">PDF Preview:</p>
<textarea disabled="disabled" style="width: 100%;resize: none;min-height: 200px;"><?php echo get_post_meta(get_the_ID(), 'pdf_contents', true) ?></textarea>


