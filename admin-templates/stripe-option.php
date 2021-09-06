<div class="wrap">
<form method="post" action="options.php">
<?php
// display settings field on theme-option page
settings_fields("theme-options-grp");

// display all sections for theme-options page
do_settings_sections("theme-options");
submit_button();
?>
</form>
</div>