<?php if (! count($projects)): ?>
  <p><?php echo __('No project found') ?></p>
<?php else: ?>
  <?php echo form_tag('@switch_project') ?>
    <select name="id">
      <option value=""><?php echo __('Choose a project') ?></option>
      <?php foreach ($projects as $project): ?>
        <option value="<?php echo $project->getId(); ?>" <?php echo $sf_user->getCurrentProjectId() == $project->getId() ? 'selected="selected"' : '' ?>><?php echo $project; ?></option>
      <?php endforeach; ?>
    </select>
    <input type="submit" name="switch" value="<?php echo __('ok') ?>" />
  </form>
<?php endif; ?>