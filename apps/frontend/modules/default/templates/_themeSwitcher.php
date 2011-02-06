<?php if (count($themes)): ?>
  <?php echo form_tag('@switch_theme') ?>
    <select name="id">
      <option value=""><?php echo __('Choose a theme') ?></option>
      <?php foreach ($themes as $theme): ?>
        <option value="<?php echo $theme->getId(); ?>" <?php echo $sf_user->getGuardUser()->getThemeId() == $theme->getId() ? 'selected="selected"' : '' ?>><?php echo $theme->getName(); ?></option>
      <?php endforeach; ?>
    </select>
    <input type="submit" name="switch" value="<?php echo __('ok') ?>" />
  </form>
<?php endif; ?>